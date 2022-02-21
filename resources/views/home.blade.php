@extends('layouts.app')


@section('content')
@include('includes.searchbar')

<div class="container">
    <div class="row justify-content-center gap">
        <div class="col-md-8 cont">
            
            @include('includes.message')
    
            @foreach($images as $image)

                @include('includes.image',['profile' => false])

            @endforeach
        </div>

        {{-- Paginacion --}}
        <div class="clearfix"></div>
        {{ $images->links() }}

    </div>
</div>

@endsection