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
                            <div class="col-lg-3 col-xl-3">
                                <img src="{{ isset($result) ? App\Helpers\Helper::path() . '/' . $result->image : asset('assets/images/avatar.jpg') }}"
                                    class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                <h4 class="mb-0">{{ $result->username }}</h4>
                                <h6 class="text-muted">{{ $result->email }}</h6>
                                <h6 class="text-muted">{{ $result->phone }}</h6>

                            </div>
                            <div class="col-lg-7 col-xl-7">
                                <div class="text-start mt-3" style="text-align: right !important;">
                               

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-muted mb-2 font-13">

                                                <strong style="color:#3e4449c9">{{ __('Last Login') }} :</strong>
                                                <span class="ms-2"> {{ $result->last_login }}</span>
                                            </p>
                                        </div>
                                    </div>
                                 
                                 

                                </div>

                            </div>
                            <div class="col-lg-1 col-xl-1">
                                <h3 class="ms-2">
                                    
                                    @if ($result->status == 1)
                                        <span class="badge badge-soft-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge badge-soft-danger">{{ __('In-Active') }}</span>
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div>
        

        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection
