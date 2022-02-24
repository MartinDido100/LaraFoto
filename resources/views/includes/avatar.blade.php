@if(Auth::user()->image)
    <img src="{{ asset('users/'.Auth::user()->image) }}" alt="Avatar" class="avatar" >
@endif