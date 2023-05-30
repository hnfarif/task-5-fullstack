@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            {{-- button add data --}}

            @if (Session::has('success'))
            <div class="alert alert-success my-3">
                {{ session('success') }}
            </div>
            @elseif (Session::has('error'))
            <div class="alert alert-danger my-3">
                {{ session('error') }}
            </div>
            @endif

            <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Data</a>

            <div class="card my-3">
                <div class="card-header">{{ __('Article Table') }}</div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->content }}</td>
                                <td>
                                    <img class="img-fluid rounded img-thumbnail " src="{{ $post->image }}"
                                        alt="{{ $post->title }}">
                                </td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info my-2">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    {{ $posts->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
