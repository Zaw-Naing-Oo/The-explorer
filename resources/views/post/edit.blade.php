@extends('master')
@section("title") Create Post : {{ env("APP_NAME") }} @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Edit  Post</h4>
                    <p class="mb-0">
                        <i class="fas fa-calendar"></i>
                        {{ date("d M Y") }}
                    </p>
                </div>

                <form action="{{ route('post.update',$post->id) }}" method="post" id="post-create" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="form-floating mb-4">
                        <input type="text" name="title" value="{{ $post->title }}" class="form-control" id="postTitle" placeholder="no need">
                        <label for="postTitle">Post Title</label>
                    </div>
                    @error('title')
                    <p class="ps-1 text-danger">{{ $message }}</p>
                    @enderror

                    <div class="mb-4">
                        <img src="{{ asset('storage/cover/'.$post->cover) }}" id="coverPreview" class="cover-img w-100 rounded" alt="">
                        <input type="file" name="cover" class="d-none" id="cover">
                    </div>
                    @error('cover')
                    <p class="ps-1 text-danger">{{ $message }}</p>
                    @enderror

                    <div class="form-floating mb-4">
                        <textarea name="description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 450px">{{ $post->description }}</textarea>
                        <label for="floatingTextarea2">Share Your Experience</label>
                    </div>
                    @error('description')
                    <p class="ps-1 text-danger">{{ $message }}</p>
                    @enderror
                </form>

                <div class="border p-4 rounded mb-4" id="gallery">



                    <div class="d-flex align-items-stretch ">
                        <div class="border me-2 px-5 rounded rounded-2 d-flex justify-content-center align-items-center" id="upload-ui" style="height: 150px;">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="rounded overflow-scroll" style="height: 150px">
                            @forelse($post->galleries as $gallery)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/gallery/'.$gallery->photo) }}" class="h-100 rounded ms-1" alt="">
                                    <form action="{{ route('gallery.destroy',$gallery->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger position-absolute btn-sm rounded" style="top: 130px;left: 5px">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>



                    <form action="{{ route('gallery.store') }}" id="gallery-upload" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}" >
                        <div class="">
                            <input type="file" name="galleries[]" id="gallery-input" class="d-none @error('galleries') is-invalid @enderror @error('galleries.*') is-invalid @enderror"  multiple>
                            @error('galleries')
                            <p class="ps-1 text-danger">{{ $message }}</p>
                            @enderror
                            @error('galleries.*')
                            <p class="ps-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="d-none">post</button>
                    </form>
                </div>



                <div class="text-center mb-4">
                    <button class="btn btn-lg btn-primary" form="post-create">
                        <i class="fas fa-message fa-fw"></i>
                        Update Post
                    </button>
                </div>
            </div>
        </div>
    </div>




@endsection
@push("scripts")
    <script>
        let coverPreview = document.querySelector("#coverPreview");
        let cover = document.querySelector("#cover");
        coverPreview.addEventListener("click",_=>cover.click())
        cover.addEventListener("change",_=>{
            let file = cover.files[0];
            let reader = new FileReader();
            reader.onload = function (){
                coverPreview.src = reader.result;
            }
            reader.readAsDataURL(file);
        })

        let uploadUi = document.getElementById("upload-ui");
        let galleryInput = document.getElementById("gallery-input");
        let galleryUpload = document.getElementById("gallery-upload");

        uploadUi.addEventListener('click',_=>galleryInput.click());
        galleryInput.addEventListener('change',_=>galleryUpload.submit());
    </script>
@endpush
