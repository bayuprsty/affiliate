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

use App\Models\Gender;
use App\Models\User;

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
            'foto_ktp' => 'sometimes|image|mimes:jpg,jpeg,png,svg|max:10240'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $value) {
                return $this->sendResponse($value[0], '', 221);
            }
        }

        $foto_ktp = $request->file('foto_ktp');
        $filename = $request->username.'.'.$foto_ktp->getClientOriginalExtension();

        Image::make($foto_ktp)->resize(300, 300)->save( public_path('uploads/avatar/'.$filename) );

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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
            'code_verify'   => substr(str_shuffle($permitted_chars), 0, 30),
            'saldo_awal'    => 50000,
        ];

        $user = User::create($data);

        if ($user) {
            $data = [
                'nama_lengkap' => $user->nama_depan.' '.$user->nama_belakang,
                'link_verify' => route('auth.confirmation_success').'?id='.$user->id.'&code='.$user->code_verify
            ];
            
            Mail::send(['html' => 'auth.email.confirmation'], $data, function($message) use ($user) {
                $message->to($user->email)->subject('Email Verification');
            });

            $data = [
                'id' => $user->id,
                'code_verify' => $user->code_verify,
                'link' => route('verify').'?id='.$user->id.'&code='.$user->code_verify,
            ];

            return $this->sendResponse('Register Successfully', $data);
        } else {
            return $this->sendResponse('Register Failed!', '', 221);
        }
    }

    public function verifyPage(Request $request) {
        $id = $request->id;
        $code_verify = $request->code;

        return view('auth.verify', compact('id', 'code_verify'));
    }

    public function resendConfirmation(Request $request) {
        if ($request->ajax()) {
            $findUser = User::where(['id' => $request->id, 'code_verify' => $request->verify_code])->get();

            if (count($findUser) > 0) {
                $user = $findUser[0];

                $data = [
                    'nama_lengkap' => $user->nama_depan.' '.$user->nama_belakang,
                    'link_verify' => route('auth.confirmation_success').'?id='.$user->id.'&code='.$user->code_verify
                ];
    
                Mail::send(['html' => 'auth.email.confirmation'], $data, function($message) use ($user) {
                    $message->to($user->email)->subject('Email Verification');
                });

                return $this->sendResponse('Email Verification Resend');
            }
        }
    }

    public function confirmationSuccess(Request $request) {
        $user = User::where(['id' => $request->id, 'code_verify' => $request->code])->first();

        $dataUpdate = [
            'email_confirmed' => 1,
            'email_verified_at' => Carbon::NOW(),
        ];

        $verified = $user->update($dataUpdate);
        $nama_lengkap = $user->nama_depan.' '.$user->nama_belakang;

        if ($verified) {
            return view('auth.verify_success', compact('nama_lengkap'));
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgot() {
        return view('auth.passwords.confirm');
    }

    public function sendForgotPassword(Request $request) {
        if ($request->ajax()) {
            $user = User::where('email', $request->email)->first();
            
            if (is_null($user)) {
                return $this->sendResponse("Email Not Registered", [], 401);
            }

            $data = [
                'nama_lengkap' => $user->nama_depan.' '.$user->nama_belakang,
                'link_reset' => route('reset.password').'?id='.$user->id.'&code='.$user->code_verify
            ];

            Mail::send(['html' => 'auth.email.reset'], $data, function($message) use ($user) {
                $message->to($user->email)->subject('Email Reset Password');
            });

            return $this->sendResponse('Email Reset Password has been sent. Please Check your email');
        }
    }

    public function resetPassword(Request $request) {
        $id = $request->id;
        $code_verify = $request->code;

        return view('auth.passwords.reset', compact('id', 'code_verify'));
    }

    public function resetSave(Request $request) {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    return $this->sendResponse($value[0], '', 401);
                }
            }

            $user = User::where(['id' => $request->id, 'code_verify' => $request->code_verify])->first();
            
            if (is_null($user)) {
                return $this->sendResponse('Cannot Reset Password. User not Found', [], 500);
            }

            $data = [
                'password' => bcrypt($request->password)
            ];

            $isUpdated = $user->update($data);

            if ($isUpdated) {
                return $this->sendResponse('Password Reset Succesfully');
            } else {
                return $this->sendResponse('Reset Password Failed');
            }
        }
    }
}
