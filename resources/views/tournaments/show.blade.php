@extends('layouts.app')

@section('title', $tournament->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Tournament Header -->
    <div class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden mb-8">
        <!-- Banner -->
        <div class="h-64 bg-gradient-to-br from-accent-blue to-accent-purple relative">
            @if($tournament->cover_image)
                <img src="{{ $tournament->cover_image }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover">
            @endif
            
            <!-- Status Badge -->
            <div class="absolute top-4 right-4 px-4 py-2 rounded-lg text-white font-bold backdrop-blur-sm
                {{ $tournament->status === 'registration_open' ? 'bg-green-600/80' : '' }}
                {{ $tournament->status === 'in_progress' ? 'bg-blue-600/80' : '' }}
                {{ $tournament->status === 'completed' ? 'bg-gray-600/80' : '' }}">
                {{ str_replace('_', ' ', strtoupper($tournament->status)) }}
            </div>
            
            <!-- Back Button -->
            <a href="{{ route('tournaments.index') }}" class="absolute top-4 left-4 px-3 py-2 bg-black/50 backdrop-blur-sm rounded text-white hover:bg-black/70 transition-colors">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back</span>
                </div>
            </a>
        </div>
        
        <!-- Tournament Info -->
        <div class="p-8">
            <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-2">{{ $tournament->name }}</h1>
            
            @if($tournament->game)
                <p class="text-accent-blue font-medium text-lg mb-4">{{ $tournament->game }}</p>
            @endif
            
            <p class="dark:text-dark-text-secondary mb-6">{{ $tournament->description }}</p>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-4">
                @auth
                    @if($tournament->canRegister() && !$userParticipant)
                        <button x-data @click="$dispatch('open-register-modal')" class="px-6 py-3 bg-gradient-to-r from-accent-green to-accent-teal text-white rounded-lg font-medium hover:shadow-lg transition-all">
                            Register Now
                        </button>
                    @elseif($userParticipant && $userParticipant->status === 'approved' && $tournament->canCheckIn())
                        <form method="POST" action="{{ route('tournaments.check-in', $tournament) }}">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-orange to-accent-red text-white rounded-lg font-medium hover:shadow-lg transition-all">
                                Check In
                            </button>
                        </form>
                    @elseif($userParticipant)
                        <div class="px-6 py-3 bg-gray-600 text-white rounded-lg font-medium">
                            Status: {{ ucfirst($userParticipant->status) }}
                        </div>
                    @endif
                @endauth
                
                <a href="{{ route('tournaments.bracket', $tournament) }}" class="px-6 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                    View Bracket
                </a>
                
                <a href="{{ route('tournaments.participants', $tournament) }}" class="px-6 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                    View Participants
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Tournament Details -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h2 class="text-xl font-bold dark:text-dark-text-bright mb-6">Tournament Details</h2>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm dark:text-dark-text-secondary mb-1">Format</div>
                        <div class="font-semibold dark:text-dark-text-bright capitalize">
                            {{ str_replace('_', ' ', $tournament->format) }}
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm dark:text-dark-text-secondary mb-1">Type</div>
                        <div class="font-semibold dark:text-dark-text-bright capitalize">
                            {{ $tournament->type }}
                            @if($tournament->team_size)
                                ({{ $tournament->team_size }}v{{ $tournament->team_size }})
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm dark:text-dark-text-secondary mb-1">Participants</div>
                        <div class="font-semibold dark:text-dark-text-bright">
                            {{ $tournament->current_participants }}/{{ $tournament->max_participants }}
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm dark:text-dark-text-secondary mb-1">Prize Pool</div>
                        <div class="font-semibold text-accent-green">
                            @if($tournament->prize_pool)
                                ${{ number_format($tournament->prize_pool, 0) }}
                            @else
                                No prize pool
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm dark:text-dark-text-secondary mb-1">Starts At</div>
                        <div class="font-semibold dark:text-dark-text-bright">
                            {{ $tournament->starts_at->format('M d, Y g:i A') }}
                        </div>
                    </div>
                    
                    @if($tournament->registration_closes_at)
                        <div>
                            <div class="text-sm dark:text-dark-text-secondary mb-1">Registration Closes</div>
                            <div class="font-semibold dark:text-dark-text-bright">
                                {{ $tournament->registration_closes_at->format('M d, Y g:i A') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Announcements -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h2 class="text-xl font-bold dark:text-dark-text-bright mb-6">Announcements</h2>
                
                @auth
                    <form method="POST" action="{{ route('tournaments.announcements.store', $tournament) }}" class="mb-6">
                        @csrf
                        <textarea name="message" rows="3" placeholder="Post an announcement..." class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary mb-2" required></textarea>
                        <button type="submit" class="px-4 py-2 bg-accent-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Post
                        </button>
                    </form>
                @endauth
                
                <div class="space-y-4">
                    @forelse($tournament->announcements->sortByDesc('created_at')->take(10) as $announcement)
                        <div class="p-4 dark:bg-dark-bg-tertiary rounded-lg {{ $announcement->is_official ? 'border-2 border-accent-blue' : '' }}">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($announcement->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold dark:text-dark-text-bright">
                                        {{ $announcement->user->name }}
                                        @if($announcement->is_official)
                                            <span class="ml-2 px-2 py-0.5 bg-accent-blue text-white text-xs rounded">OFFICIAL</span>
                                        @endif
                                    </div>
                                    <div class="text-xs dark:text-dark-text-muted">{{ $announcement->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <p class="dark:text-dark-text-secondary">{{ $announcement->message }}</p>
                        </div>
                    @empty
                        <p class="text-center dark:text-dark-text-secondary py-8">No announcements yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Organizer -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Organizer</h3>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-orange to-accent-red flex items-center justify-center text-white font-bold">
                        {{ substr($tournament->organizer->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold dark:text-dark-text-bright">{{ $tournament->organizer->name }}</div>
                        <div class="text-sm dark:text-dark-text-secondary">Tournament Host</div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Total Matches:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->matches->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Completed:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->matches->where('status', 'completed')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Checked In:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->participants->where('status', 'checked_in')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Staff:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $tournament->staff->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    @auth
        @if($tournament->canRegister() && !$userParticipant)
            <div x-data="{ open: false }" @open-register-modal.window="open = true" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div @click="open = false" class="fixed inset-0 bg-black opacity-50"></div>
                    
                    <div class="relative dark:bg-dark-bg-secondary rounded-lg shadow-xl max-w-2xl w-full p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold dark:text-dark-text-bright">Register for Tournament</h3>
                            <button @click="open = false" class="dark:text-dark-text-secondary hover:text-dark-text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('tournaments.register', $tournament) }}">
                            @csrf

                            @if($tournament->type === 'team')
                                <!-- Team Name -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Team Name *</label>
                                    <input type="text" name="team_name" required class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                                </div>

                                <!-- Team Roster -->
                                <div class="mb-6" x-data="{ members: [{ name: '', role: '' }] }">
                                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">
                                        Team Roster (Optional)
                                        @if($tournament->team_size)
                                            <span class="text-xs dark:text-dark-text-muted">Max {{ $tournament->team_size - 1 }} additional members</span>
                                        @endif
                                    </label>
                                    
                                    <template x-for="(member, index) in members" :key="index">
                                        <div class="flex space-x-2 mb-2">
                                            <input type="text" :name="'roster[' + index + '][name]'" x-model="member.name" placeholder="Player Name" class="flex-1 px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                                            <input type="text" :name="'roster[' + index + '][role]'" x-model="member.role" placeholder="Role (optional)" class="w-32 px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                                            <button type="button" @click="members.splice(index, 1)" x-show="members.length > 1" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>

                                    <button type="button" @click="members.push({ name: '', role: '' })" class="mt-2 px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded hover:bg-dark-bg-elevated transition-colors text-sm">
                                        + Add Team Member
                                    </button>
                                </div>
                            @endif

                            <div class="p-4 dark:bg-dark-bg-tertiary rounded-lg mb-6">
                                <p class="text-sm dark:text-dark-text-secondary">
                                    @if($tournament->requires_approval)
                                        <strong>Note:</strong> Your registration will be reviewed by the tournament organizer before approval.
                                    @else
                                        You will be automatically registered for this tournament.
                                    @endif
                                </p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-accent-green to-accent-teal text-white rounded-lg font-medium hover:shadow-lg transition-all">
                                    Submit Registration
                                </button>
                                <button type="button" @click="open = false" class="px-6 py-3 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth
</div>
@endsection
