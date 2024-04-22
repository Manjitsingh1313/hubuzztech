@extends('layouts.app')
  
{{-- @section('title', 'Dashboard - Laravel Admin Panel With Login and Registration') --}}
  
@section('contents')

   <!-- Page Heading -->
   <h1 class="h3 mb-2 text-gray-800">Tables</h1>
   <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
       For more information about DataTables, please visit the <a target="_blank"
           href="https://datatables.net">official DataTables documentation</a>.</p>

   <!-- DataTales Example -->
   <div class="card shadow mb-4">
       <div class="card-header py-3">
           <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
       </div>
       <div class="card-body">
           <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                       <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Rera Number</th>
                        <th>Role</th>
                       </tr>
                   </thead>
                   <tfoot>
                       <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Rera Number</th>
                        <th>Role</th>
                   </tfoot>
                   <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ isset($user->name) ? $user->name : 'Name not set' }}</td>
                        <td>{{ isset($user->email) ? $user->email : 'Email not set' }}</td>
                        <td>{{ isset($user->mobile) ? $user->mobile : 'Mobile not set' }}</td>
                        <td>{{ isset($user->user_city) ? $user->user_city : 'City not set' }}</td>
                        <td>{{ isset($user->rera_number) ? $user->rera_number : 'Rera Number not set' }}</td>
                        <td>{{ isset($user->role) ? $user->role : 'Role not set' }}</td>
                    </tr>
                @endforeach
                
                     
                   </tbody>
               </table>
           </div>
       </div>
   </div>


@endsection