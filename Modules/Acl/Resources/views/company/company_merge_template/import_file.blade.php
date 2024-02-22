@extends('dashboard.layouts.app')

@section('title', getCustomTranslation('import_companies_template'))

@section('content')
    <div class="container">
        <hr>
        <div class="card bg-light mt-3">
            <div class="card-header py-2 my-2">{{getCustomTranslation('import_companies_template')}}</div>
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
                <form id="myForm" action="{{ route('company_merge_template.import') }}" method="POST" enctype="multipart/form-data">
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
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('dashboard') }}/assets/js/import.js"></script>
    <script>
        @if($import_in_progress == 0)
            $('#submit-button').prop("disabled", false); // Element(s) are now enabled.
        @else
            RepeatFun();
        @endif
        let status_url = "{{ route('company_merge_template.status') }}";
    </script>
@endpush
