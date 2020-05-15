@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CrawCat Management</h2>
            </div>
            {{-- <div class="pull-right">
                @can('craw-create')
                <a class="btn btn-success" href="{{ route('crawcat.create') }}"> Create New craw</a>
                @endcan
                 {!! Form::open(['method' => 'GET','route' => ['admin.importCat'],'style'=>'display:inline']) !!}
                        {!! Form::submit('Craw Data For Cat', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
            </div> --}}
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
                        @can('edit_crawcat')
                        <a class="btn btn-primary" href="{{ route('crawcat.edit',$craw->id) }}">Edit</a>
                        @endcan
                        @can('craw-sync')
                        {!! Form::open(['method' => 'POST','route' => ['admin.sync', $craw->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Sync Wordpresss', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                        @endcan
                        @can('craw-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['crawcat.destroy', $craw->id],'style'=>'display:inline']) !!}
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
