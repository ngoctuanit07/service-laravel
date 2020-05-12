@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Config Management</h2>
            </div>
            <div class="pull-right">
                @can('create_config')
                <a class="btn btn-success" href="{{ route('config.create') }}"> Create New Config</a>
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
                    <th width="6%">No</th>
                    <th width="16%">Name</th>
                    <th width="15%" class="text-center">Action</th>
                </tr>
                @foreach ($configs as $key => $config)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $config->title }}</td>
                    <td class="text-center">
                        @can('edit_config')
                        <a class="btn btn-primary" href="{{ route('config.edit',$config->id) }}">Edit</a>
                        @endcan
                        @can('import_config')
                        {!! Form::open(['method' => 'POST','route' => ['admin.import', $config->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Import Data', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        @endcan
                        @can('delete_config')
                        {!! Form::open(['method' => 'DELETE','route' => ['config.destroy', $config->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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
