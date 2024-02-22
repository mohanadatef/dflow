@extends('dashboard.layouts.app')

@section('title', 'Google Login')

@section('content')
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
             data-bs-target="#kt_influencer_create" aria-expanded="true"
             aria-controls="kt_influencer_create">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Google Login</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Content-->

        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->

            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                @if(!$account)
                <div class="row mb-6">
                    <a href="{{route('login-google')}}" class="btn btn-info" type="button" > <i class="fab fa-google fa-2x"></i>
                        Login Google</a>
                </div>
                @else
                    {!! Form::open(['route' => ['logout.google'], "target"=>"_new", 'id'=> 'kt_form']) !!}

                    <div class="kt-portlet__head-wrapper">
                        {!! Form::button('logout from '.$account->email, ['type'=>'submit', 'class' =>'btn  btn-info']) !!}
                    </div>

                    {!! Form::close() !!}
                    @endif
                <!--end::Input group-->
            </div>
            <!--end::Input group-->

            <!--end::Card body-->
        </div>
        <!--end::Content-->
        </div>
        <!--begin::Card header-->
@endsection
