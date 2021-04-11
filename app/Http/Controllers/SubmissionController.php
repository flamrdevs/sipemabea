<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Laravel
use Auth;
use Carbon\Carbon;
use Session;
use Validator;

// Helper
use Helper;

// Model
use App\Submission;

class SubmissionController extends Controller
{
    // =======================|               |=======================  //
    // =======================|     ADMIN     |=======================  //
    // =======================|               |=======================  //

    private $paginate = 10;

    // GET
    public function admin_index(Request $request)
    {
        $monthQuery = $request->query('month');

        $submissions = null;

        if (isset($monthQuery)) {
            $submissions = Submission::where(function ($query) {
                $query->where('status', 'processed')->orWhereNull('status');
            })->whereMonth('created_at', Carbon::parse($monthQuery)->format('m'))->latest()->get();
        } else {
            $submissions = Submission::where('status', 'processed')->orWhereNull('status')->latest()->paginate($this->paginate);
        }
        
        return view('admin.submissions.index', compact(['submissions', 'monthQuery']));
    }

    // GET
    public function admin_show($id)
    {
        $submission = Submission::where('id', $id)->where(function ($query) {
            $query->where('status', 'processed')->orWhereNull('status');
        })->first();
        if (is_null($submission)) {
            return redirect()->route('admin.approvements.show', ['id' => $id]);
        }
        if (is_null($submission['status'])) {
            $submission['status'] = 'processed';
            $submission->save();
        }
        return view('admin.submissions.show', compact('submission'));
    }

    // PUT
    public function admin_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string|max:2048',
            'attachment-link' => 'required|mimetypes:application/pdf',
            'status' => 'required|in:accepted,rejected'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attachmentLinkPath = $this->fileSaveToStorage($request->file('attachment-link'), 'attachment');

        $submission = Submission::where('id', $id)->where(function ($query) {
            $query->where('email_sent', false)->orWhereNull('email_sent');
        })->firstOrFail();
        $submission['note'] = $request['note'];
        $submission['attachment_link'] = $attachmentLinkPath;
        $submission['status'] = $request['status'];
        $submission['email_sent'] = false;

        if ($submission->save()) {
            return redirect()->route('admin.approvements.mail-preview', ['id' => $id]);
        } else {
            Session::flash('failure', trans('messages.session:failure-update-submission'));
            return redirect()->back()->withInput();
        }
    }

    // =======================|               |=======================  //
    // =======================|     GUEST     |=======================  //
    // =======================|               |=======================  //

    // GET
    public function guest_create()
    {
        return view('submission');
    }

    // POST
    public function guest_store(Request $request)
    {
        $members = collect($request['member'])->filter(function($member) {
            return $member !== null;
        });

        $validator = $this->validateSubmission($request);

        if ($validator->fails()) {
            $memberErrors = collect($validator->errors()->get('member.*'));

            $membersInputWithError = collect([]);

            foreach ($members as $key => $value) {
                $membersInputWithError->push([
                    'input' => $value,
                    'errors' => collect($memberErrors['member.'.$key] ?? [])
                ]);
            }

            $request['member'] = $membersInputWithError;

            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->attemptSubmission($request)) {
            Session::flash('email', $request['email']);
            Session::flash('success', trans('messages.session:success-create-submission'));
            return redirect()->route('submission');
        } else {
            Session::flash('failure', trans('messages.session:failure-create-submission'));
            return redirect()->back()->withInput();
        }
    }

    // SELF
    private function fileSaveToStorage($file, $folder = '')
    {
        $originalName = $file->getClientOriginalName();
        $hashedToday = hash('sha256', date('d-m-Y H.i.s'));
        $hashedName = $hashedToday.'-'.config('app.name').'-'.$originalName;

        $year = date('Y');

        $targetFolder = 'uploads/' . $year . '/' . $folder;

        return $file->storeAs($targetFolder, $hashedName);
    }

    // SELF
    private function validateSubmission($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email|max:128',
            'person-in-charge' => 'required|string|max:64',
            'member.*' => 'nullable|string|max:64',
            'agency' => 'required|string|max:128',
            'phone-number' => 'required|string|max:32|regex:/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/',
            'goal' => 'required|string|max:2048',
            'start-date' => 'required|date|after:'.Carbon::today()->format('Y-m-d'),
            'end-date' => 'required|date|after:'.Carbon::today()->format('Y-m-d'),
            'proposal-link' => 'required|mimetypes:application/pdf',
            'cover-letter-link' => 'required|mimetypes:application/pdf',
        ]);
    }

    // SELF
    private function attemptSubmission($request)
    {
        $proposalLinkPath = $this->fileSaveToStorage($request->file('proposal-link'), 'proposal');
        $coverLetterLinkPath = $this->fileSaveToStorage($request->file('cover-letter-link'), 'cover-letter');

        return Submission::create([
            'email' => $request['email'],
            'person_in_charge' => $request['person-in-charge'],
            'members' => json_encode(collect($request['member'])->filter(function($member) {
                return $member !== null;
            })),
            'agency' => $request['agency'],
            'phone_number' => $request['phone-number'],
            'goal' => $request['goal'],
            'start_date' => $request['start-date'],
            'end_date' => $request['end-date'],
            'proposal_link' => $proposalLinkPath,
            'cover_letter_link' => $coverLetterLinkPath,
        ])->save();
    }
}
