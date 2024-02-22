@extends('dashboard.layouts.app')

@section('title', 'Unique Influencers')

@section('content')
    <div class="container-xxl">
        <!--begin::Tab Content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->

                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                </div>
                <!--begin::Card body-->
                <div id="data-table">
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
                                        @if(user()->role->role->type != 1)
                                            <th class="min-w-20px">ID</th>
                                        @endif
                                        <th class="min-w-250px">Name</th>
                                        <th class="min-w-90px">Country</th>
                                        <th class="min-w-90px">Number Of Ads
                                            <i class="fas fa-sort" data-sorting_type="desc" id="sortigcount"
                                               onclick="sortig()"></i>
                                        </th>
                                        <th class="min-w-90px">Categories</th>
                                    </tr>
                                    </thead>
                                    <!--end::Head-->
                                    <!--begin::Body-->
                                    <tbody class="fs-6">
                                    @forelse($datas as $data)
                                        <tr>
                                            @if(user()->role->role->type != 1)
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
                                                           class="mb-1 text-gray-800 text-hover-primary">{{$data->name_en}}</a>

                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                            </td>
                                            <td>
                                                {{ $data->country->name_en ?? ""}}
                                                <!--end::User-->
                                            </td>
                                            <td>
                                                {{  ($data->count==0)?'N/A':number_format($data->count) }}
                                            </td>
                                            <td>
                                                @foreach ($data->category as $category)
                                                    {{ $category->name_en . !$loop->last ?? ' , ' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <div class="alert alert-danger text-center">No Data</div>
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
                                {{ $datas->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas,'perPage' =>Request::get('perPage') ?? $datas->perPage(),'perArray'=>[12,24,48,96,192]]) }}
                            @endif
                            <!--end::Table container-->
                        @else
                            <h3 class="text-center text-gray">No Records to display in this time range ...</h3>
                        @endif
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Tab Content-->
    </div>
@endsection
@push('scripts')

    <script>
        function sortig(){
            let sorting = "&sorting=" + '{{ Request('sorting') == 'desc' ? 'asc' :'desc'}}';
            window.location.href = "{{route('influencer.InfluencersByids')}}?sorting=" + sorting + "&category=" + '{{ Request('category')}}' +  "&ranges=" + '{{ Request('ranges')}}';
        }



    </script>
@endpush
