@extends('layouts.vertical', ['title' => $pageTitle])

@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/summernote/summernote.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .iframe-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            /* Ratio 16:9 ( 100%/16*9 = 56.25% ) */
        }

        .iframe-container>* {
            display: block;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        @include('layouts.shared/breadcrumb')

        {!! Form::open([
            'route' => isset($result) ? ['admin.user.update', $result->id] : 'admin.user.store',
            'files' => true,
            'method' => isset($result) ? 'PATCH' : 'POST',
            'class' => 'forms-sample',
            'id' => 'main-form',
            'onsubmit' => 'submitMainForm();return false;',
        ]) !!}
        <div id="form-alert-message"></div>
        <div class="row">


            {{-- <div class="row"> --}}
            <div class="col-lg-6">
                <div class="card-box">




                    <div class="form-group mb-3">
                        <label>{{ __('User Name') }}</label><br>
                        {!! Form::text('username', isset($result) ? $result->username : null, [
                            'class' => 'form-control',
                            'id' => 'username-form-input',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="invalid-feedback" id="username-form-error"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('email') }}</label><br>
                        {!! Form::text('email', isset($result) ? $result->email : null, [
                            'class' => 'form-control',
                            'id' => 'email-form-input',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="invalid-feedback" id="email-form-error"></div>
                    </div>
                    @if (!isset($result))
                        <div class="form-group mb-3">
                            <label>{{ __('password') }}</label><br>
                            {!! Form::text('password', isset($result) ? $result->password : null, [
                                'class' => 'form-control',
                                'id' => 'password-form-input',
                                'autocomplete' => 'off',
                            ]) !!}
                            <div class="invalid-feedback" id="password-form-error"></div>
                        </div>
                    @endif
                    <div class="form-group mb-3">
                        <label>{{ __('Phone') }}</label><br>
                        {!! Form::text('phone', isset($result) ? $result->phone : null, [
                            'class' => 'form-control',
                            'id' => 'phone-form-input',
                            'name' => 'phone',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="invalid-feedback" id="phone-form-error"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('Block') }}</label>
                        @php
                            $bock = null;
                            if (isset($result)) {
                                if ($result->in_block == null) {
                                    $bock = 1;
                                } else {
                                    $bock = 0;
                                }
                            }
                        @endphp
                        {!! Form::select('in_block', [null => __('Select Status'), '1' => __('Active'), '0' => __('In-Active')], $bock, [
                            'class' => 'form-control',
                            'id' => 'in_block-form-input',
                        ]) !!}
                        <div class="invalid-feedback" id="in_block-form-error"></div>

                    </div>

                </div> <!-- end card-box -->
            </div> <!-- end col -->
            <div class="col-lg-6">
                <div class="card-box">
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">{{ __('Images') }}</h5>

                    <div class="form-group mb-3">
                        <input type="file" name="image" placeholder="{{ __('Choose image') }}" id="image">
                        <div class="invalid-feedback" id="image-form-error"></div>

                    </div>
                    <div class="form-group mb-3">
                        <img id="preview-image" class="img-fluid"
                            src="{{ isset($result) ? App\Helpers\Helper::path() . '/' . $result->image : asset('assets/images/avatar.jpg') }}"
                            alt="preview image">
                    </div>

                </div>
            </div>



        </div><br><br>
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-3">

                    <button type="submit"
                        class="btn w-sm btn-success waves-effect waves-light">{{ isset($result) ? __('Edit') : __('Submit') }}</button>
                </div>
            </div> <!-- end col -->
        </div>
        {{-- </div> --}}
        {!! Form::close() !!}

        <!-- end row -->


        <!-- end row -->





    </div> <!-- container -->
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>

    <!-- Page js-->
    <script src="{{ asset('assets/js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/add-product.init.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>

    <script type="text/javascript">
        $('#image').change(function() {

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });

        function submitMainForm() {
            var route = $('#main-form').attr('action');
            formSubmit(
                route,
                new FormData($('#main-form')[0]),
                function($data) {
                    if ($data.status) {
                        if (typeof $data.data.url !== 'undefined') {
                            $('#main-form')[0].reset();
                            $("html, body").animate({
                                scrollTop: 0
                            }, "fast");
                            pageAlert('#form-alert-message', 'success', $data.message);
                            setTimeout(function() {
                                window.location = $data.data.url;
                            }, 2500);
                        } else {
                            $('#main-form')[0].reset();
                            $("html, body").animate({
                                scrollTop: 0
                            }, "fast");
                            pageAlert('#form-alert-message', 'success', $data.message);
                        }
                    } else {
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        pageAlert('#form-alert-message', 'error', $data.message);
                    }
                },
                function($data) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    pageAlert('#form-alert-message', 'error', $data.message);
                }
            );
        }
        $(document).ready(function() {
            @if (isset($result))
                $("#username-form-input").attr('disabled', true);
                $("#email-form-input").attr('disabled', true);
                $("#phone-form-input").attr('disabled', true);
            @endif
        });
    </script>
@endsection
