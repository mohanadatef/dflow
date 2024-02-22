@include('dashboard.error.error')
@if(count($dates))
    <table class="table align-middle table-row-dashed fs-6 gy-5"  id="kt_influencer_trend_table_new">
    <!--begin::Table head-->
    <thead>
    <!--begin::Table row-->
    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
        <th class="w-10px pe-2">

            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                <input class="form-check-input" type="checkbox" data-kt-check="true"
                       data-kt-check-target="#kt_influencer_trend_table_new .form-check-input" value="1"/>
            </div>

        </th>
        <th class="min-w-125px">{{getCustomTranslation('subject')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('influencer')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('platform')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('country')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('tag')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('date_from')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('date_to')}}</th>
        <th class="min-w-125px">{{getCustomTranslation('audience_impression')}}</th>
        <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
    </tr>
    <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody class="fw-semibold text-gray-600">
        @foreach ($dates as $influencer_trend)
            <tr>
                <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="item_check"
                               value="{{$influencer_trend->id}}"/>
                    </div>
                </td>
                <td>{{ $influencer_trend->subject }}</td>
                <td>{{ $influencer_trend->influencer->{'name_'.$lang} }}</td>
                <td>{{implode(',',$influencer_trend->platform->pluck('name_'.$lang)->toArray())}}</td>
                <td>{{ $influencer_trend->country->{'name_'.$lang} }}</td>
                <td>{{ $influencer_trend->tag->{'name_'.$lang} }}</td>
                <td>{{ date('Y-m-d', strtotime($influencer_trend->date_from))}}</td>
                <td>{{ date('Y-m-d', strtotime($influencer_trend->date_to))}}</td>
                <td>{{ getCustomTranslation($influencer_trend->audience_impression) }}</td>
                @can('update_influencer_trend')
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
                                @can('update_influencer_trend')
                                <a href="{{route('influencer_trend.edit',$influencer_trend->id)}}"
                                   class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                @endcan
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                @can('delete_influencer_trend')
                                <a href="#" data-kt-influencer_trend-table-filter="delete_row"
                                   class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                @endcan
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                    @endcan
            </tr>
        @endforeach
    </tbody>
</table>
{{ $dates->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $dates,'perPage' =>Request::get('perPage') ?? $dates->perPage()]) }}
@else
    <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
@endif
