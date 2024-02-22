<div class="table-responsive">
    @include('dashboard.error.error')
    @if(count($datas['table']))
    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-7 gs-7">
        <thead>
        <tr class="fw-semibold fs-4 text-gray-800">
            <th scope="col">{{getCustomTranslation('duplicate_count')}}</th>
            <th scope="col">{{getCustomTranslation('ad_date')}}</th>
            <th scope="col">{{getCustomTranslation('company')}}</th>
            <th scope="col">{{getCustomTranslation('influencer')}}</th>
            <th scope="col">{{getCustomTranslation('platform')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($datas['table'] as $data)
            <tr>
                <th scope="row">{{$data->count()}}</th>
                <td>{{ date('Y-m-d', strtotime($data[0]->date))}}</td>
                <td>{{$data[0]->company->{'name_'.$lang} }}</td>
                <td>{{$data[0]->influencer->{'name_'.$lang} }}</td>
                <td>{{$data[0]->platform->{'name_'.$lang} }}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table table-row-dashed table-row-gray-500 gy-5 gs-5 mb-0">
                        <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th scope="col">{{getCustomTranslation('id')}}</th>
                            <th scope="col">{{getCustomTranslation('ad_date')}}</th>
                            <th scope="col">{{getCustomTranslation('company')}}</th>
                            <th scope="col">{{getCustomTranslation('influencer')}}</th>
                            <th scope="col">{{getCustomTranslation('platform')}}</th>
                            <th scope="col">{{getCustomTranslation('category')}}</th>
                            <th scope="col">{{getCustomTranslation('service')}}</th>
                            <th scope="col">{{getCustomTranslation('promoted_products')}}</th>
                            <th scope="col">{{getCustomTranslation('promoted_offer')}}</th>
                            <th scope="col">{{getCustomTranslation('does_ad_word_mentioned')}}</th>
                            <th scope="col">{{getCustomTranslation('government_entity')}}</th>
                            <th scope="col">{{getCustomTranslation('notes')}}</th>
                            <th scope="col">{{getCustomTranslation('price')}}</th>
                            <th scope="col">{{getCustomTranslation('target_market')}}</th>
                            <th scope="col">{{getCustomTranslation('promotion_type')}}</th>
                            <th scope="col">{{getCustomTranslation('link')}}</th>
                            @can('update_ad_record')
                                <th class="min-w-125px">{{getCustomTranslation('researcher')}}</th>
                            @endcan
                            <th class="min-w-70x">{{getCustomTranslation('visit')}}</th>
                            @can('update_ad_record')
                                <th class="text-end min-w-70px">{{getCustomTranslation('actions')}}</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $da)
                        <tr>
                            <td>{{$da->id}}</td>
                            <td>{{ date('Y-m-d', strtotime($da->date))}}</td>
                            <td>{{$da->company->{'name_'.$lang} }}</td>
                            <td>{{$da->influencer->{'name_'.$lang} }}</td>
                            <td>{{$da->platform->{'name_'.$lang} }}</td>
                            <td>{{implode(',',$da->category->pluck('name_'.$lang)->toArray())}}</td>
                            <td>{{implode(',',$da->service->pluck('name_'.$lang)->toArray())}}</td>
                            <td>{{$da->promoted_products}}</td>
                            <td>{{$da->promoted_offer}}</td>
                            <td>{{$da->mention_ad ? "Yes" : "No"}}</td>
                            <td>{{$da->gov_ad ? "Yes" : "No"}}</td>
                            <td>{{$da->notes}}</td>
                            <td>{{$da->price}}</td>
                            <td>{{implode(',',$da->target_market->pluck('name_'.$lang)->toArray())}}</td>
                            <td>{{implode(',',$da->promotion_type->pluck('name_'.$lang)->toArray())}}</td>
                            <td>{{$da->url_post}}</td>
                            @can('update_ad_record')
                                <td>
                                    <a href="{{route('user.show', $da->user_id)}}">{{ $da->user->name }}</a>
                                </td>
                            @endcan
                            <td>
                                <a href="{{route('ad_record.show', $da->id)}}" type="button"
                                   class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/coding/cod007.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                <i class="fa fa-eye"></i>
                            </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </td>
                            @canany('update_ad_record','log_ad_record','delete_ad_record')
                                <td class="text-end">
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{getCustomTranslation('actions')}}
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                    fill="currentColor"/>
                        </svg>
                    </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--begin::Menu-->
                                    <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                            data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        @can('update_ad_record')
                                            <div class="menu-item px-3">
                                                <a href="{{route('ad_record.edit',$da->id)}}"
                                                   class="menu-link px-3">{{getCustomTranslation('edit')}}</a>
                                            </div>
                                        @endcan
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        @can('delete_ad_record')
                                            <div class="menu-item px-3">
                                                <a href="#" data-kt-ad_record-table-filter="delete_row"
                                                   class="menu-link px-3">{{getCustomTranslation('delete')}}</a>
                                            </div>
                                        @endcan
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                            @endcanany
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $datas['duplicates']->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas['duplicates'],'perPage' =>Request::get('perPage') ?? $datas['duplicates']->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>