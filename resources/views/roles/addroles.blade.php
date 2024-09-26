@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3">Add New Role</h6>
                <h1 class="mb-5">Add Your Role</h1>
                <p class="mb-5">Fill out the form below to add a new role to the system.</p>
            </div>
            <div class="col-lg-7">
                <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control border-0" placeholder="Role Name" required name="role_name" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control border-0" placeholder="Role Description" name="description" style="height: 100px;"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Add Role</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection