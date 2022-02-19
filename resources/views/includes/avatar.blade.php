@if(Auth::user()->image)
    <img src="{{ route('user.avatar',['filename' => Auth::user()->image]) }}" alt="Avatar" class="avatar" >
@endif