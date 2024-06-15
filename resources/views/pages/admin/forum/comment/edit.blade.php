@extends('layout.admin')

@section('title')
    Edit Forum-Comment - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Forum Comment</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageForumComment') }}">Forum Comment</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Forum-Comment
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
                                            <form enctype="multipart/form-data" action="{{route('manageForumCommentEditPost', $data->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">

                                                        <div class="form-group">
                                                            <label for="forum_id" class="text-dark font-weight-bolder">Select Forum</label>
                                                            <select class="select2 form-control text-dark font-weight-bolder" id="forum_id" name="forum_id">
                                                                @foreach($forums as $index => $item)
                                                                    <option value="{{$item->id}}" {{($item->id == $selectedForum->id)  ? 'selected' :  ''}} >
                                                                        {{$item->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="message" class="text-dark font-weight-bolder">Message*</label>
                                                            <textarea type="text"
                                                                      class="form-control text-dark font-weight-bolder @error('message') is-invalid @enderror"
                                                                      placeholder="Message" name="message"
                                                                      id="message" > {{ old('message') ? old('message') : $data->message }} </textarea>
                                                            @error('message')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="border rounded p-2">
                                                            <h5 class="mb-1">Upload File (optional)</h5>
                                                            <div class="media flex-column flex-md-row">
                                                                <img src="{{ asset("storage/forum/comment/".$data->file)}}" id="blog-feature-image" class="rounded mr-2 mb-1 mb-md-0" width="170" height="110" alt="Uploaded File">
                                                                <div class="media-body">
                                                                    <small class="text-muted">Suggested image resolution 100x100, image size 10mb.</small>
                                                                    <div class="d-inline-block mt-1">
                                                                        <div class="form-group mb-0">
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input" name="uploaded_file" id="uploaded_file" accept="image/*">
                                                                                <label class="custom-file-label" for="uploaded_file">Choose file</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-12 mt-2 mb-3 text-right">
                                                        <button type="submit"
                                                                class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Listing</button>
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
