@extends('layouts.app')

@section('title', 'Create Tournament')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright">Create Tournament</h1>
        <p class="dark:text-dark-text-secondary mt-2">Organize a competitive gaming tournament</p>
    </div>

    <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-8">
        <form method="POST" action="{{ route('tournaments.store') }}">
            @csrf

            <!-- Tournament Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Tournament Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">{{ old('description') }}</textarea>
            </div>

            <!-- Game -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Game</label>
                <input type="text" name="game" value="{{ old('game') }}" placeholder="e.g., Counter-Strike 2, Valorant, League of Legends" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
            </div>

            <!-- Format and Type -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Format *</label>
                    <select name="format" required class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                        <option value="single_elimination" {{ old('format') === 'single_elimination' ? 'selected' : '' }}>Single Elimination</option>
                        <option value="double_elimination" {{ old('format') === 'double_elimination' ? 'selected' : '' }}>Double Elimination</option>
                        <option value="round_robin" {{ old('format') === 'round_robin' ? 'selected' : '' }}>Round Robin</option>
                        <option value="swiss" {{ old('format') === 'swiss' ? 'selected' : '' }}>Swiss System</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Type *</label>
                    <select name="type" required id="tournament-type" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                        <option value="solo" {{ old('type') === 'solo' ? 'selected' : '' }}>Solo</option>
                        <option value="team" {{ old('type') === 'team' ? 'selected' : '' }}>Team</option>
                    </select>
                </div>
            </div>

            <!-- Team Size (conditional) -->
            <div class="mb-6" id="team-size-field" style="display: none;">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Team Size</label>
                <input type="number" name="team_size" value="{{ old('team_size', 5) }}" min="2" max="32" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                <p class="text-sm dark:text-dark-text-muted mt-1">Number of players per team</p>
            </div>

            <!-- Max Participants -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Max Participants *</label>
                <input type="number" name="max_participants" value="{{ old('max_participants', 16) }}" min="2" max="512" required class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
            </div>

            <!-- Prize Pool -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Prize Pool (USD)</label>
                <input type="number" name="prize_pool" value="{{ old('prize_pool') }}" min="0" step="0.01" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Registration Opens</label>
                    <input type="datetime-local" name="registration_opens_at" value="{{ old('registration_opens_at') }}" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Registration Closes</label>
                    <input type="datetime-local" name="registration_closes_at" value="{{ old('registration_closes_at') }}" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Check-in Starts</label>
                    <input type="datetime-local" name="check_in_starts_at" value="{{ old('check_in_starts_at') }}" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Check-in Ends</label>
                    <input type="datetime-local" name="check_in_ends_at" value="{{ old('check_in_ends_at') }}" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                </div>
            </div>

            <!-- Tournament Start -->
            <div class="mb-6">
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Tournament Starts *</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" required class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
            </div>

            <!-- Options -->
            <div class="mb-8 space-y-3">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }} class="w-4 h-4">
                    <span class="text-sm dark:text-dark-text-primary">Public Tournament</span>
                </label>

                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="requires_approval" value="1" {{ old('requires_approval') ? 'checked' : '' }} class="w-4 h-4">
                    <span class="text-sm dark:text-dark-text-primary">Require Approval for Registration</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center space-x-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    Create Tournament
                </button>
                <a href="{{ route('tournaments.index') }}" class="px-6 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('tournament-type').addEventListener('change', function() {
    const teamSizeField = document.getElementById('team-size-field');
    if (this.value === 'team') {
        teamSizeField.style.display = 'block';
    } else {
        teamSizeField.style.display = 'none';
    }
});

// Show on page load if already selected
if (document.getElementById('tournament-type').value === 'team') {
    document.getElementById('team-size-field').style.display = 'block';
}
</script>
@endsection
