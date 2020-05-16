@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> {{ __('app.ConfigTrackingManagement') }}</h2>
            </div>
            <div class="pull-right">
                @can('configtracking_create')
                <a class="btn btn-success" href="{{ route('configtracking.create') }}"> {{ __('app.CreateNewConfig') }}</a>
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
                    <th width="16%">{{ __('app.url') }}</th>
                    <th width="16%">{{ __('app.credentials') }}</th>
                    <th width="16%">{{ __('app.status') }}</th>
                    <th width="15%" class="text-center">{{ __('app.Action') }}</th>
                </tr>
                @foreach ($configs as $key => $config)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $config->url }}</td>
                    <td>{{ $config->credentials }}</td>
                    <td>{{ $config->status }}</td>
                    <td class="text-center">
                        @can('configtracking_edit')
                        <a class="btn btn-primary" href="{{ route('configtracking.edit',$config->id) }}">{{ __('app.Edit') }}</a>
                        @endcan
                        @can('configtracking_delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['configtracking.destroy', $config->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-danger" type="submit">{{ __('app.Delete') }}</button>
                        {{-- {!! Form::submit({{ __('app.Delete') }}, ['class' => 'btn btn-danger']) !!} --}}
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $configs->render() !!}
        </div>
    </div>
</div>

@endsection
