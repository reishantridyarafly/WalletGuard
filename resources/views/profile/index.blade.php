@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ auth()->user()->avatar == '' ? 'https://ui-avatars.com/api/?background=random&name=' . auth()->user()->name : asset('storage/avatar/' . auth()->user()->avatar) }}"
                            class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                        <h4 class="mb-0 mt-2">Hi, {{ auth()->user()->name }}</h4>
                        <p class="text-muted font-14">{{ auth()->user()->type }}</p>

                        <div class="text-start mt-3">
                            <div class="text-start mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Name :</strong> <span
                                        class="ms-2">{{ auth()->user()->name }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ms-2">{{ auth()->user()->email }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span
                                        class="ms-2">{{ auth()->user()->phone_number }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Status :</strong> <span
                                        class="ms-2 ">{!! auth()->user()->active_status == 0
                                            ? '<span class="badge-outline-success rounded-pill p-1">Active</span>'
                                            : '<span class="badge-outline-danger rounded-pill p-1">Inactive</span>' !!}</span></p>
                            </div>

                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0 active">
                                    Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#password" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    Change Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#account" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    Delete Account
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            @include('profile.settings')

                            @include('profile.password')

                            @include('profile.account')
                        </div> <!-- end tab-content -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row-->


    </div>
    <!-- container -->

    </div>
    <!-- content -->
@endsection
