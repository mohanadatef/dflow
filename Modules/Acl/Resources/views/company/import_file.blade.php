@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('companies_import'))

@section('content')
    <div class="container">
        <hr>
        <div class="card bg-light mt-3">
            <div class="card-header py-2 my-2">{{getCustomTranslation('companies_import')}}</div>
            <div class="card-body">
                @if(session()->has('message'))
                    <div class="bg-light mt-3">
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    </div>
                    @php
                        session()->forget('message');
                    @endphp
                @endif
                <form id="myForm" action="{{ route('company.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control" required>
                    <br>
                    <button id="submit-button" class="btn btn-success" disabled
                    >
                        {{getCustomTranslation('import_file')}}
                    </button>
                    <button id="loading-button" class="btn btn-primary d-none" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="sr-only">{{getCustomTranslation('loading')}}...</span>
                        {{getCustomTranslation('importing_data')}}
                    </button>
                    <a href="{{ route('company.download') }}" class="btn btn-danger download_link"
                       @if($import_in_progress == 1) style="display: none;" @endif
                       title="download rows with missing data"
                       data-toggle="tooltip"
                    >{{getCustomTranslation('download')}}

                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('dashboard/assets/jquery/jquery-3.7.1.min.js')}}"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"
    >
    </script>
    <script src="{{asset('dashboard/assets/jquery/jquery.form.min.js')}}"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"
    >
    </script>
    <script src="{{ asset('dashboard') }}/assets/js/import.js"></script>
    <script>
        @if($import_in_progress == 0)
            $('#submit-button').prop("disabled", false); // Element(s) are now enabled.
        @else
            RepeatFun();
        @endif
        let status_url = "{{ route('company.status') }}";
    </script>
@endpush
