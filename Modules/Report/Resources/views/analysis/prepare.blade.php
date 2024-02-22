@extends('dashboard.layouts.app')

@section('content')

{{--<script src="https://cdn.tiny.cloud/1/y1u7blwxqr1qidp5qkhppfgsd0w6k7wr056oe2tp4yumt5md/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>--}}

<div style="min-height:700px">

<form action="{{route('reports.analysis.viewPost')}}" method="POST" class="row g-6 g-xl-9">
    @csrf
    <input type="hidden" name="company_id" value="{{request('company_id')}}" />
    <input type="hidden" name="ranges" value="{{ request('ranges') }}" />

    @if(count($companiesData))
        <div class="">
            <div class="card border-transparent" data-theme="light" style="background-color: #1C325E;">
                <!--begin::Body-->
                <div class="card-body d-flex ps-xl-15">
                    <!--begin::Wrapper-->
                    <div class="m-0">
                        <!--begin::Title-->
                        <div class="position-relative fs-2x z-index-2 fw-bold text-white mb-7">
                        <span class="me-2">{{getCustomTranslation("you_can_insert_social_data_For")}}
                        <span class="position-relative d-inline-block text-danger">
                            <span class="text-danger opacity-75-hover">{{getCustomTranslation("each_competitor")}}</span>
                            <!--begin::Separator-->
                            <span class="position-absolute opacity-50 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                            <!--end::Separator-->
                        </span></span>
                        <br>{{getCustomTranslation("update_fields_bellow_then_generate_pdf")}} ...</div>
                        <!--end::Title-->
                        <!--begin::Action-->
                        <div class="mb-3">

                            @can('competitive_analysis_page')
                            <a href="{{route('reports.competitive_analysis',['company_id'=>request('company_id'), 'ranges' => request('ranges')])}}" class="btn btn-danger fw-semibold px-6 py-3">Change Time range</a>
                          @endcan


                            <button type="submit" class="btn btn-success fw-semibold px-6 py-3">{{getCustomTranslation("generate_pdf")}}</button>
                        </div>
                        <!--begin::Action-->
                    </div>
                    <!--begin::Wrapper-->
                    <!--begin::Illustration-->
                    <img src="{{ asset('dashboard/assets/media/illustrations/sigma-1/17-dark.png')}}" class="position-absolute me-3 bottom-0 end-0 h-200px" alt="">
                    <!--end::Illustration-->
                </div>
                <!--end::Body-->
            </div>
        </div>

        @foreach($companiesData as $competitor)
            <div class=" col-md-6 col-xxl-6">
                <div class="card card-flush mb-xxl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">{{ $competitor['company']->{'name_'.$lang} }}</span>
                            <span class="text-gray-400 pt-2 fw-semibold fs-6">
                                {{getCustomTranslation("all_possible_company_platforms")}}
                            </span>
                        </h3>
                        <!--end::Title-->

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Nav-->
                        <ul class="nav nav-pills nav-pills-custom mb-3" role="tablist">
                            @foreach($platforms as $platform)
                            <!--begin::Item-->
                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px h-85px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_{{$competitor['company']->id}}_{{$platform->id}}" aria-selected="false" role="tab" tabindex="-1">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt="" src="{{ asset('dashboard/assets/media/svg/social-logos/' . Str::lower($platform->name_en) . '.svg') }}" class="animated pulse infinite">
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">{{ $platform->{'name_'.$lang} }}</span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            @endforeach

                        </ul>
                        <!--end::Nav-->
                        <!--begin::Tab Content-->
                        <div class="tab-content">
                            @foreach($platforms as $platform)
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_stats_widget_1_tab_{{$competitor['company']->id}}_{{$platform->id}}" role="tabpanel">
                                <!--begin::Table container-->
                                <div>
                                    <textarea name="company[{{$competitor['company']->id}}][{{$platform->id}}]" class="form-control">{!! \Modules\Acl\Entities\CompanySocial::where('platform_id', $platform->id)->where('company_id', $competitor['company']->id)->first()?->content !!}</textarea>
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Tap pane-->
                            @endforeach
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>
        @endforeach
    @else
        <div class="card bgi-position-y-bottom bgi-position-x-end bgi-no-repeat bgi-size-cover min-h-250px bg-primary mb-5 mb-xl-8" style="background-color: ;background-position: 100% 50px;background-size: 500px auto;background-image:url('{{asset('dashboard/assets/media/misc/city.png')}}')">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column justify-content-center ps-lg-12">
                <!--begin::Title-->
                <h3 class="text-white fs-2qx fw-bold mb-7">{{getCustomTranslation("no_competitors")}}
                <br>{{getCustomTranslation("to_show_in_this_time_range")}}</h3>
                <!--end::Title-->
                <!--begin::Action-->
                <div class="m-0">

                    @can('competitive_analysis_page')
                    <a href="{{route('reports.competitive_analysis',['company_id'=>request('company_id'), 'ranges' => request('ranges')])}}" class="btn btn-danger fw-semibold px-6 py-3">Change Time range</a>
                    @endcan

                        <button type="submit" class="btn btn-success fw-semibold px-6 py-3">{{getCustomTranslation("generate_pdf")}}</button>
                </div>
                <!--begin::Action-->
            </div>
            <!--end::Body-->
        </div>
    @endif

</form>
</div>


@endsection

@push('styles')

@endpush

@push('scripts')

<script>
    tinymce.init({
        selector: '.tiny',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
    });


</script>

@endpush
