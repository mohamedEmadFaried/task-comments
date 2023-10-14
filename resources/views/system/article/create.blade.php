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
            'route' => isset($result) ? ['admin.article.update', $result->id] : 'admin.article.store',
            'files' => true,
            'method' => isset($result) ? 'PATCH' : 'POST',
            'class' => 'forms-sample',
            'id' => 'main-form',
            'onsubmit' => 'submitMainForm();return false;',
        ]) !!}
        <div id="form-alert-message"></div>
        <div class="row">


            {{-- <div class="row"> --}}
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="form-group mb-3">
                        <label>{{ __('Title') }}</label><br>
                        {!! Form::text('title', isset($result) ? $result->title : null, [
                            'class' => 'form-control',
                            'id' => 'title-form-input',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="invalid-feedback" id="title-form-error"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('content') }}</label><br>
                        {!! Form::text('content', isset($result) ? $result->content : null, [
                            'class' => 'form-control',
                            'id' => 'content-form-input',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="invalid-feedback" id="content-form-error"></div>
                    </div>
                  
                </div> <!-- end card-box -->
            </div> <!-- end col -->
            
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

    </script>
@endsection
