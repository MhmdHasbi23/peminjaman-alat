<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen p-4 bg-[#eef2f3]">
        <div
            class="flex flex-col md:flex-row-reverse w-full max-w-[850px] bg-white rounded-[40px] shadow-2xl overflow-hidden min-h-[600px]">

            <div class="w-full md:w-1/2 p-10 md:p-14 flex flex-col justify-center bg-white">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Create Account</h1>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Silakan isi data diri Anda:
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                            required autofocus autocomplete="name"
                            class="w-full px-5 py-3 bg-[#f0f0f0] border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        @if ($errors->get('name'))
                        <p class="text-red-500 text-[10px] mt-1 ml-2">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Email Address" required autocomplete="username"
                            class="w-full px-5 py-3 bg-[#f0f0f0] border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        @if ($errors->get('email'))
                        <p class="text-red-500 text-[10px] mt-1 ml-2">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <input id="password" type="password" name="password" placeholder="Password" required
                            autocomplete="new-password"
                            class="w-full px-5 py-3 bg-[#f0f0f0] border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        @if ($errors->get('password'))
                        <p class="text-red-500 text-[10px] mt-1 ml-2">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="Confirm Password" required
                            class="w-full px-5 py-3 bg-[#f0f0f0] border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>

                    <div class="pt-6 flex justify-center">
                        <button type="submit"
                            class="px-14 py-3 bg-indigo-700 text-white font-bold rounded-full shadow-lg hover:bg-indigo-800 active:scale-95 transition-all text-sm uppercase tracking-widest">
                            Sign Up
                        </button>
                    </div>
                </form>
            </div>

            <div
                class="hidden md:flex w-1/2 bg-gradient-to-br from-[#5c4ae2] to-[#8d49f8] p-12 text-white flex-col items-center justify-center text-center relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full"></div>
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-white/10 rounded-full"></div>

                <div class="relative z-10">
                    <h2 class="text-4xl font-bold mb-6">Welcome Back!</h2>
                    <p class="text-sm leading-relaxed mb-10 font-light opacity-90">
                        Sudah punya akun? Tetap terhubung dengan kami dengan login menggunakan akun lama Anda.
                    </p>

                    <a href="{{ route('login') }}"
                        class="px-12 py-3 border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-indigo-700 transition-all text-sm uppercase tracking-widest">
                        Sign In
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>