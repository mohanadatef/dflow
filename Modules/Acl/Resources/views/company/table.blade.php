<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($data))
<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_company_table">
    <!--begin::Table head-->
    <thead>
    <!--begin::Table row-->
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                <input class="form-check-input item_check" type="checkbox" data-kt-check="true"
                       data-kt-check-target="#kt_company_table .item_check" value="1"/>
            </div>
        </th>
        <th class="w-30px">{{getCustomTranslation('icon')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('name_en')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('name_ar')}}</th>
        <th class="w-450px" style="text-align:left !important">{{getCustomTranslation('industry')}}</th>
        <th class="w-125px" style="text-align:center !important">{{getCustomTranslation('link')}}</th>
        <th class="min-w-125px" style="text-align:start !important">{{getCustomTranslation('active_status')}}</th>
        <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
    </tr>
    <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        @foreach($data as $row)
        <tr>
            <td>
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input item_check" type="checkbox"  name="item_check"
                           value="{{$row->id}}"/>
                </div>
            </td>
            <td>
                @if($row->iconUrl)

                    <div class="symbol symbol-50 me-4">
                    <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">
                        <img src="{{$row->iconUrl}}" style="width: 50px;height: 50px">
                    </div>
                </div>
                @else

                <div class="symbol symbol-50px me-4">
                    <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">{{$row->{'name_'.$lang}[0]}}</div>
                </div>
                @endif
            </td>
            <td>
                {{$row->name_en }}
            </td>
            <td>
                {{$row->name_ar }}
            </td>
            <td>
                {{implode(',',$row->industry->pluck('name_'.$lang)->toArray())}}
            </td>
            <td class="text-cneter">
                @if(count($row->company_website) > 0)
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-5 m-0"
                            >
                                                    <i class="fa fa-eye"></i>
                                                            </span>

                            <!--end::Svg Icon-->
                        </a>
                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            @foreach($row->company_website as $site)
                                <div class="menu-item px-3">
                                    <a href="{{$site['url']}}" target="_blank"
                                       class="menu-link px-3">{{$site->website['name_'.$lang]}}</a>
                                </div>
                            @endforeach
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                @else
                    <a disabled="disabled" title="{{getCustomTranslation("no_link")}}" target="_blank" type="button" data-bs-custom-class="tooltip-inverse"
                       id="kt_app_layout_builder_toggle"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       data-bs-dismiss="click"
                       data-bs-trigger="hover"
                       class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                    >
                        <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                                                    <i class="fa fa-eye"></i>
                                                            </span>
                    </a>
                @endif
            </td>

            <td>
            <?php
                  $label = $row->active ? getCustomTranslation('active') : getCustomTranslation('inactive');
                      $checked = $row->active ? 'checked' : '';

                ?>
                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" >
                    <input class="form-check-input" type="checkbox" value="" name="notifications" {{$checked}} onclick="toggleActive({{$row->id}} )">
                    <label class="form-check-label" id="active-label-{{$row->id}}"> {{$label}}</label>
                </div>
            </td>


            <td class="text-end">
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
                    <!--end::Svg Icon-->
                </a>
                <!--begin::Menu-->
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        @can('update_companies')
                        <a href="{{route('company.edit',$row->id)}}"
                           class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                        @endcan
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        @can('delete_companies')
                        <a href="#" data-kt-company-table-filter="delete_row"
                           class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
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
{{ $data->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $data,'perPage' =>Request::get('perPage') ?? $data->perPage()]) }}

@else
    <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
@endif
</div>