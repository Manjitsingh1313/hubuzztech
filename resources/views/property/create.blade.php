@extends('layouts.app')

@section('contents')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p><a href="{{ route('properties') }}" class="btn btn-primary">Go Back</a></p>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-0">Add Property</h2>
                    <hr />

                    {{-- Display error message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    
                    <form action="{{ route('properties/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Property Fields -->
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="property_name" class="form-control" placeholder="Property Name" value="{{ old('property_name') }}">
                                @error('property_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="number" name="price" class="form-control" placeholder="Price" value="{{ old('price') }}">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <input type="number" name="area_sqft" class="form-control" placeholder="Area (sqft)" value="{{ old('area_sqft') }}">
                                @error('area_sqft')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="number" name="parking" class="form-control" placeholder="Parking" value="{{ old('parking') }}">
                                @error('parking')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <input type="number" name="bedrooms" class="form-control" placeholder="Bedrooms" value="{{ old('bedrooms') }}">
                                @error('bedrooms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="number" name="bathrooms" class="form-control" placeholder="Bathrooms" value="{{ old('bathrooms') }}">
                                @error('bathrooms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <select name="deal" class="form-control @error('deal') is-invalid @enderror">
                                    <option value="sale" {{ old('deal') == 'sale' ? 'selected' : '' }}>Sale</option>
                                    <option value="rent" {{ old('deal') == 'rent' ? 'selected' : '' }}>Rent</option>
                                </select>
                                @error('deal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="house" {{ old('type') == 'house' ? 'selected' : '' }}>House</option>
                                    <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="villa" {{ old('type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        

                        <!-- Basic Property Details Fields -->
                        <div class="form-group">
                            <label>Basic Property Details</label>
                            <div class="row">
                                <div class="col">
                                    <label for="city_view">City View:</label>
                                    <input type="text" class="form-control " id="city_view" name="property_details[city_view]" value="{{ $property_details['city_view'] ?? '' }}">
                                    @error('property_details.city_view')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="family_villa">Family Villa:</label>
                                    <input type="text" class="form-control" id="family_villa" name="property_details[family_villa]" value="{{ $property_details['family_villa'] ?? '' }}">
                                    @error('property_details.family_villa')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="air_conditioned">Air Conditioned:</label>
                                    <input type="text" class="form-control " id="air_conditioned" name="property_details[air_conditioned]" value="{{ $property_details['air_conditioned'] ?? '' }}">
                                    @error('property_details.air_conditioned')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="phone">Phone:</label>
                                    <input type="tel" class="form-control" id="phone" name="property_details[phone]" pattern="[0-9]{10}" value="{{ $property_details['phone'] ?? '' }}">
                                    @error('property_details.phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="internet">Internet:</label>
                                    <input type="text" class="form-control" id="internet" name="property_details[internet]" value="{{ $property_details['internet'] ?? '' }}">
                                    @error('property_details.internet')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        

                        <!-- Additional Required Fields -->
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="description" class="form-control" placeholder="Description" value="{{ old('description') }}">
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="tel" name="dealer_contact" class="form-control" placeholder="Dealer Contact" value="{{ old('dealer_contact') }}">
                                @error('dealer_contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Images and Photo Fields -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="photo">Main Photo:</label>
                                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="images">Selected multiple images:</label>
                                <input type="file" class="form-control-file" id="images" name="images[]" multiple accept="image/*">
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Required Fields -->
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="district" class="form-control" placeholder="District" value="{{ old('district') }}">
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
