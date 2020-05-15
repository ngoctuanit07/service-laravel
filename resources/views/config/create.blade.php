@extends('admin.layouts.master')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ __('app.CreateNewConfig') }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('config.index') }}"> {{ __('app.Back') }}</a>
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
            {!! Form::open(array('route' => 'config.store','method'=>'POST')) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Url') }}:</strong>
                        {!! Form::text('url', null, array('placeholder' => 'Url','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Sitemap') }}:</strong>
                        {!! Form::text('sitemap', null, array('placeholder' => 'Sitemap','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.DivContent') }}:</strong>
                        {!! Form::text('contentfull', null, array('placeholder' => 'Div Parent','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Title') }}:</strong>
                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Content') }}:</strong>
                        {!! Form::text('content', null, array('placeholder' => 'Content','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Image') }}:</strong>
                        {!! Form::text('featured_image', null, array('placeholder' => 'Featured image','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('app.Continuity') }}:</strong>

                        {!!Form::select('continuity', array('0' => 'Tắt', '1' => 'Bật'), '0')!!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">{{ __('app.Submit') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</div>

@endsection
