@php
$page_title = trans('admin.Admin | Profile');
@endphp
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/css/mediamanager.css')}}">

@endpush
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{trans('admin.Profile')}}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.dashboard')}}" role="button"><i
                    class="fas fa-arrow-circle-left    "></i> {{trans('admin.Back')}}</a>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('admin.user-profile.store')}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    @include('admin.layouts.mediaInput', [
                                    'inputTitle' => 'Avatar',
                                    'inputName' => 'avatar',
                                    'inputData' => $user->avatar,
                                    'multiInput' => false,
                                    'buttonText' => 'Select',
                                    ])
                                    <div class="form-group">
                                        <label for="">{{trans('admin.Name')}}</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{@$user->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{trans('admin.Email')}}</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{@$user->email}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{trans('admin.Password')}}</label>
                                        <input type="password" class="form-control" name="password"
                                            value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{trans('admin.Confirm Password')}}</label>
                                        <input type="password" class="form-control" name="confirm_password"
                                            value="">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block" role="button"> {{trans('admin.Save')}} </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('script')
        @include('admin.layouts.mediaJs')
    @endpush
    @include('admin.layouts.mediaModal')
@endsection
