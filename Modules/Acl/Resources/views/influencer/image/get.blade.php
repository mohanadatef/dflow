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
            <form id="myForm" action="{{ route('influencer.image.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <input type="file" name="images[]"
                           class="form-control"
                           required multiple
                    >
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

@endpush
