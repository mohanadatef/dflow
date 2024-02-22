<!--begin::Javascript-->
<script>
    let getCustomTranslationEdit = "{{getCustomTranslation('edit')}}";
    let getCustomTranslationDelete = "{{getCustomTranslation('delete')}}";
    let getCustomTranslationActions = "{{getCustomTranslation('actions')}}";
    let are_you_sure_you_want_to_delete = "{{getCustomTranslation('are_you_sure_you_want_to_delete')}}";
    let yes_delete = "{{getCustomTranslation('yes_delete')}}";
    let no_cancel = "{{getCustomTranslation('no_cancel')}}";
    let you_have_deleted = "{{getCustomTranslation('you_have_deleted')}}";
    let you_have_deleted_all_selected = "{{getCustomTranslation('you_have_deleted_all_selected')}}";
    let ok_got_it = "{{getCustomTranslation('ok_got_it')}}";
    let was_not_deleted = "{{getCustomTranslation('was_not_deleted')}}";
    let are_you_sure_you_want_to_delete_ = "{{getCustomTranslation('are_you_sure_you_want_to_delete')}}";
    let are_you_sure_you_want_to_delete_selected = "{{getCustomTranslation('are_you_sure_you_want_to_delete_selected')}}";
    let activeText = "{{getCustomTranslation('active')}}";
    let inactiveText = "{{getCustomTranslation('inactive')}}";
    let answerText = "{{getCustomTranslation('answered')}}";
    let notAnswerText = "{{getCustomTranslation('not_answered')}}";
    let addingTheText = "{{getCustomTranslation('adding_the')}}";
    let toThisListText = "{{getCustomTranslation('to_this_list')}}";
    let removeInfluencerText = "{{getCustomTranslation('remove_influencer')}}";
    let selectAInfluencerText = "{{getCustomTranslation('select_a_influencer')}}";
    let updatedSuccessfullyText = "{{getCustomTranslation('updated_successfully')}}";
    let somethingWentWrongText = "{{getCustomTranslation('something_went_wrong')}}";
    let categoryParentIsNotActivatedText = "{{getCustomTranslation('category_parent_is_not_activated')}}";
    let locationParentIsNotActivatedText = "{{getCustomTranslation('location_parent_is_not_activated')}}";
    let DeletedText = "{{getCustomTranslation('deleted')}}";
    let ShowingText = "{{getCustomTranslation('showing_text')}}";
    let recordsText = "{{getCustomTranslation('records_text')}}";
    let toText = "{{getCustomTranslation('to')}}";
    let ofText = "{{getCustomTranslation('of')}}";
    let loadingText = "{{getCustomTranslation('loading')}}";
    let showing_no_records = "{{getCustomTranslation('showing_no_records')}}";
    let copyLinkText = "{{getCustomTranslation('copy_link')}}";
</script>
<script>var hostUrl = "{{ asset('dashboard') }}/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('dashboard') }}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used by this page)-->
<script src="{{ asset('dashboard') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
@if(!isset($charts_disabled))
    <script src="{{asset('dashboard/assets/js/amcharts/index.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/xy.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/percent.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/radar.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/themes/Animated.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/map.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/worldLow.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/continentsLow.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/usaLow.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/worldTimeZonesLow.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/amcharts/geodata/worldTimeZoneAreasLow.js')}}"></script>
@endif

<script src="{{ asset('dashboard') }}/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used by this page)-->
<script src="{{ asset('dashboard') }}/assets/js/widgets.bundle.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/widgets.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/apps/chat/chat.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/create-app.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom/utilities/modals/users-search.js"></script>
<!--begin::Theme mode setup on page load-->

<script>
    if (document.documentElement) {
        if (typeof themeMode !== 'undefined') {
            if (themeMode == "dark") {
                document.getElementById("lightImage").style.display = "none";
                document.getElementById("lightImage1").style.display = "none";
                document.getElementById("darkImage").style.display = "block";
                document.getElementById("darkImage1").style.display = "block";
            } else {
                document.getElementById("lightImage").style.display = "block";
                document.getElementById("lightImage1").style.display = "block";
                document.getElementById("darkImage").style.display = "none";
                document.getElementById("darkImage1").style.display = "none";
            }
        } else {
            let themeModeLogo = null;
            const defaultThemeMode = "system";
            const name = document.body.getAttribute("data-kt-name");
            let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
            if (themeMode === null) {
                if (defaultThemeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                } else {
                    themeMode = defaultThemeMode;
                }
                themeModeLogo = themeMode;
            }
            if (themeMode == "dark") {
                document.getElementById("lightImage").style.display = "none";
                document.getElementById("lightImage1").style.display = "none";
                document.getElementById("darkImage").style.display = "block";
                document.getElementById("darkImage1").style.display = "block";
            } else {
                document.getElementById("lightImage").style.display = "block";
                document.getElementById("lightImage1").style.display = "block";
                document.getElementById("darkImage").style.display = "none";
                document.getElementById("darkImage1").style.display = "none";
            }
        }
    }

    function changeLogo(logoMode) {

        if (logoMode == "dark") {
            document.getElementById("lightImage").style.display = "none";
            document.getElementById("darkImage").style.display = "block";
            location.reload()
        } else {
            document.getElementById("lightImage").style.display = "block";
            document.getElementById("darkImage").style.display = "none";
            location.reload()
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var toggleSearch = function (id) {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('user.toggleSearch') }}",
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content"),
            },
            data: {
                _token: "{{ csrf_token() }}",
                'id': id
            },
            success: function (data) {
                var labelItem = $('#search-label-' + id)
                var labelItem1 = $('#search-label-1-' + id)
                var label = data.match_search == 0 ? activeText : inactiveText;
                labelItem.html(label);
                labelItem1.html(label);
            }
        });
    }

    function language(lang) {
        $.ajax({
            type: "get",
            dataType: "json",
            url: "{{ route('language.change') }}",
            headers: {
                "X-CSRF-TOKEN": $(
                    'meta[name="csrf-token"]'
                ).attr("content"),
            },
            data: {
                'lang': lang
            },
            success: function () {
                location.reload()
            }
        });

    }
    if('{{ session('download-link') }}'){
        $('#downloadLink').attr('href', '{{ session('download-link') }}');
        $('#showModalButton').trigger('click');
        '{{ session()->forget('download-link') }}';
    }
    @if($userType && user())
    document.addEventListener('contextmenu', event => event.preventDefault());
    @endif
</script>
<!--end::Theme mode setup on page load-->
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@if(!$userType && user())
    <script>
        var now = new Date();
        var delay = 30 * 1000; // 1 min in msec
        var start = delay - (now.getSeconds()) * 1000 + now.getMilliseconds();

        function getNotifaction()
        {
            $.ajax({
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                url: "{{route('notification.get')}}",
                success: function (data) {
                    $("#notification-user").empty();
                    $('#notification-user').html(data);
                },
            })
        }
        function readNotifaction(id,url)
        {
            $.ajax({
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                url: "{{route('notification.read')}}",
                data: {'id':id},
                success: function (data) {
                        location.href=url;
                },
            })
        }
        setTimeout(function setTimer() {
            getNotifaction();
            setTimeout(setTimer, delay);
        }, start);
    </script>
    @endif
@stack('scripts')
<!--end::Custom Javascript-->
<!--end::Javascript-->
