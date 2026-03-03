@extends('layouts.auth')

@section('left')
<img src="{{ asset('images/login-ecoride.png') }}" 
     alt="Electric Motorcycle" 
     class="w-full mb-6">
@endsection

@section('right')
<img src="{{ asset('images/logo-ecoride-login.png') }}" alt="Logo Ecoride" class=" mx-auto mb-10">

<img src="{{ asset('images/wa-verifikasi.png') }}" alt="Logo Ecoride" class="mx-auto mt-10">
<h3 class="text-2xl font-medium text-gray-800 mt-2 text-center">Masukkan Kode OTP</h3>
<p class="text-gray-500 mb-6 text-center">
    Kode verifikasi telah dikirimkan melalui WhatsApp ke nomor 
    <span class="font-semibold text-gray-800">
        {{ session('phone') }}
    </span>
</p>

<form action="{{ route('otp.verify') }}" method="POST" class="space-y-6" autocomplete="off">
    @csrf
  

    <div class="flex justify-center gap-6">
        @for ($i = 0; $i < 6; $i++)
            <input
                type="text"
                name="otp[]"
                maxlength="1"
                inputmode="numeric"
                pattern="\d*"
                class="otp-input w-10 h-10 text-center text-lg rounded border focus:outline-none focus:ring-2"
                data-index="{{ $i }}"
                required
                value="{{ old('otp.'.$i) ?? '' }}"
                @if(session('otp_error'))
                    style="border-color:#EB5757; background:#FDE2D3; color:#EB5757;"
                @else
                    style="border-color:#74788D; color:#000;"
                @endif
            >
        @endfor
    </div>

    {{-- Pesan error --}}
    <div id="errorMsg"
         role="alert"
         aria-live="assertive"
         class="mt-4 text-sm rounded p-3 {{ session('otp_error') ? '' : 'hidden' }}"
         style="color:#EB5757; background:#FDE2D3; border:1px solid rgba(235,87,87,0.15);">
        {{ session('otp_error') ?? 'Kode OTP Salah, harap periksa kembali kode OTP anda' }}
    </div>
    
    <button
        type="submit"
        id="submitBtn"
        class="w-full text-white py-2 rounded-lg transition hover:brightness-90 disabled:cursor-not-allowed"
        style="{{ session('otp_error') ? 'background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);' : 'background: #E0E0E0;' }}"
        @if(!session('otp_error')) disabled @endif
    >
        Masuk
    </button>
</form>

<p class="mt-6 text-center text-gray-500">
    <a href="{{ route('login') }}" class="text-grey-500 hover:underline">Batalkan</a>
</p>

<p class="mt-6 text-center text-gray-500">
    Tidak Mendapatkan kode verifikasi?
    <a href="{{ route('otp.resend') }}" 
       id="resendLink" 
       class="text-orange-500 hover:underline hidden">
       Kirim Ulang OTP
    </a>
    <span id="countdown" style="color:#FF6200; font-weight:500;"></span>
</p>


<p class="mt-16 text-center text-gray-400 text-sm">
    <a href="#" class="inline-flex items-center gap-2 hover:underline" style="color:#F37022;">
        <img src="{{ asset('images/hubungi-kami.png') }}" alt="Bantuan" class="w-5 h-5">
        Bantuan WooWEcoRide
    </a>
</p>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = Array.from(document.querySelectorAll('.otp-input'));
    const submitBtn = document.getElementById('submitBtn');
    const errorMsg = document.getElementById('errorMsg');

    let hasServerError = {!! json_encode(session('otp_error') ? true : false) !!};

    function setErrorState(on) {
        inputs.forEach(i => {
            if (on) {
                i.style.borderColor = '#EB5757';
                i.style.background = '#FDE2D3';
                i.style.color = '#EB5757';
            } else {
                styleInput(i); // reset sesuai isi kosong / terisi
            }
        });
        if (on) {
            errorMsg.classList.remove('hidden');
        } else {
            errorMsg.classList.add('hidden');
        }
    }

    function styleInput(input) {
        if (input.value.trim() !== '') {
            input.style.borderColor = '#FF8F00';
            input.style.color = '#FF8F00';
            input.style.background = '';
        } else {
            input.style.borderColor = '#74788D';
            input.style.color = '#000';
            input.style.background = '';
        }
    }

    function checkInputs() {
        const allFilled = inputs.every(i => i.value.trim() !== '');
        if (allFilled) {
            submitBtn.disabled = false;
            submitBtn.style.background = "linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%)";
        } else {
            submitBtn.disabled = true;
            submitBtn.style.background = "#E0E0E0";
        }
    }

    // inisialisasi awal
    if (hasServerError) {
        setErrorState(true);
    } else {
        inputs.forEach(styleInput);
        checkInputs();
    }

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value.length > 1) {
                input.value = input.value.slice(-1);
            }

            if (!hasServerError) {
                styleInput(input);
            }

            if (input.value.length === 1 && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }

            if (hasServerError) {
                hasServerError = false;
                setErrorState(false);
            }

            checkInputs();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value === '' && idx > 0) {
                inputs[idx - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/\D/g, '').slice(0, inputs.length).split('');
            digits.forEach((d, i) => {
                inputs[i].value = d;
                if (!hasServerError) {
                    styleInput(inputs[i]);
                }
            });
            if (digits.length > 0) {
                const nextIndex = Math.min(digits.length, inputs.length) - 1;
                inputs[nextIndex].focus();
            }
            if (hasServerError) {
                hasServerError = false;
                setErrorState(false);
            }
            checkInputs();
        });
    });
});


// resend otp


document.addEventListener('DOMContentLoaded', function () {
    let countdown = 60; // detik
    const countdownEl = document.getElementById('countdown');
    const resendLink = document.getElementById('resendLink');

    function updateCountdown() {
        if (countdown > 0) {
            countdownEl.textContent = `Kirim Ulang OTP dalam ${countdown} detik`;
            countdown--;
            setTimeout(updateCountdown, 1000);
        } else {
            countdownEl.textContent = "";
            resendLink.classList.remove('hidden'); // tampilkan link
        }
    }

    updateCountdown();
});
</script>
@endsection
