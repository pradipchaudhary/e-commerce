@extends('layouts.main')
@section('title', 'Dashboard')
@section('is_active_home', 'active')
@section('main_content')

    <div class="row pt-2">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>

            </div>
            <div class="row" id="app">
                <div class="col-9">
                    <div class="card direct-chat direct-chat-primary">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">Users</h3>
                            <div class="card-tools">
                                <span title="3 New Messages"
                                    class="badge badge-primary">{{ $users->where('status', 0)->count() }}</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline"
                                aria-describedby="example2_info" >
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Business name</th>
                                        <th class="text-center">E-mail</th>
                                        <th class="text-center"></th>
                                        <th class="text-center">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $inactiveuser)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                {{ $inactiveuser->name . ' ' . $inactiveuser->last_name }}
                                            </td>
                                            <td class="text-center">{{ $inactiveuser->business_name }}
                                            </td>
                                            <td class="text-center">{{ $inactiveuser->email }}
                                            </td>
                                            <td class="text-center">
                                                @if($inactiveuser->status == 1)
                                                <button href="#" disabled
                                                    class="btn btn-sm btn-success">{{ __('approved') }}</button>
                                                @else
                                                 <a href="{{ route('user.approve', $inactiveuser) }}"
                                                    class="btn btn-sm btn-primary">{{ __('approve') }}</a>
                                                @endif
                                               
                                            </td>
                                            <td class="text-center"><a class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal"
                                                    v-on:click="openModal('{{ $inactiveuser->id }}')"><i
                                                        class="fa-solid fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- this is modal for view user --}}
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl" v-if="user">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel" v-text="(user.name ? (user.name + ' ' +  user.last_name) : '') + ' details'">
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div v-if="userDataLoading" style="display: flex; justify-content: center;">
                                                <strong>Loading...</strong>
                                                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                            </div>
                                            <table v-if="!userDataLoading" id="example2"
                                                class="table table-bordered table-hover dataTable dtr-inline">
                                                <thead>
                                                    <tr v-if="user.name">
                                                        <th class="text-center">Full name :</th>
                                                        <td v-text="user.name + ' ' +  user.last_name"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Email :</th>
                                                        <td v-text="user.email"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Business name :</th>
                                                        <td v-text="user.business_name"></td>
                                                    </tr>
                                                    <tr v-if="user.user_detail">
                                                        <th class="text-center">Country :</th>
                                                        <td v-text="user.user_detail.country.name_woc"></td>
                                                    </tr>
                                                     <tr v-if="user.user_detail">
                                                        <th class="text-center">State :</th>
                                                        <td v-text="user.user_detail.state.name"></td>
                                                    </tr>
                                                     <tr v-if="user.user_detail != null">
                                                        <th class="text-center">City :</th>
                                                        <td v-text="user.user_detail.city.name"></td>
                                                    </tr>
                                                    <tr v-if="user.user_detail">
                                                        <th class="text-center">Street Address :</th>
                                                        <td v-text="user.user_detail.address"></td>
                                                    </tr>
                                                    <tr v-if="user.user_detail">
                                                        <th class="text-center">Business phone number :</th>
                                                        <td v-text=" '+' + user.user_detail.business_phone_number_code + ' ' +user.user_detail.business_phone_number"></td>
                                                    </tr>
                                                     <tr v-if="user.user_detail && user.user_detail.whatsapp_number">
                                                        <th class="text-center">WhatsApp number :</th>
                                                        <td v-text=" '+' + user.user_detail.whatsapp_code + ' ' +user.user_detail.whatsapp_number"></td>
                                                    </tr>
                                                     <tr v-if="user.user_detail != null">
                                                        <template v-if=" user.user_detail.document != null">
                                                            <th class="text-center">Document :</th>
                                                            <td>
                                                                <a :href="img_path+'/'+user.user_detail.document" download>Reseller Certificate</a>
                                                            </td>
                                                        </template>
                                                    </tr>
                                                    
                                                   
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                img_path : "{{asset('storage/upload/')}}",
                user: [],
                userDataLoading: false
            },
            methods: {
                openModal: function(user_id) {
                    let vm = this;
                    vm.userDataLoading = true;
                    axios.get("{{ route('api.getUserDetail') }}", {
                        params: {
                            user_id: user_id
                        }
                    }).then(function(response) {
                        vm.user = response.data;
                        console.log(vm.user);
                        vm.userDataLoading = false;
                    }).catch(function(error) {
                        console.log(error);
                            // vm.userDataLoading = false;
                        alert("Something went wrong !!");
                    });
                }
            },
            mounted() {
                let vm = this;
            }
        });
    </script>
@endsection
