@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3">PLEASE LOGIN</h6>
                <h1 class="mb-5">EDIT User</h1>
                <p class="mb-5">Please Edit in to the site in order to use the features.</p>
                <a href="{{ route('login') }}">Login</a>
            </div>
            <div class="col-lg-7">
                <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">
                    <form action="{{ route('update.regstier', ['id' => auth()->user()->id]) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control border-0" placeholder="Your Name" required name="name" value="{{ auth()->user()->name }}" style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" class="form-control border-0" placeholder="Your Email" required name="email" value="{{ auth()->user()->email }}" style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control border-0" placeholder="Your Username" required name="username" value="{{ auth()->user()->username }}" style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="password" class="form-control border-0" placeholder="Your Password" name="password" style="height: 55px;">
                            </div>
                            <div class="col-12 col-sm-6">
                                <select class="form-select border-0" name="role" style="height: 55px;">
                                    <option value="1" {{ auth()->user()->role == 1 ? 'selected' : '' }}>Merchant</option>
                                    <option value="2" {{ auth()->user()->role == 2 ? 'selected' : '' }}>Company</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
