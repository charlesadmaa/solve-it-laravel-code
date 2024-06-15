@extends('layout.admin')

@section('title')
    Edit Blog - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Blog</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageBlog') }}">Blog</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Blog
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
                                                    Editing Blog with name : <b>{{$data->title}}</b>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="float-right">
                                                        <a href="{{route('manageBlogDelete', $data->id)}}" type="submit" class="btn btn-danger mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light">Delete</a>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mb-4">
                                            <form enctype="multipart/form-data" action="{{route('manageBlogEditPost', $data->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="text-dark font-weight-bolder">
                                                                Blog Title</label>
                                                            <input type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('title') is-invalid @enderror"
                                                                   placeholder="Blog Title" name="title"
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
                                                                Content</label>
                                                            <textarea id="content" type="text"
                                                                   class="form-control text-dark font-weight-bolder @error('body') is-invalid @enderror"
                                                                   placeholder="Content" name="body"
                                                                      id="description" > {{ old('body') ?? $data->body }} </textarea>
                                                            @error('body')
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
                                                                <option value="0"
                                                                    {{ $data->is_featured == '0' ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ $data->is_featured == '1' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="status"
                                                                   class="text-dark font-weight-bolder">Post Author</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="status" name="author">
                                                                @foreach($users as $index => $item)
                                                                    <option value="{{$item->id}}" {{($item->id ==$data->created_by_id)  ? 'selected' :  ''}} >
                                                                        {{$item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="status"
                                                                   class="text-dark font-weight-bolder">Category</label>
                                                            <select
                                                                class="select2 form-control text-dark font-weight-bolder"
                                                                id="status" multiple name="categories[]">
                                                                @foreach($categories as $index => $item)
                                                                    <option value="{{$item->id}}" {{in_array($item->id, $selectedCategories) ? 'selected' :  ''}} >
                                                                        {{$item->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Featured Image</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/blog/".$data->featured_image)}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Blog Featured Image">
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
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Update Blog</button>
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
