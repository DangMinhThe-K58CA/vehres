@extends('layouts.app')
@section('javascript')

@endsection
@section('css')

@endsection
@section('content')
    <div class="col-md-10 col-md-offset-1" id="myWorldField">
        <section class="panel">
            <header class="panel-heading tab-bg-info">
                <ul class="nav nav-tabs">
                    <li class="{{ count($errors->all()) === 0 ? 'active' : ''}}">
                        <a data-toggle="tab" href="#viewBookmark" id="viewBookmarkBtn">
                            <i class="fa fa-bookmark" aria-hidden="true" style="color:#eff050; font-size:26px"></i>
                            {{ trans('layout.bookmark') }}
                        </a>
                    </li>
                    <li class="{{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.update_profile') ? 'active' : ''}}">
                        <a data-toggle="tab" href="#viewVisit" id="viewVisitBtn">
                            <i class="fa fa-check" aria-hidden="true" style="color:rgba(79, 208, 22, 1); font-size:26px"></i>
                            {{ trans('layout.seen') }}
                        </a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="viewBookmark" class="col-md-12 tab-pane {{ count($errors->all()) === 0 ? 'active' : ''}}">
                        {{--Bookmarks view here--}}
                    </div>
                    <div id="viewVisit" class="tab-pane col-md-12 {{ count($errors->all()) > 0 && session('tabStatus') === config('common.user.task_bar_status.update_profile') ? 'active' : ''}}">
                        {{--Visite view here--}}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>

    </script>
@endsection
