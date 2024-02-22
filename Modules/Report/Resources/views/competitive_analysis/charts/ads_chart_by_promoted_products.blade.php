<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ad_record_table">
            <!--begin::Table head-->

            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($datas as $data)
                <tr>
                    <td>
                        <a href="{{route('ad_record.show', $data->id)}}">
                        {{ date('Y-m-d', strtotime($data->date))}}
                    </a>
                    </td>

                    <td>
                        <a href="{{route('influencer.show', $data->influencer_id)}}">
                        {{isset($data->influencer->{'name_'.$lang} )?$data->influencer->{'name_'.$lang} :""}}
                    </a>
                    </td>

                    <td>
                        {{ $data->platform->{'name_'.$lang} }}
                    </td>




                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
