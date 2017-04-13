@extends('partners.layouts.master')

@section('tag')
    @if ($status == config('common.garage.status.activated'))
        {{ trans('admin.garages.activated_garages') }}
    @else
        Unactivated Garages
    @endif
@stop

@section('content')
<div class="grid-form1" id="garagesField">
    <div class="col-md-10 col-md-offset-1">
        <div id="showGarageModal" aria-hidden="true">

        </div>
    </div>
    <div>
        <table class="table table-bordered">
            @include('errors.success')
            <thead>
                <tr align="center">
                    <th>{{ trans('admin.garages.id') }}</th>
                    <th>{{ trans('admin.garages.name') }}</th>
                    <th>Type</th>
                    <th>{{ trans('admin.garages.phone_number') }}</th>
                    <th>{{ trans('admin.garages.address') }}</th>
                    <th>{{ trans('admin.garages.website') }}</th>
                    <th>Maps</th>
                    <th>{{ trans('admin.garages.view') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($garages->items() as $key => $item)
                <tr>
                    <td>
                        <label>{{ $key + 1 }}</label>
                        <input type='hidden' class="garageId" value="{{ $item->id }}">
                    </td>
                    <td>{{ $item->name }}</td>
                    <td class="center">
                        @if($item->type === 1)
                            <i class="fa fa-automobile" style="font-size:24px;color:#bf050c"></i>
                        @endif
                        @if($item->type === 2)
                            <i class="fa fa-motorcycle" style="font-size:24px;color:#0000cc"></i>
                        @endif
                        @if($item->type === 3)
                            <i class="fa fa-bicycle" style="font-size:24px;color:#4cbf33"></i>
                        @endif
                    </td>
                    <td class="center">{{ $item->phone_number }}</td>
                    <td class="center">{{ $item->address }}</td>
                    <td class="center"><a href="{{$item->website}}">{{ $item->website }}</a></td>
                    <td class="center">
                        @if($item->status === 0)
                            <a href="{{ action('Partner\GarageController@garageMaps', ['id' => $item->id]) }}">
                                <i class="fa fa-map-o" style="font-size:24px;color:#0a568c"></i>
                            </a>
                        @else
                            <a href="{{ action('Home\GarageController@show', ['id' => $item->id]) }}" target="_blank">
                                <i class="fa fa-map-o" style="font-size:24px;color:#0a568c"></i>
                            </a>
                        @endif
                    </td>
                    <td class="center">
                        <a class="btn btn-small btn-primary" data-garage-id="{{ $item->id }}" href="{{ action('Partner\GarageController@show', ['garage' => $item->id]) }}">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- pagination -->
    <div class="pagination pull-right">
        {!! $garages->appends(Request::except('page'))->links() !!}
    </div>
    <!-- end pagination -->
</div>
@stop
