@extends('layout.admin')

@section('title')
    Level List - SolveIt Admin
@endsection

@section('extra_css')
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
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Level</a>
                                    </li>
                                    <li class="breadcrumb-item active">All Level
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body pt-3">
                <section id="basic-datatable">
                    <div class="row ">
                        <div class="col-12">

                            <div class="card">

                                <div class="card-header border-bottom p-1">

                                    <div class="demo-inline-spacing">
                                        <a class="btn btn-primary waves-effect waves-float waves-light"
                                           href="{{route('manageLevelsAdd')}}">
                                            Add New
                                        </a>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Bulk Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item delete-all" href="javascript:void(0);"
                                                   data-url="{{route('manageLevelsDeleteMultiple')}}">Delete
                                                </a>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="p-1">


                                    <table class="datatables-basic table reduced-size">
                                        <thead>
                                        <tr>
                                            <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all"
                                                rowspan="1" colspan="1" style="width: 25px;" data-col="1"
                                                aria-label="">
                                                <input type="checkbox" name="" class="checkAll" id="checkAll">
                                            </th>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Date Updated</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (count($data) > 0)
                                            @foreach ($data as $key => $item)
                                                <tr id="tr_{{ $item->id }}">
                                                    <td class="sorting_disabled dt-checkboxes-cell" rowspan="1"
                                                        colspan="1" style="width: 25px;" data-col="1"
                                                        aria-label="">
                                                        <input type="checkbox" name="" class="sub_check"
                                                               data-id="{{ $item->id }}">
                                                    </td>
                                                    <td>{{ ++$key }}</td>
                                                    <td>
                                                        {{ $item->name }}
                                                    </td>
                                                    <td>{{ $item->updated_at->format('M d, Y') }}</td>
                                                    <td>{{ $item->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm dropdown-toggle hide-arrow waves-effect waves-float waves-light"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                     height="14" viewBox="0 0 24 24" fill="none"
                                                                     stroke="currentColor" stroke-width="2"
                                                                     stroke-linecap="round" stroke-linejoin="round"
                                                                     class="feather feather-more-vertical">
                                                                    <circle cx="12" cy="12"
                                                                            r="1"></circle>
                                                                    <circle cx="12" cy="5"
                                                                            r="1"></circle>
                                                                    <circle cx="12" cy="19"
                                                                            r="1"></circle>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu" style="">

                                                                <a class="dropdown-item"
                                                                   href="{{route('manageLevelsEdit', $item->id)}}">
                                                                    <i data-feather="edit"></i><span
                                                                        class="menu-title text-truncate"
                                                                        data-i18n="Email"> Edit</span>
                                                                </a>
                                                                <a class="dropdown-item"
                                                                   onclick="return confirm('Are you sure you want to delete this card?')"
                                                                   href="{{route('manageLevelsDelete', $item->id)}}">
                                                                    <i data-feather="trash"></i><span
                                                                        class="menu-title text-truncate"
                                                                        data-i18n="Email"> Delete</span>
                                                                </a>


                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif



                                        </tbody>
                                        <tfoot>
                                        <tr>

                                            <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all"
                                                rowspan="1" colspan="1" style="width: 25px;" data-col="1"
                                                aria-label="">
                                                <div class="custom-control custom-checkbox d-none"> <input
                                                        class="custom-control-input" type="checkbox" value=""
                                                        id="checkboxSelectAll">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </th>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Date Updated</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    @if($data->hasPages())
                                        <div id="url1-content" class="border-grey border-lighten-2 mb-1 mt-3">Showing page {{$data->currentPage()}} </div>
                                        <div class="pagination ">
                                            {{$data->links()}}
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.datatables-basicx').DataTable();
        });

        //delete all
        $('.delete-all').on('click', function(event) {

            var allVals = [];
            $(".sub_check:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            //check if any is checked
            if (allVals.length <= 0) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please select row(s) to delete.'
                })
            } else {

                //swal validate
                Swal.fire({
                    title: 'Are you sure?',
                    html: 'Type the word <b>delete</b> ' + ' to continue',
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete',
                    inputValidator: (value) => {
                        if (value !== 'delete') {
                            return 'You need to type correctly!'
                        }

                        //grab all values
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: $(this).data('url'),
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'selectItemId=' + join_selected_values,
                            success: function(data) {
                                if (data['success']) {
                                    $(".sub_check:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    //alert(data['success']);
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Item Successfully'
                                    })
                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        text: 'Whoops Something went wrong!!'
                                    })
                                }
                            },
                            error: function(data) {
                                alert(data.responseText);
                            }
                        });
                    }
                })
            }
        });
    </script>

@endsection
