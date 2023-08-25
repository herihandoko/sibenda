@php
$page_title = trans('admin.Admin | Create Role');
@endphp
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/mediamanager.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}">
    
    <style>
        .scroll {
            width: 100%;
            overflow-y: scroll;
            padding-right: 10px;
            height: 50vh;
        }
        .scroll div {
            /* padding-left: 10px; */
        }
        .scroll::-webkit-scrollbar {
            width: 8px;
        }
        .scroll::-webkit-scrollbar-thumb {
            background-color: rgb(192, 192, 192);
            border-radius: 5px;
        }
    </style>

@endpush
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ trans('admin.Create Role') }}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{ URL::previous() }}" role="button"><i
                    class="fas fa-arrow-circle-left    "></i> {{ trans('admin.Back') }}</a>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">

                        {!! Form::open(['route' => 'admin.roles.store', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Name')}}</label>
                                    {!! Form::text('name', null, ['placeholder' => trans('admin.Name'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>{{trans('admin.Permission')}}</label>
                                    <br />
                                    <div class="form-group">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" name="checkall" id="checkall"
                                                        class="form-check-input"
                                                        onClick="check_uncheck_checkbox(this.checked);" />
                                                    <label class="form-check-label" for="checkall">
                                                        {{trans('admin.All Permissions')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="scroll">
                                            <div class="row">
                                                @foreach ($permissionGroup as $group)
                                                <div class="col-sm-4">
                                                    <div class="card border">
                                                        <div class="card-header border-bottom">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    data-group-main="{{ Illuminate\Support\Str::camel($group->name) }}"
                                                                    name="{{ Illuminate\Support\Str::camel($group->name) }}"
                                                                    id="{{ Illuminate\Support\Str::camel($group->name) }}"
                                                                    class="form-check-input"
                                                                    onClick="check_uncheck_checkbox_group(this.checked, '{{ Illuminate\Support\Str::camel($group->name) }}');" />
                                                                <label class="form-check-label"
                                                                    for="{{ Illuminate\Support\Str::camel($group->name) }}">
                                                                    {{ $group->name }}
                                                                </label>
                                                            </div>
                                                            <div style="position: absolute; right: 9px;" type="button" data-toggle="collapse" data-target="#id-{{ Illuminate\Support\Str::camel($group->name) }}" aria-expanded="false" aria-controls="id-{{ Illuminate\Support\Str::camel($group->name) }}">
                                                                <i class="fas fa-arrow-circle-down"></i>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card-body">
                                                            <div class="collapse" id="id-{{ Illuminate\Support\Str::camel($group->name) }}">
                                                                @foreach (\DB::table('permissions')->where(['permission_group_id' => $group->id])->get() as $value)
                                                                    <div class="form-check">
                                                                        {{ Form::checkbox('permission[]', $value->id, false, [
                                                                            'class' => 'form-check-input ' . Illuminate\Support\Str::camel($group->name),
                                                                            'id' => $value->id,
                                                                            'data-group' => Illuminate\Support\Str::camel($group->name),
                                                                        ]) }}
                                                                        <label class="form-check-label" for="{{ $value->id }}">
                                                                            {{ $value->title }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

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
        function check_uncheck_checkbox(isChecked) {

            if (isChecked) {
                $('input[type="checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[type="checkbox"]').each(function() {
                    this.checked = false;
                });
            }

        }

        function check_uncheck_checkbox_group(isChecked, group) {

            if (isChecked) {
                $('.' + group).each(function() {
                    this.checked = true;
                });
            } else {
                $('.' + group).each(function() {

                    this.checked = false;

                });
            }

        }

        $('input[type="checkbox"]').on("click", function() {

            if ($(this).is(":not(:checked)"))
                $('#checkall').prop('checked', false);

            if ($('input[name="permission[]"]:checked').length == $('input[name="permission[]"]').length) {
                $('#checkall').prop('checked', true);
            }

            if ($(this).attr('data-group')) {
                var group = $(this).attr('data-group');
                if ($('[data-group='+group+']:checked').length == $('[data-group='+group+']').length) {
                    $('[data-group-main='+group+']').prop('checked', true);
                }else $('[data-group-main='+group+']').prop('checked', false);
            }
        });
    </script>
    @include('admin.layouts.mediaJs')
@endpush
