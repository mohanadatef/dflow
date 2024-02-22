<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ad_record_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                @can('delete_ad_record_draft')
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                               data-kt-check-target="#kt_ad_record_table .form-check-input" value="1"/>
                    </div>
                </th>
                @endcan
                <th class="min-w-70x">{{getCustomTranslation('ad_date')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('company')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('influencer')}}</th>
                <th class="min-w-200px">{{getCustomTranslation('category')}}</th>
                <th class="min-w-200px">{{getCustomTranslation('platform')}}</th>
                @can('update_ad_record_draft')
                    <th class="min-w-125px">{{getCustomTranslation('researcher')}}</th>
                @endcan
                <th class="min-w-70x">{{getCustomTranslation('visit')}}</th>
                @can('update_ad_record_draft')
                <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                @endcan
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($datas as $data)
                <tr>
                    @can('delete_ad_record_draft')
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="item_check"
                                   value="{{$data->id}}"/>
                        </div>
                    </td>
                    @endcan
                    <td>
                        {{ $data->date ? date('Y-m-d', strtotime($data->date)) : ""}}
                    </td>
                    <td>
                        {{$data->company->{'name_'.$lang} ?? "" }}
                    </td>
                    <td>
                        {{isset($data->influencer->{'name_'.$lang} )?$data->influencer->{'name_'.$lang} :""}}
                    </td>
                    <td>
                        {{implode(',',$data->category->pluck('name_'.$lang)->toArray())}}
                    </td>
                    <td>
                        {{$data->platform->{'name_'.$lang} ?? ""}}
                    </td>
                    <td>
                        <a href="{{route('user.show', $data->user_id)}}">{{ $data->user->name }}</a>
                    </td>
                    <td>
                        <a href="{{route('ad_record_draft.show', $data->id)}}" type="button"
                           class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa fa-eye"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                    </td>
                    @canany('update_ad_record_draft','log_ad_record_draft','delete_ad_record_draft')
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
                            @can('update_ad_record_draft')
                            <div class="menu-item px-3">
                                <a href="{{route('ad_record_draft.edit',$data->id)}}"
                                   class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                            </div>
                            @endcan
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            @can('delete_ad_record_draft')
                            <div class="menu-item px-3">
                                <a href="#" data-kt-ad_record-table-filter="delete_row"
                                   class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                            </div>
                            @endcan
                            @can('log_ad_record_draft')
                            <div class="menu-item px-3">
                                <a href="{{route('ad_record_draft_log.index',['ad_record_draft_id'=>$data->id])}}"
                                   class="menu-link px-3">{{getCustomTranslation('log')}}</a>
                            </div>
                            @endcan
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>



