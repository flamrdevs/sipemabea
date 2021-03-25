<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Laravel
use Auth;
use Carbon\Carbon;
use Mail;
use Session;
use Validator;

// Mail
use App\Mail\ApprovalMail;

// Model
use App\Submission;

class SubmissionController extends Controller
{
    // =======================|               |=======================  //
    // =======================|     ADMIN     |=======================  //
    // =======================|               |=======================  //

    private $paginate = 3;

    // GET
    public function admin_index(Request $request)
    {
        $dateQuery = $request->query('date');

        $submissions = null;

        if (isset($dateQuery)) {
            $submissions = Submission::where(function ($query) {
                $query->where('status', 'processed')->orWhereNull('status');
            })->where('start_date', Carbon::parse($dateQuery))->latest()->get();
        } else {
            $submissions = Submission::where('status', 'processed')->orWhereNull('status')->latest()->paginate($this->paginate);
        }
        
        return view('admin.submissions.index', compact(['submissions', 'dateQuery']));
    }

    // GET
    public function admin_show($id)
    {
        $submission = Submission::where('id', $id)->where(function ($query) {
            $query->where('status', 'processed')->orWhereNull('status');
        })->firstOrFail();
        if (is_null($submission['status'])) {
            $submission['status'] = 'processed';
            $submission->save();
        }
        return view('admin.submissions.show', compact(['submission']));
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

        $submission = Submission::findOrFail($id);
        $submission['note'] = $request['note'];
        $submission['attachment_link'] = $attachmentLinkPath;
        $submission['status'] = $request['status'];
        $submission['email_sent'] = false;

        if ($submission->save()) {

            $user = [
                'name' => $submission['person_in_charge'],
                'email' => $submission['email']
            ];

            $data = [
                'name' => $user['name'],
                'from' => config('mail.from'),
                'attachmentLink' => $attachmentLinkPath,
                'type' => $request['status'] == 'accepted' ? 'reception' : 'rejection',
            ];

            try {
                Mail::to($user['email'])->send(new ApprovalMail($data));
            
                if (count(Mail::failures()) > 0) {
                    Session::flash('mail-failure', trans('messages.session:failure-mail-submission'));
                } else {
                    $submission['email_sent'] = true;
                    if ($submission->save()) {
                        Session::flash('mail-success', trans('messages.session:success-mail-submission'));
                    } else {
                        Session::flash('mail-failure', trans('messages.session:failure-mail-submission'));
                    }
                }
            } catch (\Throwable $th) {
                Session::flash('mail-service-error', trans('messages.session:service-error-mail-submission'));
            }
            Session::flash('success', trans('messages.session:success-update-submission'));
            return redirect()->route('admin.approvements.show', ['id' => $id]);
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
        $validator = $this->validateSubmission($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->attemptSubmission($request)) {
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
            'agency' => 'required|string|max:128',
            'phone-number' => 'required|string|max:32',
            'goal' => 'required|string|max:2048',
            'start-date' => 'required|date|after:today',
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
            'agency' => $request['agency'],
            'phone_number' => $request['phone-number'],
            'goal' => $request['goal'],
            'start_date' => $request['start-date'],
            'proposal_link' => $proposalLinkPath,
            'cover_letter_link' => $coverLetterLinkPath,
        ])->save();
    }
}
