<!--begin::Card-->
@include('dashboard.error.error')
@if(count($datas))
    <div id="kt_project_users_card_pane" class="tab-pane fade active show" role="tabpanel">
        <!--begin::Row-->
        <div class="row g-6 g-xl-9">
            @foreach($datas as $data)
                <!--begin::Col-->
                <div id="card-{{$data->id}}" class="col-md-6 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column p-9">

                            <div class="d-flex flex-stack mb-3 w-100">

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
                                        @can('status_support_center')
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
                                        @endcan
                                        <!-- change permission to answer and add it to seeder -->
                                        @can('update_support_center')
                                        <div class="menu-item px-3">
                                            <a href="#"
                                               class="answerBtn-{{$data->id}} menu-link flex-stack px-3"
                                               onclick="toggleAnswer({{$data->id}})">
                                                {{ $data->is_answered ? getCustomTranslation('answered') : getCustomTranslation('not_answered') }}
                                                <i class="fas fa-toggle-{{$data->is_answered ? 'off' : 'on' }} text-primary ms-2 fs-7"
                                                   data-bs-toggle="tooltip"
                                                   aria-label="Specify a target name for future usage and reference"
                                                   data-kt-initialized="1"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        <!--begin::Menu item-->
                                        @can('view_support_center')
                                        <div class="menu-item px-3">
                                            <a href="{{route('question.show', $data->id)}}"
                                               class="menu-link flex-stack px-3">
                                                {{getCustomTranslation('show')}}
                                                <i class="fas fa-eye text-primary ms-2 fs-7"
                                                   data-bs-toggle="tooltip"
                                                   aria-label="Specify a target name for future usage and reference"
                                                   data-kt-initialized="1"></i>
                                            </a>
                                        </div>
                                        @endcan
                                        <!--end::Menu item-->
                                        @can('update_support_center')
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{route('support_center.edit', $data->id)}}"
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

                                        @can('delete_support_center')
                                            <div class="menu-item px-3">
                                                <a href="{{route('question.delete', ['id' => $data->id])}}"
                                                   class="menu-link flex-stack px-3">
                                                    {{ getCustomTranslation('delete') }}
                                                </a>
                                            </div>
                                        @endcan
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--begin::Name-->
                            <a href="{{route('question.show', $data->id)}}"
                               class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $data->question }}
                            </a>
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-center flex-wrap">
                                <!--begin::Stats-->
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bold text-gray-700">
                                        {{  (count($data->answers)==0)?'N/A':number_format(count($data->answers)) }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">{{getCustomTranslation('answers')}}</div>
                                </div>
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bold text-gray-700">
                                        {{ $data->user->name }}

                                        {{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}
                                    </div>
                                    <div class="fw-semibold text-gray-400">{{getCustomTranslation('owner')}}</div>
                                </div>
                            </div>
                                <!--end::Stats-->

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                <!--end::Col-->
            @endforeach

        </div>
        <!--end::Row-->
@else
    <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
@endif
@if(count($datas))
    {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage(),'perArray'=>[12,24,48,96,192]]) }}

@endif





<!--end::Card-->


