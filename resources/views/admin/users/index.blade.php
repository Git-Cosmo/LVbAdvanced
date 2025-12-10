@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="flex-1">
    <header class="dark:bg-dark-bg-secondary bg-light-bg-secondary border-b dark:border-dark-border-primary border-light-border-primary p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">User Management</h1>
            <div class="dark:text-dark-text-tertiary text-light-text-tertiary">{{ auth()->user()->roles->first()->name }}</div>
        </div>
    </header>

    <main class="p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                <p class="text-green-500">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="mb-6 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by name or email..." 
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                >
                <select 
                    name="role"
                    class="px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:border-dark-border-primary border-light-border-primary border dark:text-dark-text-primary text-light-text-primary"
                >
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <button 
                    type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg overflow-hidden">
            <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
                <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">XP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">Karma</th>
                        <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-tertiary text-light-text-tertiary uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-dark-border-primary divide-light-border-primary">
                    @forelse($users as $user)
                        <tr class="dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm dark:text-dark-text-primary text-light-text-primary">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 text-xs rounded-full bg-gradient-to-r from-accent-blue/20 to-accent-purple/20 text-accent-blue">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-primary text-light-text-primary">
                                {{ $user->profile->level ?? 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-primary text-light-text-primary">
                                {{ number_format($user->profile->xp ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-primary text-light-text-primary">
                                {{ number_format($user->profile->karma ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a 
                                    href="{{ route('admin.users.edit', $user) }}" 
                                    class="text-accent-blue hover:text-accent-purple transition-colors"
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center dark:text-dark-text-tertiary text-light-text-tertiary">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </main>
</div>
@endsection
