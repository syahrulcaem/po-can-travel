@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to PO CAN Travel</h1>
            <p class="text-gray-600 mb-8">Your trusted bus ticket booking platform</p>

            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">
                    Register
                </a>
            </div>
        </div>
    </div>
@endsection
