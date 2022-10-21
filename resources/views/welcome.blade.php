@section('title', env('APP_NAME'))
@include('frontend.include.header')
@include('frontend.include.navbar')

{{-- <section id="breadcrumb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="breadcrumb">
                    <h1> Our grading Scale: Precisely Defined </h1>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<section id="app">
    <div class="container grading">
        @foreach ($grades as $key => $grade)
            <div class="row">
                <div class="col-md-12">
                    <div class="grading-head">
                        <div class="title-sec">
                            <h4> {{ $grade->name }} (
                                @foreach ($grade->gradingScale as $key => $gradingScale)
                                    @if ($loop->last)
                                        {{ $gradingScale->name }}
                                    @else
                                        {{ $gradingScale->name . ',' }}
                                    @endif
                                @endforeach
                                )
                            </h4>
                            <p> {!! $grade->description !!} </p>
                        </div>
                        <div class="shipped-by">
                            <p> Shipped by : </p>
                            <img src="{{ asset('logo.jpg') }}" alt="" class="logo">
                        </div>
                    </div>
                    @foreach ($grade->gradingScale as $gradingScale)
                        {{-- grading item --}}
                        <div class="grading_item">
                            <div class="name">
                                <h1> {{ $gradingScale->name }} </h1>
                            </div>
                            <div class="description">
                                @if ($gradingScale->apperance != null)
                                    <div class="apperance"><b> A1 apperance: </b> <span>
                                            {{ $gradingScale->apperance }}
                                        </span>
                                    </div>
                                @endif
                                @if ($gradingScale->screen != null)
                                    <div class="screen"><b> Screen: </b> <span> {!! $gradingScale->screen !!} </span>
                                    </div>
                                @endif

                                @if ($gradingScale->bezel != null)
                                    <div class="housing"><b> Housing/bezel: </b> <span>
                                            {!! $gradingScale->bezel !!}</span></div>
                                @endif
                                @if ($gradingScale->other != null)
                                    <div class="other"><b> Other : </b> <span> {!! $gradingScale->other !!}</span>
                                    </div>
                                @endif
                                @if ($gradingScale->functionality != null)
                                    <div class="functionality"><b> Functionality : </b> <span>
                                            {!! $gradingScale->functionality !!}</span></div>
                                @endif
                                @if ($gradingScale->lcd != null)
                                    <div class="lcd"><b> LCD : </b> <span> {!! $gradingScale->lcd !!}</span>
                                    </div>
                                @endif
                                <div class="img-gallerys">
                                    @foreach ($gradingScale->images as $image)
                                        <a class="gimg" href="{{ asset('storage/thumbnails/' . $image->name) }}">
                                            <img src="{{ asset('storage/thumbnails/' . $image->name) }}"
                                                alt="Mobile Image ">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
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
