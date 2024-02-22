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
                <th>{{getCustomTranslation('id_request')}}</th>
                <th>{{getCustomTranslation('id_ad')}}</th>
                <th>{{getCustomTranslation('ad_Date')}}</th>
                <th>{{getCustomTranslation('ad_Platform')}}</th>
                <th>{{getCustomTranslation('ad_Company')}}</th>
                <th>{{getCustomTranslation('ad_influencer')}}</th>
                <th>{{getCustomTranslation('request_create_at')}}</th>
                <th>{{getCustomTranslation('Status')}}</th>
                <th>{{getCustomTranslation('Client')}}</th>
                <th>{{getCustomTranslation('User')}}</th>
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
                        {{$data->id}}
                    </td>
                    <td>
                        {{$data->ad_record_id}}
                    </td>
                    <td>
                        {{strtok($data->ad_record->date,' ')}}
                    </td>
                    <td>
                        {{$data->ad_record->platform->{'name_'.$lang} }}
                    </td>
                    <td>
                        {{$data->ad_record->company->{'name_'.$lang} }}
                    </td>
                    <td>
                        {{$data->ad_record->influencer->{'name_'.$lang} }}
                    </td>
                    <td>
                        {{$data->created_at}}
                    </td>
                    <td id="status-{{$data->id}}">
                        {{getCustomTranslation(requestAccessText()[$data->status])}}
                    </td>
                    <td>
                        {{$data->client->name}}
                    </td>
                    <td id="user-{{$data->id}}">
                        {{$data->user->name ?? ""}}
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
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                             data-kt-menu="true">
                            @can('status_request_ad_media_access')
                            @if($data->status == 1)
                                <div id="action-{{$data->id}}">
                                    <div class="menu-item px-3" id="action-approve-{{$data->id}}">
                                        <a href="#" onclick="approve({{$data->id}})"
                                           class="menu-link px-3">{{getCustomTranslation(requestAccessText()[2])}}</a>
                                    </div>
                                    <div class="menu-item px-3" id="action-reject-{{$data->id}}">
                                        <a href="#" onclick="rejectRequest({{$data->id}})"
                                           class="menu-link px-3">{{getCustomTranslation(requestAccessText()[3])}}</a>
                                    </div>
                                    <div class="menu-item px-3" id="action-canceled-{{$data->id}}">
                                        <a href="#" onclick="canceledRequest({{$data->id}})"
                                           class="menu-link px-3">{{getCustomTranslation(requestAccessText()[5])}}</a>
                                    </div>
                                </div>
                            @endif
                            @endcan
                            @can('log_request_ad_media_access')
                            <div class="menu-item px-3">
                                <a href="{{Route('request_ad_media_access_log.index',['request_ad_media_access_id'=>$data->id])}}"
                                   class="menu-link px-3">{{getCustomTranslation('view_log')}} </a>
                            </div>
                            @endcan
                            <div class="menu-item px-3">
                                <a href="{{route('ad_record.show',$data->ad_record_id)}}"
                                   class="menu-link px-3">{{getCustomTranslation('view_ad')}}</a>
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

