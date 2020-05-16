@extends('admin.layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ __('app.Trackingkeywordrankmanagement') }}</h2>
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
                    <th width="16%">{{ __('app.Keyword') }}</th>
                    <th width="16%">{{ __('app.TotalClick') }}</th>
                    <th width="16%">{{ __('app.PossitionKeyword') }}</th>
                </tr>
                @foreach ($craws as $key => $craw)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $craw->keyword }}</td>
                    <td>{{ $craw->clicks }}</td>
                    <td>{{ $craw->avg_position }}</td>
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $craws->render() !!}

        </div>
    </div>
</div>

@endsection
