@extends('layout.admin')

@section('title')
    SolveIt NG Administrative Dashboard
@endsection

@section('extra_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/charts/apexcharts.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/charts/chart-apex.css') }}">
    <style>
        .mb-1.text-white {
            font-size: 16px;
        }

        .card-text {
            font-size: 12px;
        }

        .apexcharts-canvas {
            overflow: hidden;
            border-radius: 5px;
        }

        .most_recent_transaction_heading {
            border-bottom: 1px dashed #374466;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .card-datatable.table-responsive td {
            font-size: 11px;
        }

    </style>
@endsection

@section('content')

   <div class="app-content content ">
       <div class="content-overlay"></div>
       <div class="header-navbar-shadow"></div>
       <div class="content-wrapper container-xxl p-0">
           <div class="content-header row">
           </div>
           <div class="content-body">
               <!-- Dashboard Analytics Start -->
               <section id="dashboard-analytics">
                   <div class="row match-height">
                       <!-- Greetings Card starts -->
                       <div class="col-lg-6 col-md-12 col-sm-12">
                           <div class="card card-congratulations">
                               <div class="card-body text-center">
                                   <img src="{{ asset('/app-assets/images/elements/decore-left.png') }}"
                                       class="congratulations-img-left" alt="card-img-left" />
                                    <img src="{{ asset('/app-assets/images/elements/decore-right.png') }}"
                                        class="congratulations-img-right" alt="card-img-right" />
                                    <div class="avatar avatar-xl bg-primary shadow">
                                        <div class="avatar-content">
                                            <i data-feather="award" class="font-large-1.0"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h1 class="mb-1 text-white">Hello {{ auth()->user()->name }},</h1>
                                        <p class="card-text m-auto w-75">
                                            We have <strong>{{ $usersToday }}</strong> new user today.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Greetings Card ends -->

                        <!-- Subscribers Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="bar-chart-2" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $usersActive }}</h2>
                                    <p class="card-text">All Active Users </p>
                                </div>
                                <div id="gained-chart"></div>
                            </div>
                        </div>
                        <!-- Subscribers Chart Card ends -->

                        <!-- Orders Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="bar-chart" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $usersRestricted }}</h2>
                                    <p class="card-text">All Restricted Users </p>
                                </div>
                                <div id="order-chart"></div>
                            </div>
                        </div>
                        <!-- Orders Chart Card ends -->
                    </div>

                    <div class="row match-height">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="user-check" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $regularUsers }}</h2>
                                    <p class="card-text">All Regular Users</p>
                                </div>
                                <div id="gained-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="user-check" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $studentUsers }}</h2>
                                    <p class="card-text">All Student Users</p>
                                </div>
                                <div id="gained-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $staffUsers }}</h2>
                                    <p class="card-text">Staff Users</p>
                                </div>
                                <div class="div-min-height" id="gained-chart-1"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="user-minus" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $adminUsers }}</h2>
                                    <p class="card-text">Administrative Users</p>
                                </div>
                                <div class="div-min-height" id="gained-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="layers" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $departments }}</h2>
                                    <p class="card-text">All Departments</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="home" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $schools }}</h2>
                                    <p class="card-text">All Schools</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="grid" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $interests }}</h2>
                                    <p class="card-text">All Interests</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="file-text" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allBlogs }}</h2>
                                    <p class="card-text">All Blogs</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="check-circle" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $activeBlogs }}</h2>
                                    <p class="card-text">Active Blogs</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="loader" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $pendingBlogs }}</h2>
                                    <p class="card-text">Pending Blogs</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="crop" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allBlogCategories }}</h2>
                                    <p class="card-text">Total Blog-Categories</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="check-circle" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $activeBlogCategories }}</h2>
                                    <p class="card-text">Active Blog-Categories</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="loader" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $pendingBlogCategories }}</h2>
                                    <p class="card-text">Pending Blog-Categories</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="message-square" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allBlogComments }}</h2>
                                    <p class="card-text">All Blog-Comments</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="thumbs-up" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allBlogLikes }}</h2>
                                    <p class="card-text">All Blog-Comment-Likes</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="trello" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allForums }}</h2>
                                    <p class="card-text">Total Forums</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="check-circle" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $activeForums }}</h2>
                                    <p class="card-text">Active Forums</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="loader" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $pendingForums }}</h2>
                                    <p class="card-text">Pending Forums</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="message-square" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allForumComments }}</h2>
                                    <p class="card-text">Total Forum-Comments</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="package" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allProducts }}</h2>
                                    <p class="card-text">Total Products</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="check-circle" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $activeProducts }}</h2>
                                    <p class="card-text">Active Products</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="loader" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $pendingProducts }}</h2>
                                    <p class="card-text">Pending Products</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="server" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allServices }}</h2>
                                    <p class="card-text">Total Services</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="check-circle" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $activeServices }}</h2>
                                    <p class="card-text">Active Services</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="loader" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $pendingServices }}</h2>
                                    <p class="card-text">Pending Services</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="tag" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allTags }}</h2>
                                    <p class="card-text">All Tags</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="message-square" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allProductComments }}</h2>
                                    <p class="card-text">All Product-Comments</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="thumbs-up" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="font-weight-bolder mt-1">{{ $allProductCommentLikes }}</h2>
                                    <p class="card-text">All Product-Comment-Likes</p>
                                </div>
                                <div class="div-min-height" id="order-chart"></div>
                            </div>
                        </div>
                    </div>


                </section>

                <div class="row">
                    <div class="col-12">
                        <div class="most_recent_transaction_heading">
                            Most recent withdrawal request
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-datatable table-responsive">

                            datatable here
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')
    <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(window).on('load', function() {
            'use strict';

            var $avgSessionStrokeColor2 = '#ebf0f7';
            var $textHeadingColor = '#5e5873';
            var $white = '#fff';
            var $strokeColor = '#ebe9f1';

            var $gainedChart = document.querySelector('#gained-chart');
            var $orderChart = document.querySelector('#order-chart');

            var gainedChartOptions;
            var orderChartOptions;

            var gainedChart;
            var orderChart;

            // Subscribed Gained Chart
            // ----------------------------------

            gainedChartOptions = {
                chart: {
                    height: 100,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    sparkline: {
                        enabled: true
                    },
                    grid: {
                        show: false,
                        padding: {
                            left: 0,
                            right: 0
                        }
                    }
                },
                colors: [window.colors.solid.primary],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2.5
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 0.9,
                        opacityFrom: 0.7,
                        opacityTo: 0.5,
                        stops: [0, 80, 100]
                    }
                },
                series: [{
                    name: 'Subscribers',
                    data: [28, 40, 36, 52, 38, 60, 55]
                }],
                xaxis: {
                    labels: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: [{
                    y: 0,
                    offsetX: 0,
                    offsetY: 0,
                    padding: {
                        left: 0,
                        right: 0
                    }
                }],
                tooltip: {
                    x: {
                        show: false
                    }
                }
            };
            gainedChart = new ApexCharts($gainedChart, gainedChartOptions);
            gainedChart.render();

            // Order Received Chart
            // ----------------------------------

            orderChartOptions = {
                chart: {
                    height: 100,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    sparkline: {
                        enabled: true
                    },
                    grid: {
                        show: false,
                        padding: {
                            left: 0,
                            right: 0
                        }
                    }
                },
                colors: [window.colors.solid.warning],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2.5
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 0.9,
                        opacityFrom: 0.7,
                        opacityTo: 0.5,
                        stops: [0, 80, 100]
                    }
                },
                series: [{
                    name: 'Orders',
                    data: [10, 15, 8, 15, 7, 12, 8]
                }],
                xaxis: {
                    labels: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: [{
                    y: 0,
                    offsetX: 0,
                    offsetY: 0,
                    padding: {
                        left: 0,
                        right: 0
                    }
                }],
                tooltip: {
                    x: {
                        show: false
                    }
                }
            };
            orderChart = new ApexCharts($orderChart, orderChartOptions);
            orderChart.render();

        });
    </script>


    <script>
        $(document).ready(function() {
            $('.datatables-basicx').DataTable();
        });
    </script>
@endsection
