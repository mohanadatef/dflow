<!--begin::Card-->
@include('dashboard.error.error')
@if(count($datas))
    <div id="kt_project_users_card_pane" class="tab-pane fade active show" role="tabpanel">
        <!--begin::Row-->
        <div class="row g-6 g-xl-9">
            @foreach($datas as $data)
                <!--begin::Col-->
                <div class="col-md-6 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column p-9">

                            <div class="d-flex flex-stack mb-3 w-100">
                                <!--begin::Badge-->
                                @if($data->active)
                                    <div class="activeBadge-{{$data->id}} badge badge-success">{{getCustomTranslation('active')}}</div>
                                @else
                                    <div class="activeBadge-{{$data->id}} badge badge-danger">{{getCustomTranslation('inactive')}}</div>
                                @endif
                                <!--end::Badge-->
                                <!--begin::Menu-->
                                <div class="mt--3">
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                        <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                     viewBox="0 0 24 24">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="5" y="5" width="5" height="5" rx="1"
                                              fill="currentColor"></rect>
                                        <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor"
                                              opacity="0.3"></rect>
                                        <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor"
                                              opacity="0.3"></rect>
                                        <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor"
                                              opacity="0.3"></rect>
                                    </g>
                                </svg>
                            </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu 3-->
                                    <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                            data-kt-menu="true" style="">
                                        <!--begin::Heading-->
                                        <!-- <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Actions</div>
                                        </div> -->
                                        <!--end::Heading-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('influencer.show', $data->id)}}"
                                               class="menu-link flex-stack px-3">
                                                {{getCustomTranslation('show')}}
                                                <i class="fas fa-eye text-primary ms-2 fs-7"
                                                   data-bs-toggle="tooltip"
                                                   aria-label="Specify a target name for future usage and reference"
                                                   data-kt-initialized="1"></i>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        @can('update_influencers')
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#"
                                                   class="activeBtn-{{$data->id}} menu-link flex-stack px-3"
                                                   onclick="toggleActive({{$data->id}})">
                                                    {{ $data->active ? getCustomTranslation('inactive') : getCustomTranslation('active') }}
                                                    <i class="fas fa-toggle-{{$data->active ? 'off' : 'on' }} text-primary ms-2 fs-7"
                                                       data-bs-toggle="tooltip"
                                                       aria-label="Specify a target name for future usage and reference"
                                                       data-kt-initialized="1"></i>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{route('influencer.edit', $data->id)}}"
                                                   class="menu-link flex-stack px-3">
                                                    {{getCustomTranslation('edit')}}
                                                    <i class="fas fa-edit text-info ms-2 fs-7"
                                                       data-bs-toggle="tooltip"
                                                       aria-label="Specify a target name for future usage and reference"
                                                       data-kt-initialized="1"></i>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        @endcan
                                        @can('merge_influencers')
                                        <div class="menu-item px-3">
                                            <a href="{{route('influencer.merge.info', $data->id)}}"
                                               class="menu-link flex-stack px-3">
                                                {{getCustomTranslation('merge')}}
                                                <i class="fas fa-edit text-info ms-2 fs-7"
                                                   data-bs-toggle="tooltip"
                                                   aria-label="Specify a target name for future usage and reference"
                                                   data-kt-initialized="1"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        <!--begin::Menu item-->
                                        <!-- <div class="menu-item px-3">
                                            <a href="#" data-kt-influencer-table-filter="delete_row" class="menu-link flex-stack px-3">Delete
                                                <i class="fas fa-trash text-danger ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a target name for future usage and reference" data-kt-initialized="1"></i></a>
                                            </a>
                                        </div> -->
                                        <!--end::Menu item-->

                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--begin::Avatar-->
                                <?php $image = $data->gender == 'Male' ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png') ?>
                                <?php $snapchat_avatar = $data->influencer_follower_platform->where('platform_id', 1)
                                ->first() ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $data->influencer_follower_platform->where('platform_id',
                                    1)->first()->url . "&type=SVG&bitmoji=enable" : $image; ?>

                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img
                                        src="{{$data->image ? getFile($data->image->file??null,pathType()['ip'],getFileNameServer($data->image)) : $snapchat_avatar }}"
                                        alt="Avatar">
                                <div
                                        class="{{$data->active ? 'bg-success' : 'bg-danger'}} position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="{{route('influencer.show', $data->id)}}"
                               class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $data->{'name_'.$lang} }}
                                @if($data->mawthooq)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                         viewBox="0 0 24 24">
                                        <path
                                                d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                fill="green"/>
                                        <path
                                                d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                fill="white"/>
                                    </svg>
                                @endif
                            </a>
                            <!--end::Name-->

                            <!--begin::Position-->
                            <div class="fw-semibold text-gray-400 mb-6">
                                @if(isset($data->country))
                                    {{ implode(',',$data->country->pluck('name_'.$lang)->toArray())  }}
                                @endif
                            </div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center flex-wrap">
                                <!--begin::Stats-->
                                <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bold text-gray-700">
                                        {{  (count($data->ad_record)==0)?'N/A':number_format(count($data->ad_record)) }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">{{getCustomTranslation('ads_count')}}</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bold text-gray-700">
                                        @php
                                            $ads_cost=$data->ads_cost();
                                        @endphp
                                        {{  ($ads_cost->price??0)==0?'N/A':number_format($ads_cost->price) }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">{{$ads_cost->service->{'name_'.$lang} ?? getCustomTranslation('estimated_cost') }}</div>
                                </div>
                                <!--end::Stats-->

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            @endforeach

        </div>
        <!--end::Row-->

    </div>
    <div id="kt_project_users_table_pane" class="tab-pane fade">

        <div class="card card-flush">
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table id="kt_influencer_table"
                           class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                        <!--begin::Head-->
                        <thead class="fs-7 text-gray-400 text-uppercase">
                        <tr>
                            @can('delete_influencers')
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                               data-kt-check-target="#kt_influencer_table .item_check" value="1"/>
                                    </div>
                                </th>
                                <th class="min-w-20px">{{getCustomTranslation('id')}}</th>
                            @endcan
                            <th class="min-w-50px">{{getCustomTranslation('mawthooq')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('name')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('total_ads')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('ads_cost')}}</th>
                            @can('update_influencers')
                                <th class="min-w-50px">{{getCustomTranslation('active_status')}}</th>
                            @endcan
                            @canany(['update_influencers','delete_influencers'])
                                <th class="min-w-50px">{{getCustomTranslation('actions')}}</th>
                            @endcanany
                        </tr>
                        </thead>
                        <!--end::Head-->
                        <!--begin::Body-->
                        <tbody class="fs-6">
                        @foreach($datas as $data)
                            <tr>
                                @can('delete_influencers')
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input item_check" type="checkbox"
                                                   name="item_check"
                                                   value="{{$data->id}}"
                                            />
                                        </div>
                                    </td>

                                    <td>{{$data->id}}</td>
                                    <td>
                                        @if($data->mawthooq)
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                     viewBox="0 0 24 24">
                                                    <path
                                                            d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                            fill="green"/>
                                                    <path
                                                            d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                            fill="white"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                @endcan
                                    <?php $image = $data->gender == 'Male' ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png') ?>
                                    <?php $snapchat_avatar = $data->influencer_follower_platform->where('platform_id',
                                    1)
                                    ->first() ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $data->influencer_follower_platform->where('platform_id',
                                        1)->first()->url . "&type=SVG&bitmoji=enable" : $image; ?>

                                <td>
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Wrapper-->
                                        <div class="me-5 position-relative">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img
                                                        src="{{$data->image ? getFile($data->image->file??null,pathType()['ip'],getFileNameServer($data->image)) : $snapchat_avatar }}"
                                                        alt="Avatar"/>
                                            </div>
                                            <!--end::Avatar-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-column justify-content-center">
                                            <a href="{{route('influencer.show', $data->id)}}"
                                               class="mb-1 text-gray-800 text-hover-primary">{{$data->{'name_'.$lang} }}</a>
                                            <div
                                                    class="fw-semibold fs-6 text-gray-400">
                                                @if(isset($data->country))
                                                    {{ implode(',',$data->country->pluck('name_'.$lang)->toArray()) }}
                                                @endif
                                            </div>
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User-->
                                </td>
                                <td>

                                    {{  (count($data->ad_record)==0)?'N/A':number_format(count($data->ad_record)) }}
                                </td>
                                <td>

                                    @php
                                                $ads_cost=$data->ads_cost();
                                    @endphp
                                    {{  ($ads_cost->price??0) == 0 ?'N/A':number_format($ads_cost->price) }}
                                </td>
                                @can('update_influencers')
                                    <td>
                                        <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">

                                            <input class="form-check-input activeInput-{{$data->id}}"
                                                   type="checkbox" value="" name="notifications"
                                                   {{ $data->active ? 'checked' : '' }} onclick="toggleActive({{$data->id}})">


                                            <label class="form-check-label"
                                                   id="active-label-{{$data->id}}">{{$data->active ? getCustomTranslation('active') : getCustomTranslation('inactive')}}</label>
                                        </div>
                                    </td>
                                @endcan
                                @canany(['update_influencers','delete_influencers'])

                                    <td>
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            {{getCustomTranslation('actions')}}
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
                                            @can('update_influencers')
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{route('influencer.edit', $data->id)}}"
                                                       class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                                </div>
                                                <!--end::Menu item-->
                                            @endcan
                                                @can('merge_influencers')
                                                <div class="menu-item px-3">
                                                    <a href="{{route('influencer.merge.info', $data->id)}}"
                                                       class="menu-link px-3">{{getCustomTranslation('merge')}}</a>
                                                </div>
                                                @endcan
                                            @can('delete_influencers')
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" data-kt-influencer-table-filter="delete_row"
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

        </div>
    </div>

@else
    <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
@endif
@if(count($datas))
    {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage(),'perArray'=>[12,24,48,96,192]]) }}

@endif





<!--end::Card-->


