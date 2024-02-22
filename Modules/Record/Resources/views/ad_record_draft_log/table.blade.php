<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($datas))
        <!--begin::Table-->

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>{{getCustomTranslation('id_ad')}}</th>
                <th>{{getCustomTranslation('create_at')}}</th>
                <th>{{getCustomTranslation('type')}}</th>
                <th>{{getCustomTranslation('user')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">

            @foreach($datas as $data)
                <tr>
                    <td>
                        {{$data->ad_record_draft_id}}
                    </td>
                    <td>
                        {{$data->created_at}}
                    </td>
                    <td>
                        {{getCustomTranslation(adReocrdLogText()[$data->type])}}
                    </td>
                    <td>
                        {{$data->user->name ?? ""}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>

