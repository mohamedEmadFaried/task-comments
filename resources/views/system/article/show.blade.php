@extends('layouts.vertical', ['title' => $pageTitle])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        @include('layouts.shared/breadcrumb')
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                               
                                <h4 class="mb-0">{{ $result->title }}</h4>
                                <h6 class="text-muted">{{ $result->content }}</h6>

                            </div>
                           
                        </div>
                    </div>
                </div> <!-- end card -->
            </div>
       
        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection
