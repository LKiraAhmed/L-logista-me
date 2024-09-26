@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Verify Your Account</h2>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('verify.code.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="verification_code" class="form-label">Enter Verification Code</label>
            <input type="text" name="verification_code" class="form-control" id="verification_code" placeholder="Enter the code sent to your email" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
