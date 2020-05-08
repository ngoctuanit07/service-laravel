@extends('admin.layouts.master')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Craw Data</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('craw.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            {!! Form::model($craws, ['method' => 'PATCH','route' => ['craw.update', $craws->id]]) !!}
            <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Title:</strong>
                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Content:</strong>
                        {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control textarea')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Image:</strong>
                        {!! Form::text('featured_image', null, array('placeholder' => 'Featured image','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
