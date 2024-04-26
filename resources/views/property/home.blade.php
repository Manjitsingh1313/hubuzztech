@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Properties</h1>
        <a href="{{ route('properties/create') }}" class="btn btn-primary  mb-2 ">
            <i class="fas fa-plus"></i> Add Property
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Properties</h6>
        </div>
        <div class="card-body">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>

                <script>
                    setTimeout(function() {
                        document.querySelector('.alert').remove();
                    }, 3000);
                </script>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Property Name</th>
                            <th>Price</th>
                            <th>Area Sqft</th>
                            <th>Deal</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($properties as $property)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $property->property_name }}</td>
                                <td>&#8377; {{ $property->price }}</td>
                                <td>{{ $property->area_sqft }} / sqft</td>
                                <td>{{ $property->deal }}</td>
                                <td>{{ $property->type }}</td>
                               
                                <td>
                                    <div class="d-flex" role="group" aria-label="Basic example">
                                        <a href="{{ route('properties/edit', ['id' => $property->_id]) }}"
                                           class="btn btn-warning mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $property->_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $property->_id }}" tabindex="-1"
                                             role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this property?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        <a href="{{ route('properties/delete', ['id' => $property->_id]) }}"
                                                           class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Properties not found</td>
                            </tr>
                        @endforelse
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