@php
    // decide the next 2 pages!
    $startPages = '';
    $nextPages = '';
    if ($paginator->currentPage()+2 <= $paginator->lastPage()) {

        $startPages = $paginator->currentPage();
        $nextPages = $paginator->currentPage()+2;
    }
    else if ($paginator->currentPage() == $paginator->lastPage()) {
        $startPages = ($paginator->currentPage()-2 > 0)? $paginator->currentPage()-2 : 1;
        $nextPages = $paginator->currentPage();
    } else {
        $startPages = ($paginator->currentPage()-1 > 0)? $paginator->currentPage()-1 : 1;
        $nextPages = $paginator->lastPage();
    }
@endphp
    <!--Begin::Pagination-->
<div class="row" style="margin-top:20px">
    <div class="col-xl-12">
        <!--begin:: Components/Pagination/Default-->
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <!--begin: Pagination-->
                <div class="my-work" style="display: flex;justify-content: space-between;">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $paginator->url(1) . (Request::get('perPage') ? "&perPage=".Request::get('perPage') : "")}}"
                                   aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" @empty($paginator->previousPageUrl()) hidden @endempty>
                                <a class="page-link"
                                   href="{{ $paginator->previousPageUrl() . (Request::get('perPage') ? "&perPage=".Request::get('perPage') : "")}}"
                                   aria-label="Previous">
                                    <span aria-hidden="true">{{$custom[strtolower('last')]?? getCustomTranslation('prev')}}</span>
                                </a>
                            </li>
                            @for ($i = $startPages; $i <= $nextPages; $i++)
                                <li class="@if ($paginator->currentPage() == $i) page-item active @else page-item @endif">
                                    <a class="page-link"
                                       href="{{ $paginator->url($i) . (Request::get('perPage') ? "&perPage=".Request::get('perPage') : "")}}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item" @empty($paginator->nextPageUrl()) hidden @endempty>
                                <a class="page-link"
                                   href="{{ $paginator->nextPageUrl() . (Request::get('perPage') ? "&perPage=".Request::get('perPage') : "")}}"
                                   aria-label="Next">
                                    <span aria-hidden="true">{{$custom[strtolower('next')]??getCustomTranslation('next')}} </span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $paginator->url($paginator->lastPage()) . (Request::get('perPage') ? "&perPage=".Request::get('perPage') : "")}}"
                                   aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="kt-pagination__toolbar ml-auto" style="display: flex">
                        <select class="form-control kt-font-brand per-page-select" id="limit" style="width: 54px; text-align-last:center; "
                               >
                            @if(isset($perArray))
                                <option value="12"
                                        @if((isset($perPage) && $perPage == 12 )|| (Request::get('perPage') && Request::get('perPage') == 12 )) selected @endif>
                                    12
                                </option>
                                <option value="24"
                                        @if((isset($perPage) && $perPage == 24 )|| (Request::get('perPage') && Request::get('perPage') == 24 )) selected @endif>
                                    24
                                </option>
                                <option value="48"
                                        @if((isset($perPage) && $perPage == 48 )|| (Request::get('perPage') && Request::get('perPage') == 48 )) selected @endif>
                                    48
                                </option>
                                <option value="96"
                                        @if((isset($perPage) && $perPage == 96 )|| (Request::get('perPage') && Request::get('perPage') == 96 )) selected @endif>
                                    96
                                </option>
                                <option value="192"
                                        @if((isset($perPage) && $perPage == 192 )|| (Request::get('perPage') && Request::get('perPage') == 192 )) selected @endif>
                                    192
                                </option>
                            @else
                                <option value="10"
                                        @if((isset($perPage) && $perPage == 10 )|| (Request::get('perPage') && Request::get('perPage') == 10 )) selected @endif>
                                    10
                                </option>
                                <option value="20"
                                        @if((isset($perPage) && $perPage == 20 )|| (Request::get('perPage') && Request::get('perPage') == 20 )) selected @endif>
                                    20
                                </option>
                                <option value="30"
                                        @if((isset($perPage) && $perPage == 30 )|| (Request::get('perPage') && Request::get('perPage') == 30 )) selected @endif>
                                    30
                                </option>
                                <option value="50"
                                        @if((isset($perPage) && $perPage == 50 )|| (Request::get('perPage') && Request::get('perPage') == 50 )) selected @endif>
                                    50
                                </option>
                                <option value="100"
                                        @if((isset($perPage) && $perPage == 100 )|| (Request::get('perPage') && Request::get('perPage') == 100 )) selected @endif>
                                    100
                                </option>
                            @endif
                        </select>
                        <span class="pagination__desc"
                              style="margin: 10px 0 0 10px;font-weight: 500;color: #31186f;font-size: 1.075rem;"
                        >
                        {{$custom[strtolower('Displaying')]??getCustomTranslation('displaying')}} {{ $paginator->count() }} {{$custom[strtolower('of')]??getCustomTranslation('of')}}  {{($paginator->total() == 0)?'N/A': number_format($paginator->total()) }} {{$custom[strtolower('records')]??getCustomTranslation('records')}}
                    </span>
                    </div>
                </div>
                <!--end: Pagination-->
            </div>
        </div>
        <!--end:: Components/Pagination/Default-->
    </div>
</div>
<script>
    function setPerPage() {
       
        var perPageValue = $('.per-page-select').val();

        // Remove the 'page' parameter from the URL
        var urlWithoutPage = window.location.href.replace(/([?&])page=[^&]*(&|$)/, '$1');

        if (urlWithoutPage.indexOf('perPage') !== -1) {
            // Update the 'perPage' parameter in the URL
            window.location.href = urlWithoutPage.replace(/&?perPage=(\d+)/g, `&perPage=${perPageValue}&page=1`);
        } else {
            if (urlWithoutPage.indexOf('?') !== -1) {
                // Add the 'perPage' and 'page' parameters to the URL
                window.location.href = urlWithoutPage + `&perPage=${perPageValue}&page=1`;
            } else {
                // Add the 'perPage' and 'page' parameters to the URL
                window.location.href = urlWithoutPage + `?perPage=${perPageValue}&page=1`;
            }
        }
    }

</script>
<!--End::Pagination-->
