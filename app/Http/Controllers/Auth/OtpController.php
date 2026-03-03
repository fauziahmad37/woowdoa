<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function showForm() {
        return view('auth.otp');
    }

    public function verify(Request $request) {
        $request->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'digits:1'
        ]);

        $otp = implode('', $request->otp);
        $phone = $request->session()->get('phone');

        if(!$phone){
            return redirect()->route('login')->withErrors(['login'=>'Session OTP tidak ditemukan']);
        }

        $response = Http::post('http://103.181.243.156:3001/api/verify-user-otp', [
            'phone' => $phone,
            'otp' => $otp,
            'dataMitra' => new \stdClass()
        ]);

        $data = $response->json();
//   dd([
//             'otp_input' => $otp,
//             'phone_session' => $phone,
//             'http_status' => $response->status(),
//             'response_body' => $response->body(),
//             'response_json' => $data,
//         ]);


$user = User::where('phone', $phone)->first();

if (!$user) {
    return redirect()->route('login')->withErrors([
        'phone' => 'Nomor HP belum terdaftar, silakan hubungi admin.'
    ]);
}

Auth::login($user);
$request->session()->forget('phone');
$request->session()->put('accessToken', $data['accessToken'] ?? null);

return redirect()->route('dashboard')->with('status','Berhasil login dengan OTP.');



        // if(isset($data['success']) && $data['success']===true){
        //     $user = User::firstOrCreate(
        //         ['phone'=>$phone],
        //         ['name'=>$data['data']['name'] ?? 'User '.$phone, 'email'=>$data['data']['email'] ?? null]
        //     );

        //     Auth::login($user);
        //     $request->session()->forget('phone');
        //     $request->session()->put('accessToken', $data['accessToken'] ?? null);

        //     return redirect()->route('dashboard')->with('status','Berhasil login dengan OTP.');
        // }

    return back()
    ->withInput()
    ->with('otp_error', 'Kode OTP Salah, harap periksa kembali kode OTP anda');


    }


    // OtpController.php
public function resend(Request $request)
{
    $phone = $request->session()->get('phone');
    if (!$phone) {
        return redirect()->route('login')->withErrors(['login'=>'Session OTP tidak ditemukan']);
    }

    // Call API kirim ulang OTP
    $response = Http::post('http://103.181.243.156:3001/api/user-send-otp', [
        'no_hp' => $phone,
    ]);

    $data = $response->json();

    return back()->with('status', $data['message'] ?? 'OTP baru telah dikirim.');
}

}
