@extends('layouts.main')
@section('title', 'Grade scale')
@section('menu_show', 'menu-open')
@section('s_child_grade', 'block')
@section('setting_grade_scale', 'active')
@section('main_content')
    <div class="row pt-2" id="app">
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right my-3">
                    <a href="{{ route('grade-scale.create') }}" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-plus px-1"></i>{{ __('Add Grade scale') }}</a>
                </div>
                {{-- this is modal for creating grade --}}
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Grade') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grading_scales as $key => $grading_scale)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $grading_scale->name }}</td>
                                    <td class="text-center">{{ $grading_scale->Grade->name }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm text-white" data-toggle="modal"
                                            data-target="#description"
                                            v-on:click="loadData('{{ $grading_scale->id }}')"><i
                                                class="fa-solid fa-eye px-1"></i>{{ __('view ') . $grading_scale->name . ' scale' }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- this is a modal for viewing grade scale description --}}
        <div class="modal fade" id="description" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@{{ grade_scales.name }} description</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-lg">
                        <span class="font-weight-bold" v-if="grade_scales.grade_id == 1">@{{ grade_scales.name }} apperance:</span> <span
                            class="px-1" v-if="grade_scales.grade_id == 1">@{{ grade_scales.apperance }}<br></span>
                        <span class="font-weight-bold">Screen:</span> <span class="px-1">@{{ grade_scales.screen }}</span><br>
                        <span class="font-weight-bold" v-if="grade_scales.bezel !=null">Housing/bezel:</span> <span class="px-1" v-html="grade_scales.bezel"></span><br>
                        <span class="font-weight-bold" v-if="grade_scales.functionality !=null">Functionality:</span> <span class="px-1" v-html="grade_scales.functionality"></span><br>
                        <span class="font-weight-bold" v-if="grade_scales.other != null">Other:</span> <span class="px-1">@{{grade_scales.other}}</span>
                        <span class="font-weight-bold" v-if="grade_scales.lcd != null">Other:</span> <span class="px-1">@{{grade_scales.lcd}}</span>

                        <div class="row mt-2">
                            <div class="col-3 mt-1" v-for="(image,key) in grade_scales.images">
                                <a :href="PATH + '/'+image.name" target="_blank">
                                    <img :src="PATH + '/'+image.name" alt="" height="100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- xx this is a modal for viewing grade scale description xx --}}
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
        new Vue({
            el: "#app",
            data: {
                grade_scales: [],
                PATH : '{{asset('storage/thumbnails/')}}'
            },
            methods: {
                loadData: function(param) {
                    let vm = this;
                    axios.get("{{ route('api.getGradeScaleDetailById') }}", {
                            params: {
                                grade_scale_id: param
                            }
                        })
                        .then(function(response) {
                            vm.grade_scales = response.data;
                            console.log(vm.grade_scales);
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                }
            }
        });
    </script>
@endsection
