@extends('layouts.app')
@section('title','Edit Employee')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Edit Employee</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Employees</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('employees.index') }}" class="btn btn-primary float-end"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employees.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <img src="{{ $user->profile ? asset('uploads/profile'.'/' . $user->profile) : asset('default.jpg') }}" alt="" height="150px" class="rounded" id="preview">
                                <br>
                                <label for="profile" class="btn btn-primary my-3">Profile Image</label>
                                <input type="file" name="profile" id="profile" hidden class="form-control">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" class="form-control" required placeholder="First Name" value="{{ $user->first_name }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required placeholder="Last Name" value="{{ $user->last_name }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" required placeholder="Email" value="{{ $user->email }}" autocomplete="aff">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone</label>
                                <input type="text" name="phone" class="form-control" required placeholder="Phone" value="{{ $user->phone }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Designation</label>
                                <select name="designation_id" class="form-control" id="">
                                    <option selected disabled>Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ $user->designation_id == $designation->id ? 'selected' : ''}}>{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Department</label>
                                <select name="department_id" class="form-control" id="">
                                    <option selected disabled>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : ''}}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Role</label>
                                <select name="role_id" class="form-control" id="">
                                    <option selected disabled>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hired_at">Hire Date</label>
                                <input type="datetime-local" name="hired_at" class="form-control" id="hired_at" value="{{ $user->hired_at }}">
                                @error('hired_at')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="">
                                    <option  value="1" {{ $user->status == 1 ? 'selected' : ''}}>Active</option>
                                    <option  value="0" {{ $user->status == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
                                @error('status')
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

@section('script')
<script>
    $(document).ready(function() {
        $(document).on('change', '#profile', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    });
</script>
@endsection