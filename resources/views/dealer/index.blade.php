@extends('layouts.app')

@section('title', 'Dealers')

@section('contents')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="p-6 text-gray-900">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Dealers</h1>
            <a href="{{ route('dealer/create') }}" class="btn btn-primary mb-2">
                <i class="fas fa-plus"></i> Add Dealer
            </a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dealers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-primary" style="background-color: grey;">
                        <tr>
                            <th  style="color: white;">#</th>
                            <th  style="color: white;">Name</th>
                            {{-- <th  style="color: white;">Email</th> --}}
                            <th  style="color: white;">Mobile</th>
                            {{-- <th  style="color: white;">User City</th> --}}
                            <th  style="color: white;">Role</th>
                            <th  style="color: white;">Status</th>
                            <!-- <th  style="color: white;">Dealer Properties</th> -->
                            <th  style="color: white;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $dealer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ isset($dealer->name) && !empty($dealer->name) ? $dealer->name : 'N/A' }}</td>
                            {{-- <td>{{ isset($dealer->email) && !empty($dealer->email) ? $dealer->email : 'N/A' }}</td> --}}
                            <td>{{ isset($dealer->mobile) && !empty($dealer->mobile) ? $dealer->mobile : 'N/A' }}</td>
                            {{-- <td>{{ isset($dealer->user_city) && !empty($dealer->user_city) ? $dealer->user_city : 'N/A' }}</td> --}}
                            <td>{{ isset($dealer->role) && !empty($dealer->role) ? $dealer->role : 'N/A' }}</td>
                            <td>{{ isset($dealer->status) ? ($dealer->status ? 'Active' : 'Inactive') : 'Inactive' }}</td>
                            <!-- <td>
                                <a href="{{ route('user/properties', ['user_id' => $dealer->_id]) }}">View</a>
                            </td> -->
                            <td>
                                <a href="{{ route('user/properties', ['user_id' => $dealer->_id]) }}" class="btn btn-secondary" data-toggle="tooltip" title="Search">
                                    <i class="fas fa-search" style="color: white;"></i>
                                </a>

                                <a href="{{ route('dealer/edit', $dealer->_id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $dealer->_id }}" data-toggle="tooltip" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $dealer->_id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                Are you sure you want to delete this dealer?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <form action="{{ route('dealer/delete', $dealer->_id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Dealers not found</td>
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
