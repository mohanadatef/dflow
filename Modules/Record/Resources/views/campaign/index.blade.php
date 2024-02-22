@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('campaign'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                      transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"/>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-docs-table-filter="search"
                           class="form-control form-control-solid w-250px ps-15" placeholder="{{getCustomTranslation('search_campaigns')}}"/>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-campaign-table-toolbar="base">
                    @can('create_campaigns')
                    <!--begin::Add campaign-->
                    <a href="{{ route('campaign.create') }}" class="btn btn-primary">{{getCustomTranslation('add_campaign')}}</a>
                    <!--end::Add campaign-->
                    @endcan
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center" data-kt-campaign-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        {{--
                                                <span class="me-2" data-kt-campaign-table-select="selected_count"></span>Selected</div>
                        --}}
                        @can('delete_campaigns')
                        <button type="button" class="btn btn-danger" data-kt-campaign-table-select="delete_selected">
                            {{getCustomTranslation('delete_selected')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_campaign_table">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_campaign_table .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th class="min-w-125px">{{getCustomTranslation('id')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('name_en')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('name_ar')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('company')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('influencer')}}</th>
                        <th class="min-w-125px">{{getCustomTranslation('url')}}</th>
                        <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600">
                    @foreach($datas as $data)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="item_check"
                                           value="{{$data->id}}"/>
                                </div>
                            </td>
                            <td>
                                {{$data->id}}
                            </td>
                            <td>
                                {{$data->name_en }}
                            </td>
                            <td>
                                {{$data->name_ar }}
                            </td>
                            <td>
                                {{implode(',',$data->company->pluck('name_'.$lang))}}
                            </td>
                            <td>
                                    {{implode(',',$data->$influencer->pluck('name_'.$lang))}}
                            </td>
                            <td>
                                <a href="{{$data->url}}" target="_blank">{{$data->url}}</a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{getCustomTranslation('actions')}}
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
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        @can('update_campaigns')
                                        <a href="{{route('campaign.edit',$data->id)}}" class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                        @endcan
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        @can('delete_campaigns')
                                        <a href="#" data-kt-campaign-table-filter="delete_row" class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                        @endcan
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage()]) }}
            </div>
            <!--end::Datatable-->
        </div>
        <!--end::Products-->
        @endsection
        @push('scripts')

            <script>
                var route = "{{ route('campaign.index') }}";
                var routeAll = "{{ route('campaign.index',Request()->all()) }}";
                var csrfToken = "{{ csrf_token() }}";
            </script>
            <script src="{{ asset('dashboard') }}/assets/js/campaign/list.js?v=1"></script>
    @endpush