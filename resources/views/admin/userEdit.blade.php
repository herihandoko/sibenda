@php
$page_title = trans('admin.Admin | Edit User');
@endphp
@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/css/mediamanager.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-iconpicker.min.css')}}">

@endpush
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{trans('admin.Edit User')}}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.users.index')}}" role="button"><i
                    class="fas fa-arrow-circle-left    "></i> {{trans('admin.Back')}}</a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['admin.users.update', $user->id]]) !!}

                        @include('admin.layouts.mediaInput', [
                            'inputTitle' => 'Image',
                            'inputName' => 'avatar',
                            'inputData' => $user->avatar,
                            'multiInput' => false,
                            'buttonText' => 'Select',
                        ])

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Name')}}</label>
                                    {!! Form::text('name', null, ['placeholder' => trans('admin.Name'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Username')}}</label>
                                    {!! Form::text('username', null, ['placeholder' => trans('admin.Username'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Email')}}</label>
                                    {!! Form::text('email', null, ['placeholder' => trans('admin.Email'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Password')}}</label>
                                    {!! Form::password('password', ['placeholder' => trans('admin.Password'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Confirm Password')}}</label>
                                    {!! Form::password('confirm-password', ['placeholder' => trans('admin.Confirm Password'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Role')}}</label>
                                    {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple','id' => 'multiple-select']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-block">{{trans('admin.Submit')}}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.layouts.mediaModal')
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#multiple-select').select2();
        });
    </script>
    @include('admin.layouts.mediaJs')
@endpush
