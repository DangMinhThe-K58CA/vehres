@extends('partners.layouts.master')

@section('tag')
    @if ($status == config('common.article.status.activated'))
        Activated Artilces
    @else
        Unactivated Artilces
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
                    <th>Id</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Summary</th>
                    <th>Create</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles->items() as $key => $item)
                <tr>
                    <td>
                        <label>{{ $key + 1 }}</label>
                        <input type='hidden' class="garageId" value="{{ $item->id }}">
                    </td>
                    <td>{{ $item->title }}</td>
                    <td class="center">
                        @if($item->type === 1)
                            <p>News</p>
                        @endif
                        @if($item->type === 2)
                            <p>Tip</p>
                        @endif
                    </td>
                    <td class="center">{{ $item->short_description }}</td>
                    <td class="center">{{ $item->created_at }}</td>
                    <td class="center">
                        <a class="btn btn-small btn-primary" data-garage-id="{{ $item->id }}" href="{{ action('Partner\ArticleController@show', ['article' => $item->id]) }}">
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
        {!! $articles->appends(Request::except('page'))->links() !!}
    </div>
    <!-- end pagination -->
</div>
@stop
