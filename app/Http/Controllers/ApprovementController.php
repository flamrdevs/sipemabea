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

class ApprovementController extends Controller
{
    // =======================|               |=======================  //
    // =======================|     ADMIN     |=======================  //
    // =======================|               |=======================  //

    private $paginate = 2;

    // GET
    public function admin_index(Request $request)
    {
        $dateQuery = $request->query('date');

        $submissions = null;

        if (isset($dateQuery)) {
            $submissions = Submission::whereIn('status', ['accepted', 'rejected'])->where('start_date', Carbon::parse($dateQuery))->latest()->get();
        } else {
            $submissions = Submission::whereIn('status', ['accepted', 'rejected'])->latest()->paginate($this->paginate);
        }

        return view('admin.approvements.index', compact(['submissions', 'dateQuery']));
    }

    // GET
    public function admin_show($id)
    {
        $submission = Submission::where('id', $id)->whereIn('status', ['accepted', 'rejected'])->latest()->firstOrFail();
        $isEmailSent = $submission['email_sent'];
        return view('admin.approvements.show', compact(['submission', 'isEmailSent']));
    }

    // PUT
    public function admin_resendApprovalMail(Request $request, $id) {
        $submission = Submission::where('id', $id)->whereIn('status', ['accepted', 'rejected'])->latest()->firstOrFail();

        $user = [
            'name' => $submission['person_in_charge'],
            'email' => $submission['email']
        ];

        $data = [
            'name' => $user['name'],
            'from' => config('mail.from'),
            'attachmentLink' => $submission['attachment_link'],
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
        return redirect()->route('admin.approvements.show', ['id' => $id]);
    }
}
