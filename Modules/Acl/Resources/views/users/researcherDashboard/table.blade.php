<div class="card-body pt-0">
    @include('dashboard.error.error')
    @if(count($table))
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

            @foreach($table as $dat)
                <tr>
                    <td>
                        <a href="#" @if($userLogin->id != request('user_id')) style="pointer-events: none"
                           @else onclick="markAdComplete({{$dat['id']}});event.preventDefault();" @endif >
                            @if($dat->is_complete == 0)
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                    <path opacity="0.5"
                                          d="M12.4343 12.4343L10.75 10.75C10.3358 10.3358 9.66421 10.3358 9.25 10.75C8.83579 11.1642 8.83579 11.8358 9.25 12.25L12.2929 15.2929C12.6834 15.6834 13.3166 15.6834 13.7071 15.2929L19.25 9.75C19.6642 9.33579 19.6642 8.66421 19.25 8.25C18.8358 7.83579 18.1642 7.83579 17.75 8.25L13.5657 12.4343C13.2533 12.7467 12.7467 12.7467 12.4343 12.4343Z"
                                          fill="currentColor"/>
                                    <path
                                            d="M8.43431 12.4343L6.75 10.75C6.33579 10.3358 5.66421 10.3358 5.25 10.75C4.83579 11.1642 4.83579 11.8358 5.25 12.25L8.29289 15.2929C8.68342 15.6834 9.31658 15.6834 9.70711 15.2929L15.25 9.75C15.6642 9.33579 15.6642 8.66421 15.25 8.25C14.8358 7.83579 14.1642 7.83579 13.75 8.25L9.56569 12.4343C9.25327 12.7467 8.74673 12.7467 8.43431 12.4343Z"
                                            fill="currentColor"/>
                                </svg>
                            @else
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="green"/>
                                    <path opacity="0.5"
                                          d="M12.4343 12.4343L10.75 10.75C10.3358 10.3358 9.66421 10.3358 9.25 10.75C8.83579 11.1642 8.83579 11.8358 9.25 12.25L12.2929 15.2929C12.6834 15.6834 13.3166 15.6834 13.7071 15.2929L19.25 9.75C19.6642 9.33579 19.6642 8.66421 19.25 8.25C18.8358 7.83579 18.1642 7.83579 17.75 8.25L13.5657 12.4343C13.2533 12.7467 12.7467 12.7467 12.4343 12.4343Z"
                                          fill="green"/>
                                    <path
                                            d="M8.43431 12.4343L6.75 10.75C6.33579 10.3358 5.66421 10.3358 5.25 10.75C4.83579 11.1642 4.83579 11.8358 5.25 12.25L8.29289 15.2929C8.68342 15.6834 9.31658 15.6834 9.70711 15.2929L15.25 9.75C15.6642 9.33579 15.6642 8.66421 15.25 8.25C14.8358 7.83579 14.1642 7.83579 13.75 8.25L9.56569 12.4343C9.25327 12.7467 8.74673 12.7467 8.43431 12.4343Z"
                                            fill="green"/>
                                </svg>
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{urlType()[$dat->platform_id].$dat->url}}"
                           target="_blank">
                            {{$dat->influencer->{'name_'.$lang} }}
                        </a>
                    </td>
                    <td>
                        {{$dat->platform->{'name_'.$lang} }}
                    </td>
                    <td>
                        {{$dat['ads_count']}} {{getCustomTranslation('ads')}}
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-1 symbol symbol-50px me-5"
                                 @if($dat['files']) onclick="getData({{$dat}})" @endif>
                                @if($dat['files'])
                                    <a href="#" style="pointer-events: none">
                                        <img alt="Logo" style="width: 50px;height: 50px"
                                             src="{{asset('dashboard') .'/assets/media/svg/avatars/blank.svg' }}"/>
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                {{getCustomTranslation('seen')}} : {{($dat['files_count_seen'])}}
                                <br>
                                {{getCustomTranslation('unseen')}} : {{ $dat['files'] - $dat['files_count_seen'] }}
                            </div>
                        </div>

                    </td>

                    <td>
                        @if($dat['owner_researcher_id'] )
                            {{getCustomTranslation('extra_from')}} {{ $dat['ownerResearcher']->name ?? "" }}
                        @endif
                    </td>
                    <td>
                       <a target="_blank" href="{{route('ad_record.create',['date'=>request('search_day') ?? \Carbon\Carbon::parse('today')->format('Y-m-d'),
'influencer_id'=>$dat->influencer_id,'platform_id'=>$dat->platform_id])}}">{{getCustomTranslation('add_ad_record')}}</a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $table->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $table,'perPage' =>Request::get('perPage') ?? 10]) }}
    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>

