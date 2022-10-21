@section('title', env('APP_NAME'))
@include('frontend.include.header')
@include('frontend.include.navbar')
<section id="app">
    <div class="container grading">
        <div class="row" id="app">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ auth()->user()->name }} Order Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table id="order_table" class="table table-bordered table-hover dataTable dtr-inline"
                                aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('Order no.') }}</th>
                                        <th class="text-center">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order,key) in orders">
                                        <td class="text-center" v-text="key+1"></td>
                                        <td class="text-center" v-text="order[0].token"></td>
                                        <td class="text-center">
                                            <span v-text="returnStatusText(order[0])"></span>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm text-white"
                                                v-on:click="redirect(order[0])"></i>
                                                <span>View Details</span></a>
                                        </td>
                                    </tr>
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
<script src="{{ asset('vue/bundle.js') }}"></script>
<script src="{{ asset('user/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('vue/bundle.js') }}"></script>
<script>
    new Vue({
        el: "#app",
        data: {
            orders: @json($order_logs)
        },
        methods: {
            redirect: function(order_log) {
                window.location.href = "{{ url('/') }}" + "/user-order-detail/" + order_log.token;
            },
            returnStatusText: function(order_log) {
                let vm = this;
                text = "";
                if (!order_log.is_paid) {
                    text += "Pending";
                }else{
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
            console.log(vm.orders);
        }
    });
</script>
</body>

</html>
