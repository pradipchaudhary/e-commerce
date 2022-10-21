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
                            <table id="order_table" class="table table-bordered table-hover dataTable dtr-inline p-2"
                            aria-describedby="example2_info">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('Name') }}</th>
                                    <th class="text-center">{{ __('Your offer') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                           <tbody>
                                @foreach ($offers as $key => $offer)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="text-center">{{ $offer->Stock->Product->Manufacturer->name . ' ' . $offer->Stock->Product->name . ' ' . $offer->Stock->Color->name . ' ' . $offer->Stock->Status->name . ' ' . $offer->Stock->gradingScale->name . '-STOCK' }}</td>
                                        <td class="text-center">
                                            <span class="px-1">Quantity : </span> {{$offer->quantity}} <br>
                                            <span class="px-1">Price : </span> {{ '$'.$offer->price}} <s>{{$offer->Stock->price}}</s> <br>
                                        </td>
                                        <td class="text-center">
                                            @if ($offer->status == 0)
                                                <button class="btn-sm btn-danger btn">Rejected</button>
                                            @endif
                                            @if ($offer->status == 1)
                                                <button class="btn-sm btn-success btn" disabled>Accepted</button>
                                            @endif
                                            @if ($offer->status == 2)
                                                <button class="btn-sm btn-warning btn" disabled>Pending</button> 
                                            @endif
                                            @if ($offer->status == 3)
                                                <a href="{{route('cart.status.accept',$offer)}}" class="btn btn-sm text-white btn-success">Accept</a>
                                                <a href="{{route('cart.status.reject',$offer)}}" class="btn btn-sm text-white btn-danger mx-1">Reject</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                           </tbody>
                        </table>
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
