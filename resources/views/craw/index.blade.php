@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Craw Management</h2>
            </div>
            <div class="pull-right">
                @can('craw-create')
                <a class="btn btn-success" href="{{ route('craw.create') }}"> Create New craw</a>
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
                @foreach ($craws as $key => $craw)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $craw->title }}</td>
                    <td class="text-center">
                        @can('craw-edit')
                        <a class="btn btn-primary" href="{{ route('craw.edit',$craw->id) }}">Edit</a>
                        @endcan
                        @can('craw-sync')
                        {!! Form::open(['method' => 'POST','route' => ['admin.dongbo', $craw->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Sync Wordpresss', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        @endcan
                        @can('craw-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['craw.destroy', $craw->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $craws->render() !!}

        </div>
    </div>
</div>

@endsection
