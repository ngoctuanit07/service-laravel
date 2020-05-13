@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ __('app.UsersManagement') }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}">{{ __('app.CreateNewUser') }}</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div clas="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('app.No') }}</th>
                    <th>{{ __('app.Name') }}</th>
                    <th>{{ __('app.Email') }}</th>
                    <th>{{ __('app.Role') }}</th>
                    <th width="280px">{{ __('app.Action') }}</th>
                </tr>
                @foreach ($data as $key => $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">{{ __('app.Edit') }}</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                        <button class="btn btn-danger" type="submit">{{ __('app.Delete') }}</button>
                        {{-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} --}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $data->render() !!}
        </div>
    </div>
</div>
@endsection
