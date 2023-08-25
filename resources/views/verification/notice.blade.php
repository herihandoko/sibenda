@php
$page_title = trans('frontend.Verify Email');
@endphp
@extends('frontend.layouts.master')
@section('content')
    @include('cookieConsent::index')
    <div id="wrapper" class="clearfix">
        <!-- Header -->
        @include(getHeader())
        <!-- Start main-content -->
        <div class="main-content-area">

            <div class="container">



                <div class="row d-flex justify-content-center">
                    <div class="col-md-8 mt-5">
                       <div class="card h-100 text-center">
                         <div class="card-body  p-5 shadow-sm">
                            @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{trans('frontend.A fresh verification link has been sent to your email address.')}}
                            </div>
                        @endif

                        {{trans('frontend.Before proceeding, please check your email for a verification link. If you did not receive the email,')}}


                        <form action="{{route('verification.resend')}}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="d-inline btn btn-link p-0">
                               {{trans('frontend.click here to request another')}}

                            </button>
                        </form>
                         </div>
                       </div>
                    </div>
                </div>



            </div>

        </div>
        <!-- end main-content -->
        @include(getFooter())
        <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
    </div>
    <!-- end wrapper -->
@endsection
