@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
            Reputation Management
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary mt-1">
            Manage user XP, levels, and karma
        </p>
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
            Top Users by XP
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary">
                    <tr>
                        <th class="px-4 py-3 text-left">Rank</th>
                        <th class="px-4 py-3 text-left">User</th>
                        <th class="px-4 py-3 text-left">Level</th>
                        <th class="px-4 py-3 text-left">XP</th>
                        <th class="px-4 py-3 text-left">Karma</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $index => $user)
                        <tr>
                            <td class="px-4 py-3">#{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->profile->level ?? 1 }}</td>
                            <td class="px-4 py-3">{{ number_format($user->profile->xp ?? 0) }}</td>
                            <td class="px-4 py-3">{{ number_format($user->profile->karma ?? 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
