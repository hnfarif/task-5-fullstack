@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">

            @if (Session::has('success'))
            <div class="alert alert-success my-3">
                {{ session('success') }}
            </div>
            @elseif (Session::has('error'))
            <div class="alert alert-danger my-3">
                {{ session('error') }}
            </div>
            @endif

            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Data</a>

            <div class="card my-3">
                <div class="card-header">{{ __('Article Table') }}</div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->user->name }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-info my-2">Edit</a>
                                    <form action="{{ route('categories.destroy', $c->id) }}" method="post"
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
                                    {{ $categories->links() }}
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
