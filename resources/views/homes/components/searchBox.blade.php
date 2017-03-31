<div data- class="row searchBox col-md-10 col-md-offset-right-2" style="margin-bottom: 10px;">
    <div class="input-group">
        <div class="input-group-btn search-panel">
            <select class="selectInstancePicker">
                @if(isset($searchOptions) && $searchOptions != null)
                    @foreach($searchOptions as $key => $value)
                        <option value="{{ $value }}">{{ $key }}</option>
                    @endforeach
                @else
                    <option disabled>Your search</option>
                @endif
            </select>
        </div>
        <input data-search-parameter="{{ json_encode($searchParamters) }}" type="text" class="form-control searchInput" placeholder="Search...">
    </div>
</div>
