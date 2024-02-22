<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($data))
        <div id="kt_project_users_card_pane" class="tab-pane fade active show" role="tabpanel">
            <!--begin::Row-->
            <div class="row g-6 g-xl-9">
                @foreach($data as $dat)
                    <!--begin::Col-->
                    <div class="col-md-6 col-xxl-4">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center flex-column p-9">

                                <div class="d-flex flex-stack mb-3 w-100">
                                    <!--begin::Badge-->

                                    <div></div>

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

                                                @can('competitive_analysis_page')
                                            <div class="menu-item px-3">
                                                <a href="{{route('reports.competitive_analysis', ['company'=>$dat->id])}}"
                                                   class="menu-link flex-stack px-3" target="_blank">
                                                    {{getCustomTranslation('competitive_analysis')}}
                                                    <i class="fas fa-eye text-primary ms-2 fs-7"
                                                       data-bs-toggle="tooltip"
                                                       aria-label="Specify a target name for future usage and reference"
                                                       data-kt-initialized="1"></i>
                                                </a>
                                            </div>
                                                    @endcan

                                            @if(count($dat->company_website) > 0)
                                                @foreach($dat->company_website as $site)
                                                    <div class="menu-item px-3">
                                                        <a href="{{$site['url']}}" target="_blank"
                                                           class="menu-link flex-stack px-3">{{$site->website['name_'.$lang]}}
                                                            <i
                                                                    class="fas fa-eye text-primary ms-2 fs-7"
                                                                    data-bs-toggle="tooltip"
                                                                    aria-label="Specify a target name for future usage and reference"
                                                                    data-kt-initialized="1"></i></a>
                                                    </div>

                                                    <!--begin::Menu item-->

                                                @endforeach
                                                <!--end::Menu item-->
                                                <!--end::Menu-->
                                            @else

                                                <div class="menu-item px-3">
                                                    <a disabled="disabled" title="{{getCustomTranslation("no_link")}}"
                                                       target="_blank" type="button" data-bs-custom-class="tooltip-inverse"
                                                       id="kt_app_layout_builder_toggle"
                                                       data-bs-toggle="tooltip"
                                                       data-bs-placement="top"
                                                       data-bs-dismiss="click"
                                                       data-bs-trigger="hover"
                                                       class="menu-link flex-stack px-3"
                                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                    >{{getCustomTranslation('no_link')}}
                                                        <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                                        <i
                                                                class="fas fa-eye text-primary ms-2 fs-7"
                                                                data-bs-toggle="tooltip"
                                                                aria-label="Specify a target name for future usage and reference"
                                                                data-kt-initialized="1"></i></a>
                                                    </a>
                                                </div>
                                            @endif
                                            @if($userType != 1)
                                                <div class="menu-item px-3">
                                                    <a href="{{route('company.edit', ['id'=>$dat->id])}}"
                                                       class="menu-link flex-stack px-3" target="_blank">
                                                        {{getCustomTranslation('edit')}}
                                                        <i class="fas fa-eye text-primary ms-2 fs-7"
                                                           data-bs-toggle="tooltip"
                                                           aria-label="Specify a target name for future usage and reference"
                                                           data-kt-initialized="1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            <!--end::Menu item-->
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
                                <div class="symbol symbol-65px symbol-circle mb-5">
                                    @if($dat->iconUrl)
                                        <img src="{{$dat->iconUrl}}" alt="Avatar">
                                    @else

                                        <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger">{{$dat->{'name_'.$lang}[0]}}</div>

                                    @endif

                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                {{ $dat->{'name_'.$lang} }}
                                <!--end::Name-->
                                <!--begin::Position-->
                                <!--end::Position-->
                                <!--begin::Info-->

                                <div class="d-flex flex-center flex-wrap">
                                    <!--begin::Stats-->
                                    <div
                                            class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-6 fw-bold text-gray-700">
                                            {{implode(',',$dat->industry->pluck('name_'.$lang)->toArray()) ?? getCustomTranslation('no_industry')}}
                                        </div>
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
        @if (@$data)
            {{ $data->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $data,'perPage' =>Request::get('perPage') ?? $data->perPage()]) }}
        @endif
    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
