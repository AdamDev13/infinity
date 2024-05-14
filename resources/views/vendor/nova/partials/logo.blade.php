@if(Request::path() === 'users/login' || Request::path() === 'users/password/reset')
    <img src="{{ asset('images/logo_green.png')  }}" style="max-width:320px;" alt="">
@else
    <img src="{{ asset('images/logo_only.png')  }}" style="max-width:160px;" alt="">
@endif