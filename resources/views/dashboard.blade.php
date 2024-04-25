@extends('layouts.app')

@section('title', 'Hubuzztechnology(Unify)')

@section('contents')
    {{-- <?php
    echo '<pre>';
    print_r($user);
    echo '</pre>';
    ?> --}}

    {{-- @if ($user)
        <h1>Welcome, {{ $user->mobile }}</h1>
    @else
        <h1>Welcome, Guest</h1>
        <p>Please login to access the dashboard.</p>
    @endif --}}

    @if ($message)
        <div class="alert alert-success" id="successAlert">
            {{ $message }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('successAlert').remove();
            }, 3000); // 3000 milliseconds = 3 seconds
        </script>
    @endif


    <div class="row">

        <!-- Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Properties Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Properties</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $properties->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!-- Active Users Card -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Active</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $activeUsersCount }}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                {{-- You can use this if you want to display a progress bar based on the count --}}
                                {{-- <div class="progress-bar bg-info" role="progressbar" style="width: {{ $activeUsersCount }}%" aria-valuenow="{{ $activeUsersCount }}" aria-valuemin="0" aria-valuemax="100"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    {{-- <i class="fas fa-clipboard-list fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inactive Users Card -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Inactive</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inactiveUsersCount }}</div>
                </div>
                <div class="col-auto">
                    {{-- <i class="fas fa-comments fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
    </div>
</div>




        <!-- Buttons -->
        <div class="col-12 mb-4">
            <button class="btn btn-primary" onclick="window.location.href='{{ route('dealers') }}'">Show Dealers</button>
            <button class="btn btn-secondary" onclick="window.location.href='{{ route('properties') }}'">Show
                Properties</button>
        </div>

    </div>
    <div>
        <img src="{{ asset('/assets/images/column-chart.webp') }}" alt="Inactive Icon" class="img-fluid" style="width: 100%; height: 100%;">
    </div>
    
    
   
    
@endsection
