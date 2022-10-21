    @section('title', 'LOGIN')
    @include('frontend.include.header')
    @include('frontend.include.navbar')

    <section id="login">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center
            ">
                <div class="col-md-4">
                    <div class="login_form">
                        <h2> Welcome! </h2>
                        {{-- <img src="{{ asset('logo.jpg') }}" alt="" class="img-fluid"> --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" required autocomplete="current-password">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
    
                                <!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                        </form>
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
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script src="{{ asset('user/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $('.img-gallerys').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    </script>
    </body>

    </html>
