@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase mb-3">PLEASE LOGIN</h6>
                <h1 class="mb-5">LOGIN</h1>
                <p class="mb-5">Please log in to the site in order to use the features.</p>
                <a href="{{ route('register') }}">Register</a>
            </div>
            <div class="col-lg-7">
                <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s">
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control border-0" placeholder="Your Email or Username" required name="email_or_username" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="password" class="form-control border-0" placeholder="Your Password" required name="password" style="height: 55px;">
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
