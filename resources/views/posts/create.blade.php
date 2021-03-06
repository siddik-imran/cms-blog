@extends('layouts.app')

@section('page_name')
Post create
@endsection


@section('content')
<div class="col-md-10 offset-1">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
           {{ isset($post) ? 'Edit Post' : 'Create a new post' }}
        </h6>
        </div>
        <div class="card-body">
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if (isset($post))
                @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ isset($post) ? $post->title : '' }}">
                    @error('title')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="3" rows="3" class="form-control">{{ isset($post) ? $post->description : '' }}</textarea>
                    @error('description')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}">
                    <trix-editor input="content"></trix-editor>
                    @error('content')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="published_at">Published At</label>
                    <input type="text" class="form-control" name="published_at" id="published_at" placeholder="Pick your Date & Time" value="{{ isset($post) ? $post->published_at : '' }}">
                    @error('published_at')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                @if (isset($post))
                <div class="form-group">
                    <img src="{{ asset('uploads/'.$post->image) }}" alt="" style="width: 400px; height:300px; border-radius:5px">
                </div>
                @endif
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" name="image" >
                    @error('image')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select name="category" id="category" class="form-control">
                       @foreach ($categories as $category )
                            <option value="{{ $category->id }}"
                                @if(isset($post))
                                    @if($category->id == $post->category_id) selected
                                    @endif
                                @endif
                            >
                                {{ $category->name }}
                            </option>
                       @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                @if($tags->count() > 0)
                <div class="form-group">
                    <label for="tags">Select Tags</label>
                    <select name="tags[]" id="tags" class="form-control tag-selector" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                               @if (isset($post))
                                @if (in_array($tag->id, $post->tags->pluck('id')->toArray())) selected
                                @endif
                               @endif
                            >
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('tags')
                        <div class="text-danger text-bold">{{ $message }}</div>
                    @enderror
                </div>
                @endif
                <div class="form-group">
                   <button type="submit" class="btn btn-sm btn-primary">
                       {{ isset($post) ? 'Update' : 'Create' }}
                   </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr('#published_at', {
            enableTime: true,
            enableSeconds: true
        })

        $(document).ready(function() {
            $('.tag-selector').select2();
        });
    </script>
@endsection
