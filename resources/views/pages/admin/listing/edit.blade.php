@extends('layout.admin')

@section('title')
    Edit Listing - SolveIt Admin
@endsection

@section('extra_css_top')
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h4 class="content-header-title float-left mb-0">Listing</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageListing') }}">Listing</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Listing
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row  pt-15">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    Editing Listing with title : <b>{{$data->title}}</b>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="float-right">
                                                        <a href="{{route('manageListingDelete', $data->id)}}" type="submit" class="btn btn-danger mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light">Delete</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mb-4">

                                            <form enctype="multipart/form-data" action="{{route('manageListingEditPost', $data->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">
                                                        <div class="form-group">
                                                            <label for="title" class="text-dark font-weight-bolder">Title</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('title') is-invalid @enderror"
                                                                   placeholder="Title" name="title"
                                                                   value="{{ old('title') ? old('title') : $data->title }}" id="title" />

                                                            @error('title')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="description" class="text-dark font-weight-bolder">Description</label>
                                                            <textarea type="text"
                                                                      class="form-control text-dark font-weight-bolder @error('description') is-invalid @enderror"
                                                                      placeholder="Description" name="description" rows="7"
                                                                      id="description" > {{ old('description') ? old('description') : $data->description }} </textarea>
                                                            @error('description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="type" class="text-dark font-weight-bolder">Type</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="type" name="type">
                                                                <option value="">Select option</option>
                                                                <option value="service"
                                                                    {{ $data->type == 'service' ? 'selected' : '' }}>
                                                                    Service</option>
                                                                <option value="product"
                                                                    {{ $data->type == 'product' ? 'selected' : '' }}>
                                                                    Product</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="amount" class="text-dark font-weight-bolder">Amount (₦{{ number_format($data->amount, 2) }})</label>
                                                            <input type="number" class="form-control text-dark font-weight-bolder @error('amount') is-invalid @enderror"
                                                                   placeholder="Amount" name="amount"
                                                                   value="{{ old('amount') ? old('amount') : $data->amount }}" id="amount" />
                                                            @error('amount')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="location" class="text-dark font-weight-bolder">Location</label>
                                                            <input type="text" class="form-control text-dark font-weight-bolder @error('location') is-invalid @enderror"
                                                                   placeholder="Location" name="location"
                                                                   value="{{ old('location') ? old('location') : $data->location }}" id="location" />
                                                            @error('location')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="phone" class="text-dark font-weight-bolder">Phone</label>
                                                            <input type="tel" class="form-control text-dark font-weight-bolder @error('phone') is-invalid @enderror"
                                                                   placeholder="Phone" name="phone"
                                                                   value="{{ old('phone') ? old('phone') : $data->phone }}" id="phone" />
                                                            @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="whatsapp" class="text-dark font-weight-bolder">Whatsapp</label>
                                                            <input type="tel" class="form-control text-dark font-weight-bolder @error('whatsapp') is-invalid @enderror"
                                                                   placeholder="Whatsapp" name="whatsapp"
                                                                   value="{{ old('whatsapp') ? old('whatsapp') : $data->whatsapp }}" id="whatsapp" />
                                                            @error('whatsapp')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="is_featured" class="text-dark font-weight-bolder">Is Featured</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="is_featured" name="is_featured">
                                                                <option value=""> Select Option </option>
                                                                <option value="0"
                                                                    {{ $data->is_featured == '0' ? 'selected' : '' }}>
                                                                    Active</option>
                                                                <option value="1"
                                                                    {{ $data->is_featured == '1' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                            </select>
                                                        </div>

                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Featured Image</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/product/".$data->featured_image)}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Featured Image">
                                                                <div class="media-body">
                                                                    <small class="text-muted">Suggested image resolution 100x100, image size 10mb.</small>
                                                                    <div class="d-inline-block mt-1">
                                                                        <div class="form-group mb-0">
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" name="featured_image" id="featured_image" accept="image/*">
                                                                                <label class="custom-file-label" for="featured_image">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group pt-2">
                                                            <label for="tag_id" class="text-dark font-weight-bolder">Select Tag</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="tag_id" name="tag_id">
                                                                <option value=""> Select Option </option>
                                                                @foreach($productTags as $index => $item)
                                                                    <option value="{{$item->id}}" {{($item->id == $selectedProductTag->id)  ? 'selected' :  ''}} >
                                                                        {{$item->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                    </div>

                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update Listing</button>
                                                    </div>
                                                </div>
                                            </form>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script src="{{ asset('/app-assets/js/scripts/forms/form-select2.js') }}"></script>
@endsection
