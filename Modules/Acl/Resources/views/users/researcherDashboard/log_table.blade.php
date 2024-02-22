<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($logsTable))
        <!--begin::Table-->

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->

            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody id="tbody" class="fw-semibold text-gray-600">

            @foreach($logsTable as $dat)
                <tr>
                    <td>
                        <a href="{{route('ad_record.show',['id' => $dat['ad_record_id']])}}"
                        {{$dat['ad_record_id']}}
                        </a>
                    </td>
                    <td>
                        {{$dat->user->name ?? ""}}
                    </td>
                    <td>
                        {{adReocrdLogText()[$dat->type]}}
                    </td>
                    <td>
                        {{$dat->created_at}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logsTable->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $logsTable,'perPage' =>Request::get('perPage') ?? 10]) }}
    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>

