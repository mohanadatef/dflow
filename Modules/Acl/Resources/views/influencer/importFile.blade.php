@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('import_influencers'))

@section('content')
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header my-2 py-2">{{getCustomTranslation('import_influencers')}}</div>
        <div class="card-body">
            @if(session()->has('message'))
                <div class="bg-light mt-3">
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                </div>
                <hr>
                @php
                    session()->forget('message');
                @endphp
            @elseif(session()->has('bad'))
                <div class="bg-light mt-3">
                    <div class="alert alert-danger">
                        {{ session()->get('bad') }}
                    </div>
                </div>
                <hr>
                @php
                    session()->forget('bad');
                @endphp
            @endif
            <form id="myForm" action="{{ route('influencer.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <input type="file" name="file"
                           class="form-control"
                           required
                    >
                    {{--<select name="spread_sheet" aria-label="Select a spread_sheet"
                            data-control="select2" data-placeholder="Select a spread_sheet..."
                            class="form-select form-select-solid form-select-lg fw-semibold">
                        <option value="">Select a spread_sheet...</option>
                        @foreach($account->spread_sheet as $value)
                            <option value="{{$value->id}}">{{$value->{'name_'.$lang} }}</option>
                        @endforeach
                    </select>--}}
                <br>
                <button id="submit-button" class="btn btn-success">
                   {{getCustomTranslation('import_data')}}
                </button>
                <button id="loading-button" class="btn btn-primary d-none" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">{{getCustomTranslation('loading')}}...</span>
                    {{getCustomTranslation('importing_data')}}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('dashboard/assets/jquery/jquery-3.7.1.min.js')}}"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{asset('dashboard/assets/jquery/jquery.form.min.js')}}"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
        crossorigin="anonymous"></script>
<script>
    document.forms["myForm"].addEventListener("submit", async (event) => {
        $("#loading-button").removeClass("d-none");
        $("#submit-button").addClass("d-none");
        setTimeout(async function () {
            const resp = await fetch('{{ route('influencer.import') }}' + '?check_status=1');
            const body = await resp;
            if (body) {
                $("#submit-button").removeClass("d-none");
                $("#loading-button").addClass("d-none");
                alert("{{getCustomTranslation('importing_is')}}");
            }
        }, 1000);
    });
</script>

@endpush
