@extends('layout.admin')

@section('title')
    Edit Category - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Category</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageCategory') }}">Category</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Category
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
                                                    Editing Category with name : <b>{{$data->title}}</b>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="float-right">
                                                        <a href="{{route('manageCategoryDelete', $data->id)}}" type="submit" class="btn btn-danger mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light">Delete</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mb-4">
                                            <form enctype="multipart/form-data" action="{{route('manageCategoryEditPost', $data->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="text-dark font-weight-bolder">
                                                                Category Title</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('title') is-invalid @enderror"
                                                                   placeholder="Category Title" name="title"
                                                                   value="{{ old('title') ?? $data->title }}" id="name" />
                                                            @error('title')
                                                            <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="text-dark font-weight-bolder">
                                                                Category Description</label>
                                                            <textarea type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('description') is-invalid @enderror"
                                                                   placeholder="Category Description" name="description"
                                                                      id="description" > {{ old('description') ?? $data->description }} </textarea>
                                                            @error('description')
                                                            <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                            @enderror
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="status"
                                                                   class="text-dark font-weight-bolder">Featured</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="status" name="is_featured">
                                                                <option value="1"
                                                                    {{ $data->is_featured == '1' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="0"
                                                                    {{ $data->is_featured == '0' ? 'selected' : '' }}>
                                                                    No</option>
                                                            </select>
                                                        </div>


                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Featured Image</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/blog-category/".$data->featured_image)}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image">
                                                                <div class="media-body">
                                                                    <small class="text-muted">Suggested image resolution 800x400, image size 10mb.</small>
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

                                                    </div>



                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update Category</button>
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
