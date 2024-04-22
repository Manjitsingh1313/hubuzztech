@extends('layouts.app')

@section('title', 'Create Dealer')

@section('contents')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <p><a href="{{ route('dealers') }}" class="btn btn-primary">Go Back</a></p>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <div class="p-6 text-gray-900">
                <h2 class="mb-0">New Dealer</h2>
                <hr />
                {{-- Start Display error message --}}
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
                {{-- End Display error message --}}

                <form action="{{ route('dealer/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="tel" name="mobile" class="form-control" placeholder="Mobile" value="{{ old('mobile') }}" required>
                        </div>
                        <div class="col">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="otp_status" class="form-control" value="true" placeholder="OTP Status" required hidden>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select name="role" class="form-control">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Role Admin</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Role User</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="status" class="form-control">
                                <option value="true" {{ old('status') == 'true' ? 'selected' : '' }}>Status Active</option>
                                <option value="false" {{ old('status') == 'false' ? 'selected' : '' }}>Status Inactive</option>
                            </select>
                        </div>
                    </div>
                    {{-- Removed commented out fields --}}
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block">Submit</button>
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
