@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('duplicate_company'))

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                 
                </div>
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Filter-->
                <button type="button" class="btn btn-primary me-3 dropdown-toggle" id="dropdownMenuClickable"
                        data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                    <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                        fill="currentColor"/>
                            </svg>
                        </span>
                    <!--end::Svg Icon-->{{getCustomTranslation('filter_duplicate_company')}}
                </button>
                <!--begin::Menu 1-->
                <form method="GET" id="filterDataForm" action="{{route('ad_record.duplicate_ad')}}"
                      class="dropdown-menu w-400px w-md-325px" data-kt-menu="true"
                      aria-labelledby="dropdownMenuClickable">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">{{getCustomTranslation('filter')}}</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Content-->
                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                        <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('ad_date')}}:</label>

                        <div class="mb-10 d-flex justify-content-between">
                            <div class="mx-2">
                                <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('from')}}:</label>

                                <input
                                        type="text"
                                        name="start"
                                        id="start"
                                        min="{{user()->start_access ?? ""}}"
                                        max="{{user()->end_access ?? ""}}"
                                        autocomplete="off"
                                        @if(request('start'))
                                            value="{{ $range_start->format('Y-m-d') }}"
                                        @endif
                                        style="margin-right:5px"
                                        class="form-select"
                                />


                            </div>

                            <div>
                                <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('to')}}:</label>

                                <input
                                        type="text"
                                        name="end"
                                        id="end"
                                        min="{{user()->start_access ?? ""}}"
                                        max="{{user()->end_access ?? ""}}"
                                        autocomplete="off"
                                        @if(request('end'))
                                            value="{{$range_end->format('Y-m-d') }}"
                                        @endif
                                        style="margin-right:5px"
                                        class="form-select"
                                />
                            </div>

                        </div>


                        <!--begin::Input group-->
                     
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('company')}}:</label>
                            <!--begin::Input-->
                            <select id="company" name="company_ids[]"
                                    class="form-select form-select-solid form-select-lg fw-semibold"
                                    data-mce-placeholder="" multiple>
                                @if( request('company_ids'))
                                    @foreach($companys_data as $company_data)
                                        <option value="{{$company_data->id}}"
                                                @if(in_array($company_data->id , request('company_ids') ?: [])) selected @endif>{{$company_data->{'name_'.$lang} }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!--end::Input group-->

                      
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-semibold">{{getCustomTranslation('category')}}:</label>
                            <select name="category[]" multiple="multiple" id="category"
                                    class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                    data-placeholder="{{getCustomTranslation('select_option')}}" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="false">
                                
                            </select>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                                <a href="{{ route('ad_record.duplicate_ad') }}" id="reset_filter"
                                   class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                   data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}
                                </a>
                            {{-- <button type="reset" id="reset_filter" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-user-table-filter="reset">{{getCustomTranslation('reset')}}</button>  --}}
                            <button type="button" class="btn btn-primary fw-semibold px-6 filterDataForm"
                                    data-kt-menu-dismiss="true"
                                    data-kt-user-table-filter="filter">{{getCustomTranslation('apply')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </form>
                <!--end::Menu 1-->
                <!--end::Filter-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div id="listAdRecord" style="width: 100%">
                @include('acl::company.duplicate.table')
            </div>

            <!--end::Datatable-->
        </div>
        <!--end::Products-->
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
 $(document).ready(function () { 
$("input[type='checkbox']").each(function(){
  $(this).click(function(){
	  var tmp = [];
    var c = $(this).attr("class");
    if($(this).is(":checked")){
		
  $("."+c).attr("disabled",true);
  $(this).removeAttr("disabled",true);
   $("."+c).each(function() {
  var checked = $(this).val();
  tmp.push(checked);
  
  $("#"+c).val(tmp);
   } );
     // $("."+c).attr("disabled",true);
    }else{
       $("."+c).attr("disabled",false);
    }
  })
})

 $(".mybutton").click(function(){        
        $(this).submit(); // Submit the form
    });

 }); 

		</script>
@push('scripts')
    <script>
        var route = "{{ route('company.duplicate_company') }}";
        var routeAll = "{{ route('company.duplicate_company',Request()->all()) }}";
        var csrfToken = "{{ csrf_token() }}";
    </script>
  <script src="{{ asset('dashboard') }}/assets/js/company/listduplicate.js?v=1"></script>
    <script>
	
	  //data-kt-company-table-filter
        function handleDeleteRows() {

            // Select all delete buttons
            const deleteButtons = document.querySelectorAll(
                '[data-kt-company-table-filter="delete_row"]'
            );
            if (deleteButtons) {
                deleteButtons.forEach((d) => {

                    // Delete button on click
                    d.addEventListener("click", function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest("tr");

                        // Get customer name
                        const customerName = parent.querySelectorAll("td")[1].innerText;
                        const customerId = parent.querySelectorAll("td div input")[0].value;

                        // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text:
                                are_you_sure_you_want_to_delete +
                                customerId +
                                "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: yes_delete,
                            cancelButtonText: no_cancel,
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton:
                                    "btn fw-bold btn-active-light-primary",
                            },
                        }).then(function (result) {
                            if (result.value) {
                                $.ajax({
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                    url: route + "/" + customerId,
                                    data: {
                                        _token: csrfToken,
                                        _method: "DELETE",
                                        id: customerId,
                                    },
                                })
                                    .done(function (res) {
                                        // Simulate delete request -- for demo purpose only
                                        Swal.fire({
                                            text:
                                                you_have_deleted +
                                                customerId +
                                                "!.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-primary",
                                            },
                                        }).then(function () {
                                            // delete row data from server and re-draw datatable
                                            location.reload();
                                        });
                                    })
                                    .fail(function (res) {
                                        Swal.fire({
                                            text:
                                                customerId + was_not_deleted,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: ok_got_it,
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-primary",
                                            },
                                        });
                                    });
                            } else if (result.dismiss === "cancel") {
                                Swal.fire({
                                    text: customerId + was_not_deleted,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: ok_got_it,
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    },
                                });
                            }
                        });
                    });
                });
            }
        }
	
        $(function () {
		
			
            $('input[name="start"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            $('input[name="end"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            $('input[name="start"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate: new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate: new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });
            $('input[name="start"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            $('input[name="end"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate: new Date("{{user()->start_access ? \Carbon\Carbon::parse(user()->start_access) : 0}}"),
                maxDate: new Date("{{user()->end_access ? \Carbon\Carbon::parse(user()->end_access) : \Carbon\Carbon::today()}}"),
                //  startDate: '{{$range_end}}', // after open picker you'll see this dates as picked
                locale: {
                    format: 'YYYY/MM/DD',
                }
            });

            $('input[name="end"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });

        var filterValues = $("#filterDataForm").serialize();
        $(document).ready(function () {
            var form = $("#filterDataForm");
            // form.deserialize(filterValues);
        });
        var limit = "{{Request::get('perPage') ?? 10}}";

        //on keyup, start the countdown
        function my_fun_reset() {

            $('#influencer').val('');
            $('#company').val('');
            $('#start').val('');
            $('#end').val('');

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');

            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit + "&" + $("#filterDataForm").serialize();

            $('#filterDataForm').removeClass('show');


            $.get({
                url: full,
                data: "{{ json_encode(request()->all()) }}",
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        }

        $(".filterDataForm").on("click", function (e) {
            e.preventDefault();
            var full = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit + "&" + $("#filterDataForm").serialize();


            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            $('#filterDataForm').removeClass('show');
            loadTableData(full);
        });

        function updatePageParam(url, page) {
            var hasPageParam = url.includes('page=');

            if (hasPageParam) {
                // Update the 'page' parameter in the URL
                url = url.replace(/([?&])page=[^&]*(&|$)/, '$1page=' + page + '$2');
            } else {
                // Add the 'page' parameter to the URL
                url += (url.includes('?') ? '&' : '?') + 'page=' + page;
            }

            return url;
        }

        $(document).on('click', '.pagination a', function (event) {

            event.preventDefault();
            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');
            var url = $(this).attr('href') + "&perPage=" + limit + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        $(document).on('change', '#limit', function () {

            $('#listAdRecord').html('<div class="d-flex justify-content-center"><div style="height: 50px;width: 50px;margin: 50px;" class="spinner-border spinner-border-sm" role="status"><span class="sr-only">{{getCustomTranslation('loading')}}...</span></div></div>');


            limit = $(this).val();

            var url = "{{(request()->fullUrl() == request()->url()) ? request()->url().'?' : request()->fullUrl().'&'}}" + "&perPage=" + limit + "&" + $("#filterDataForm").serialize();

            loadTableData(url);
        });

        function loadTableData(url) {
            $.get({
                url: url,
                success: function (data) {

                    $('#listAdRecord').html(data);
                    KTMenu.createInstances();
                    handleDeleteRows();
                }
            });
        }

        $("#dropdownMenuClickable").on("click", function (e) {
            //$('#filterDataForm').show();
        });

        let search_influencer_url = "{{ route('influencer.search') }}";
        $('#influencer').select2({
            minimumInputLength: 1,
            delay: 900,
            placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_influencer_url,
                method: 'get',
                dataType: 'json',
                delay: 900,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item, index) {
                            return {
                                id: item.id,
                                text: item['name_' + "{{$lang}}"],
                            }
                        }),
                    };
                },
            }
        });

        function template(data) {
            if ($(data.html).length === 0) {
                return data.text;
            }
            return $(data.html);
        }

        let search_company_url = "{{ route('reports.search_companies') }}";
        $('#company').select2({
            minimumInputLength: 1,
            delay: 900,
            placeholder: "{{getCustomTranslation('select_a_company')}}...",
            ajax: {
                cacheDataSource: [],
                url: search_company_url,
                method: 'POST',
                dataType: 'json',
                delay: 900,
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },

            }, templateResult: template,
            templateSelection: template, language: {
                "noResults": function () {
                    return "{{getCustomTranslation('no_results_found')}} <br> " +
                        '<button   style="width: 100%;border: none;background-color: green;color: white;padding: 10px 0;margin-top: 10px;border-radius: 10px;" onclick="openCreateCompany()" class="select2-link">{{getCustomTranslation('add_new_company')}}</button>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

    </script>

@endpush
