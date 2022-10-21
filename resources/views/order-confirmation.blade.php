@section('title', 'Order confirmation')
@include('frontend.include.header')
@include('frontend.include.navbar')
<section id="breadcrumb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="breadcrumb">
                    <h1> Shipping </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="app" class="">
    <div class="container">
        <div class="col-12">
            <form method="POST" class="shipping-form" action="#">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mb-4">Your Product Detail</h4>
                        <table class="table">
                            <tr>
                                <th> Product List </th>
                                <th class="qty"> Qty </th>
                                <th class="price"> Rate </th>
                                <th class="price"> Price </th>
                            </tr>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->Stock->Product->Manufacturer->name . ' ' . $cart->Stock->Product->name . ' ' . $cart->Stock->Color->name . ' ' . $cart->Stock->Status->name . ' (#' . $cart->Stock->product_no . ')' }}
                                    </td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ " $" . $cart->Stock->price }}</td>
                                    <td>{{ " $" . $cart->Stock->price * $cart->quantity }}</td>
                                </tr>
                            @endforeach
                            @foreach ($offers as $offer)
                                <tr>
                                    <td>{{ $offer->Stock->Product->Manufacturer->name . ' ' . $offer->Stock->Product->name . ' ' . $offer->Stock->Color->name . ' ' . $offer->Stock->Status->name . ' (#' . $offer->Stock->product_no . ')' }} (Offer)
                                    </td>
                                    <td>{{ $offer->quantity }}</td>
                                    <td>{{ " $" . $offer->price }}</td>
                                    <td>{{ " $" . $offer->price * $offer->quantity}}</td>
                                </tr>
                            @endforeach
                            <tr class="total">
                                <td colspan="3"> <b> Delivery Charge </b> </td>
                                <td>{{ "$" . $delivery_charge }}
                                <td>
                            </tr>
                            <tr class="total">
                                <td colspan="3"> <b> Insurance </b> </td>
                                <td>{{ "$" . $insurance_charge . ' (' . $insurance->percent . '%)' }}
                                <td>
                            </tr>
                            <tr class="total">
                                <td colspan="3"> <b> Total </b> </td>
                                <td> {{ "$" . $total_sum }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="any-query">
                            <h5> Note : </h5>
                            <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                        </div>
                    </div>

                </div>

                <div class="button-box">
                    <button class="btn btn-primary" type="submit"
                        onclick="return confirm('Are you sure you want to continue ?');">{{ __('Continue ') }}</button>
                </div>

            </form>
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
<script>
    new Vue({
        el: "#app",
        data: {

        },
        methods: {

        },
        mounted() {}
    });
</script>
</body>

</html>
