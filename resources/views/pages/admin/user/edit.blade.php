@extends('layout.admin')

@section('title')
    Edit User - SolveIt Admin
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
                                    <li class="breadcrumb-item active">Edit User
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
                                                    Editing User with name : <b>{{$data->name}}</b>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="float-right">
                                                        <a href="{{route('manageCategoryDelete', $data->id)}}" type="submit" class="btn btn-danger mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light">Delete</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mb-4">

                                            <form enctype="multipart/form-data" action="{{route('manageUserEditPost', $data->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="name" class="text-dark font-weight-bolder">Fullname</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('name') is-invalid @enderror"
                                                                   placeholder="Fullname" name="name"
                                                                   value="{{ old('name') ? old('name') : $data->name }}" id="name" />
                                                            @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="email" class="text-dark font-weight-bolder">Email</label>
                                                            <input type="email" class="form-control text-dark font-weight-bolder @error('email') is-invalid @enderror"
                                                                   placeholder="Email" name="email"
                                                                   value="{{ old('email') ? old('email') : $data->email }}" id="email" />
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
                                                                   value="{{ old('phone') ? old('phone') : $data->phone }}" id="phone" />
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
                                                                    {{ $data->status == '0' ? 'selected' : '' }}>
                                                                    Pending</option>
                                                                <option value="1"
                                                                    {{ $data->status == '1' ? 'selected' : '' }}>
                                                                    Active</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="dob" class="text-dark font-weight-bolder">Date of birth</label>
                                                            <input type="date" name="dob" class="form-control text-dark font-weight-bolder @error('dob') is-invalid @enderror"
                                                                   placeholder="12-12-12" name="dob"
                                                                   value="{{ old('dob') ? old('dob') : $data->dob }}" id="dob" />
                                                            @error('dob')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="gender" class="text-dark font-weight-bolder">Gender</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="gender" name="gender">
                                                                <option value="male" {{ $data->gender == 'male' ? 'selected' : '' }}>
                                                                    Male
                                                                </option>
                                                                <option value="female" {{ $data->gender == 'female' ? 'selected' : '' }}>
                                                                    Female
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="role" class="text-dark font-weight-bolder">Role</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="role" name="role">
                                                                <option value="">Select option</option>
                                                                @foreach($roles as $index => $item)
                                                                    <option value="{{$index}}" {{($index == $data->role_id)  ? 'selected' :  ''}} >
                                                                        {{$item}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('role')
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Profile Image</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/images/users/".$data->avatar)}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Profile Image">
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
                                                        <h4 class="text-left">Datasets</h4>
                                                        <hr class="mb-4">

                                                        <div class="form-group">
                                                            <label for="school" class="text-dark font-weight-bolder">Select School</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="school" name="school">
                                                                <option value="">Select option</option>
                                                                @foreach($schools as $item)
                                                                    <option value="{{$item->id}}" {{ (isset($userSchool->id) && ($item->id === $userSchool->id))  ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="department" class="text-dark font-weight-bolder">Select Department</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="department" name="department">
                                                                <option value="">Select option</option>
                                                                @foreach($departments as $index => $item)
                                                                    <option value="{{$item->id}}" {{ (isset($userDepartment->id) && ($item->id === $userDepartment->id))  ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="level" class="text-dark font-weight-bolder">Select Level</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="level" name="level">
                                                                <option value="">Select Option</option>
                                                                @foreach($levels as $index => $item)
                                                                    <option value="{{$item->id}}" {{(isset($userLevel->id) && ($item->id === $userLevel->id)) ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="Interest" class="text-dark font-weight-bolder">Select Interest</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="interests" name="interests[]" multiple>
                                                                <option value="">Select Option</option>
                                                                @foreach($interests as $index => $item)
                                                                    <option value="{{$item->id}}" {{isset($userInterestIds) && (in_array($item->id, $userInterestIds)) ? 'selected' :  ''}} >
                                                                        {{$item->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save User</button>
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
    <script src="{{ asset('app-assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>

        var editor_config = {
            path_absolute: "/",
            relative_urls : false,
            content_css : "",
            convert_urls : false,
            selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'undo redo | advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools',
            toolbar: 'insertfile | bold italic | alignleft aligncenter alignright | indent outdent | image | bullist numlist | table | code | link | emoticons | insertfile',
            height: '700px',
            image_advtab: true,
            file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                console.log( meta.fieldname)
                var cmsURL = editor_config.path_absolute + 'admin/laravel-filemanager?editor=' + meta.fieldname;

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        }
        tinymce.init(editor_config);

    </script>




@endsection
