 <div class="container">
        <a>{{ $user->name }}</a>
        <a>{{ $user->email }}</a>
        <h1>{{ trans('layout.hello') }} ! {{ $user->name }}</h1>
        <p>{{ trans('layout.your_email') }}: {{ $user->email }} {{ trans('layout.email_short_description') }}.</p>
        <p>{{ trans('layout.email_confirm_thanks') }}</p>
        <br/>
        <a href = {{ $link }} target="_blank">{{ trans('layout.click_here') }}</a>
 </div>
