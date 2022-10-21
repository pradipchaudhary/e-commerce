@section('title', 'Everest Phone | Shipping ')
@include('frontend.include.header')
@include('frontend.include.navbar')
<style>
    * {
        color: #000 !important;
    }
</style>
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
            <form method="POST" class="shipping-form" action="{{ route('checkout.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h5>Shipping Address</h5>
                        <input type="checkbox" id="is_business_address" name="is_business_address" value="1"
                            @change="checkEvent($event)" checked>
                        <label for="vehicle1"> Use business address</label><br>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label for="product_id" style="font-weight: 400">{{ __('Business phone number') }}
                            <span class="text-danger font-weight-bold px-1">*</span>
                        </label>
                        <div class="input-group d-md-flex">
                            <div class="input-group-prepend d-md-flex">
                                <select v-model="business_phone_code" name="business_phone_number_code"
                                    id="business_phone_number_code"
                                    class="form-control @error('business_phone_number_code') is-invalid @enderror">
                                    <option :value="country.phonecode" v-for="(country,key) in countries"
                                        v-text="country.name_woc"></option>
                                </select>
                                <input type="text" class="form-control" name="business_phone_code" readonly
                                    :value="'+' + business_phone_code">
                            </div>
                            <input type="text" :placeholder="'+' + business_phone_code" name="business_phone_number"
                                id="business_phone_number"
                                class="form-control @error('business_phone_number') is-invalid @enderror"
                                v-model="business_phone_number" />
                        </div>
                        @error('business_phone_number')
                            {{ $message }}
                        @enderror
                    </div>

                    <div class="col-md-6 mt-4">
                        <label for="product_id" style="font-weight: 400">{{ __('Whatsapp number') }}
                        </label>
                        <div class="input-group d-md-flex">
                            <div class="input-group-prepend d-md-flex">
                                <select v-model="whatsapp_code" name="whatsapp_code" id="whatsapp_code"
                                    class="form-control">
                                    <option :value="country.phonecode" v-for="(country,key) in countries"
                                        v-text="country.name_woc"></option>
                                </select>
                                <input type="text" class="form-control" readonly :value="'+' + whatsapp_code">
                            </div>
                            <input type="text" :placeholder="'+' + whatsapp_code" name="whatsapp_number"
                                id="whatsapp_number" class="form-control" v-model="whatsapp_number" />
                        </div>
                    </div>
                    <div class="col-12 p-3 my-3">
                        <div class="row">
                            <div class="col-12">
                                <h5>{{ __('Business Address') }}
                                </h5>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label for="country_id" style="font-weight: 400">{{ __('Country') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="country_id" name="country_id" id="country_id"
                                        class="form-control @error('country_id') is-invalid @enderror"
                                        v-on:change="loadState()" :class="{ 'is-invalid': is_invalid_for_country }"
                                        required>
                                        <option value="">{{ __('--Select--') }}</option>
                                        <option :value="country.id" v-for="(country,key) in countries"
                                            v-text="country.name_woc">
                                        </option>
                                    </select>
                                    @error('country_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Country name is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  mt-1">
                                <label for="state_id" style="font-weight: 400">{{ __('State/ Province') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="state_id" name="state_id" id="state_id"
                                        class="form-control @error('state_id') is-invalid @enderror" required>
                                        <option value="">{{ __('--Select--') }}</option>
                                        <option :value="state.id" v-for="(state,key) in states"
                                            v-text="state.name">
                                        </option>
                                    </select>
                                </div>
                                @error('state_id')
                                    <p class="invalid-feedback" style="font-size: 1rem">
                                        {{ __('State is required') }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-md-6  mt-1">
                                <label for="city_id" style="font-weight: 400">{{ __('City') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="city_id" name="city_id" id="city_id"
                                        class="form-control @error('city_id') is-invalid @enderror" required>
                                        <option value="">{{ __('--Select--') }}</option>
                                        <option :value="city.id" v-for="(city,key) in cities"
                                            v-text="city.name">
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="col-md-6 mt-4">-->
                            <!--    <label for="city" style="font-weight: 400">{{ __('City') }}<span-->
                            <!--            class="text-danger font-weight-bold px-1">*</span>-->
                            <!--    </label>-->
                            <!--    <div class="input-group">-->
                            <!--        <input type="text" class="form-control @error('city') is-invalid @enderror"-->
                            <!--            id="city" name="city" v-model="city">-->
                            <!--        @error('city')-->
                            <!--            <p class="invalid-feedback" style="font-size: 1rem">-->
                            <!--                {{ __('city is required') }}-->
                            <!--            </p>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-md-6 mt-4">
                                <label for="address" style="font-weight: 400">{{ __('Street Name') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" v-model="address">
                                    @error('address')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Address is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="postal_code" style="font-weight: 400">{{ __('Zip / Postal code') }}
                                </label>
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @error('postal_code') is-invalid @enderror"
                                        id="postal_code" name="postal_code" required v-model="postal_code">
                                </div>
                                @error('postal_code')
                                    <p class="invalid-feedback" style="font-size: 1rem">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-3">
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <label for="shipping_id" style="font-weight: 400">{{ __('Shipping method') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="shipping_id" name="shipping_id" id="shipping_id"
                                        class="form-control @error('shipping_id') is-invalid @enderror" required>
                                        <option :value="shipping.id" v-for="(shipping,key) in shippings"
                                            v-text="(shipping.quantity < cart_quantity_sum ? 0 : shipping.cost) + '$ ' +shipping.name + ' ' + shipping.description">
                                        </option>
                                    </select>
                                    @error('shipping_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Country name is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-3">
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <label for="insurance_id"
                                    style="font-weight: 400">{{ __('Would you like insurance') }}<span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <select v-model="insurance_id" name="insurance_id" id="insurance_id"
                                        class="form-control @error('insurance_id') is-invalid @enderror" required>
                                        <option :value="insurance.id" v-for="(insurance,key) in insurances"
                                            v-text="insurance.description">
                                        </option>
                                    </select>
                                    @error('insurance_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Country name is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
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
            countries: @json($countries),
            business_phone_code: 1,
            whatsapp_code: 1,
            cities: @json($cities),
            country_id: @json($user->userDetail->country_id),
            address: @json($user->userDetail->address),
            state_id: @json($user->userDetail->state_id),
            city_id: @json($user->userDetail->city_id),
            is_invalid_for_country: false,
            business_phone_number: @json($user->userDetail->business_phone_number),
            postal_code: @json($user->userDetail->postal_code),
            states: @json($states),
            whatsapp_number: @json($user->userDetail->whatsapp_number),
            shippings: @json($shippings),
            shipping_id: 1,
            cart_quantity_sum: @json($cart_quantity_sum),
            insurances: @json($insurances),
            insurance_id: 1
        },
        methods: {
            loadState: function() {
                let vm = this;
                if (vm.country_id == '') {
                    vm.is_invalid_for_country = true;
                } else {
                    axios.get("{{ route('api.getStateByCountry') }}", {
                            params: {
                                country_id: vm.country_id
                            }
                        })
                        .then(function(response) {
                            vm.state_id = '';
                            vm.states = response.data;
                            vm.is_invalid_for_country = false;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                }
            },
            checkEvent: function(param) {
                let vm = this;
                if (!param.target.checked) {
                    vm.country_id = '';
                    vm.address = '';
                    vm.state_id = '';
                    vm.business_phone_number = '';
                    vm.postal_code = '';
                    vm.states = [];
                    vm.whatsapp_number = '';
                } else {
                    vm.country_id = @json($user->userDetail->country_id);
                    vm.address = @json($user->userDetail->address);
                    vm.state_id = @json($user->userDetail->state_id);
                    vm.business_phone_number = @json($user->userDetail->business_phone_number);
                    vm.postal_code = @json($user->userDetail->postal_code);
                    vm.states = @json($states);
                    vm.whatsapp_number = @json($user->userDetail->whatsapp_number);
                }
            }
        },
        mounted() {
            let vm = this;
            vm.loadState();
            console.log(vm.state_id)
        }
    });
</script>
</body>

</html>
