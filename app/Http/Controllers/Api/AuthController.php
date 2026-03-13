<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use App\Models\Student;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            // 'password' => 'required|confirmed'
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Username atau password tidak sesuai'], 400);
        }

        $user = auth()->user();

        // JIKA USER MERCHANT, TAMBAHKAN URL LOGO KE PROFILE_PHOTO
        if ($user->merchant && $user->merchant->logo) {
            $user->profile_photo = url($user->merchant->logo);
        }

        // STORE DEVICE TOKEN
        if ($request->has('device_token')) {
            $deviceToken = $request->input('device_token');
            User::where('id', $user->id)->update(['device_token' => $deviceToken]);
        }

        // JIKA USER SELAIN MERCHANT, TAMBAHKAN URL LOGO KE PROFILE_PHOTO
        if (!$user->merchant && $user->profile_photo) {
            $user->profile_photo = url($user->profile_photo);

            // get nis anak
            $user_id = $user->id;
            $parent = Parents::where('user_id', $user_id)->first(); // ambil parent
            if ($parent) {
                $student = Student::where('parent_id', $parent->id)->first(); // ambil student
                if ($student) {
                    $user->nis = $student->nis; // tambahkan nis ke response
                }
            }
        }

        // $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $accessToken = $user->createToken('authToken')->plainTextToken;
        // $user = User::where('email', $request->email)->first();
        // $accessToken = $user->createToken('auth-token')->plainTextToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email tidak terdaftar'
            ], 404);
        }

        $otp = rand(10000, 99999);

        PasswordResetOtp::create([
            'email' => $user->email,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(10)
        ]);

        Mail::raw("OTP reset password anda: $otp", function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject('Reset Password OTP');
        });

        return response()->json([
            'message' => 'OTP berhasil dikirim'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $otp = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'OTP salah'], 400);
        }

        if (now()->gt($otp->expired_at)) {
            return response()->json(['message' => 'OTP kadaluarsa'], 401);
        }

        return response()->json(['message' => 'OTP valid']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $otp = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otp || now()->gt($otp->expired_at)) {
            return response()->json([
                'message' => 'OTP tidak valid'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // tandai otp sudah dipakai
        $otp->update([
            'is_used' => true
        ]);

        // jika pakai sanctum
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password berhasil direset'
        ]);
    }

    public function refreshToken(Request $request)
    {

        $user = $request->user();


        // hapus token lama yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        // buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token berhasil diperbarui',
            'token' => $token,
        ]);
    }
}
