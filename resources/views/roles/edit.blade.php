@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3">Edit Role</h6>
                <h1 class="mb-5">Edit Role: {{ $role->role_name }}</h1>

                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" value="{{ $role->role_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $role->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Update Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
