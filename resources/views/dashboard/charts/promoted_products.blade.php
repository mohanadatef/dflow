
<div class="modal fade" id="kt_modal_showads" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold"> ads</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close" onclick="closemodel()">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                              rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                              transform="rotate(45 7.41422 6)" fill="currentColor"/>
                    </svg>
                </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">

                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <div class="row">

                            <label class="fs-5 fw-bold form-label mb-2">
                                <span >promoted products  :<span id="text_promoted_products"></span></span>
                            </label>

                            <label class="fs-5 fw-bold form-label mb-2">
                                <span >Count : <span id="count"></span></span>
                            </label>

                    </div>
                    <div id="listAdRecord" style="width: 100%">

                    </div>


                    <!--end::Label-->
                    <!--begin::Input-->

                    <!--end::Input-->
                </div>

                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<div id="container"></div>
<script>

    function closemodel(){
    $('#kt_modal_showads').modal('toggle');
}
    // promoted products
    data = @json($promoted_products_cloud);

    defaultThemeMode = "system";
    name = document.body.getAttribute("data-kt-name");
    themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");

    if (themeMode === null) {
        if (defaultThemeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        } else {
            themeMode = defaultThemeMode;
        }
        themeModeLogo = themeMode;
    }



    if (themeMode == 'light') {
        Highcharts.chart('container', {
            accessibility: {
                screenReaderSection: {
                    beforeChartFormat: '<h5>{chartTitle}</h5>' +
                        '<div>{chartSubtitle}</div>' +
                        '<div>{chartLongdesc}</div>' +
                        '<div>{viewTableButton}</div>'
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                    $('#kt_modal_showads').modal('toggle');
                   $("#text_promoted_products").text(this.name);
                   $("#count").text(this.weight);
                   $.get({
                url: "{{route('getdatechartbypromotedProducts')}}",
                data:{
                    'promoted_products':this.name,
                    'company_id':"{{$current_company->id}}",
                      'ranges':$('#ranges').val(),
                      },
                success: function(data) {

                    $('#listAdRecord').html(data);

                }
            });

                }
            }
        }
                }
            },

            series: [{
                type: 'wordcloud',
                data,
                name: 'Occurrences'
            }


        ],
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            tooltip: {
                enabled: false,
                headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
            },
        });
    } else {
        Highcharts.chart('container', {
            chart: {
                backgroundColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 1,
                        y2: 1
                    },
                    stops: [
                        [0, '#151521'],
                        [1, '#151521']
                    ]
                },
                style: {
                    fontFamily: '\'Unica One\', sans-serif'
                },
                plotBorderColor: '#606063'
            },
            accessibility: {
                screenReaderSection: {
                    beforeChartFormat: '<h5>{chartTitle}</h5>' +
                        '<div>{chartSubtitle}</div>' +
                        '<div>{chartLongdesc}</div>' +
                        '<div>{viewTableButton}</div>'
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
         point: {
             events: {
                click: function() {
                    $('#kt_modal_showads').modal('toggle');
                   $("#text_promoted_products").text(this.name);
                   $("#count").text(this.weight);
                   $.get({
                url: "{{route('getdatechartbypromotedProducts')}}",
                data:{
                    'promoted_products':this.name,
                    'company_id':"{{$current_company->id}}",
                      'ranges':$('#ranges').val(),
                      },
                success: function(data) {

                    $('#listAdRecord').html(data);
             
                }
            });

                }
            }
        }
                }
            },
            series: [{
                type: 'wordcloud',
                data,
                name: 'Occurrences'
            }],
            title: {
                text: '',
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                text: ''
            },
            tooltip: {
                enabled: false,
                headerFormat: '<span style="font-size: 16px"><b>{point.key}</b></span><br>'
            },
        });
    }


</script>
