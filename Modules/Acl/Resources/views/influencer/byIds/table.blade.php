
    <div class="card-body pt-0">
        @if(count($datas))
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="kt_influencer_table"
                       class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                    <!--begin::Head-->
                    <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                        @if($userType != 1)
                            <th class="min-w-20px">{{getCustomTranslation('id')}}</th>
                        @endif
                        <th class="min-w-250px">{{getCustomTranslation('name')}}</th>
                        <th class="min-w-90px">{{getCustomTranslation('country')}}</th>
                        <th class="min-w-90px">{{getCustomTranslation('number_of_ads')}}
                            <i class="fas fa-sort" data-sorting_type="{{$sorting}}" id="sortingcount"
                               onclick="sorting()"></i>
                        </th>
                        <th class="min-w-90px">{{getCustomTranslation('categories')}}</th>
                    </tr>
                    </thead>
                    <!--end::Head-->
                    <!--begin::Body-->
                    <tbody class="fs-6">
                    @forelse($datas as $data)
                        <tr>
                            @if($userType != 1)
                                <td>{{$data->id}}</td>
                            @endif
                                <?php $image = $data->gender == 'Male' ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png') ?>
                                <?php $snapchat_avatar = $data->influencer_follower_platform->where('platform_id',
                                1)
                                ->first() ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $data->influencer_follower_platform->where('platform_id',
                                    1)
                                    ->first()->url . "&type=SVG&bitmoji=enable" : $image; ?>
                            <td>
                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Wrapper-->
                                    <div class="me-5 position-relative">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img src="{{$data->image ? getFile($data->image->file??null,pathType()['ip'],getFileNameServer($data->image)) : $snapchat_avatar }}"
                                                 alt="Avatar"/>
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="{{route('influencer.show', $data->id)}}"
                                           class="mb-1 text-gray-800 text-hover-primary">{{$data->{'name_'.$lang} }}</a>

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                            </td>
                            <td>
                                {{implode(',',$data->country->pluck('name_'.$lang)->toArray())}}
                                <!--end::User-->
                            </td>
                            <td>
                                {{  ($data->count==0)?'N/A':number_format($data->count) }}
                            </td>
                            <td>
                                {{implode(',',$data->category->pluck('name_'.$lang)->toArray())}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-danger text-center">{{getCustomTranslation('no_data')}}</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <!--end::Body-->
                </table>
                <!--end::Tab pane-->
                <!--end::Table-->
            </div>
            @if(count($datas))
                {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage(),'perArray'=>[10,20,30,50,100]]) }}
            @endif
            <!--end::Table container-->
        @else
            <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
        @endif
    </div>
