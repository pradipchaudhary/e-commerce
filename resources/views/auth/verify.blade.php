@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('please check your email for a verification code.') }}
                    {{-- {{ __('If you did not receive the email') }}, --}}
                    <form action="{{route('verifyEmail')}}" method="post">
                        @csrf
                        <input type="number" name="remember_token" class="form-control form-control-sm my-2" required>
                        <button class="btn btn-dark my-2">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
