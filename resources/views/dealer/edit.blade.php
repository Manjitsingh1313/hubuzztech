@extends('layouts.app')

@section('title', 'Edit Dealer')

@section('contents')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-0">Update Dealer</h3>
                    <hr />

                    {{-- start Display error message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{-- Display error message --}}
                                        {{ $error }}
                                        {{-- Example: Commenting on the error --}}
                                        {{-- Comment: This error is related to the user's input --}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    {{-- end  Display error message --}}

                    <form action="{{ route('dealer/update', $dealer->_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name"
                                    value="{{ old('name', $dealer->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $dealer->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">User City</label>
                                <input type="text" name="user_city" class="form-control" placeholder="User City"
                                    value="{{ old('user_city', $dealer->user_city) }}">
                                @error('user_city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile"
                                    value="{{ old('mobile', $dealer->mobile) }}">
                                @error('mobile')
                                    @foreach ($errors->get('mobile') as $error)
                                        <span class="text-danger">{{ $error }}</span><br>
                                    @endforeach
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="otp_status" class="form-control"
                                value="{{ old('otp_status', $dealer->otp_status) }}">
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="user" {{ old('role', $dealer->role) == 'user' ? 'selected' : '' }}>
                                        User</option>
                                    <option value="admin" {{ old('role', $dealer->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status', $dealer->status) ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ !old('status', $dealer->status) ? 'selected' : '' }}>InActive
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Profile</label>
                                @if (isset($dealer->image))
                                    <img src="{{ asset($dealer->image) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 200px;">
                                    <div class="mt-2">
                                        <label for="image" class="file-upload-btn btn btn-primary">
                                            Update picture
                                            <input type="file" id="image" name="image" class="form-control inputfile" accept="image/*">
                                        </label>
                                        <small class="text-muted">Upload a new image to update</small>
                                    </div>
                                @else
                                    <label for="image" class="file-upload-btn btn btn-primary">
                                        Upload Image
                                        <input type="file" id="image" name="image" class="form-control inputfile" accept="image/*">
                                    </label>
                                    <small class="text-muted">Upload a profile image</small>
                                @endif
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">User Pincode</label>
                                <input type="text" name="user_pincode" class="form-control" placeholder="User Pincode" value="{{ old('user_pincode', $dealer->user_pincode) }}">
                                @error('user_pincode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">RERA Number</label>
                                <input type="text" name="rera_number" class="form-control" placeholder="RERA Number"
                                    value="{{ old('rera_number', $dealer->rera_number) }}">
                                @error('rera_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col d-flex justify-content-end">
                                <div class="d-grid">
                                    <button class="btn btn-warning btn-inline">Update</button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-grid">
                                    <a href="{{ route('dealers') }}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
