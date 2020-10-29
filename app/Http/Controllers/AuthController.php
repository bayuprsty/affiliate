<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Gate;
use Validator;
use Hash;

use App\Gender;
use App\User;

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

        if (auth()->attempt($login)) {
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:3',
                'password' => 'required|confirmed',
                'email' => 'required|email|unique:users',
                'ktp' => 'required',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    return $this->sendResponse($value[0], '', 221);
                }
            }

            $data = [
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'gender_id' => $request->gender_id,
                'jalan' => $request->jalan,
                'provinsi' => $request->provinsi,
                'kabupaten_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'kodepos' => $request->kodepos,
                'ktp' => $request->ktp,
                'nama_bank' => $request->nama_bank,
                'atasnama_bank' => $request->atasnama_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'join_date' => Carbon::NOW(),
            ];

            $user = User::create($data);

            if ($user) {
                return $this->sendResponse('User Affiliate Created Successfully');
            } else {
                return $this->sendResponse('Register Failed!', '', 221);
            }
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
