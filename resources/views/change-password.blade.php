@extends('layouts.app')
@section('title', 'Change Password')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password</div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('change/password') }}">
                        @csrf

                        <!-- Old Password -->
                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">Old Password</label>
                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Show/Hide Password -->
                            <div class="col-md-2">
                                <input type="checkbox" onclick="showHidePassword('old_password_toggle', 'old_password')">
                                <label for="show_hide">Show</label>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Show/Hide Password -->
                            <div class="col-md-2">
                                <input type="checkbox" onclick="showHidePassword('new_password_toggle', 'new_password')">
                                <label for="show_hide">Show</label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showHidePassword(toggleId, targetId) {
        const toggle = document.getElementById(toggleId);
        const target = document.getElementById(targetId);

        if (target.type === "password") {
            target.type = "text";
            toggle.checked = true;
        } else {
            target.type = "password";
            toggle.checked = false;
        }
    }
</script>
@endsection
