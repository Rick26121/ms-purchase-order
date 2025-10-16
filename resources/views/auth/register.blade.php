<x-guest-layout>
    <head>
        <title>Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Assets ubicados en /public/assets -->
        <link rel="icon" type="image/png" href="{{ asset('assets/images/icons/favicon.ico') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animate/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    </head>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('assets/images/favicon.png') }}" alt="IMG">
                </div>

                {{-- 🔹 FORMULARIO DE REGISTRO FUNCIONAL --}}
                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <span class="login100-form-title">
                        {{ __('Registrar Usuario') }}
                    </span>

                    {{-- 🔸 MENSAJES DE ERROR --}}
                    <x-validation-errors class="mb-4" />

                    {{-- 🔸 NOMBRE --}}
                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <input class="input100" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Full Name') }}" required autofocus autocomplete="name">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    {{-- 🔸 EMAIL --}}
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    {{-- 🔸 CONTRASEÑA --}}
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" required autocomplete="new-password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    {{-- 🔸 CONFIRMAR CONTRASEÑA --}}
                    <div class="wrap-input100 validate-input" data-validate="Confirm password is required">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </span>
                    </div>

                    {{-- 🔸 TÉRMINOS Y POLÍTICA (opcional Jetstream) --}}
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="text-start mt-3">
                            <label class="text-gray-700 text-sm">
                                <input type="checkbox" name="terms" id="terms" required>
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-primary">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-primary">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </label>
                        </div>
                    @endif

                    {{-- 🔸 BOTÓN REGISTRARSE --}}
                    <div class="container-login100-form-btn mt-4">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Register') }}
                        </button>
                    </div>

                    {{-- 🔸 ENLACE A LOGIN --}}
                    <div class="text-center p-t-12">
                        <span class="txt1">{{ __('Already registered?') }}</span>
                        <a class="txt2" href="{{ route('login') }}">
                            {{ __('Login here') }}
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({ scale: 1.1 })
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</x-guest-layout>
