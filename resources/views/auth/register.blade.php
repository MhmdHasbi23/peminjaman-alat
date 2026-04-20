<x-guest-layout>

<div class="min-h-screen flex items-center justify-center p-4 login-bg">

    <div class="login-card">

        {{-- LEFT PANEL (WELCOME BACK) --}}
        <div class="login-side">

            <div class="blur-circle top"></div>
            <div class="blur-circle bottom"></div>

            <div class="z-10 text-center">

                <h2 class="side-title">Welcome Back 👋</h2>

                <p class="side-text">
                    Sudah punya akun? Login untuk melanjutkan akses sistem peminjaman alat.
                </p>

                <a href="{{ route('login') }}" class="btn-outline">
                    Sign In
                </a>

            </div>

        </div>

        {{-- RIGHT FORM --}}
        <div class="login-form">

            <div class="text-center mb-8">
                <h1 class="title">Create Account</h1>
                <p class="subtitle">Silakan isi data diri Anda</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- NAME --}}
                <div>
                    <input id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="Full Name"
                        required autofocus
                        class="input-box">

                    @if ($errors->get('name'))
                        <p class="error-text">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- EMAIL --}}
                <div>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        required
                        class="input-box">

                    @if ($errors->get('email'))
                        <p class="error-text">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                {{-- PASSWORD --}}
                <div>
                    <input id="password" type="password" name="password"
                        placeholder="Password"
                        required
                        class="input-box">

                    @if ($errors->get('password'))
                        <p class="error-text">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div>
                    <input id="password_confirmation" type="password"
                        name="password_confirmation"
                        placeholder="Confirm Password"
                        required
                        class="input-box">
                </div>

                {{-- BUTTON --}}
                <div class="pt-4 flex justify-center">
                    <button type="submit" class="btn-primary">
                        Sign Up
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<style>

/* BACKGROUND */
.login-bg {
    background: linear-gradient(145deg, #0b1220, #0f172a);
}

/* CARD */
.login-card {
    display: flex;
    width: 100%;
    max-width: 900px;
    min-height: 520px;
    border-radius: 24px;
    overflow: hidden;
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}

/* LEFT SIDE (WELCOME BACK) */
.login-side {
    width: 50%;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    color: white;
    padding: 40px;
    text-align: center;
    overflow: hidden;
}

/* RIGHT FORM */
.login-form {
    width: 50%;
    padding: 50px;
    background: rgba(255,255,255,0.03);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* TEXT */
.title {
    font-size: 32px;
    font-weight: 800;
    color: #e2e8f0;
}

.subtitle {
    font-size: 13px;
    color: #94a3b8;
    margin-top: 6px;
}

/* INPUT */
.input-box {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.05);
    color: white;
    outline: none;
    transition: .2s;
}

.input-box:focus {
    border-color: #60a5fa;
    background: rgba(255,255,255,0.08);
}

/* ERROR */
.error-text {
    color: #f87171;
    font-size: 11px;
    margin-top: 5px;
}

/* BUTTON */
.btn-primary {
    background: #3b82f6;
    color: white;
    padding: 12px 40px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 1px;
    transition: .2s;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
}

/* OUTLINE */
.btn-outline {
    display: inline-block;
    border: 2px solid white;
    padding: 10px 28px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 12px;
    transition: .2s;
}

.btn-outline:hover {
    background: white;
    color: #1d4ed8;
}

/* TEXT SIDE */
.side-title {
    font-size: 34px;
    font-weight: 800;
    margin-bottom: 16px;
}

.side-text {
    font-size: 13px;
    opacity: 0.9;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* BLUR */
.blur-circle {
    position: absolute;
    width: 180px;
    height: 180px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    filter: blur(30px);
}

.blur-circle.top {
    top: -40px;
    right: -40px;
}

.blur-circle.bottom {
    bottom: -40px;
    left: -40px;
}

/* RESPONSIVE */
@media(max-width: 768px) {
    .login-card {
        flex-direction: column;
    }

    .login-form,
    .login-side {
        width: 100%;
    }

    .login-side {
        display: none;
    }
}

</style>

</x-guest-layout>