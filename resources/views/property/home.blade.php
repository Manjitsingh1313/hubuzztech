@extends('layouts.app')

@section('contents')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="p-6 text-gray-900">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Properties</h1>
                        <a href="{{ route('properties/create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Property
                        </a>
                    </div>
                    
                    <hr />
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                        </div>

                        <script>
                            setTimeout(function() {
                                document.querySelector('.alert').remove();
                            }, 3000);
                        </script>
                    @endif

                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Property Name</th>
                                <th>Price</th>
                                {{-- <th>Location</th> --}}
                                {{-- <th>Bedrooms</th> --}}
                                {{-- <th>Bathrooms</th> --}}
                                <th>Area Sqft</th>
                                <th>Deal</th>
                                <th>Type</th>
                                {{-- <th>Parking</th> --}}
                                {{-- <th>Description</th> --}}
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($properties as $property)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $property->property_name }}</td>
                                    <td class="align-middle">&#8377; {{ $property->price }}</td>
                                    {{-- <td class="align-middle">{{ json_encode($property->location) }}</td> --}}
                                    {{-- <td class="align-middle">{{ $property->bedrooms }}</td> --}}
                                    {{-- <td class="align-middle">{{ $property->bathrooms }}</td> --}}
                                    <td class="align-middle">{{ $property->area_sqft }} / sqft</td>
                                    <td class="align-middle">{{ $property->deal }}</td>
                                    <td class="align-middle">{{ $property->type }}</td>
                                    {{-- <td class="align-middle">{{ $property->parking }}</td> --}}
                                    {{-- <td class="align-middle">{{ $property->description }}</td> --}}
                                    {{-- <td class="align-middle">{{ $property->status }}</td> --}}
                                    <td class="align-middle">
                                        <div class="d-flex" role="group" aria-label="Basic example">
                                            <a href="{{ route('properties/edit', ['id' => $property->_id]) }}" type="button"
                                                class="btn  btn-warning  mr-2">
                                                <span class="icon text-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                    <!-- Assuming you want to use an edit icon -->
                                                </span>
                                            </a>

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $property->_id }}">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash"></i>
                                                    <!-- Assuming you want to use a trash icon for delete -->
                                                </span>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $property->_id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete
                                                            </h5>
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
                                                                type="button" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="12">Properties not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
