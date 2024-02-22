<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($data['table']))
        <!--begin::Table-->

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_users_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0" id="htabel">
                <th class="min-w-125px">{{getCustomTranslation('name')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('first_ad')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('working_hours')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('first_login')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('last_ad')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('role')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('total_records')}}</th>

            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody id="tbody" class="fw-semibold text-gray-600">

            @foreach($data['table'] as $dat)
                <tr id="row-{{$dat['id']}}">

                    <td>
                        @if($dat->user->role_id == 3)
                            <a href="{{route('researcher_dashboard.researcherDashboard')}}?user_id={{$dat->user_id}}">
                                {{$dat->user->name}}
                            </a>
                        @else
                            {{$dat->user->name}}
                        @endif
                    </td>
                    <td>
                        {{$dat['first_ad']}}
                    </td>
                    <td>
                        {{$dat['working_hours']}}
                    </td>
                    <td>
                        {{$dat['first_login']}}
                    </td>
                    <td>
                        {{$dat['last_ad']}}
                    </td>
                    <td>
                        {{$dat->user->role->name}}
                    </td>
                    <td>
                        <a href="{{route('ad_record.index')}}?creationD_start={{$range_start}}&creationD_end={{$range_end}}&user_id[]={{$dat->user_id}}">
                            {{$dat['total_user_records']}}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>



        {{ $data['table']->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $data['table'],'perPage' =>Request::get('perPage') ?? $data['table']->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
<script>
    document.getElementById("totalAds").innerHTML = {{$data['cards']['totalAds']}};
</script>
