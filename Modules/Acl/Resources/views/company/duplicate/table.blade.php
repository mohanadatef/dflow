<div class="table-responsive">
    @include('dashboard.error.error')
    @if(count($datas['table']))
    <table class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-7 gs-7">
        <thead>
        <tr class="fw-semibold fs-4 text-gray-800">
            <th scope="col">Duplicate Count</th>
            <th scope="col">{{getCustomTranslation('name_en')}}</th> 
			<th scope="col">{{getCustomTranslation('name_ar')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($datas['table'] as $data)
           
      @if($data->count() >1) 
		 <form class="form" name="{{$data[0]->id}}" method="get" action="{{route('company.mergeduplicate')}}" enctype="multipart/form-data">
                @csrf  
	   <tr>
                <th scope="row">{{$data->count()}}</th>
                <td>{{$data[0]->name_en }}</td>
				<td>{{$data[0]->name_ar }}</td>
           
            </tr>
	
            <tr>
                <td colspan="5">
                    <table class="table table-row-dashed table-row-gray-500 gy-5 gs-5 mb-0">
                        <thead>
                    <tr class="">
					        <th scope="col">
							<button type="submit"  name="{{getCustomTranslation('ID')}}" id="{{getCustomTranslation('ID')}}" class="dropbtn btn btn-primary me-3" class="mybutton">Merge
                        </button> 
						
						 <input name="compval"    type="hidden" value="" id="{{$data[0]->name_en }}"/>	
						</th>
                            <th scope="col">{{getCustomTranslation('ID')}}</th>
                            <th scope="col">{{getCustomTranslation('name_en')}}</th>
                            <th scope="col">{{getCustomTranslation('name_ar')}}</th>
                            <th scope="col">{{getCustomTranslation('link')}}</th>  
							<th scope="col">{{getCustomTranslation('industry')}}</th>
							<th scope="col">Action</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $da)
					
                        <tr style="font-weight: 300;font-size: 14px;">
                         <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input name="comp[]"  class="{{ str_replace(' ', '', $da->name_en) }}"  data-id="same_{{$da->name_en }}_{{$da->id}}" id="same_{{$da->name_en }}_{{$da->id}}" type="checkbox" 
                                       value="{{$da->id}}"/>
									   
								   
                            </div>
                        </td>
						   <td>{{$da->id}}</td>
                            <td>
							<a href="{{route('company.edit',$da->id)}}" title="view Details"
                           class="menu-link px-3">{{$da->name_en }}</a>
							</td>
                            <td>{{$da->name_ar }}</td>
                            <td>{{$da->old_link}}</td>
							<td>
                {{implode(',',$data[0]->industry->pluck('name_'.$lang)->toArray())}}
            </td>
			<td>  
						   
	    {{-- <span class="me-2" data-kt-company-table-select="selected_count"></span>Selected</div> --}}              
 <button type="button" class="btn btn-danger ms-1"
                                data-kt-company-table-select="delete_selected">Ignore</button>

					  </button>   
						   </td>
                        </tr>
						
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr> 
			 </form>
			@endif
        @endforeach

        </tbody>
    </table>
    {{ $datas['duplicates']->appends($_GET)->links('dashboard.layouts.pagination', ['paginator' => $datas['duplicates'],'perPage' =>Request::get('perPage') ?? $datas['duplicates']->perPage()]) }}

    @else
        <h3 class="text-center text-gray">{{getCustomTranslation("no_records_to_display_in_this_time_range")}} ...</h3>
    @endif
</div>