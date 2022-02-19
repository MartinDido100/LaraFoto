@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center gap">
            <div class="col-md-8 cont profile-cont">

                @include('includes.message')

                <div class="data-user">
                    @if($user->image)
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar',['filename' => $user->image]) }}" alt="Avatar">
                        </div>
                    @endif
                    <div class="user-info">
                        <h1>{{ $user->nick }}</h1>
                        <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                    </div>
                </div>
                <hr width="80%">
                @if (count($user->images) >= 1)                    
                    <h3>Imagenes subidas:</h3>
                    <div class="profile-images">
                        @foreach ($user->images as $image)

                            @include('includes.image',['profile' => true])

                        @endforeach
                    </div>
                @else
                    <h3>El usuario aun no tiene imagenes...</h3>
                @endif

            </div>
        </div>
    </div>

@endsection