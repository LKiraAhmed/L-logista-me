@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-12">
          
                @if (auth()->check()) 
                    <h1 class="mb-4">Welcome, {{ auth()->user()->name }}</h1>

           
                    <form action="{{ route('send.token') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Send Token to Email</button>
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

                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Token Input Field -->
                    <div class="mt-4">
                        <h2>Enter your token</h2>
                        <form action="{{ route('verify.token') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="api_token" class="form-control" placeholder="Enter the token you received via email" required>
                            </div>
                            <button type="submit" class="btn btn-success">Verify Token</button>
                        </form>
                    </div>
                    <style>
                        .table {
                            width: 100%;
                            margin: 20px 0;
                            border-collapse: collapse;
                        }
                    
                        .table th, .table td {
                            padding: 15px;
                            text-align: left;
                            border: 1px solid #fff; 
                            color: #fff; 
                        }
                    
                        .table th {
                            background-color: #000; 
                        }
                    
                        .table td {
                            background-color: #222; 
                        }
                    
                        pre {
                            background-color: #000; 
                            color: #fff; 
                            padding: 15px;
                            border: 1px solid #fff; 
                            max-width: 100%;
                            overflow: auto;
                        }
                    </style>
                    
                    
             
                    @if (session('token_valid'))
                        <div class="mb-5 mt-3">
                            <h2>Your API Token</h2>
                            <pre>{{ session('user_token') }}</pre> 

                            @if (auth()->user()->role == 'Company')
                                <div class="mb-5 mt-3">
                                    <h2 class="mb-3">Company API</h2>
                                    <p>
                                        <a href="#" id="company-api-link" class="api-link" onclick="copyToClipboard('company-api-link')">POST /api/company/orders</a>
                                    </p>
                                </div>
                               
                                <h3>Order Data in JSON</h3>
                                <pre id="json-output"></pre>
                            </div>
                            @elseif (auth()->user()->role == 'Merchant')
                                <div class="mb-5 mt-3">
                                    <h2 class="mb-3">Merchant API</h2>
                                    <p>
                                        <a href="#" id="merchant-api-link" class="api-link" onclick="copyToClipboard('merchant-api-link')">POST /api/merchant/orders</a>
                                    </p>
                                </div>
                                <h3>Order Data in JSON</h3>
                                <pre id="json-output"></pre>
                            </div>
                            @else
                                <div class="mb-5 mt-3">
                                    <h2 class="mb-3">No API Available</h2>
                                </div>
                            @endif
                        </div>
                    @endif
                @else
                    <h1 class="mb-4">Welcome To Logista</h1>
                    <div class="mb-5">
                        <h2 class="mb-3">Unauthorized Access</h2>
                        <p>You must be logged in to access the API information. Please <a href="{{ route('login') }}">login</a> first.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderData = {
    order_number: "123456",
    customer_name: "John Doe",
    customer_email: "johndoe@example.com",
    customer_phone: "123456789",
    shipping_address: "123 Main St",
    billing_address: "456 Market St",
    total_amount: 100,
    order_status: "Processing",
    payment_method: "Credit Card",
    shipping_method: "Standard Shipping", 
    shipping_cost: 10,
    tax_amount: 5,
    discount: 0,
    currency: "USD",
    notes: "Leave at front door",  
    tracking_number: "TRACK12345",
    expected_delivery_date: "2024-12-01",
    token: "AUlJLzk09vtguRiC8jXQ6sHjNAXJApOLfCd93lFv1883"  
};

        const jsonOutput = document.getElementById('json-output');
        jsonOutput.textContent = JSON.stringify(orderData, null, 4);
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const baseUrl = window.location.origin; 

    const companyApiLink = document.getElementById('company-api-link');
    const merchantApiLink = document.getElementById('merchant-api-link');

    const randomString = Math.random().toString(36).substring(2, 12);

    if (companyApiLink) {
        companyApiLink.href = `${baseUrl}/api/company/orders/${randomString}`;
        companyApiLink.textContent = `POST ${baseUrl}/api/company/orders/${randomString}`;
    }

    if (merchantApiLink) {
        merchantApiLink.href = `${baseUrl}/api/merchant/orders/${randomString}`;
        merchantApiLink.textContent = `POST ${baseUrl}/api/merchant/orders/${randomString}`;
    }
});


    function copyToClipboard(elementId) {
        const link = document.getElementById(elementId).href;
        navigator.clipboard.writeText(link).then(function() {
            alert("API link copied to clipboard: " + link);
        }, function() {
            alert("Failed to copy link");
        });
    }
</script>
@endsection
