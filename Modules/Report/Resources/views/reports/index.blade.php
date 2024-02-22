@extends('dashboard.layouts.app')

@section('title', 'Report')

@section('content')
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Navbar-->
        <div class="card mb-8">
            <div class="card-body py-7">
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap flex-stack">
                    <!--begin::Title-->
                    <div class="d-flex flex-wrap align-items-center my-1">
                        <!-- right -->
                    </div>
                    <!--end::Title-->
                    <!--begin::Controls-->
                    <div class="d-flex flex-wrap my-1">


                        <!--begin::Filter-->
                        <button type="button" class="btn btn-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                            <!--end::Svg Icon-->Filter
                        </button>
                        <!--begin::Menu 1-->
                        <form method="GET" action="{{route('reports.index')}}"
                              class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">{{getCustomTranslation('filter')}}</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('name')}}:</label>
                                    <input type="text" name="name" value="{{request('name')}}"
                                           class="form-control" placeholder="{{getCustomTranslation('search_by_name')}}"/>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('platform')}}:</label>
                                    <input type="text" name="platform" value="{{request('platform')}}"
                                           class="form-control" placeholder="{{getCustomTranslation('search_by_platform')}}"/>
                                </div>
                                <!--end::Input group-->


                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" id="reset_filter"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                    </button>
                                    <button type="submit" class="btn btn-primary fw-semibold px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </form>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                        <!--begin::Export-->
                        <button
                            type="button"
                            class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users"
                            onclick="location.href='{{ route('reports.export') }}'"
                        >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                        transform="rotate(90 12.75 4.25)" fill="currentColor"/>
                                    <path
                                        d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                        fill="currentColor"/>
                                    <path opacity="0.3"
                                        d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                        fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->{{getCustomTranslation('export')}}
                        </button>
                        <!--end::Export-->


                        <!--begin::Import-->


                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {{getCustomTranslation('import_file')}}
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('reports.upload') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{getCustomTranslation('import_file')}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            @csrf
                                            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                                <div class="custom-file text-left">
                                                    <input type="file" name="file" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">{{getCustomTranslation('choose_file')}}</label>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-primary">Import data</button> -->
                                            <!-- <a class="btn btn-success" href="{{ route('reports.upload') }}">{{getCustomTranslation('export')}} data</a> -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{getCustomTranslation('close')}}</button>
                                        <button type="submit" class="btn btn-primary">{{getCustomTranslation('upload')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!--end::Import-->


                        @can('delete_reports')
                        <button type="button" class="btn btn-danger ms-1 "
                                data-kt-report-table-select="delete_selected">
                            {{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan

                    </div>
                    <!--end::Controls-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>


        <!--begin::Tab Content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div id="kt_project_users_table_pane" class="tab-pane fade active show" role="tabpanel">
                <!--begin::Card-->
                <div class="card card-flush">
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table id="kt_report_table"
                                   class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                <!--begin::Head-->
                                <thead class="fs-7 text-gray-400 text-uppercase">
                                <tr>
                                    <!-- <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                   data-kt-check-target="#kt_report_table .item_check" value="1"/>
                                        </div>
                                    </th> -->
                                    <th class="min-w-20px">{{getCustomTranslation('id')}}</th>
                                    <th class="min-w-120px">{{getCustomTranslation('name')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('platform')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('identifier')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('type')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('license_status')}}</th>
                                    <th class="min-w-100px">{{getCustomTranslation('status_date')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('advertised_party')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('advertise_category')}}</th>
                                    <th class="min-w-100px">{{getCustomTranslation('report_date')}}</th>
                                    <th class="min-w-90px">{{getCustomTranslation('advertise_url')}}</th>
                                    @canany(['update_reports','delete_reports'])
                                        <th class="min-w-50px text-end">{{getCustomTranslation('actions')}}</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <!--end::Head-->
                                <!--begin::Body-->
                                <tbody class="fs-6">
                                @foreach($datas as $data)
                                    <tr>
                                        {{-- <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input item_check" type="checkbox"
                                                       name="item_check"
                                                       value="{{$data->id}}"/>
                                            </div>
                                        </td> --}}
                                        <td>{{$data->id}}</td>

                                        <td>
                                            {{$data->name}}
                                        </td>
                                        <td>{{ $data->platform }}</td>
                                        <td>{{ $data->identifier }}</td>
                                        <td>{{ $data->type }}</td>
                                        @if($data->license_status)
                                        <td><i class="fa-solid fa-toggle-on text-success fs-1"></i></td>
                                        @else
                                        <td><i class="fa-solid fa-toggle-off text-danger fs-1"></i></td>
                                        @endif
                                        <td>{{ $data->status_date->format('d-m-Y') }}</td>
                                        <td>{{ $data->advertised_party }}</td>
                                        <td>{{ $data->advertise_category }}</td>
                                        <td>{{ $data->report_date->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ $data->advertise_url }}">{{ $data->advertise_url }}</a>
                                        </td>

                                        @canany(['update_reports','delete_reports'])

                                            <td class="text-end">
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    Actions
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor"/>
                                            </svg>
                                        </span>
                                                    <!--end::Svg Icon--></a>

                                                <!--begin::Menu-->
                                                <div
                                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    @can('update_reports')
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{route('reports.edit', $data->id)}}"
                                                           class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @endcan
                                                    @can('delete_reports')
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" data-kt-report-table-filter="delete_row"
                                                           class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @endcan
                                                </div>
                                                <!--end::Menu-->
                                            </td>
                                        @endcanany

                                    </tr>
                                @endforeach
                                </tbody>
                                <!--end::Body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Tab pane-->

            {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage(),'perArray'=>[12,24,48,96,192]]) }}

        </div>
        <!--end::Tab Content-->

    </div>

@endsection
@push('scripts')
    <script>
        var route = "{{ route('reports.index') }}";
        var routeAll = "{{ route('reports.index',Request()->all()) }}";
        var toggleActiveRoute = "{{ route('reports.toggleActive') }}";
        var csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/report/list.js?v=1"></script>
    <script>
        $('#reset_filter').on('click', function () {
            $('#country_id').val('').trigger('change');
            $('#gender').val('').trigger('change');
            window.location = route;
        })
    </script>
@endpush
