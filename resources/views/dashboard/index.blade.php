@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Projects</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Projects</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-6 col-xl-6">
                                <div class="card shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="uil-arrow-to-bottom text-muted" style="font-size: 24px;"></i>
                                        <h3><span>29</span></h3>
                                        <p class="text-muted font-15 mb-0">Incomes</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-6">
                                <div class="card shadow-none m-0 border-start">
                                    <div class="card-body text-center">
                                        <i class="uil-top-arrow-to-top text-muted" style="font-size: 24px;"></i>
                                        <h3><span>93%</span>
                                        </h3>
                                        <p class="text-muted font-15 mb-0">Spendings</p>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
    </div>
@endsection
