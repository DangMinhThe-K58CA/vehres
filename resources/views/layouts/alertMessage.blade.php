<nav>
    <div name="validation-errors" class="col-lg-6 col-lg-offset-3">
        @if (session('success'))
            <div class="form-horizontal">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="form-horizontal">
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (count($errors->all()) > 0)
                <div class="alert alert-danger">
                    Something's wrong here !
                </div>
        @endif
    </div>
</nav>
