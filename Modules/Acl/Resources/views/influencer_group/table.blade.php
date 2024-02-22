<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                               data-kt-check-target="#kt_users_table .item_check" value="1"/>
                    </div>
                </th>
                <th class="min-w-125px">{{getCustomTranslation('name_en')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('name_ar')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('platform')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('total_influencer')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('average_ads')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('researcher')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('count_ads')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('complete')}}</th>
                <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">

            @foreach($datas as $data)
                @php
                    $info = $data->info();
                 @endphp
                <tr id="remove{{$data->id}}">
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input item_check" type="checkbox" name="item_check"
                                   value="{{$data->id}}"/>
                        </div>
                    </td>
                    <td>
                        {{$data->name_en}}
                    </td>
                    <td>
                        {{$data->name_ar}}
                    </td>
                    <td>
                        {{implode(',',array_unique($data->influencer_follower_platform->pluck('platform.name_'.$lang)->toArray()))}}
                    </td>
                    <td>
                        {{$info['total_influencer']}}
                    </td>
                    <td>
                        {{$info['average_ads']}}
                    </td>
                    <td>
                        {{implode(',',$info['researcher'])}}
                    </td>
                    <td>
                        {{$info['count_ads']}}
                    </td>
                    <td>
                        {{$info['complete'] . " %"}}
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{getCustomTranslation('actions')}}
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                    </svg>
                                </span>
                            <!--end::Svg Icon--></a>
                        <!--begin::Menu-->
                        <div class="users-list-actions menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                @can('update_influencer_group')
                                <a href="{{route('influencer_group.edit',$data->id)}}"
                                   class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                @endcan
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                @can('delete_influencer_group')
                                <a href="#" data-kt-users-table-filter="delete_row"
                                   class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                @endcan
                            </div>
                            <div class="menu-item px-3">
                                <a href="{{route('influencer_group_log.index',['influencer_group_id'=>$data->id])}}"
                                   class="menu-link px-3">{{getCustomTranslation('log')}}</a>
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

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
