@extends('layouts.main')
@section('title', 'Order History')
@section('is_active_order_history', 'active')
@section('main_content')
<div class="row pt-2" id="app">
    <div class="col-12">
        <div class="row">
            <div class="col-6"></div>
            <div class="col-12">
                <div class="row mt-3">
                    <template v-for="(order,key) in order_logs">
                        <div class="col-md-6">
                            <h4 style="font-size: 1.1rem;" v-text="order.stock.product.manufacturer.name + ' ' + order.stock.product.name + ' ' + order.stock.color.name + ' ' + order.stock.status.name + ' ' + order.stock.grading_scale.name + '-STOCK' + ( order.is_offer ? '('+'OFFER'+')':'')">
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
                                    <td class="text-left">
                                        <span v-if="order.is_dispatch" v-text="seperateComma(key)"></span>
                                        <button href="#" v-if="!order.is_dispatch" data-toggle="modal" data-target="#exampleModal" v-on:click="openModal(key)" class="btn btn-primary btn-sm"><i class="fa-solid fa-hand-holding px-1 pb-1"></i>
                                            <span v-text="'Assign Esn'"></span></button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </template>
                    <div class="col-12">
                        <table class="table table-bordered" v-if="order_logs[0].insurance_id != ''">
                            <tr>
                                <td class="text-center">User :</td>
                                <td class="text-center" v-text="order_logs[0].user.name">
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td class="text-center">Country :</td>
                                <td class="text-center" v-text="order_logs[0].user.user_detail.country.name_woc">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">State :</td>
                                <td class="text-center" v-text="order_logs[0].user.user_detail.state.name">
                                </td>
                            </tr>
                            <tr v-if="order_logs[0].user.user_detail.city != null">
                                <td class="text-center">City :</td>
                                <td class="text-center" v-text="order_logs[0].user.user_detail.city">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" v-if="order_logs[0].user.user_detail.address != null">Street name :</td>
                                <td class="text-center" v-text="order_logs[0].user.user_detail.address">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Status :</td>
                                <td class="text-center" v-text="returnStatusText(order_logs[0])">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Note :</td>
                                <td class="text-center" v-text="order_logs[0].note == null ? '--' :order_logs[0].note">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Total item cost :</td>
                                <td class="text-center" v-text="'$'+item_cost">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">Insurance :</td>
                                <td class="text-center" v-text="order_logs[0].insurance.description + '($'+ insurance_cost+')'">
                                </td>
                            </tr>
                            <tr v-if="order_logs[0].shipping_id != null">
                                <td class="text-center">Shipping :</td>
                                <td class="text-center" v-text="order_logs[0].shipping.name +'($'+shipping_cost+')'">
                                </td>
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
                                <td class="text-center">Grand total :</td>
                                <td class="text-center" v-text="'$'+total_cost"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- this is modal for assigning more esn --}}
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <form action="{{ route('order_history.dispatch') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Assign ESN') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" v-if="order_modal!=''">
                                    @csrf
                                    <p class="text-center" v-if="order_modal != ''">Assign ESN for
                                        @{{ order_modal.stock.product.manufacturer.name + ' ' + order_modal.stock.product.name + ' ' + order_modal.stock.color.name + ' ' + order_modal.stock.status.name + ' ' + order_modal.stock.grading_scale.name + '-STOCK' }}</p>
                                    <input type="hidden" name="order_log_id" id="order_log_id" :value="order_modal.id">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __('Tracking number') }} <span class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <input type="text" v-model="order_logs[0].track_id" name="track_id" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __('Shipping method') }} <span class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <select name="shipping_method_id" class="form-control form-control-sm">
                                                <option :value="shipping_method.id" v-for="shipping_method in shipping_methods" :selected="order_logs[0].shipping_method_id == shipping_method.id ? true : false">
                                                    @{{ shipping_method.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="loop" v-for="index in order_modal.quantity">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">{{ __('ESN \ IMEI ') }} <span class="text-danger font-weight-bold px-1">*</span>
                                                </label>
                                                <input type="text" :id="'esn_' + index" v-on:input="checkEsn(order_modal.id,index)" class="form-control form-control-sm" value="" v-model="tokenData[index-1]" name="esn[]" required>
                                            </div>
                                        </div>
                                        <p class="mb-0 pl-3 text-danger" style="margin-top:-10px;" :id="'feedback_' + index">
                                        </p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button id="button" class="btn btn-primary" v-on:click="dispatch()" id="button">{{ __('Shipp') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- xxx this is modal for assigning more esn xxx --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vue/bundle.js') }}"></script>
<script src="{{ asset('vue/bundle.js') }}"></script>
<script>
    new Vue({
        el: "#app",
        data: {
            order_logs: @json($order_logs),
            shipping_methods: @json($shipping_methods),
            tokenData: [],
            order_modal: [],
            item_cost : @json($item_cost),
            insurance_cost: @json($insurance_cost),
            shipping_cost: @json($shipping_cost),
            total_cost: @json($total_cost)
        },
        methods: {
            seperateComma: function(key) {
                let vm = this;
                result = Array.prototype.map.call(vm.order_logs[key].stock.esns, function(item) {
                    return item.esn;
                }).join(",");
                return result;
            },
            openModal: function(key) {
                let vm = this;
                vm.order_modal = vm.order_logs[key];
                // console.log(vm.order_modal);
            },
            dispatch: function() {
                let vm = this;
                // (document.getElementById("button")).disabled = true;
                check = false;
                for (let i = 0; i < vm.tokenData.length; i++) {
                    if (vm.tokenData.indexOf(vm.tokenData[i]) !== vm.tokenData.lastIndexOf(vm.tokenData[
                            i])) {
                        check = true;
                    }
                }
                if (check) {
                    event.preventDefault();
                    (document.getElementById("button")).disabled = true;
                    alert("ESN is repeated !");
                } else {
                    (document.getElementById("button")).disabled = false;
                    return true;
                }
            },
            checkEsn: function(order_log_id, index) {
                let vm = this;
                esn = document.getElementById("esn_" + index).value;
                button = document.getElementById("button");
                axios.get("{{ route('api.checkEsn') }}", {
                    params: {
                        esn: esn
                    }
                }).then(function(response) {
                    element = document.getElementById("feedback_" + index);
                    if (response.data) {
                        button.disabled = true;
                        element.innerHTML = "Esn doesn't exist";
                    } else {
                        button.removeAttribute('disabled');
                        element.innerHTML = "";
                    }
                }).catch(function(error) {
                    console.log(error);
                    alert("Something went wrong");
                });
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
            },
            returnInsuranceText: function(key) {
                let vm = this;
                text = "";
                text += vm.order_logs[key].insurance.description + (vm.order_logs[key].insurance.status ?
                    ' ($' + (vm.order_logs[key].insurance.percent / 100) * vm.order_logs[key].quantity *
                    vm.order_logs[key].price + ')' : '($ 0)');
                return text;
            }
        },
        mounted() {
            let vm = this;
            console.log(vm.order_logs);
        }
    });
</script>
@endsection