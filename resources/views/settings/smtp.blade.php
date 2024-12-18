@extends('layouts.app')
@section('title','SMTP Configuration')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>SMTP Configuration</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">SMTP Configuration</li>
                </ol>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-primary w-md" data-bs-toggle="modal" data-bs-target="#exampleModal">Send Test Email</button>
        </div>
    </div>
    <form action="{{ route('smtp.update',$smtp->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="from_name">From Name</label>
                        <input type="text" class="form-control" id="from_name" value="{{ $smtp->from_name }}" name="from_name" required>
                        @error('from_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="from_email">From Email</label>
                        <input type="email" class="form-control" id="from_email" value="{{ $smtp->from_email }}" name="from_email" required>
                        @error('from_email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_driver">SMTP Driver</label>
                        <input type="text" class="form-control" id="smtp_driver" value="{{ $smtp->smtp_driver }}" name="smtp_driver" required>
                        @error('smtp_driver')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_host">SMTP Host</label>
                        <input type="text" class="form-control" id="smtp_host" value="{{ $smtp->smtp_host }}" name="smtp_host" required>
                        @error('smtp_host')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_port">SMTP Port</label>
                        <input type="text" class="form-control" id="smtp_port" value="{{ $smtp->smtp_port }}" name="smtp_port" required>
                        @error('smtp_port')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_encryption">SMTP Encryption</label>
                        <input type="text" class="form-control" id="smtp_encryption" value="{{ $smtp->smtp_encryption }}" name="smtp_encryption" required>
                        @error('smtp_encryption')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_username">SMTP Username</label>
                        <input type="text" class="form-control" id="smtp_username" value="{{ $smtp->smtp_username }}" name="smtp_username" required>
                        @error('smtp_username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="smtp_password">SMTP Password</label>
                        <input type="password" class="form-control" id="smtp_password" value="{{ $smtp->smtp_password }}" name="smtp_password" required>
                        @error('smtp_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Send Test Email</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('smtp.test') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection