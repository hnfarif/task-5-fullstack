@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card my-3">
                <div class="card-header">{{ __('Form Add Article') }}</div>

                <div class="card-body">
                    {{-- form add data --}}
                    <form action="{{ route('posts.store') }}" enctype="multipart/form-data" method="POST">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('title') is-invalid
                                     @enderror" id="title" placeholder="Article Title" name="title"
                                    value="{{ old('title') }}">
                                <label for="title">Title</label>
                            </div>
                        </div>

                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <textarea class="form-control @error('content')
                                is-invalid
                            @enderror" name="content" id="content" placeholder="leave a content here"
                                    style="height: 150px"></textarea>
                                <label for="content">Content</label>
                            </div>
                        </div>

                        @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <select class="form-select @error('category_id')
                                is-invalid
                            @enderror" id="category" name="category_id">
                                    <option selected>Choose Category</option>
                                    @foreach($category as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <label for="category">Category</label>
                            </div>
                        </div>

                        @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
