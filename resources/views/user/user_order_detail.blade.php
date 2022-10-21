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
                            <template v-for="(order,key) in order_logs">
                                <div class="col-md-6">
                                    <h4 style="font-size: 1.1rem; color:black;"
                                        v-text=" order.stock.product.manufacturer.name + ' ' + order.stock.product.name + ' ' + order.stock.color.name + ' ' + order.stock.status.name + ' ' + order.stock.grading_scale.name + '-STOCK' ">
                                    </h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="text-right">SKU</td>
                                            <td class="text-left" v-text="order.stock.sku"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">Quantity</td>
                                            <td class="text-left" v-text="order.quantity"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">price</td>
                                            <td class="text-left" v-text="'$ '+order.price * order.quantity"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">ESN</td>
                                            <td class="text-left" v-text="seperateComma(key)"></td>
                                        </tr>
                                    </table>
                                </div>
                            </template>
                            <div class="col-12">
                                <table class="table table-bordered" v-if="order_logs[0].insurance_id != ''">
                                    <tr>
                                        <td class="text-center">Order Date :</td>
                                        <td class="text-center"
                                            v-text="date"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Status :</td>
                                        <td class="text-center"
                                            v-text="returnStatusText(order_logs[0])">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Note :</td>
                                        <td class="text-center"
                                            v-text="order_logs[0].note == null ? '--' :order_logs[0].note"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Order no. :</td>
                                        <td class="text-center"
                                            v-text="order_logs[0].token"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Total Item cost :</td>
                                        <td class="text-center"
                                            v-text="'$'+total_item_cost"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Insurance :</td>
                                        <td class="text-center"
                                            v-text="order_logs[0].insurance.description + '($'+ insurance_cost+')'">
                                        </td>
                                    </tr>
                                    <tr v-if="order_logs[0].shipping_id != null">
                                        <td class="text-center">Shipping :</td>
                                        <td class="text-center"
                                            v-text="order_logs[0].shipping.name +'($'+shipping_cost+')'"></td>
                                    </tr>
                                    <tr v-if="order_logs[0].shipping_method_id != null">
                                        <td class="text-center">Shipping Method :</td>
                                        <td class="text-center" v-text="order_logs[0].shipping_method.name"></td>
                                    </tr>
                                    <tr v-if="order_logs[0].track_id != null">
                                        <td class="text-center">Tracking ID :</td>
                                        <td class="text-center" v-text="order_logs[0].track_id"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Total :</td>
                                        <td class="text-center" v-text="'$'+total_cost"></td>
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
<script src="{{ asset('vue/bundle.js') }}"></script>
</body>
<script>
    new Vue({
        el: "#app",
        data: {
            order_logs: @json($order_logs),
            insurance_cost: {{ $insurance_cost }},
            shipping_cost: {{ $shipping_cost }},
            total_cost: {{ $total_cost }},
            total_item_cost : @json($item_cost),
            date : @json($date)
        },
        methods: {
            seperateComma: function(key) {
                let vm = this;
                result = Array.prototype.map.call(vm.order_logs[key].stock.esns, function(item) {
                    return item.esn;
                }).join(" , ");
                return result;
            },
            returnStatusText: function(order_log) {
                let vm = this;
                text = "";
                if (!order_log.is_paid) {
                    text += "Pending";
                } else {
                    text += "Paid ";
                }

                if (order_log.is_dispatch) {
                    text += " - Shipped";
                }

                if (order_log.is_delivered) {
                    text += " - Delivered";
                }

                return text;
            }
        },
        mounted() {
            let vm = this;
            console.log(vm.order_logs);
        }
    });
</script>

</html>
