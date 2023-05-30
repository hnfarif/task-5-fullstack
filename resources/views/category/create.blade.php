@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card my-3">
                <div class="card-header">{{ __('Form Add Categories') }}</div>

                <div class="card-body">
                    {{-- form add data --}}
                    <form action="{{ route('categories.store') }}" enctype="multipart/form-data" method="POST">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid
                                     @enderror" id="name" placeholder="Categories Name" name="name"
                                    value="{{ old('name') }}">
                                <label for="name">name</label>
                            </div>
                        </div>

                        @error('name')
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
