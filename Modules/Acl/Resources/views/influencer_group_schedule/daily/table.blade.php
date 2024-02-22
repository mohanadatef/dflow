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
                <th class="min-w-125px">{{getCustomTranslation('id')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('influencer')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('platform')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('type')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">

            @foreach($datas as $data)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input item_check" type="checkbox" name="item_check[]"
                                   value="{{$data->id}}"/>
                        </div>
                    </td>
                    <td>
                        {{$data->influencer_follower_platform->influencer->{'name_'.$lang} }}
                    </td>
                    <td>
                        {{$data->influencer_follower_platform->platform->{'name_'.$lang} }}
                    </td>
                    <td>
                        @if($data->owner_researcher_id)
                        {{getCustomTranslation('extra_from')}} {{ $data->ownerResearcher->name ?? "" }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>
