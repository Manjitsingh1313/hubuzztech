@extends('layouts.app')
  
@section('contents')

   <!-- Page Heading -->
   <h1 class="h3 mb-2 text-gray-800">User Properties</h1>
   <p class="mb-4">Below is the list of properties associated with the selected user.</p>

   <!-- DataTales Example -->
   <div class="card shadow mb-4">
       <div class="card-header py-3">
           <h6 class="m-0 font-weight-bold text-primary">User Properties</h6>
       </div>
       <div class="card-body">
           <p>Total Number of Properties: <strong>{{ $properties->count() }}</strong></p>
           <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                       <tr>
                        <th>Property Name</th>
                        <th>Price</th>
                        <th>Area Sqft</th>
                        <!-- Add more columns as needed -->
                       </tr>
                   </thead>
                   
                   <tbody>
                    @foreach($properties as $property)

                    <tr>
                        <td>{{ isset($property->property_name) ? $property->property_name : 'Name not set' }}</td>
                        <td>{{ isset($property->price) ? $property->price : 'Price not set' }}</td>
                        <td>{{ isset($property->area_sqft) ? $property->area_sqft : 'Area Sqft not set' }}</td>
                        <!-- Add more columns as needed -->
                    </tr>
                    @endforeach
                   </tbody>
               </table>
           </div>
       </div>
   </div>

@endsection
