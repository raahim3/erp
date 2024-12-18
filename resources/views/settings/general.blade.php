@extends('layouts.app')
@section('title','General Settings')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4>General Settings</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">General</li>
                    </ol>
                </div>
            </div>
        </div>
        <form action="{{ route('general.update',$settings->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $settings->title }}" required placeholder="Title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email">Description</label>
                                    <textarea class="form-control" name="description" value="" required placeholder="Description" rows="4">{{ $settings->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $settings->email }}" required placeholder="Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $settings->address }}" required placeholder="Address">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $settings->phone }}" required placeholder="Phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Primary Color</label>
                                    <input type="color" class="form-control" name="primary_color" value="{{ $settings->primary_color }}" required placeholder="Primary Color">
                                    @error('primary_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <label for="light_logo">Light Logo</label>
                                <input type="file" class="form-control dropify" name="light_logo" value="" data-default-file="{{ asset('uploads/logos'.'/' . $settings->light_logo) }}">
                                @error('light_logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="light_logo">Dark Logo</label>
                                <input type="file" class="form-control dropify" name="dark_logo" value="" data-default-file="{{ asset('uploads/logos'.'/' . $settings->dark_logo) }}">
                                @error('dark_logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="favicon">Favicon</label>
                                <input type="file" class="form-control dropify" name="favicon" value="" data-default-file="{{ asset('uploads/logos'.'/' . $settings->favicon) }}">
                                @error('favicon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection