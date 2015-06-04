@extends('laravel-admin::layout')

@section('title')
    Создать галлерею
@stop

@section('js')
    <script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            CKEDITOR.replace( 'editor', {
                filebrowserUploadUrl: '/image/upload'
            });
            $('#tags').tagsinput();
            $('#description').autogrow();
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Создать галлерею</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default" id="gallery">
                <div class="panel-heading">
                    Галлерея
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('laravel-gallery::errorBasic')

                            {!! Form::model($gallery, ['route'=>['admin.gallery.store'],
                                'method' => 'POST',
                                'class'=>'form-horizontal', 'role'=>'form']) !!}
                                @include('laravel-gallery::_form')
                            {!! Form::close() !!}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@stop
