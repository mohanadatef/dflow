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
                <th >{{getCustomTranslation('id_request')}}</th>
                <th >{{getCustomTranslation('id_ad')}}</th>
                <th >{{getCustomTranslation('create_at')}}</th>
                <th >{{getCustomTranslation('status')}}</th>
                <th >{{getCustomTranslation('user')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">

            @foreach($datas as $data)
                <tr>
                    <td>
                        {{$data->request_ad_media_access_id}}
                    </td>
                    <td>
                        {{$data->request_ad_media_access->ad_record_id}}
                    </td>
                    <td>
                        {{$data->created_at}}
                    </td>
                    <td >
                        {{getCustomTranslation(requestAccessText()[$data->status]) ?? ""}}
                    </td>
                    <td>
                        @if(in_array($data->status,[1,4]))
                        {{$data->request_ad_media_access->client->name ?? ""}}
                        @else
                        {{$data->request_ad_media_access->user->name ?? ""}}
                        @endif
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

