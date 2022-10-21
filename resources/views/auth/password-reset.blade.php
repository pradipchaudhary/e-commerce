@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset password') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        <form action="{{ route('resetpassword') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $user->email }}" name="email">
                            <input type="hidden" value="{{ $remember_token }}" name="remember_token">
                            <label for="password">{{ _('New password') }}</label>
                            <input type="password" name="password" class="form-control form-control-sm my-2" required>
                            @error('password')
                                <p class="text-danger mb-0">
                                    {{ $message }}
                                </p><br>
                            @enderror
                            <label for="password_confrimation">{{ _('Confirm password') }}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-sm my-2" required>
                            <button class="btn btn-dark my-2" type="submit">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
