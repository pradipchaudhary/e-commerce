@section('title', env('APP_NAME'))
@include('frontend.include.header')
@include('frontend.include.navbar')
<section id="app">
    <div class="container grading">
        <div class="row" id="app">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="color: black;">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="font-size: 1.1rem;color:black;" class="text-center">
                                    {{ ' Change password' }}
                                </h4>
                                <form method="POST" action="{{ route('user.dashboard.change_password_submit') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 my-3">
                                            <label for="old_password" style="font-weight: 400">{{ __('Old Password') }}
                                                <span class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input type="password" class="form-control" id="old_password"
                                                        name="old_password" required>
                                                </div>
                                            </div>
                                            @error('old_password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <label for="new_password" style="font-weight: 400">{{ __('New Password') }}
                                                <span class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input type="password" class="form-control" id="new_password"
                                                        name="new_password" required>
                                                </div>
                                            </div>
                                            @error('new_password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="col-md-4 my-3">
                                            <label for="confirm_password"
                                                style="font-weight: 400">{{ __('Confrim password') }}
                                                <span class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input type="password" class="form-control" id="confirm_password"
                                                        name="confirm_password" required>
                                                </div>
                                            </div>
                                            @error('confirm_password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <button class="btn btn-primary"
                                                    type="submit">{{ __('Change password') }}</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('frontend.include.footer')
<!-- JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('user/assets/js/main.js') }}"></script>
<script src="{{ asset('user/assets/js/jquery.magnific-popup.min.js') }}"></script>

</html>
