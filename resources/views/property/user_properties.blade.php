@extends('layouts.app')

@section('contents')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Dealer Properties</h1>
        {{-- <p class="mb-4">Below is the list of properties.</p> --}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Properties</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Price</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Property</th>
                                <th>Price</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($properties as $property)
                            {{-- {{dd($property)}} --}}
                                <tr>
                                    <td>{{ isset($property->property_name) ? $property->property_name : 'Name not set' }}</td>
                                    <td>{{ isset($property->price) ? $property->price : 'Price not set' }}</td>
                                    {{-- <td>{{ isset($property->area_sqft) ? $property->area_sqft : 'Area Sqft not set' }}</td> --}}
                                    {{-- <td>{{ isset($property->status) ? $property->status : 'Status not set' }}</td> --}}
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('properties/edit', $property->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('properties/delete', $property->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
