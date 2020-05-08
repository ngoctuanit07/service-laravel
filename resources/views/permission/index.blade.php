@extends('admin.layouts.master')
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Permission Management</h2>
        </div>
        <div class="pull-right">
            @can('role-create')
            <a class="btn btn-success" href="{{ route('permission.create') }}"> Create New Permission</a>
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
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($permission as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('permission.show',$role->id) }}">Show</a>
                    @can('role-edit')
                    <a class="btn btn-primary" href="{{ route('permission.edit',$role->id) }}">Edit</a>
                    @endcan
                    @can('role-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['permission.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>


        {!! $permission->render() !!}

    </div>
</div>
</div>

@endsection
