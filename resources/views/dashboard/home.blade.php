@extends('dashboard.layouts.app')

@section('title', getCustomTranslation( 'welcome') ." ".user()->name)

@section('content')
    <div class="card card-flush">
        <!--begin::Card header-->

        <!--begin::Card title-->

        <!--begin::Card title-->
        <!--begin::Card toolbar-->

        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <img alt="Logo" src="{{ asset('dashboard') }}/assets/logo.png"  id="lightImage"
                 style="width: 100%;height: 100%;display: block;"/>
            <img alt="Logo" src="{{ asset('dashboard') }}/assets/logosbySI-03-2-1.png"  id="darkImage"
                 style="width: 100%;height: 100%;display: none;"/>
        </div>
        <!--end::Datatable-->
    </div>
@endsection

