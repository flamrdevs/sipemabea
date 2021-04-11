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

// Helper
use Helper;

// Model
use App\Submission;

class ApprovementController extends Controller
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
            $submissions = Submission::whereIn('status', ['accepted', 'rejected'])->whereMonth('created_at', Carbon::parse($monthQuery)->format('m'))->latest()->get();
        } else {
            $submissions = Submission::whereIn('status', ['accepted', 'rejected'])->latest()->paginate($this->paginate);
        }

        return view('admin.approvements.index', compact(['submissions', 'monthQuery']));
    }

    // GET
    public function admin_show($id)
    {
        $submission = Submission::where('id', $id)->whereIn('status', ['accepted', 'rejected'])->latest()->firstOrFail();
        $isEmailSent = $submission['email_sent'];
        return view('admin.approvements.show', compact(['submission', 'isEmailSent']));
    }

    // GET
    public function admin_previewApprovalMail($id)
    {
        $submission = Submission::where('id', $id)->where(function ($query) {
            $query->where('email_sent', false)->orWhereNull('email_sent');
        })->whereIn('status', ['accepted', 'rejected'])->firstOrFail();

        $text = $submission['note'];

        // if (is_null($submission['note'])) {
        //     $templateEmailApproval = Helper::getStaticJson()['template']['email']['approval'];

        //     $text = $submission['status'] == 'accepted' ? $templateEmailApproval['accepted'] : $templateEmailApproval['rejected'];
        // } else {
        //     $text = $submission['note'];
        // }

        return view('admin.approvements.mail-preview', compact(['submission', 'text']));
    }

    // PUT
    public function admin_sendApprovalMail(Request $request, $id)
    {
        $submission = Submission::where('id', $id)->where(function ($query) {
            $query->where('email_sent', false)->orWhereNull('email_sent');
        })->whereIn('status', ['accepted', 'rejected'])->firstOrFail();

        $user = [
            'name' => $submission['person_in_charge'],
            'email' => $submission['email']
        ];

        $data = [
            'name' => $user['name'],
            'from' => config('mail.from'),
            'attachmentLink' => $submission['attachment_link'],
            'note' => $submission['note'],
        ];

        // return new ApprovalMail($data);

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
    }
}
