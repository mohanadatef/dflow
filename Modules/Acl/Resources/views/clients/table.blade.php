<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->

            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_clients_table">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                   data-kt-check-target="#kt_clients_table .item_check" value="1"/>
                        </div>
                    </th>
                    <th class="min-w-125px">{{getCustomTranslation('name')}}</th>
                    <th class="min-w-125px">{{getCustomTranslation('email')}}</th>
                    <th class="min-w-125px">{{getCustomTranslation('company')}}</th>
                    <th class="min-w-125px" style="text-align:start !important">{{getCustomTranslation('active_status')}}</th>
                    @can('match_search_setting')
                    <th class="min-w-125px" style="text-align:start !important">{{getCustomTranslation('exact_match_search')}}</th>
                    @endcan
                    <th class="min-w-125px">{{getCustomTranslation('start_access')}}</th>
                    <th class="min-w-125px">{{getCustomTranslation('end_access')}}</th>
                    <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">

                    @foreach($datas as $data)
                    <tr id="remove{{$data->id}}">
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input item_check" type="checkbox" name="item_check"
                                       value="{{$data->id}}"/>
                            </div>
                        </td>
                        <td>
                            {{$data->name}}
                        </td>
                        <td>
                            {{$data->email}}
                        </td>
                        <td>
                            {{$data->company->{'name_'.$lang} ?? "" }}
                        </td>

                        <td>
                   <?php
                       $label = $data->active ? getCustomTranslation('active') : getCustomTranslation('inactive');
                       $checked = $data->active ? 'checked' : '';
                    ?>
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" >
                                <input class="form-check-input" type="checkbox" value="" name="notifications" {{$checked}} onclick="toggleActive({{$data->id}})">
                                <label class="form-check-label" id="active-label-{{$data->id}}">{{$label}}</label>
                            </div>

                        </td>
                        @can('match_search_setting')
                        <td>
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid" >
                                <input class="form-check-input" type="checkbox" value="" name="notifications" {{$data->match_search == 0 ? 'checked' : ''}} onclick="toggleSearch({{$data->id}})">
                                <label class="form-check-label" id="search-label-{{$data->id}}">{{$data->match_search == 0 ? getCustomTranslation('active') : getCustomTranslation('inactive')}}</label>
                            </div>

                        </td>
                        @endcan

                        <td>
                            {{strtok($data->start_access,' ')}}
                        </td>
                        <td>
                            {{strtok($data->end_access,' ')}}
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
                                    @can('view_clients')
                                    <a href="{{route('client.show',$data->id)}}" class="menu-link px-3">{{getCustomTranslation('view')}}</a>
                                    @endcan

                               </div>
                               <!--end::Menu item-->
                               <!--begin::Menu item-->
                               <div class="menu-item px-4">
                                @can('change_password_users')
                                <a href="{{url('acl/client/password/'.$data->id)}}" class="menu-link px-3">{{getCustomTranslation('change_passsword')}}</a>
                                @endcan

                               </div>
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    @can('update_clients')
                                    <a href="{{route('client.edit',$data->id)}}"
                                       class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                    @endcan
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    @can('delete_clients')
                                    <a href="#" data-kt-clients-table-filter="delete_row"
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



        {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
