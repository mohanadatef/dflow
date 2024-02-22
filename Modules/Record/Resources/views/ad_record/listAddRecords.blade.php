<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ad_record_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                @permission('delete_ad_record')
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                               data-kt-check-target="#kt_ad_record_table .form-check-input" value="1"/>
                    </div>
                </th>
                @endpermission
                <th class="min-w-70x">Ad Date</th>
                <th class="min-w-125px">Company</th>
                <th class="min-w-125px">Influencer</th>
                <th class="min-w-200px">Category</th>
                <th class="min-w-200px">Platform</th>
                @permission('update_ad_record')
                    <th class="min-w-125px">Researcher</th>
                @endpermission
                <th class="min-w-70x">Visit</th>
                @permission('update_ad_record')
                <th class="text-end min-w-70px">Actions</th>
                @endpermission
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($datas as $data)
                <tr>
                    @permission('delete_ad_record')
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="item_check"
                                   value="{{$data->id}}"/>
                        </div>
                    </td>
                    @endpermission
                    <td>
                        {{ date('Y-m-d', strtotime($data->date))}}
                    </td>
                    <td>
                        {{$data->company->name_en}}
                    </td>
                    <td>
                        {{isset($data->influencer->name_en)?$data->influencer->name_en:""}}
                    </td>
                    <td>
                        @foreach($data->category as $category)
                            {{$category->name_en}},
                        @endforeach
                    </td>
                    <td>
                        {{$data->platform->name_en}}
                    </td>
                    @permission('update_ad_record')
                        <td>
                            <a href="{{route('user.show', $data->user->id)}}">{{ $data->user->name }}</a>
                        </td>
                    @endpermission
                    <td>
                        <a href="{{route('ad_record.show', $data->id)}}" type="button"
                           class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa fa-eye"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                    </td>
                    @permission('update_ad_record')
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                            <!--end::Svg Icon-->
                        </a>
                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                @permission('update_ad_record')
                                <a href="{{route('ad_record.edit',$data->id)}}"
                                   class="menu-link px-3">Edit</a>
                                @endpermission
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                @permission('delete_ad_record')
                                <a href="#" data-kt-ad_record-table-filter="delete_row"
                                   class="menu-link px-3">Delete</a>
                                @endpermission
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                    @endpermission
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage()]) }}

    @else
        <h3 class="text-center text-gray">No Records to display in this time range ...</h3>
    @endif
</div>
