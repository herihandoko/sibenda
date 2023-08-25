@php
$page_title = trans('admin.Admin | Admin language');
@endphp
@extends('admin.layouts.master')
@section('content')
    {{-- Main Content --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{trans('admin.Admin Language')}}</h1>
            </div>
            <a class="btn btn-primary mb-4" href="{{route('admin.dashboard')}}" role="button"><i class="fas fa-arrow-circle-left    "></i> {{trans('admin.Back')}}</a>
            <div class="section-body">
                <form action="{{route('admin.admin-language.update' ,1)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped   table-bordered w-100">
                                <thead class="thead-inverse border-bottom">
                                    <tr>
                                        <th>{{trans('admin.Content Name')}}</th>
                                        <th>{{trans('admin.Localization')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($language as $key => $value)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>
                                                <div class="form-group mt-4">
                                                    <input type="text" class="form-control" name="{{$key}}" value="{{$value}}" required>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary btn-block"> {{trans('admin.Save')}} </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

