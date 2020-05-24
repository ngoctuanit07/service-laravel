@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> {{ __('app.ProxyManagement') }}</h2>
            </div>
            <div class="pull-right">
                @can('proxy_create')
                <a class="btn btn-success" href="{{ route('proxy.create') }}"> {{ __('app.CreateNewProxy') }}</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th width="6%">{{ __('app.No') }}</th>
                    <th width="16%">{{ __('app.urlpory') }}</th>
                    <th width="16%">{{ __('app.status') }}</th>
                    <th width="15%" class="text-center">{{ __('app.Action') }}</th>
                </tr>
                @foreach ($proxys as $key => $config)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $config->url }}</td>
                    <td>{{ $config->status }}</td>
                    <td class="text-center">
                        @can('proxy_edit')
                        <a class="btn btn-primary" href="{{ route('proxy.edit',$config->id) }}">{{ __('app.Edit') }}</a>
                        @endcan
                        @can('proxy_delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['proxy.destroy', $config->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-danger" type="submit">{{ __('app.Delete') }}</button>
                        {{-- {!! Form::submit({{ __('app.Delete') }}, ['class' => 'btn btn-danger']) !!} --}}
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $proxys->render() !!}
        </div>
    </div>
</div>

@endsection
