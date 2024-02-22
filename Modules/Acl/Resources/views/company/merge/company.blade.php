<div class="card-body px-5">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_company_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2">
                </th>
                <th class="min-w-125px">{{getCustomTranslation('name_en')}}</th>
                <th class="min-w-125px">{{getCustomTranslation('name_ar')}}</th>
                <th class="w-450px" style="text-align:left !important">{{getCustomTranslation('industry')}}</th>
                @foreach($sites as $value)
                <th class="w-450px" style="text-align:left !important">{{$value->{'name_'.$lang} }}</th>
                @endforeach
                <th class="w-450px">{{getCustomTranslation('ad')}}</th>
                <th class="w-450px">{{getCustomTranslation('actions')}}</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            @foreach($data as $row)
                <tr id="company-{{$row->id}}">
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input  type="checkbox"  name="id_company" id="id_company" class="id_company" hidden
                                   value="{{$row->id}}"/>
                        </div>
                    </td>
                    <td>
                        {{$row->name_en }}
                    </td>
                    <td>
                        {{$row->name_ar }}
                    </td>
                    <td>
                        {{implode(',',$row->industry->pluck('name_'.$lang)->toArray())}}
                    </td>
                    @foreach($sites as $value)
                        <td>
                            @php
                             $url =    $row->company_website->where('website_id',$value->id)->first()->url ?? null;
                        @endphp
                             <a class="hoverable" id="kt_app_layout_builder_toggle" title="{{$url}}"
                                data-bs-custom-class="tooltip-inverse"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-dismiss="click"
                                data-bs-trigger="hover"
                                data-kt-initialized="1"
                                target="_blank" href="{{$url ?? "#"}}">{{$url ? getCustomTranslation('show') : ""}}</a>
                        </td>
                    @endforeach
                    <td>
                        {{$row->ad_record->count() }}
                    </td>
                    <td>
                        <a onclick="removeCampnay({{$row->id}})">{{getCustomTranslation('remove')}}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

</div>
