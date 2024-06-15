@extends('layout.admin')

@section('title')
    Add new Level - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Level</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageLevels') }}">Level</a>
                                    </li>

                                    <li class="breadcrumb-item active">Add New Level
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
                                    <div class="tab-content">
                                        <!-- Account Tab starts -->
                                        <div class="tab-pane active" id="account" aria-labelledby="account-tab"
                                             role="tabpanel">

                                            <div class="row  pt-15">
                                                <div class="col-md-6 offset-md-3">
                                                    <form action="" method="POST">
                                                        @csrf

                                                        <!--form start was here-->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="name"
                                                                           class="text-dark font-weight-bolder">
                                                                        Level Name</label>
                                                                    <input type="text"
                                                                           class="form-control text-dark font-weight-bolder @error('name') is-invalid @enderror"
                                                                           placeholder="Level Name" name="name"
                                                                           value="{{ old('name') }}" id="name" />
                                                                    @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-12 mt-2 mb-3 text-right">
                                                                <button type="submit"
                                                                        class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Add New Level</button>
                                                            </div>
                                                        </div>
                                                    </form>



                                                </div>
                                            </div>

                                        </div>
                                        <!-- Account Tab ends -->

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
