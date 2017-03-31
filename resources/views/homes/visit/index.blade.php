<div class="panel col-md-12">
    @include('homes.components.searchBox')
    <div class="col-md-6" id="viewVisitedGarages">
        <label>{{ trans_choice('layout.garages', 2) }}</label>
        <div id="visitedGarages">
            @include('homes.visit.visits', ['visits' => $visitsList['garage'], 'searchParamters' => $searchParamters])
        </div>
    </div>

    <div class="col-md-6" id="viewVisitedArticles">
        <label>{{ trans_choice('layout.articles', 2) }}</label>
        <div id="visitedArticles">
            @include('homes.visit.visits', ['visits' => $visitsList['article']])
        </div>
    </div>
</div>
