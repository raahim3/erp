@extends('layouts.app')
@section('title','Edit Designation')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Edit Designation</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Designations</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('designation_read'))
            <div class="col-sm-6">
                <a href="{{ route('designations.index') }}" class="btn btn-primary float-end"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
            </div>
        @endif
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('designations.update', $designation->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Department Name</label>
                                <input type="text" name="name" class="form-control" required value="{{ $designation->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Department Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $designation->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

</div>

@endSection