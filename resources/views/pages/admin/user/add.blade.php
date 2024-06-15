@extends('layout.admin')

@section('title')
    Add New User - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">User</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageUser') }}">User</a>
                                    </li>
                                    <li class="breadcrumb-item active">Add New User
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
                                            <hr class="mb-4">
                                            <form enctype="multipart/form-data" action="{{route('manageUserAddPost')}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">
                                                        <div class="form-group">
                                                            <label for="fullname" class="text-dark font-weight-bolder">Fullname</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('fullname') is-invalid @enderror"
                                                                   placeholder="Fullname" name="fullname"
                                                                   value="{{ old('fullname') }}" id="fullname" />
                                                            @error('fullname')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="email" class="text-dark font-weight-bolder">Email</label>
                                                            <input type="email" class="form-control text-dark font-weight-bolder @error('email') is-invalid @enderror"
                                                                   placeholder="Email" name="email"
                                                                   value="{{ old('email') }}" id="email" />
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="phone" class="text-dark font-weight-bolder">Phone</label>
                                                            <input type="tel" class="form-control text-dark font-weight-bolder @error('phone') is-invalid @enderror"
                                                                   placeholder="Phone" name="phone"
                                                                   value="{{ old('phone') }}" id="phone" />
                                                            @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="status" class="text-dark font-weight-bolder">Status</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="status" name="status">
                                                                <option value="0"
                                                                    {{ old('status') == '0' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                                <option value="1"
                                                                    {{ old('status') == '1' ? 'selected' : '' }}>
                                                                    Active</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="dob" class="text-dark font-weight-bolder">Date of birth</label>
                                                            <input type="date" name="dob" class="form-control text-dark font-weight-bolder @error('dob') is-invalid @enderror"
                                                                   placeholder="12-12-12" name="dob"
                                                                   value="{{ old('dob') }}" id="dob" />
                                                            @error('dob')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="gender" class="text-dark font-weight-bolder">Gender</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="gender" name="gender">
                                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                                    Male
                                                                </option>
                                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                                    Female
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="role" class="text-dark font-weight-bolder">Role</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="role" name="role">
                                                                @foreach($roles as $index => $item)
                                                                    <option value="{{$index}}" {{old('role') ? 'selected' :  ''}} >
                                                                        {{$item}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Profile Image</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/user/default-image.png")}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Profile Image">
                                                                <div class="media-body">
                                                                    <small class="text-muted">Suggested image resolution 100x100, image size 10mb.</small>
                                                                    <div class="d-inline-block mt-1">
                                                                        <div class="form-group mb-0">
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" name="avatar" id="avatar" accept="image/*">
                                                                                <label class="custom-file-label" for="avatar">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12">
                                                        <hr class="mb-4">
                                                        <h4 class="text-center">Datasets</h4>
                                                        <div class="form-group">
                                                            <label for="school" class="text-dark font-weight-bolder">Select School</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="school" name="school">
                                                                @foreach($schools as $index => $item)
                                                                    <option value="{{$item->id}}" {{old('school') ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="department" class="text-dark font-weight-bolder">Select Department</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="department" name="department">
                                                                @foreach($departments as $index => $item)
                                                                    <option value="{{$item->id}}" {{old('department') ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="level" class="text-dark font-weight-bolder">Select Level</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="level" name="level">
                                                                @foreach($levels as $index => $item)
                                                                    <option value="{{$item->id}}" {{old('level') ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="Interest" class="text-dark font-weight-bolder">Select Interest</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="interests" name="interests[]" multiple>

                                                                @foreach($interests as $index => $item)
                                                                    <option value="{{$item->id}}" {{in_array($item->id, (old('interests') ?? [])) ? 'selected' :  ''}} >
                                                                        {{$item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Create User</button>
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
