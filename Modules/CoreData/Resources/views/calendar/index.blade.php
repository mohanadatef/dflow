@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('calendar'))

@push('styles')

    <link
        rel="stylesheet"
        href="{{asset('dashboard/assets/css/fullcalendar.min.css')}}"/>

    <style>
        .fc-event {
            font-size: 16px !important;
        }

        .fc-day-grid-event .fc-content {
            white-space: normal !important;
            overflow: hidden !important;
        }
        .form-control-inline {
            min-width: 0;
            width: 66px;
            display: inline;
        }
    </style>

@endpush


@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">

            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-select="base">
                    <!--begin::Add customer-->
                    <button id="create_event" class="btn btn-primary">{{getCustomTranslation('add')}} {{getCustomTranslation('event')}}</button>
                    <!--end::Add customer-->
                </div>

            </div>
            <!--end::Card header-->

            <div>
                <div id='calendar' class="pt-12" style="margin-bottom:150px;"></div>
            </div>
            <!--end::Datatable-->
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="create">
        <div class="modal-dialog">
            <div class="modal-content position-absolute">
                <div class="modal-header">
                    <h5 class="modal-title">{{getCustomTranslation('add')}} {{getCustomTranslation('event')}}</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
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
                                        <input id="from" type="date" name="from"
                                               value=""
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="{{getCustomTranslation('from')}}"
                                        />
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
                                        <input id="to" type="date" name="to"
                                               value=""
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
                                        <input id="campaign" type="text" name="campaign"
                                               value=""
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="{{getCustomTranslation('campaign')}}"
                                        />
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
                                        <textarea
                                            id="description" type="text" name="description"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="{{getCustomTranslation('description')}}"
                                        ></textarea>
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
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('influencers')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row">
                                        <select id="influencer" name="influencer[]" aria-label="{{getCustomTranslation('select_an_influencer')}}" multiple="multiple"
                                                data-placeholder="{{getCustomTranslation('select_an_influencer')}}..."
                                                class="form-select form-select-solid form-select-lg fw-semibold influencer_select">
                                        </select>
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{getCustomTranslation('close')}}</button>
                    <button id="kt_contact_submit_button" type="button" class="btn btn-primary">
                        <span id="save-spinner" class="save-spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        {{getCustomTranslation('save_changes')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="update">
        <div class="modal-dialog">
            <div class="modal-content position-absolute">
                <div class="modal-header">
                    <h5 class="modal-title">{{getCustomTranslation('update_event')}} </h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form action="" id="edit_form">
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
                                        <input id="from" type="date" name="from"
                                               value=""
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="{{getCustomTranslation('from')}}"
                                        />
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
                                        <input id="to" type="date" name="to"
                                               value=""
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="To"/>
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
                                        <input id="campaign" type="text" name="campaign"
                                               value=""
                                               class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                               placeholder="{{getCustomTranslation('campaign')}}"
                                        />
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
                                        <textarea
                                            id="description" type="text" name="description"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="{{getCustomTranslation('description')}}"
                                        ></textarea>
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
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">{{getCustomTranslation('influencers')}}</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-12 fv-row">
                                        <select id="influencer_update" name="influencer[]" aria-label="{{getCustomTranslation('select_an_influencer')}}" multiple="multiple"
                                                data-placeholder="{{getCustomTranslation('select_an_influencer')}}..."
                                                class="influencer_select form-select form-select-solid form-select-lg fw-semibold">
                                        </select>
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{getCustomTranslation('close')}}</button>
                    <button type="button" id="delete_submit_button" data-url="" onclick="deleteEvent()" class="btn btn-light"  style="display: none">{{getCustomTranslation('delete')}}</button>
                    <button id="edit_submit_button" type="button" class="btn btn-primary">
                        <span id="save-spinner-edit" class="save-spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        {{getCustomTranslation('save_changes')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--end::Products-->
@endsection
@push('scripts')

    <!-- ✅ load jQuery ✅ -->
    <!-- <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script> -->


    <!-- ✅ load moment.js ✅ -->
    <script src="{{asset('dashboard/assets/js/moment.min.js')}}"></script>

    <!-- ✅ load FullCalendar ✅ -->
{{--    <script--}}
{{--        src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"--}}
{{--        integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg=="--}}
{{--        crossorigin="anonymous"--}}
{{--        referrerpolicy="no-referrer"--}}
{{--    ></script>--}}

    <script
        src="{{ asset('dashboard') }}/assets/plugins/fullcalendar/fullcalendar.min.js"

    ></script>

    <script>
        let success_message= "";

        function reset_form(from_date="",to_date="") {
            $('[name="from"]').val(from_date);
            $('#to').val(to_date);
            $('#campaign').val("");
            $('#description').val("");
            $('#name').val("");
            $('.invalid-feedback').empty();
            $('#influencer').empty();
            $('#influencer_update').empty();
        }

        $(document).ready(function () {
            let calendar = false;
            let from_date;
            $('#toggle_calendar').click(function () {
                $('#calendar').toggleClass('d-none');
                $('#calendar_table').toggle('d-none');
            });

            let fullCalendar = $('#calendar').fullCalendar({
                header: {
                    left: 'today',
                    center: 'prev',
                    right: '',

                },
                defaultDate: moment().format("YYYY-MM-DD"),
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: "{{route('calendar.events')}}",
                timeFormat: 'H(:mm)', // uppercase H for 24-hour clock、
                displayEventTime: false,
                eventClick: function (event, jsEvent, view) {
                    let update_route = '/dflowplanner/calendar/' + event.id
                    route = update_route;
                    $('[name="from"]').val(event.start.format('YYYY-MM-DD'));
                    $('[name="to"]').val(event.end.format('YYYY-MM-DD'));
                    $('[name="description"]').val(event.description);
                    $('[name="title"]').val(event.title);
                    $('[name="campaign"]').val(event.campaign);

                    if("{{user()->id}}" == event.user_id && {{permissionShow('delete_calender')}})
                    {
                        document.getElementById('delete_submit_button').style.display = 'block';
                        document.getElementById('delete_submit_button').setAttribute("data-url", event.delete_url)
                    }else{
                        document.getElementById('delete_submit_button').style.display = 'none';
                    }
                    $('#update').modal('show');
                    //$('.modal-title').html('Update Event');
                    success_message = "{{getCustomTranslation('the_event_is_updated_successfully')}}";
                    $('.invalid-feedback').empty();
                    $('#influencer_update').empty();
                    let influencers = event.influencers;
                    for (let x in influencers) {
                        $(`#influencer_update`).append(`<option value="${influencers[x].id}" selected>${influencers[x]['name_{{$lang}}']}</option>`);
                    }
                },
                dayClick: function (date, jsEvent, view) {
                    let currentTime = new Date();
                    currentTime.setHours(0,0,0,0)
                    if(date.toDate().getTime() >= currentTime.getTime() ){
                        route = store_route;
                        // change the day's background color just for fun
                        //$(this).css('background-color', 'gray');
                        $('#create').modal('show');
                        from_date = date.format();
                        reset_form(from_date,from_date)
                        success_message = "{{getCustomTranslation('a_new_event_is_added_successfully')}}";
                        //$('.modal-title').html('Create Event');
                    }else {
                        Swal.fire({
                            icon: "error",
                            text: "{{getCustomTranslation('sorry_you_cant_add_event_in_the_past')}}",
                        });
                    }

                    //window.location.href = '/coredata/calendar/create?from=' + date.format()
                },
                viewRender: function (view, element) {
                    let date = $('#calendar').fullCalendar('getDate').toDate();
                    let year = date.getFullYear();
                    let month = date.toLocaleString('default', {month: 'long'});
                    $('.current_month').text(month);
                    $('.select_year').val(year);
                },
            });

            //create_event
            $('#create_event').click(function () {
                $('#create').modal('show');
                reset_form();
            });
            const current_date = new Date();  // 2009-11-10
            const current_month =  "{{getCustomTranslation(\Carbon\Carbon::today()->format('F'))}}";

            $(".fc-center").append(
                `<div class="current_month" style="width: 87px">${current_month}</div>` +
                    `<input class="form-control-inline select_year fc-button-group" type="number" value="${current_date.getFullYear()}">`
            );
            $(".fc-center").append(`
                <button type="button" onmouseover="addClass()" onmouseleave="removeClass()" class="custom-next fc-next-button fc-button fc-state-default fc-corner-left fc-corner-right" aria-label="next"><span class="fa-solid fa-caret-right"></span></button>
            `);

            $(".select_year").on("change", function (event) {
                let date = parseInt($("#calendar").fullCalendar('getDate').toDate().getMonth()) + 1;
                $('#calendar').fullCalendar('changeView', 'month', this.value);
                $('#calendar').fullCalendar('gotoDate', this.value + "-" + date);
                date = fullCalendar.fullCalendar('getDate').toDate();
                let month_c = date.toLocaleString('default', {month: 'long'});
                $('.current_month').text(month_c);
            });

            $(".custom-next").click(function () {
                $('#calendar').fullCalendar( 'next' );
            });

            $('.fc-icon-left-single-arrow').addClass('fa-solid fa-caret-left')
            $('.fc-icon-left-single-arrow').removeClass('fc-icon')
            $('.fc-icon-left-single-arrow').removeClass('fc-icon-left-single-arrow')
            $('.fc-icon-right-single-arrow').addClass('fa-solid fa-caret-right')
            $('.fc-icon-right-single-arrow').removeClass('fc-icon')
            $('.fc-icon-right-single-arrow').removeClass('fc-icon-right-single-arrow')
        });
        function addClass() {
            $('.custom-next').addClass('fc-state-hover')
        }
        function removeClass() {
            $('.custom-next').removeClass('fc-state-hover')
        }
    </script>

    <script>
        let route = "{{ route('calendar.store') }}";
        let store_route = "{{ route('calendar.store') }}";
        let routeAll = "{{ route('calendar.index',Request()->all()) }}";
        let csrfToken = "{{ csrf_token() }}";
        let deletePermission = {{permissionShow('delete_calendars') ? 1 : 0}};
        let updatePermission = {{permissionShow('update_calendars') ? 1 : 0}};
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/custom/pages/general/add_event_v2.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/custom/pages/general/edit_event.js"></script>

    <script>
        $('#influencer').select2({
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: "{{ route('influencer.search') }}",
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            }
        });
        $('#influencer_update').select2({
            delay: 1000,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: "{{ route('influencer.search') }}",
                method: 'get',
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_'+"{{$lang}}"],
                            }
                        }),
                    };
                },
            }
        });

        function deleteEvent()
        {
            window.location = document.getElementById('delete_submit_button').getAttribute('data-url');
        }
    </script>

@endpush
