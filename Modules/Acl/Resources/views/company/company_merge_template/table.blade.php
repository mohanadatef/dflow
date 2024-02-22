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
        <th class="min-w-125px">{{getCustomTranslation('id')}}</th>
        <th class="w-450px" style="text-align:left !important">{{getCustomTranslation('name_en')}}</th>
        <th class="w-125px" style="text-align:left !important">{{getCustomTranslation('name_ar')}}</th>
        <th class="w-125px" style="text-align:left !important">{{getCustomTranslation('sheet_duplicate_ids')}}</th>
        <th class="w-125px" style="text-align:left !important">{{getCustomTranslation('system_duplicate_ids')}}</th>
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
                <a target="_blank" href="{{route('company.edit',['id' => $row->company_id])}}"> {{ $row->company_id }}</a>
            </td>
            <td>
                {{$row->name_en}}
            </td>
            <td>
                {{$row->name_ar}}
            </td>
            <td>
                @foreach(explode(',',$row->merge_id_sheet) as $id)
                    @if(!empty($id))
                        <a target="_blank" href="{{route('company.edit',['id' => $id])}}"> {{ $id }}</a>
                    @endif
                @endforeach
            </td>
            <td>
                @foreach(explode(',',$row->merge_id_system) as $id)
                    @if(!empty($id))
                        <a target="_blank" href="{{route('company.edit',['id' => $id])}}"> {{ $id }}</a>
                    @endif
                @endforeach
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
                        <a href="{{route('company_merge_template.merge',$row->id)}}"
                           class="menu-link px-3">{{getCustomTranslation('merge')}}</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" data-kt-company-table-filter="delete_row"
                           class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
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
