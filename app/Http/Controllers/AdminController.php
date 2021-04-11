<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Laravel
use Auth;
use Carbon\Carbon;
use Hash;
use Session;
use Validator;

// Model
use App\Submission;
use App\User;

class AdminController extends Controller
{
    // =======================|                          |=======================  //
    // =======================|     MINIMAL ANALYTIC     |=======================  //
    // =======================|                          |=======================  //

    // GET
    public function index()
    {
        $submissions = Submission::all();

        $data = [
            'unread' => $submissions->filter(function ($submission) {
                return is_null($submission['status']);
            }),
            'processed' => $submissions->filter(function ($submission) {
                return $submission['status'] === 'processed';
            }),
            'rejected' => $submissions->filter(function ($submission) {
                return $submission['status'] === 'rejected';
            }),
            'accepted' => $submissions->filter(function ($submission) {
                return $submission['status'] === 'accepted';
            }),
        ];

        return view('admin.index', compact('data'));
    }

    // =======================|                 |=======================  //
    // =======================|     PROFILE     |=======================  //
    // =======================|                 |=======================  //

    // GET
    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('admin.settings.profile', compact('user'));
    }

    // GET
    public function showProfileUpdateForm()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('admin.settings.edit', compact('user'));
    }

    // PUT
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'email' => 'required|email|max:128|unique:users,email,'.Auth::user()->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::user()->id);

        $user['name'] = $request['name'];
        $user['email'] = $request['email'];

        if ($user->save()) {
            Session::flash('success', trans('messages.session:success-update-profile'));
            return redirect()->route('admin.profile');
        } else {
            Session::flash('failure', trans('messages.session:failure-server-error'));
            return redirect()->route('admin.profile');
        }
    }

    // GET
    public function showProfileUpdatePasswordForm()
    {
        return view('admin.settings.edit-password');
    }

    // PUT
    public function profileUpdatePassword(Request $request)
    {   
        $regex = 'regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/';
        $validator = Validator::make($request->all(), [
            'current-password' => 'required|string|min:8|max:16',
            'new-password' => 'required|string|min:8|max:16|'.$regex.'|different:current-password',
            'new-password-confirmation' => 'required|string|'.$regex.'|same:new-password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request['current-password'], $user['password'])) {
            Session::flash('failure', trans('messages.session:failure-current-password'));
            Session::flash('failure-current-password');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user['password'] = Hash::make($request['new-password']);

        if ($user->save()) {
            Session::flash('success', trans('messages.session:success-update-password'));
            return redirect()->route('admin.profile');
        } else {
            Session::flash('failure', trans('messages.session:failure-server-error'));
            return redirect()->route('admin.profile');
        }
    }

    // =======================|                 |=======================  //
    // =======================|     SETTING     |=======================  //
    // =======================|                 |=======================  //

    // GET
    public function settings()
    {
        return view('admin.settings.index');
    }

    // =======================|                  |=======================  //
    // =======================|     SCHEDULE     |=======================  //
    // =======================|                  |=======================  //

    // GET
    public function schedules(Request $request)
    {
        $monthQuery = $request->query('month') ?? Carbon::today()->format('Y-m');
        $monthGroupType = $request->query('group') ?? "1";

        $allowedMonthGroupType = [
            '1' => 'created_at',
            '2' => 'start_date',
        ];

        $selectedMonthGroupType = $allowedMonthGroupType[$monthGroupType];

        $submissions = Submission::where(function ($query) {
            $query->where('status', '!=', 'rejected')->orWhereNull('status');
        })->whereMonth($selectedMonthGroupType, Carbon::parse($monthQuery)->format('m'))->latest()->get();

        $selectedDate = Carbon::parse($monthQuery);

        $date = $selectedDate->copy();

        $startOfMonth = $date->startOfMonth();
        $daysInMonth = $date->daysInMonth;

        $header = collect(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'])->map(function ($head) {
            return [
                'type' => 'header',
                'value' => $head,
            ];
        });

        $month = [$header];

        $firstEmpty = $date->format('N') - 1;
        $mod = ($firstEmpty+$daysInMonth)%7;
        $lastEmpty = abs(7 - ($mod == 0 ? 7 : $mod));

        $date->subDays($firstEmpty);
        $fullDays = $firstEmpty + $daysInMonth + $lastEmpty;

        $totalSubmissionsInMonth = [
            'processed' => 0,
            'accepted' => 0,
        ];
        $weeksInMonth = $fullDays/7;
        for ($week=0; $week < $weeksInMonth; $week++) {
            $thisWeek = [];
            for ($day=0; $day < 7; $day++) {
                $thisDay = [
                    'type' => 'date',
                    'value' => [
                        'date' => $date->copy(),
                        'date-string' => $date->copy()->format('Y-m-d'),
                        'is-selected' => $date->copy()->format('m') == $selectedDate->format('m'),
                        'submissions' => [
                            'processed' => $submissions->filter(function ($submission) use($date, $selectedMonthGroupType) {
                                return (Carbon::parse($submission[$selectedMonthGroupType])->format('dmY') == $date->copy()->format('dmY')) && ($submission['status'] == 'processed' || is_null($submission['status']));
                            })->values()->map(function ($submission) {
                                $submission['url'] = route('admin.submissions.show', ['id' => $submission['id']]);
                                return $submission;
                            }),
                            'accepted' => $submissions->filter(function ($submission) use($date, $selectedMonthGroupType) {
                                return (Carbon::parse($submission[$selectedMonthGroupType])->format('dmY') == $date->copy()->format('dmY')) && ($submission['status'] == 'accepted');
                            })->values()->map(function ($submission) {
                                $submission['url'] = route('admin.approvements.show', ['id' => $submission['id']]);
                                return $submission;
                            }),
                        ],
                    ],
                ];
                $totalSubmissionsInMonth['processed'] = $totalSubmissionsInMonth['processed'] + count($thisDay['value']['submissions']['processed']);
                $totalSubmissionsInMonth['accepted'] = $totalSubmissionsInMonth['accepted'] + count($thisDay['value']['submissions']['accepted']);
                array_push($thisWeek, $thisDay);
                $date->addDays();
            }
            array_push($month, $thisWeek);
        }
        
        return view('admin.schedules.index', compact(['month', 'monthQuery', 'monthGroupType', 'totalSubmissionsInMonth']));
    }
}
