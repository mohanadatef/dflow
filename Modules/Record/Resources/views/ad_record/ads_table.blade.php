<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ad_record_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">{{getCustomTranslation('ad_id')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('edit_ad')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('show_ad')}}</th>

            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($datas as $data)
                <tr>

                    <td>
                        {{$data->id}}
                    </td>
                    <td>
                        <a href="#" onclick="actionButton('edit', '{{$data->update_url}}')">
                            {{getCustomTranslation('edit_ad')}}
                        </a>
                    </td>
                    <td>
                        <a target="_blank" href="{{$data->show_url}}">
                            {{getCustomTranslation('show_ad')}}
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button id='btn' type="button" class="btn btn-primary"
                    onclick="actionButton('new')">{{getCustomTranslation('create')}}
            </button>
            <button id='draft_btn' type="button" style="margin-left: 10px" onclick="closemodel()"
                    class="btn btn-primary">{{getCustomTranslation('cansel')}}
            </button>
        </div>
    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>

<script>

    $('#kt_modal_showads').modal('toggle');
    $("#date").text({{$datas->date}});
    $("#count").text({{$datas->count}});


</script>
