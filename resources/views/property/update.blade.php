@extends('layouts.app')

@section('contents')
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <div class="p-6 text-gray-900">
                    <h3 class="mb-0">Update Property</h3>

                    <hr />

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{-- Display error message --}}
                                        {{ $error }}
                                        {{-- Example: Commenting on the error --}}
                                        {{-- Comment: This error is related to the user's input --}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('properties/update', $property->_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Input fields for property details -->
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Property Name</label>
                                <input type="text" name="property_name" class="form-control" placeholder="Property Name"
                                    value="{{ $property->property_name }}">
                                @error('property_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Price"
                                    value="{{ $property->price }}">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Bedrooms</label>
                                <input type="text" name="bedrooms" class="form-control" placeholder="Bedrooms"
                                    value="{{ $property->bedrooms }}">
                                @error('bedrooms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Bathrooms</label>
                                <input type="text" name="bathrooms" class="form-control" placeholder="Bathrooms"
                                    value="{{ $property->bathrooms }}">
                                @error('bathrooms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Area (sqft)</label>
                                <input type="text" name="area_sqft" class="form-control" placeholder="Area (sqft)"
                                    value="{{ $property->area_sqft }}">
                                @error('area_sqft')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Parking</label>
                                <input type="text" name="parking" class="form-control" placeholder="Parking"
                                    value="{{ $property->parking }}">
                                @error('parking')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Deal</label>
                                <select name="deal" class="form-control">
                                    <option value="sale" {{ $property->deal == 'sale' ? 'selected' : '' }}>Sale</option>
                                    <option value="rent" {{ $property->deal == 'rent' ? 'selected' : '' }}>Rent</option>
                                </select>
                                @error('deal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-control">
                                    <option value="house" {{ $property->type == 'house' ? 'selected' : '' }}>House
                                    </option>
                                    <option value="apartment" {{ $property->type == 'apartment' ? 'selected' : '' }}>
                                        Apartment</option>
                                    <option value="villa" {{ $property->type == 'villa' ? 'selected' : '' }}>Villa
                                    </option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Description">{{ $property->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Dealer Contact</label>
                                <input type="text" name="dealer_contact" class="form-control"
                                    placeholder="Dealer Contact" value="{{ $property->dealer_contact }}">
                                @error('dealer_contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <h4>Property Details</h4>

                            <!-- First set of property details -->
                            <div class="mb-4">
                                <h5>Basic Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="property_name" class="form-label">Property Name:</label>
                                        <input type="text" id="property_name" name="property_name"
                                            class="form-control" value="{{ $property->property_name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Price:</label>
                                        <input type="text" id="price" name="price" class="form-control"
                                            value="{{ $property->price }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bedrooms" class="form-label">Bedrooms:</label>
                                        <input type="text" id="bedrooms" name="bedrooms" class="form-control"
                                            value="{{ $property->bedrooms }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bathrooms" class="form-label">Bathrooms:</label>
                                        <input type="text" id="bathrooms" name="bathrooms" class="form-control"
                                            value="{{ $property->bathrooms }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="area_sqft" class="form-label">Area (sqft):</label>
                                        <input type="text" id="area_sqft" name="area_sqft" class="form-control"
                                            value="{{ $property->area_sqft }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="parking" class="form-label">Parking:</label>
                                        <input type="text" id="parking" name="parking" class="form-control"
                                            value="{{ $property->parking }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="deal" class="form-label">Deal:</label>
                                        <select id="deal" name="deal" class="form-control">
                                            <option value="sale" {{ $property->deal == 'sale' ? 'selected' : '' }}>
                                                Sale</option>
                                            <option value="rent" {{ $property->deal == 'rent' ? 'selected' : '' }}>
                                                Rent</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="type" class="form-label">Type:</label>
                                        <select id="type" name="type" class="form-control">
                                            <option value="house" {{ $property->type == 'house' ? 'selected' : '' }}>
                                                House</option>
                                            <option value="apartment"
                                                {{ $property->type == 'apartment' ? 'selected' : '' }}>Apartment
                                            </option>
                                            <option value="villa" {{ $property->type == 'villa' ? 'selected' : '' }}>
                                                Villa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" name="description" class="form-control" rows="4">{{ $property->description }}</textarea>
                                </div>
                            </div>

                            <!-- Second set of property details -->
                            <div class="mb-4">
                                <h5>Additional Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="city_view" class="form-label">City View:</label>
                                        <input type="text" id="city_view" name="city_view" class="form-control"
                                            value="{{ $property->property_details['city_view'] ?? 'N/A' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="family_villa" class="form-label">Family Villa:</label>
                                        <input type="text" id="family_villa" name="family_villa" class="form-control"
                                            value="{{ $property->property_details['family_villa'] ?? 'N/A' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="air_conditioned" class="form-label">Air Conditioned:</label>
                                        <input type="text" id="air_conditioned" name="air_conditioned"
                                            class="form-control"
                                            value="{{ $property->property_details['air_conditioned'] ?? 'N/A' }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ $property->property_details['phone'] ?? 'N/A' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="internet" class="form-label">Internet:</label>
                                        <input type="text" id="internet" name="internet" class="form-control"
                                            value="{{ $property->property_details['internet'] ?? 'N/A' }}">
                                    </div>
                                </div>
                            </div>

                            <pre>
                                {{-- {{var_dump($property)}} --}}
                                {{-- {{dd($property)}} --}}
                                {{-- {{ print_r($property)}} --}}
                             </pre>


                            <div class="row mb-3">
                                <!-- Existing Images -->
                                <div class="col-md-6">
                                    <h5>Existing Images</h5>
                                    @if (is_array($property) || is_object($property))
                                        <ul class="list-unstyled d-flex flex-wrap">
                                            @foreach ($property->toArray()['images'] ?? [] as $i => $imagePath)
                                                @if ($imagePath)
                                                    <li class="image-item"
                                                        style="width: 200px; margin-right: 20px; margin-bottom: 20px;">
                                                        <img src="{{ asset($imagePath) }}" alt="Property Image"
                                                            class="img-thumbnail mb-2" style="width: 100%;">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="deleteImage({{ $i }})">
                                                            Delete
                                                        </button>
                                                        <input type="hidden" name="existing_images[]"
                                                            value="{{ $imagePath }}">
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @if (empty($property->toArray()['images']))
                                            <p>No images available. Please upload some images.</p>
                                        @else
                                            <p>Please select more images.</p>
                                        @endif

                                        @error('images.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                                <!-- Main Photo -->
                                <div class="col-md-6">
                                    <h3>Main Photo</h3>
                                    <input type="file" name="photo" id="photo" class="inputfile"
                                        accept="image/*">
                                    <label for="photo" class="file-upload-btn">Choose Photo</label>
                                    @error('photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @if ($property->photo)
                                        <img src="{{ asset($property->photo) }}" alt="Property Photo"
                                            class="img-thumbnail mt-3" style="width: 200px;">
                                    @else
                                        <p>No main photo available</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Upload Images -->
                            <div class="mb-4">
                                @if (empty($property->toArray()['images']))
                                    <h5>Upload Images</h5>
                                @else
                                    <h5>Add More Images</h5>
                                @endif
                                <input type="file" name="images[]" id="images" multiple class="inputfile"
                                    accept="image/*">
                                <label for="images" class="file-upload-btn">Choose Photo</label>
                                @error('images.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <script>
                                function deleteImage(index) {
                                    console.log(index)
                                    let imagesContainer = document.querySelector('.list-unstyled');
                                    let imageItem = imagesContainer.children[index];
                                    imageItem.remove();

                                    let hiddenInput = document.querySelectorAll("input[name='existing_images[]']")[index];
                                    hiddenInput.parentNode.removeChild(hiddenInput);

                                    let deleteInput = document.createElement('input');
                                    deleteInput.type = 'hidden';
                                    deleteInput.name = 'delete_images[]';
                                    deleteInput.value = hiddenInput.value;
                                    document.querySelector('form').appendChild(deleteInput);
                                }
                            </script>








                        </div>



                        <div class="row justify-content-between">
                            <div class="col">
                                <div class="d-grid">
                                    <button class="btn btn-warning btn-block">Update</button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-grid">
                                    <a href="{{ route('properties') }}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
