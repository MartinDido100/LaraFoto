<div class="card">
                
    @if(!$profile || ($profile && $image->user->id == Auth::user()->id))
        <div class="card-header image-header">
            @if(!$profile)
                @if($image->user->image)
                    <img src="{{ route('user.avatar',['filename' => $image->user->image]) }}" alt="Avatar" class="avatar image-avatar">
                @endif
                <a href="{{ route('user.profile',['id' => $image->user->id]) }}" class="profile-link">
                    <p class="image-p">{{ $image->user->name . ' ' . $image->user->surname }} | {{ $image->user->nick }}</p>
                </a>
            @elseif($profile && $image->user->id == Auth::user()->id)
                <div class="actions">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                        Actualizar
                    </button>
    
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
    
                            <div class="modal-header">
                              <h5 class="modal-title">Actualizar</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
    
                            <div class="modal-body">
                                <form method="POST" action="{{ route('image.update') }}" autocomplete="off" enctype="multipart/form-data">

                                    @csrf
                                    
                                    @method('PUT')

                                    <input type="hidden" value="{{ $image->id }}" name="image_id">

                                    <div class="row mb-3">
                                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="description" value="{{ $image->description }}" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>
            
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <label for="image_path" class="col-md-4 col-form-label text-md-end">{{ __('Imagen') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" autocomplete="image_path">
            
                                            @error('image_path')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Actualizar
                                            </button>
                                        </div>
                                    </div>
            
                                </form>
                            </div>
    
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>
    
                          </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Borrar
                    </button>
    
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
    
                            <div class="modal-header">
                              <h5 class="modal-title">Advertencia</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
    
                            <div class="modal-body">
                              <p>Al eliminar esta imagen no podra recuperarse, ¿estas seguro?</p>
                            </div>
    
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                              <a href="{{ route('image.delete',['id' => $image->id]) }}" class="btn btn-danger">Si, borrar</a>
                            </div>
    
                          </div>
                        </div>
                    </div>

                </div>

            @endif
        </div>
    @endif

    <div class="card-body body-cont">
        <div class="image-cont">
            <img src="{{ route('image.file',['filename' => $image->image_path]) }}" class="image">
        </div>
        <div class="likes">
            <div class="description-cont">
                <p class="image-p description">{{ $image->description }}</p>
                <p class="desc-date image-p">{{ FormatTime::LongTimeFilter($image->created_at) }}</p>
            </div>
            <div class="likes-box">
                <?php $user_like = false ?>
                @foreach ($image->likes as $like)
                    @if ($like->user->id == Auth::user()->id)
                    <?php $user_like = true ?>    
                    @endif
                @endforeach
                
                <span class="likes-number" data-id="{{ $image->id }}">{{ count($image->likes) }}</span>
                @if ($user_like)
                    <img src="{{ asset('img/heart-red.png') }}" alt="Heart" class="heart btn-like" data-id="{{ $image->id }}">
                @else
                    <img src="{{ asset('img/heart.png') }}" alt="Heart" class="heart btn-dislike" data-id="{{ $image->id }}">
                @endif
            </div>
        </div>
        <div class="comments">
            <h2>Comentarios ({{count($image->comments)}})</h2>
            <ul class="comments-list">
                @foreach ($image->comments as $comment)
                    <li class="comment-li"><span class="comment-username">{{ $comment->user->nick }} |</span> {{ $comment->content }}</li>
                @endforeach
            </ul>
            <hr>
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="image_id" value="{{ $image->id }}">
                @error('image_id')
                    <span role="alert">
                        <strong class="comment-error">{{ $message }}</strong>
                    </span>
                @enderror
                <p>
                    <input type="text" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content">
                    @if($errors->has('content') && $errors->first('content') == $image->id)
                        <span role="alert" class="invalid-feedback">
                            <strong>You must complete the field</strong>
                        </span>
                    @enderror
                </p>
                <input type="submit" value="Comentar" class="btn btn-success">
            </form>
        </div>
    </div>

</div>