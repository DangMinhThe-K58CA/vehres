<div class="panel">
    <div class="col-sm-6">
        <label>{{ trans_choice('layout.garages', 2) }}</label>
        <div>
            @include('homes.visit.visits', ['visits' => $visitsList['garage']])
        </div>
    </div>

    <div class="col-sm-6">
        <label>{{ trans_choice('layout.articles', 2) }}</label>
        <div>
            @include('homes.visit.visits', ['visits' => $visitsList['article']])
        </div>
    </div>
</div>
