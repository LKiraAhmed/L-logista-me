@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-12">
                @if(auth()->check())
                    <h1 class="mb-4">Your Orders</h1>
                    @if($orders->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            No orders found.
                        </div>
                    @else
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order Number</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Customer Phone</th>
                                    <th>Shipping Address</th>
                                    <th>Billing Address</th>
                                    <th>Total Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Method</th>
                                    <th>Shipping Cost</th>
                                    <th>Tax Amount</th>
                                    <th>Discount</th>
                                    <th>Currency</th>
                                    <th>Tracking Number</th>
                                    <th>Expected Delivery Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_email }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->shipping_address }}</td>
                                        <td>{{ $order->billing_address }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>{{ $order->order_status }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                        <td>${{ number_format($order->tax_amount, 2) }}</td>
                                        <td>${{ number_format($order->discount, 2) }}</td>
                                        <td>{{ $order->currency }}</td>
                                        <td>{{ $order->tracking_number }}</td>
                                        <td>{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@endsection
