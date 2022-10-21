@section('title', env('APP_NAME'))
@include('frontend.include.header')
@include('frontend.include.navbar')
<section id="app">
    <div class="container grading">
        <div class="row" id="app">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <h4 style="font-size: 1.1rem;color:black;" class="text-center">
                                        {{auth()->user()->name ." profile detail"}}
                                    </h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="text-right">Full name</td>
                                            <td class="text-left">{{$user->name." ".$user->last_name}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Email</td>
                                            <td class="text-left">{{$user->email}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Business name</td>
                                            <td class="text-left">{{$user->business_name}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Business No.</td>
                                            <td class="text-left">{{$user->userDetail->business_phone_number}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Whatsapp No.</td>
                                            <td class="text-left">{{$user->userDetail->whatsapp_number}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Country</td>
                                            <td class="text-left">{{$user->userDetail->Country->name_woc}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">State</td>
                                            <td class="text-left">{{$user->userDetail->State->name}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">City</td>
                                            <td class="text-left">{{$user->userDetail->City->name}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Street name</td>
                                            <td class="text-left">{{$user->userDetail->address}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">ZIP Code</td>
                                            <td class="text-left">{{$user->userDetail->postal_code}}</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-right">Document</td>
                                            <td class="text-left"><a href="{{asset('storage/upload/'.$user->userDetail->document)}}" target="_blank">Reseller certificate</a></td>
                                        </tr> 
                                    </table>
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
