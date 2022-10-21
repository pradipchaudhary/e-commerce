@section('title', env('APP_NAME'))
@include('frontend.include.header')
@include('frontend.include.navbar')

@include('sweetalert::alert')
<div class="container my-2">
    <!-- /.login-logo -->
    <div class="">
        <div class="card-body">
            <div class="login-logo text-center">
                <h2>{{ __('Account setup') }} </h2>
                <img src="{{ asset('logo.png') }}" alt="">
            </div>
            <div class="row" id="app">
                <div class="col-12">
                    <form method="POST" action="{{ route('account_setup.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="product_id" style="font-weight: 400">{{ __('Business phone number') }}
                                    <span class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select v-model="business_phone_code" name="business_phone_number_code"
                                            id="business_phone_number_code"
                                            class="form-control @error('business_phone_number_code') is-invalid @enderror">
                                            <option :value="country.phonecode" v-for="(country,key) in countries"
                                                v-text="country.name_woc"></option>
                                        </select>
                                        <input type="text" class="form-control" name="business_phone_code" readonly
                                            :value="'+' + business_phone_code">
                                    </div>
                                    <input type="text" :placeholder="'+' + business_phone_code"
                                        name="business_phone_number" id="business_phone_number"
                                        class="form-control @error('business_phone_number') is-invalid @enderror" />
                                </div>
                                @error('business_phone_number')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="col-md-12 mt-4">
                                <label for="product_id" style="font-weight: 400">{{ __('Whatsapp number') }}
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select v-model="whatsapp_code" name="whatsapp_code" id="whatsapp_code"
                                            class="form-control">
                                            <option :value="country.phonecode" v-for="(country,key) in countries"
                                                v-text="country.name_woc"></option>
                                        </select>
                                        <input type="text" class="form-control" readonly
                                            :value="'+' + whatsapp_code">
                                    </div>
                                    <input type="text" :placeholder="'+' + whatsapp_code" name="whatsapp_number"
                                        id="whatsapp_number" class="form-control" />
                                </div>
                            </div>
                            <div class="card col-12 p-3 my-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-weight-bold text-center">{{ __('Business Address') }}
                                        </h5>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label for="country_id" style="font-weight: 400">{{ __('Country') }}<span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select v-model="country_id" name="country_id" id="country_id"
                                                class="form-control @error('country_id') is-invalid @enderror"
                                                v-on:change="loadState()"
                                                :class="{ 'is-invalid': is_invalid_for_country }" required>
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
                                    <div class="col-md-12 mt-3">
                                        <label for="state_id" style="font-weight: 400">{{ __('State/ Province') }}<span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select v-model="state_id" name="state_id" id="state_id"
                                                class="form-control @error('state_id') is-invalid @enderror"
                                                v-on:change="loadCity()" required>
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
                                    <div class="col-md-12 mt-3">
                                        <label for="state_id" style="font-weight: 400">{{ __('city') }}<span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select name="city_id" id="city_id" class="form-control" required>
                                                <option value="">{{ __('--Select--') }}</option>
                                                <option :value="city.id" v-for="(city,key) in cities"
                                                    v-text="city.name"></option>
                                            </select>
                                            @error('city')
                                                <p class="invalid-feedback" style="font-size: 1rem">
                                                    {{ __('city is required') }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="address"
                                                style="font-weight: 400">{{ __('Street Address') }}<span
                                                    class="text-danger font-weight-bold px-1">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    id="address" name="address">
                                                @error('address')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ __('Address is required') }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="postal_code"
                                                style="font-weight: 400">{{ __('Zip / Postal code') }}
                                            </label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control @error('postal_code') is-invalid @enderror"
                                                    id="postal_code" name="postal_code" required>
                                            </div>
                                            @error('postal_code')
                                                <p class="invalid-feedback" style="font-size: 1rem">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label for="state_id"
                                            style="font-weight: 400">{{ __('Upload Reseller Certificate') }}<span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="file"
                                                class="form-control @error('document') is-invalid @enderror"
                                                id="document" name="document">
                                            @error('document')
                                                <p class="invalid-feedback" style="font-size: 1rem">
                                                    {{ __('document is required') }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary" type="submit">{{ __('Continue') }}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('vue/bundle.js') }}"></script>
<script>
    new Vue({
        el: "#app",
        data: {
            countries: @json($countries),
            business_phone_code: 1,
            whatsapp_code: 1,
            country_id: '',
            state_id: '',
            city_id: '',
            cities: '',
            is_invalid_for_country: false,
            states: []
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
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                }
            },
            loadCity: function() {
                let vm = this;
                axios.get("{{ route('api.getCityByState') }}", {
                        params: {
                            state_id: vm.state_id
                        }
                    })
                    .then(function(response) {
                        vm.city_id = '';
                        vm.cities = response.data;
                        console.log(vm.cities);
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert("Some Problem Occured");
                    });
            }
        },
        mounted() {

        }
    });
</script>
</body>

</html>
