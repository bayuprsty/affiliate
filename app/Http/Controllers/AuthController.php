<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Gate;
use Validator;
use Hash;
use Image;
use Mail;

use App\Gender;
use App\User;

use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function showLoginForm() {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('affiliate.dashboard');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($login)) {
            if (Auth::user()->email_confirmed == false) {
                Auth::logout();
                return redirect()->route('login')->with(['error' => 'Please Verify Your Email First']);
            }

            if (Gate::allows('isAdmin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('affiliate.dashboard');
            }
        }

        return redirect()->route('login')->with(['error' => 'Username/Email/Password salah']);
    }

    public function showregisterForm() {
        $gender = Gender::all();

        return view('auth.register', compact('gender'));
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:users',
            'ktp' => 'required',
            'foto_ktp' => 'sometimes|image|mimes:jpg,jpeg,png,svg|max:1024'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $value) {
                return $this->sendResponse($value[0], '', 221);
            }
        }

        $foto_ktp = $request->file('foto_ktp');
        $filename = $request->username.'.'.$foto_ktp->getClientOriginalExtension();

        Image::make($foto_ktp)->resize(300, 300)->save( public_path('uploads/avatar/'.$filename) );

        $data = [
            'username'      => $request->username,
            'password'      => bcrypt($request->password),
            'nama_depan'    => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'no_telepon'    => $request->no_telepon,
            'email'         => $request->email,
            'gender_id'     => $request->gender_id,
            'jalan'         => $request->jalan,
            'provinsi'      => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan'     => $request->kecamatan,
            'kodepos'       => $request->kodepos,
            'ktp'           => $request->ktp,
            'nama_bank'     => $request->nama_bank,
            'atasnama_bank' => $request->atasnama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'join_date'     => Carbon::NOW(),
            'avatar'        => $filename,
        ];

        $user = User::create($data);

        if ($user) {
            $data = [
                'link_verify' => route('auth.confirmation_success', $user->id)
            ];

            // Mail::to($user->email)->send(new VerifyEmail($linkEmail));
            Mail::send('auth.email.confirmation', $data, function($message) use ($user) {
                $message->to($user->email)->subject('Email Verification');
            });

            // return view('auth.verify', compact('id'));
            return redirect()->route('verify', $user->id);
        } else {
            return $this->sendResponse('Register Failed!', '', 221);
        }
    }

    public function verifyPage($id) {
        return view('auth.verify', compact('id'));
    }

    public function resendConfirmation(Request $request) {
        if ($request->ajax()) {
            $user = User::findOrfail($reqeust->id);

            if (isset($user)) {
                $data = [
                    'link_verify' => route('auth.confirmation_success', $user->id)
                ];
    
                // Mail::to($user->email)->send(new VerifyEmail($linkEmail));
                Mail::send('auth.email.confirmation', $data, function($message) use ($user) {
                    $message->to($user->email)->subject('Email Verification');
                });

                return $this->sendResponse('Email Verification Resend');
            }
        }
    }

    public function confirmationSuccess($id) {
        $user = User::findOrfail($id);

        $dataUpdate = [
            'email_confirmed' => 1,
            'email_verified_at' => Carbon::NOW(),
        ];

        $verified = $user->update($dataUpdate);

        if ($verified) {
            return redirect(route('login'))->with(['verified' => 'Thanks For Verify Your Email. You can Login NOW']);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
