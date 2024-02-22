@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('details') ." ".getCustomTranslation('Influencer'))

@section('content')
    <form action="" id="form_id">
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{getCustomTranslation('influencer_discover')}}</h3>
                </div>
                <!--end::Card title-->
            </div>

            <div class="row" id="buttons" style="margin-left: 10px;margin-bottom: 10px">

                <div class="col-md-4">
                    @if(!$userType)
                        @can('export_influencers')
                            <button class="btn btn-primary" id="export" disabled
                                    onclick="discoverExport()">{{getCustomTranslation('export')}} {{getCustomTranslation('inf_allocation')}}
                            </button>
                        @endcan
                    @endif
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary" id="tracker" type="button" disabled onclick="linkTracker()">
                        {{getCustomTranslation('create_link_tracker')}}
                    </button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" id="calander" type="button" disabled data-bs-toggle="modal"
                            data-bs-target="#create">{{getCustomTranslation('add_to_my_calander')}}
                    </button>
                </div>

            </div>

            <!--begin::Card header-->
            <!--begin::Content-->

            <!--begin::Form-->
            <!--begin::Card body-->
            <div class="card-body  pt-0">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <input type="text" name="search" value="{{$search}}" id="search" autocomplete="off"
                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 "
                           placeholder="{{getCustomTranslation('search')}}"/>
                </div>

                <!--end::Separator-->
                <!--begin::Content-->
                <div class="row" data-kt-user-table-filter="form">
                    <!--begin::Input group-->
                    <div class="col-md-2">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('country')}}:</label>
                        <select name="country[]" id="country" multiple="multiple"
                                class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                onchange="getInfluencer()" data-placeholder="{{getCustomTranslation('select_option')}}"
                                data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="false">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}"
                                        @if($country->id == request('country_id')) selected @endif>{{$country->{'name_'.$lang} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="col-md-3">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('category')}}:</label>
                        <select name="category[]" id="category" multiple="multiple"
                                class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                onchange="getInfluencer()" data-placeholder="{{getCustomTranslation('select_option')}}"
                                data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="false">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if($category->id == request('category')) selected @endif>{{$category->{'name_'.$lang} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="col-md-3">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('platform')}}:</label>
                        <select name="platform[]" id="platform" multiple="multiple"
                                class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                onchange="getInfluencer()" data-placeholder="{{getCustomTranslation('select_option')}}"
                                data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="false">
                            @foreach($platforms as $platform)
                                <option value="{{$platform->id}}"
                                        @if($platform->id == request('platform')) selected @endif>{{$platform->{'name_'.$lang} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="col-md-2">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('gender')}}:</label>
                        <select name="gender[]" id="gender" multiple="multiple"
                                class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                onchange="getInfluencer()" data-placeholder="{{getCustomTranslation('select_option')}}"
                                data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="false">
                            @foreach($genders as $gender)
                                <option value="{{$gender}}"
                                        @if($gender==request('gender')) selected @endif>{{getCustomTranslation($gender)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="col-md-2">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('sizes')}}:</label>
                        <select name="size[]" id="size" multiple="multiple"
                                class="form-select form-select-solid fw-bold"
                                data-kt-select2="true" onchange="getInfluencer()"
                                data-placeholder="{{getCustomTranslation('select_option')}}"
                                data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="false">
                            @foreach($sizes as $size)
                                <option value="{{$size->id}}"
                                        @if($size->id == request('size')) selected @endif>{{$size->{'name_'.$lang} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Content-->


                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">

                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                            <th class="min-w-100px">#</th>
                            <th class="min-w-100px">{{getCustomTranslation('mawthooq')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('name')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('country')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('platform')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('type')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('category')}}</th>
                            <th class="min-w-100px">{{getCustomTranslation('gender')}}</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-semibold text-gray-600" id="body-influencer">
                        @foreach($influencers as $influencer)

                            <tr>

                                <td><input type="checkbox" name="infuencerSelect[]" id="{{$influencer->id}}"
                                           value="{{$influencer->id}}" onclick="influencerCheck()"></td>
                                <td>
                                    @if($influencer->mawthooq)
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

                                <td>
                                    <a href="{{route('influencer.show',['id'=>$influencer->id])}}">{{$influencer->{'name_'.$lang} }}</a>
                                </td>
                                <td>
                                    {{implode(',',$influencer->country->pluck('name_'.$lang)->toArray())}}
                                </td>
                                <td>
                                    {{implode(',',$influencer->platform->pluck('name_'.$lang)->toArray())}}
                                </td>
                                <td>@foreach($influencer->influencer_follower_platform as $follower)
                                        {{$follower->size->{'name_'.$lang} ?? ""}},
                                    @endforeach
                                </td>
                                <td
                                    {{implode(',',$influencer->category->pluck('name_'.$lang)->toArray())}}
                                </td>
                                <td>{{getCustomTranslation($influencer->gender)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!--begin::Input group-->

                <!--end::Input group-->
            </div>
            <!--end::Input group-->
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">

            </div>
            <!--end::Actions-->
        </div>
        <!--end::Content-->

    </form>
    @if(!$userType)
        <div class="modal fade" tabindex="-1" id="create">
            <div class="modal-dialog">
                <div class="modal-content position-absolute">
                    <div class="modal-header">
                        <h5 class="modal-title">{{getCustomTranslation('add_to_my_calendar')}}</h5>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="currentColor"/>
                            </svg>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <form action="" id="kt_contact_form">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('name')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <input id="name" type="text" name="title" value=""
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('name')}}"/>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('from')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <input id="from" type="date" name="from" value=""
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('from')}}"/>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('to')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <input id="to" type="date" name="to" value=""
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('to')}}"/>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{getCustomTranslation('campaign')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <input id="campaign" type="text" name="campaign" value=""
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="{{getCustomTranslation('campaign')}}"/>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>

                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('description')}}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                        <textarea id="description" type="text" name="description"
                                                  class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                  placeholder="Description"></textarea>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">{{getCustomTranslation('close')}}</button>
                        <button id="kt_contact_submit_button" type="button" class="btn btn-primary">
                        <span id="save-spinner" class="save-spinner spinner-border spinner-border-sm d-none"
                              role="status" aria-hidden="true"></span>
                            {{getCustomTranslation('save_changes')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script src="{{ asset('dashboard') }}/assets/js/custom/pages/general/add_event_v2.js?v=243323"></script>
    <script>
        $('#buttons').hide();
        var route = "{{ route('influencer.index') }}";

        function checkboxesValue() {
            let checkboxes = document.querySelectorAll('input[name="infuencerSelect[]"]:checked');
            let values = [];
            checkboxes.forEach((checkbox) => {
                values.push(checkbox.value);
            });
            return values;
        }

        $('input[name=search]').on('input', function () {

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                getInfluencer();

            }.bind(this), 800);
        });

        function getInfluencer() {

            $('#body-influencer').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            searchValue = document.getElementById('search').value;
            const platform = document.querySelectorAll('#platform option:checked');
            platformValue = Array.from(platform).map(el => el.value);
            const category = document.querySelectorAll('#category option:checked');
            categoryValue = Array.from(category).map(el => el.value);
            const country = document.querySelectorAll('#country option:checked');
            countryValue = Array.from(country).map(el => el.value);
            const size = document.querySelectorAll('#size option:checked');
            sizeValue = Array.from(size).map(el => el.value);
            const gender = document.querySelectorAll('#gender option:checked');
            genderValue = Array.from(gender).map(el => el.value);
            // arr.length === 0
            if (searchValue == '' && platformValue.length === 0 && categoryValue.length === 0
                && countryValue.length === 0 && sizeValue.length === 0 && genderValue.length === 0
            ) {
                $('#body-influencer').empty();
            } else {
                show = "{{route('influencer.show',['id'=>'id'])}}/",
                    $.ajax({
                        type: "GET",
                        url: "{{route('influencer.searchDiscover')}}",
                        data: {
                            "gender": genderValue,
                            "size": sizeValue,
                            "country": countryValue,
                            "category": categoryValue,
                            "platform": platformValue,
                            "search": searchValue,
                            "company_id": '{{request('company_id')}}',
                            "ranges": '{{request('ranges')}}',
                        },
                        success: function (res) {
                            $('#buttons').hide();

                            let text = '';
                            maleText = "{{getCustomTranslation('male')}}";
                            femaleText = "{{getCustomTranslation('female')}}";
                            for (let x in res) {
                                genderText = res[x].gender == 'male' ? maleText : femaleText;
                                text += `<tr>
                   <td><input type="checkbox" name="infuencerSelect[]" id="${res[x].id}" value="${res[x].id}" onclick="influencerCheck()"></td>
                      `;
                                if (res[x].mawthooq == 1) {
                                    text += `                   <td>                             <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                    <path
                                        d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                        fill="green"/>
                                    <path
                                        d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                        fill="white"/>
                                </svg>
                            </div>
</td>`
                                } else {
                                    text += `<td></td>`
                                }
                                text += `<td>
                    <a href="${show.replace('id', res[x].id)}">${res[x]['name_{{$lang}}']}</a>
                   </td>
                   <td>`;
                                array_text = [];
                                for (let i in res[x].country) {
                                    array_text.push(res[x].country[i]['name_{{$lang}}'])
                                }
                                text += array_text;
                                text += `</td><td>`;
                                array_text = [];
                                for (let i in res[x].platform) {
                                    array_text.push(res[x].platform[i]['name_{{$lang}}'])
                                }
                                text += array_text;
                                text += `</td><td>`;
                                array_text = [];
                                for (let i in res[x].influencer_follower_platform) {
                                    if (res[x].influencer_follower_platform[i].size_id != null) {
                                        array_text.push(res[x].influencer_follower_platform[i].size['name_{{$lang}}'])
                                    }
                                }
                                text += [...new Set(array_text)];
                                text += `</td><td>`;
                                array_text = [];
                                for (let i in res[x].category) {
                                    array_text.push(res[x].category[i]['name_{{$lang}}'])
                                }
                                text += array_text;
                                text += `</td><td>${genderText}</td>
                        </tr>`;

                            }
                            $('#body-influencer').html(text);
                        },
                        error: function (res) {
                            for (let err in res.responseJSON.errors) {
                                toastr.error(res.responseJSON.errors[err]);
                            }
                        }
                    });

            }


        }

        function influencerCheck() {
            checkboxes = checkboxesValue();
            if (checkboxes.length) {
                $('#buttons').show();
                document.getElementById("calander").disabled = false;
                document.getElementById("tracker").disabled = false;
                document.getElementById("export").disabled = false;
            } else {
                $('#buttons').hide();
                document.getElementById("calander").disabled = true;
                document.getElementById("tracker").disabled = true;
                document.getElementById("export").disabled = true;
            }

        }

        function linkTracker() {
            values = checkboxesValue();
            url = "{{route('influencer.discover')}}?id=" + values;
            $.ajax({
                type: "POST",
                url: "{{route('influencer.link_tracker')}}",
                data: {
                    'url': url,
                    'influencer': values
                },
                success: function (res) {
                    toastr.success("{{getCustomTranslation('the_link_tracker_is_successfully_created')}}");
                    window.location.href = "{{route('linktracking.index')}}/" + res[0].id + "/edit";
                },
                error: function (res) {
                    for (let err in res.responseJSON.errors) {
                        toastr.error(res.responseJSON.errors[err]);
                    }
                }
            });
        }

        function discoverExport() {
            values = checkboxesValue();
            url = "{{route('influencer.discoverExport')}}";
            $("#form_id").attr("action", url);
            $("#form_id").submit();
            toastr.success("{{getCustomTranslation('the_process_done')}}");
        }

        $(document).ready(function () {
            $('#create').on('shown.bs.modal', function (e) {
                success_message = "{{getCustomTranslation('a_new_event_is_added_successfully')}}";
                let values = checkboxesValue();

                let myArrayQry = values.map(function (el, idx) {
                    return 'influencer[' + idx + ']=' + el;
                }).join('&');
                route = "{{route('influencer.discoverCalander')}}?" + myArrayQry;
                calender = false;
            });
            $('#create').on('hidden.bs.modal', function (e) {
                reset_form();
            })
        });

        function closeModal(id) {
            $(`#${id}`).modal('toggle');
        }

        function reset_form(from_date = "", to_date = "") {
            $('[name="from"]').val(from_date);
            $('#to').val(to_date);
            $('#campaign').val("");
            $('#description').val("");
            $('#name').val("");
            $('.invalid-feedback').empty();
            $('#influencer').empty();
            $('#influencer_update').empty();
        }


    </script>
@endpush
