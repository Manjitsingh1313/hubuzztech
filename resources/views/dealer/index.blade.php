@extends('layouts.app')

@section('title', 'Dealers')

@section('contents')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="p-6 text-gray-900">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="mb-0">Dealers</h2>
                        <a href="{{ route('dealer/create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Dealer
                        </a>
                    </div>
                    
                </div>
                <hr />
                @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex" role="alert">
                            {{ Session::get('success') }}
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button> --}}
                        </div>

                        <script>
                            setTimeout(function() {
                                document.querySelector('.alert').remove();
                            }, 3000);
                        </script>
                    @endif

                @if (isset($users) && $users->count() > 0)
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>User City</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $dealer)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        {{ isset($dealer->name) && !empty($dealer->name) ? $dealer->name : 'N/A' }}</td>
                                    <td class="align-middle">
                                        {{ isset($dealer->email) && !empty($dealer->email) ? $dealer->email : 'N/A' }}</td>
                                    <td class="align-middle">
                                        {{ isset($dealer->mobile) && !empty($dealer->mobile) ? $dealer->mobile : 'N/A' }}
                                    </td>
                                    <td class="align-middle">
                                        {{ isset($dealer->user_city) && !empty($dealer->user_city) ? $dealer->user_city : 'N/A' }}
                                    </td>
                                    <td class="align-middle">
                                        {{ isset($dealer->role) && !empty($dealer->role) ? $dealer->role : 'N/A' }}</td>
                                    <td class="align-middle">
                                        {{ isset($dealer->status) ? ($dealer->status ? 'Active' : 'Inactive') : 'Inactive' }}
                                    </td>



                                    <td class="align-middle">
                                        <div class="d-flex" role="group" aria-label="Basic example">
                                            <a href="{{ route('dealer/edit', $dealer->_id) }}" type="button"
                                                class="btn btn-warning  mr-2">
                                                <span class="icon text-gray-600">
                                                    <i class="fas fa-edit"></i>
                                                    <!-- Assuming you want to use an edit icon -->
                                                </span>
                                            </a>

                                            <button type="button" class="btn btn-danger " data-toggle="modal"
                                                data-target="#deleteModal{{ $dealer->id }}">
                                                <span class="icon text-white">
                                                    <i class="fas fa-trash"></i>
                                                    <!-- Assuming you want to use a trash icon for delete -->
                                                </span>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $dealer->_id }}" tabindex="-1"
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
                                                            Are you sure you want to delete this dealer?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <form action="{{ route('dealer/delete', $dealer->_id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('GET')

                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" role="alert">
                        No dealers found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
