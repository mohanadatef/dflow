<div class="card-body ">
    @include('dashboard.error.error')

    <!--begin::Tables widget 8-->
    <div class="card h-xl-100">
        <!--begin::Header-->
        <div class="card-header position-relative py-0 border-bottom-2">
            <!--begin::Nav-->
            <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
                <!--begin::Nav item-->
                @foreach(weekSchedule() as $key =>$value)
                    <li class="nav-item p-0 ms-0 me-8">
                        <!--begin::Nav link-->
                        <a class="nav-link btn btn-color-muted px-0 day @if($key == $day ) show active @endif"
                           data-bs-toggle="tab" onclick="group({{$key}})" data-day="{{$key}}"
                           href="#kt_table_widget_7_tab_content_{{$key}}">
                            <!--begin::Title-->
                            <span class="nav-text fw-bold fs-4 mb-3 ">{{getCustomTranslation($value)}}</span>
                            <!--end::Title-->
                            <!--begin::Bullet-->
                            <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                            <!--end::Bullet-->
                        </a>
                        <!--end::Nav link-->
                    </li>
                    <!--end::Nav item-->
                @endforeach
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
            <!--begin::Toolbar-->

            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <!--begin::Tab Content (ishlamayabdi)-->
                    <div class="tab-content mb-2">
                        @foreach(weekSchedule() as $key =>$value)
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade @if($key == $day ) show active @endif"
                                 id="kt_table_widget_7_tab_content_{{$key}}">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle">
                                        <!--begin::Table head-->
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th ></th>
                                        </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                        @foreach($researchers as $researcher)
                                            <tr>
                                                <td class="fs-6 fw-bolder text-gray-800"><a
                                                            href="{{route('researcher_dashboard.researcherDashboard')}}?user_id={{$researcher->id}}">
                                                        {{$researcher->name}}
                                                    </a></td>
                                                <td class="fs-6 fw-bolder text-gray-400">{{getCustomTranslation('morning_group')}} :
                                                    @foreach($datas->where('day',$key)->where('researcher_id',$researcher->id)->where('shift',0) as $group)
                                                        <a href="#" class="btn btn-active-primary"
                                                           onclick="deleteGroup({{$group->id}})"> {{$group->influencer_group->{'name_'.$lang} }}
                                                            <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-x"></i>
                                    </span></a>

                                                    @endforeach
                                                </td>
                                                <td class="fs-6 fw-bolder text-gray-400">{{getCustomTranslation('night_group')}} :
                                                    @foreach($datas->where('day',$key)->where('researcher_id',$researcher->id)->where('shift',1) as $group)
                                                        <a href="#" class="btn btn-active-primary"
                                                           onclick="deleteGroup({{$group->id}})"> {{$group->influencer_group->{'name_'.$lang} }}
                                                            <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-x"></i>
                                    </span></a>

                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($key == $today && $researcher->reseacher_influencers_daily_count())
                                                    @can('update_influencer_group_schedule')
                                                    <!--begin::Add customer-->
                                                    <a href="{{route('influencer_group_schedule.edit',['researcher_id'=>$researcher->id])}}" class="btn btn-primary"> {{getCustomTranslation('edit_influencer_group')}} </a>
                                                    <!--end::Add customer-->
                                                    @endcan
                                                        @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                        @endforeach
                    </div>
                    <!--end::Tab Content-->
                    <!--begin::Action-->
                    <!--end::Action-->
                </div>
                <div class="col-md-3">
                    {{getCustomTranslation('influencer_group_still_not_assign')}}
                    <div id="group" style="overflow: scroll;height: 25%">

                    </div>
                </div>
            </div>
        </div>
        <!--end: Card Body-->
    </div>
    <!--end::Tables widget 8-->

</div>
