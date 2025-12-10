@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
            Gamification Settings
        </h1>
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Seasonal Leaderboard</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="dark:bg-dark-bg-tertiary">
                    <tr>
                        <th class="px-4 py-3 text-left">Rank</th>
                        <th class="px-4 py-3 text-left">User</th>
                        <th class="px-4 py-3 text-left">XP</th>
                        <th class="px-4 py-3 text-left">Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seasonalLeaderboard as $index => $user)
                        <tr>
                            <td class="px-4 py-3">#{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ number_format($user->xp) }}</td>
                            <td class="px-4 py-3">{{ $user->level }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
