<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($data))
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_company_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th >{{getCustomTranslation('action')}}</th>
                <th>{{getCustomTranslation('name')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($data as $row)
                <tr onclick="readNotifaction({{$row->id}},{{$row->url()}})">
                    <td>
                        {{ getCustomTranslation($row->action) ." ". getCustomTranslation('in') . " : ". $row->action_id ?? ""  }}
                    </td>

                    <td>
                        {{$row->pusher->name ?? "" }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $data,'perPage' =>Request::get('perPage') ?? $data->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
