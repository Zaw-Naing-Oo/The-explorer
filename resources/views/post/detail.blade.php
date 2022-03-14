@extends('master')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <div class="post mb-4">
                    <div class="row">

                        <h4 class="fw-bold mb-4">{{ $post->title }}</h4>
                        <img src="{{ asset("storage/cover/".$post->cover) }}" class="cover-img rounded-3 w-100 mb-4" alt="">

                        <p class="text-black-50 mb-4 post-detail">
                            {{ $post->description }}
                        </p>


                        @if($post->galleries->count())
                            <div class="gallery rounded mb-5">
                                <h4 class="fw-bold text-center mt-3">Post Gallery</h4>
                                <div class="row g-4 py-4 px-2 justify-content-center">
                                    @foreach($post->galleries as $gallery)
                                        <div class="col-lg-4 col-xl-3 col-6">
                                            <a class="venoBox" data-gall="gallery" href="{{ asset('storage/gallery/'.$gallery->photo) }}">
                                                <img src="{{ asset('storage/gallery/'.$gallery->photo) }}" class="gallery-photo">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        <div class="mb-5">
                            <h4 class="fw-bold text-center">Users Comment</h4>
                            <div class="row justify-content-center">

                                    <div class="col-lg-8">
                                            <div class="comments mb-3">
                                                @forelse($post->comments as $comment)

                                                    <div class="border rounded p-3">
                                                       <div class="d-flex justify-content-between mb-3">

                                                           <div class="d-flex">
                                                               <img src="{{ asset($comment->user->photo) }}" class="user-img rounded-circle" alt="">
                                                               <p class="mb-0 ms-2 small">
                                                                   {{ $comment->user->name }}
                                                                   <br>
                                                                   <i class="fas fa-calendar"></i>
                                                                   {{ $comment->created_at->diffforhumans() }}
                                                               </p>
                                                           </div>

                                                           @can('delete',$comment)
                                                           <form action="{{ route('comment.destroy',$comment->id) }}" method="post" >
                                                               @csrf
                                                               @method('delete')
                                                               <button class="btn btn-outline-danger btn-sm rounded-circle">
                                                                   <i class="fas fa-trash-alt"></i>
                                                               </button>
                                                           </form>
                                                           @endcan
                                                       </div>

                                                       <p class="mb-0 ms-5 fw-bold">{{ $comment->message }}</p>
                                                    </div>
                                                @empty
                                                    <p class="text-center mt-3 fst-italic ">
                                                        There is no comment
                                                        @auth
                                                            Start comment now
                                                        @endauth
                                                        @guest
                                                            <a href="{{ route('login') }}">Login</a>  To Comment
                                                        @endguest
                                                    </p>
                                                @endforelse
                                            </div>


                                        @auth
                                            <form action="{{ route('comment.store') }}" id="comment-create" method="post">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Leave a message here" style="height: 150px" id="floatingTextarea2" style="height: 100px"></textarea>
                                                    <label for="floatingTextarea2">Comments</label>
                                                </div>
                                                @error('message')
                                                <p class="small ps-2 text-danger">{{ $message }}</p>
                                                @enderror
                                                <div class="text-center">
                                                    <button class="btn btn-primary">Comment</button>
                                                </div>
                                            </form>
                                        @endauth
                                    </div>
                            </div>
                        </div>



                        <div class="d-flex justify-content-between align-items-center border rounded p-4">
                            <div class="d-flex">
                                <img src="{{ asset($post->user->photo) }}" class="user-img rounded-circle" alt="">
                                <p class="mb-0 ms-2 small">
                                    {{ $post->user->name }}
                                    <br>
                                    <i class="fas fa-calendar"></i>
                                    {{ $post->created_at->format("d M Y") }}
                                </p>
                            </div>

                           <div>
                               @auth
                                   @can('delete',$post)
                                   <form action="{{ route('post.destroy',$post->id) }}" method="post" class="d-inline-block">
                                       @csrf
                                       @method('delete')
                                        <button class="btn btn-outline-danger">
                                            <i class="fas fa-trash-alt fa-fw"></i>
                                        </button>
                                   </form>
                                   @endcan

                                   @can('update',$post)
                                           <a href="{{ route('post.edit',$post->id) }}" class="btn btn-outline-warning">
                                               <i class="fas fa-edit fa-fw"></i>
                                           </a>
                                       @endcan
                               @endauth
                                   <a href="{{ route('index') }}" class="btn btn-outline-primary">Read All</a>
                           </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>



@stop
