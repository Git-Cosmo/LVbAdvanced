@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Stats Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <div class="text-sm font-medium text-gray-500">Total Users</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['users'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-primary-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <div class="text-sm font-medium text-gray-500">Total Forums</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['forums'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <div class="text-sm font-medium text-gray-500">Total Threads</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $stats['threads'] }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Quick Actions</h2>
        </div>
        <div class="p-6 space-y-3">
            <a href="{{ route('admin.forum.index') }}" class="block px-4 py-3 bg-primary-50 hover:bg-primary-100 rounded-lg transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Manage Forums</span>
                </div>
            </a>
            
            <a href="{{ route('admin.moderation.index') }}" class="block px-4 py-3 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Moderation</span>
                </div>
            </a>
            
            <a href="{{ route('home') }}" target="_blank" class="block px-4 py-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span class="font-medium text-gray-700">View Public Site</span>
                </div>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-600 text-sm">Activity log will appear here...</p>
        </div>
    </div>
</div>
@endsection
