@extends('layouts.app')

@section('content')
    @include('includes.searchbar')
    <div class="container">
        <div class="row justify-content-center gap">
            <div class="col-md-8 cont profile-cont">
                <a href="{{ route('home') }}" class="btn btn-primary back">Volver al inicio</a>
                @if(count($users) >= 1)
                    @foreach ($users as $user)
                    <div class="data-user">
                        @if($user->image)
                            <div class="container-avatar">
                                <img src="{{ route('user.avatar',['filename' => $user->image]) }}" alt="Avatar">
                            </div>
                        @endif
                        <div class="user-info">
                            <h1>{{ $user->nick }}</h1>
                            <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                            <a href="{{ route('user.profile',['id' => $user->id]) }}" class="btn btn-success">Ver perfil</a>
                        </div>
                    </div>
                    <hr width="80%">
                    @endforeach

                    <div class="clearfix"></div>
                    {{ $users->links() }}
                @else
                    <h2>No se encontraron resultados...</h2>
                @endif

            </div>
        </div>
    </div>

@endsection