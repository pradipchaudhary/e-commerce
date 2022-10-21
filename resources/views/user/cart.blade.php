@section('title', 'Cart')
@include('frontend.include.header')
@include('frontend.include.navbar')

<section id="app" class="mt-4">
    <div class="container">
        <div class="row">
            <!-- Side Filter -->
            <div class="col-md-8">
                <div class="main_content cart">
                    <h4 class="title"> Product List </h4>
                    <div class="cart_item product_list">
                        <table class="table borderless" v-for="(cart,key) in carts">
                            <tr>
                                <td class="cart_name">
                                    @{{ cart.stock.product.manufacturer.name + ' ' + cart.stock.product.name + ' ' + cart.stock.color.name + ' ' + cart.stock.status.name + ' ' + cart.stock.grading_scale.name + '-STOCK' }}
                                    <span class="text-muted" v-text="'(#'+cart.stock.product_no+')'"></span> <span
                                        class="text-danger" v-if="cart.stock.quantity == 0">Out of stock</span>
                                </td>
                                <td class="quantity">
                                    Qty <span v-if="cart.stock.quantity > 0">
                                        <span class="p-btn">
                                            <i class="fa-solid fa-minus px-1" v-on:click="decreementQuantity(key)"></i>
                                        </span>
                                        <span class="p-value" :id="'quantity' + cart.id">@{{ cart.quantity }}</span>
                                        <span class="p-btn" v-on:click="incrementQuantity(key)">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </span></td>
                                <td class="price"> Price <span v-if="cart.stock.quantity > 0">
                                        @{{ '$' + cart.stock.price }} </span></td>
                                <td class="trash">
                                    <span>
                                        <i class="fa-solid fa-circle-xmark" v-on:click="removeCart(cart.id)"></i>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <div class="offer-item mt-4" v-for="(offer,key) in offers">
                            <div class="item-name">
                                @{{ offer.stock.product.manufacturer.name + ' ' + offer.stock.product.name + ' ' + offer.stock.color.name + ' ' + offer.stock.status.name + ' ' + offer.stock.grading_scale.name + '-STOCK' }}
                            </div>
                            <span class="item-number"> Item # @{{ offer.stock.product_no }} </span>
                            <div class="ap"> Avail : @{{ offer.stock.quantity }} <span class="price">
                                    Price : $@{{ offer.stock.price }} </span>
                            </div>
                            <div class="offer"><b> You Offered </b>
                                <div class="ap"> Qty : @{{ offer.quantity }} <span class="price">
                                        Price : $ <s v-if="offer.offer_prev_price_log.length"
                                            v-text="offer.offer_prev_price_log.length ? (offer.offer_prev_price_log[0].price == offer.price ? '': offer.offer_prev_price_log[0].price) : ''"></s>
                                        @{{ offer.price }}</span>
                                </div>
                            </div>
                            <span class="close" v-on:click="removeOffer(offer.id)"> <i
                                    class="fa-solid fa-circle-xmark"></i> </span>

                            <div class="status"> Status : <span> @{{ offer.status == 0 ? 'REJECTED' : (offer.status == 1 ? 'ACCEPTED' : (offer.status == 3 ? 'COUNTERED' : 'PENDING')) }} </span></div>
                            <div class="status" v-if="offer.status == 3">
                                <a v-on:click="acceptOffer(offer)" class="btn btn-success btn-sm">Accept</a>
                                <a v-on:click="rejectOffer(offer)" class="btn btn-danger btn-sm">Reject</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-4" id="total_div">
                <div class="main_content order_summary">
                    <h4 class="title"> Order Summary </h4>
                    <div class="total">
                        <div class="total_title">Total </div>
                        <div class="total_price" v-text=" '$'+cart_sum"></div>
                    </div>
                    <button v-on:click="checkout()" id="checkout"> Checkout </button>
                </div>
            </div>
        </div>
    </div>
</section>
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
            carts: @json($carts),
            cart_sum: @json($cart_sum),
            offers: @json($offers)
        },
        methods: {
            removeCart: function(cart_id) {
                if (confirm('Are you sure you want to remove from your cart ?')) {
                    axios.post("{{ route('cart.destroy') }}", {
                            cart_id: cart_id
                        })
                        .then(function(response) {
                            alert(response.data);
                            window.location.href = "{{ route('cart.index') }}"
                        })
                        .catch(function(error) {
                            alert("Some Problem Occured");
                        });
                }
            },
            removeOffer: function(offer_id) {
                if (confirm('Are you sure you want to remove your offer ?')) {
                    axios.post("{{ route('offer.destroy') }}", {
                            offer_id: offer_id
                        })
                        .then(function(response) {
                            alert(response.data);
                            window.location.href = "{{ route('cart.index') }}"
                        })
                        .catch(function(error) {
                            alert("Some Problem Occured");
                        });
                }
            },
            checkout: function() {
                let vm = this;
                if (confirm('Are you sure you want to checkout ?')) {
                    data = [vm.carts,vm.offers];
                    button = document.getElementById('checkout');
                    button.disabled = true;
                    button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                    axios.post("{{ route('cart.checkout') }}", data)
                        .then(function(response) {
                            console.log(response);
                            button.disabled = false;
                            button.innerHTML =
                                'Checkout';
                            if (response.data.msg == '') {
                                window.location.href = "{{ route('checkout.index') }}";
                            } else {
                                alert(response.data.msg);
                            }
                        })
                        .catch(function(error) {
                            alert("Some Problem Occured");
                        });
                }
            },
            decreementQuantity: function(key) {
                let vm = this;
                var data = vm.carts[key];
                if (data.quantity > 1) {
                    data.quantity = data.quantity - 1;
                    axios.post("{{ route('cart.decreementQuantity') }}", data)
                        .then(function(response) {
                            vm.cart_sum = vm.cart_sum - data.stock.price;
                            console.log(response);
                        })
                        .catch(function(error) {
                            alert("Some Problem Occured");
                        });
                }

            },
            incrementQuantity: function(key) {
                let vm = this;
                var data = vm.carts[key];
                data.quantity = data.quantity + 1;
                if (data.quantity <= data.stock.quantity) {
                    axios.post("{{ route('cart.increementQuantity') }}", data)
                        .then(function(response) {
                            vm.cart_sum = vm.cart_sum + data.stock.price;
                            console.log(response);
                        })
                        .catch(function(error) {
                            alert("Some Problem Occured");
                        });
                }

            },
            acceptOffer: function(offer) {
                let vm = this;
                window.location.href = "{{ url('/') }}" + "/change-status-accept/" + offer.id;
            },
            rejectOffer: function(offer) {
                let vm = this;
                window.location.href = "{{ url('/') }}" + "/change-status-reject/" + offer.id;
            }
        },
        mounted() {
            let vm = this;
            console.log(vm.offers);
            if (vm.carts.length == 0) {
                if (vm.offers.length == 0) {
                    (document.getElementById("total_div")).style.display = 'none';
                }
            }
        }
    });
</script>
</body>

</html>
