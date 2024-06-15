@extends('layout.admin')

@section('title')
    Edit Listing Tag - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Listing tag</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageListingTag') }}">Listing Tag</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Listing Tag
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
                                                    Editing Listing Tag with name : <b>{{$data->name}}</b>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="float-right">
                                                        <a href="{{route('manageListingTagDelete', $data->id)}}" type="submit" class="btn btn-danger mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light">Delete</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mb-4">
                                            <form action="" method="POST">
                                                @csrf

                                                <!--form start was here-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                   class="text-dark font-weight-bolder">
                                                                Listing Tag Name {{$data->title}}</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('title') is-invalid @enderror"
                                                                   placeholder="Listing Tag Name" name="title"
                                                                   value="{{ old('title') ?? $data->title }}" id="title" />
                                                            @error('title')
                                                            <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                            @enderror
                                                        </div>
                                                    </div>



                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update Listing tag</button>
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
@endsection
