@extends('layout.admin')

@section('title')
    Manage General Settings - SolveIt Admin
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
                            <h4 class="content-header-title float-left mb-0">Application Settings</h4>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="http://localhost:8000/manage">Application
                                            settings</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">settings</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="page-account-settings">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="row  pt-15">
                                            <div class="col-md-8 offset-md-2">
                                                <!-- form -->
                                                <form method="POST" action="{{ route('manageSettingsPost') }}"
                                                      class="validate-form mt-2">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="sms_api_key">SMS API
                                                                    Key</label>
                                                                <input type="text"
                                                                       class="form-control @error('sms_api_key') is-invalid @enderror"
                                                                       id="sms_api_key" name="sms_api_key"
                                                                       value="{{ $data->sms_api_key }}" />

                                                                @error('sms_api_key')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="sms_from_name">SMS from name</label>
                                                                <input type="text"
                                                                       class="form-control @error('sms_from_name') is-invalid @enderror"
                                                                       id="sms_from_name" name="sms_from_name"
                                                                       value="{{ $data->sms_from_name }}" />

                                                                @error('sms_from_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                        <hr class="mb-2 mt-2">

                                                            <div class="form-group">
                                                                <label for="from_email">Email from address (Email address)</label>
                                                                <input type="text"
                                                                       class="form-control @error('from_email') is-invalid @enderror"
                                                                       id="from_email" name="from_email"
                                                                       value="{{ $data->from_email }}" />

                                                                @error('from_email')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="from_name">Email from name (Name)</label>
                                                                <input type="text"
                                                                       class="form-control @error('from_name') is-invalid @enderror"
                                                                       id="from_name" name="from_name"
                                                                       value="{{ $data->from_name }}" />
                                                                @error('from_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_host">SMTP Host</label>
                                                                <input type="text"
                                                                       class="form-control @error('smtp_host') is-invalid @enderror"
                                                                       id="smtp_host" name="smtp_host"
                                                                       value="{{ $data->smtp_host }}" />
                                                                @error('smtp_host')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_port">SMTP Port</label>
                                                                <input type="text"
                                                                       class="form-control @error('smtp_port') is-invalid @enderror"
                                                                       id="smtp_port" name="smtp_port"
                                                                       value="{{ $data->smtp_port }}" />
                                                                @error('smtp_port')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_username">SMTP username</label>
                                                                <input type="text"
                                                                       class="form-control @error('smtp_username') is-invalid @enderror"
                                                                       id="smtp_username" name="smtp_username"
                                                                       value="{{ $data->smtp_username }}" />
                                                                @error('smtp_username')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_password">SMTP password</label>
                                                                <input type="text"
                                                                       class="form-control @error('smtp_password') is-invalid @enderror"
                                                                       id="smtp_password" name="smtp_password"
                                                                       value="{{ $data->smtp_password }}" />
                                                                @error('smtp_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_encryption">SMTP encryption</label>
                                                                <select class="select2 form-control text-dark font-weight-bolder" id="smtp_encryption" name="smtp_encryption">
                                                                    <option value="tls" {{$data->smtp_encryption == 'tls' ? 'selected': ''}}>tls</option>
                                                                    <option value="ssl" {{$data->smtp_encryption == 'ssl' ? 'selected': ''}}>ssl</option>
                                                                    <option value="null" {{$data->smtp_encryption == 'null' ? 'selected': ''}}>null</option>
                                                                </select>
                                                                @error('smtp_encryption')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror

                                                            </div>

                                                        </div>

                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mt-2 mr-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                    class="btn btn-outline-secondary mt-2">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </div>
    </div>
@endsection

