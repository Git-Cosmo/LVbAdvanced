@extends('layouts.app')

@section('content')
@vite(['resources/css/casual-games.css'])
<div x-data="millionaireGame()" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Enhanced Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         :class="'toast-' + toast.type"
         class="fixed top-4 right-4 z-50 max-w-md">
        <div :class="toast.type === 'success' ? 'bg-green-500' : toast.type === 'error' ? 'bg-red-500' : 'bg-blue-500'" 
             class="rounded-lg shadow-2xl p-5 text-white relative overflow-hidden">
            <div class="flex items-start gap-3">
                <span class="toast-icon" :class="toast.type === 'success' ? 'bg-green-600' : toast.type === 'error' ? 'bg-red-600' : 'bg-blue-600'">
                    <span x-show="toast.type === 'success'">✓</span>
                    <span x-show="toast.type === 'error'">✗</span>
                    <span x-show="toast.type === 'info'">💡</span>
                </span>
                <p class="flex-1 font-medium" x-text="toast.message"></p>
            </div>
            <div class="toast-progress"></div>
        </div>
    </div>
    <!-- Prize Ladder (Right Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Game Area -->
        <div class="lg:col-span-3">
            <!-- Current Question -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 mb-6">
                <div class="text-center mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm dark:text-dark-text-tertiary">Question {{ $attempt->current_question }} of 15</span>
                        <div class="flex items-center gap-2">
                            <span class="text-sm dark:text-dark-text-tertiary">Time:</span>
                            <!-- Enhanced timer with circular progress -->
                            <div class="timer-circle" :class="timeLeft <= 10 ? 'timer-heartbeat' : ''">
                                <svg width="60" height="60" class="absolute">
                                    <circle cx="30" cy="30" r="26" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="4"/>
                                    <circle cx="30" cy="30" r="26" fill="none" 
                                            :stroke="timeLeft <= 10 ? '#ef4444' : timeLeft <= 30 ? '#f59e0b' : '#22c55e'"
                                            stroke-width="4" stroke-linecap="round"
                                            class="timer-circle-progress"
                                            :style="`stroke-dasharray: ${2 * Math.PI * 26}; stroke-dashoffset: ${2 * Math.PI * 26 * (1 - timeLeft / {{ $game->time_limit }})}`"/>
                                </svg>
                                <span x-text="formatTime(timeLeft)" 
                                      :class="timeLeft <= 10 ? 'text-red-500 font-bold' : timeLeft <= 30 ? 'text-yellow-500 font-semibold' : 'text-green-500 font-semibold'"
                                      class="absolute inset-0 flex items-center justify-center text-sm">
                                </span>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright mt-2 zoom-in">{{ $question->question }}</h2>
                </div>

                <!-- Enhanced Answer Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($question->options as $index => $option)
                        <button @click="selectAnswer({{ $index }})" 
                                id="option-{{ $index }}"
                                :class="{
                                    'answer-selected border-accent-blue bg-accent-blue/10': selectedAnswer === {{ $index }},
                                    'border-accent-blue bg-accent-blue/10': selectedAnswer === {{ $index }}
                                }"
                                class="answer-option p-4 text-left border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-blue transition-colors dark:text-dark-text-bright">
                            <span class="font-semibold mr-2">{{ chr(65 + $index) }}:</span>
                            <span>{{ $option }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button @click="submitAnswer()" 
                            id="submit-btn"
                            :disabled="selectedAnswer === null"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        Final Answer
                    </button>
                    <form action="{{ route('casual-games.millionaire.walk-away', [$game, $attempt]) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                            Walk Away (${{ number_format($attempt->prize_won) }})
                        </button>
                    </form>
                </div>
            </div>

            <!-- Enhanced Lifelines -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
                <h3 class="font-semibold dark:text-dark-text-bright mb-4">Lifelines</h3>
                <div class="grid grid-cols-3 gap-4">
                    <button @click="useLifeline('fifty_fifty')" 
                            id="lifeline-fifty-fifty"
                            {{ !$attempt->hasLifeline('fifty_fifty') ? 'disabled' : '' }}
                            :class="!{{ $attempt->hasLifeline('fifty_fifty') ? 'true' : 'false' }} ? 'lifeline-used' : ''"
                            class="lifeline-btn p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:cursor-not-allowed">
                        <div class="lifeline-icon text-2xl mb-2">✂️</div>
                        <div class="text-sm dark:text-dark-text-secondary">50:50</div>
                    </button>
                    <button @click="useLifeline('phone_friend')" 
                            id="lifeline-phone-friend"
                            {{ !$attempt->hasLifeline('phone_friend') ? 'disabled' : '' }}
                            :class="!{{ $attempt->hasLifeline('phone_friend') ? 'true' : 'false' }} ? 'lifeline-used' : ''"
                            class="lifeline-btn p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:cursor-not-allowed">
                        <div class="lifeline-icon text-2xl mb-2" :class="phoneRinging ? 'phone-ringing' : ''">📞</div>
                        <div class="text-sm dark:text-dark-text-secondary">Phone Friend</div>
                    </button>
                    <button @click="useLifeline('ask_audience')" 
                            id="lifeline-ask-audience"
                            {{ !$attempt->hasLifeline('ask_audience') ? 'disabled' : '' }}
                            :class="!{{ $attempt->hasLifeline('ask_audience') ? 'true' : 'false' }} ? 'lifeline-used' : ''"
                            class="lifeline-btn p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:cursor-not-allowed">
                        <div class="lifeline-icon text-2xl mb-2">👥</div>
                        <div class="text-sm dark:text-dark-text-secondary">Ask Audience</div>
                    </button>
                </div>
                
                <!-- Phone Friend Speech Bubble -->
                <div x-show="phoneFriendSuggestion" x-transition class="mt-4 speech-bubble">
                    <p class="text-sm dark:text-dark-text-bright" x-text="phoneFriendSuggestion"></p>
                </div>
                
                <!-- Ask Audience Bar Chart -->
                <div x-show="audienceVotes" x-transition class="mt-4">
                    <div class="flex items-end justify-around gap-2 h-32">
                        <template x-for="(vote, index) in audienceVotes" :key="index">
                            <div class="flex flex-col items-center flex-1">
                                <div class="audience-bar w-full bg-accent-purple rounded-t" 
                                     :style="`height: ${vote}%`"></div>
                                <span class="text-xs dark:text-dark-text-secondary mt-1" x-text="String.fromCharCode(65 + index)"></span>
                                <span class="text-xs dark:text-dark-text-tertiary" x-text="vote + '%'"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Prize Ladder -->
        <div class="lg:col-span-1">
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-4 sticky top-4">
                <h3 class="font-semibold dark:text-dark-text-bright mb-4 text-center">Prize Money</h3>
                <div class="space-y-2">
                    @php
                        $prizes = [
                            15 => 1000000, 14 => 500000, 13 => 250000, 12 => 125000, 11 => 64000,
                            10 => 32000, 9 => 16000, 8 => 8000, 7 => 4000, 6 => 2000,
                            5 => 1000, 4 => 500, 3 => 300, 2 => 200, 1 => 100
                        ];
                    @endphp
                    @foreach(range(15, 1) as $level)
                        <div class="flex items-center justify-between p-2 rounded relative
                                    {{ $attempt->current_question == $level ? 'bg-yellow-500/20 border border-yellow-500 prize-current' : 'dark:bg-dark-bg-tertiary' }} 
                                    {{ in_array($level, [5, 10]) ? 'font-semibold prize-safe-haven' : '' }}">
                            <span class="text-sm dark:text-dark-text-secondary">{{ $level }}</span>
                            <span class="text-sm dark:text-dark-text-bright">${{ number_format($prizes[$level]) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
import confetti from 'canvas-confetti';

window.millionaireGame = function() {
    return {
        selectedAnswer: null,
        timeLeft: {{ $game->time_limit }},
        timerInterval: null,
        phoneRinging: false,
        phoneFriendSuggestion: '',
        audienceVotes: null,
        toast: {
            show: false,
            message: '',
            type: 'success'
        },
        
        init() {
            this.startTimer();
        },
        
        startTimer() {
            this.timerInterval = setInterval(() => {
                this.timeLeft--;
                if (this.timeLeft <= 0) {
                    clearInterval(this.timerInterval);
                    this.showToast('Time is up!', 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route('casual-games.millionaire.result', [$game, $attempt]) }}';
                    }, 2000);
                }
            }, 1000);
        },
        
        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        },
        
        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => {
                this.toast.show = false;
            }, 3000);
        },
        
        selectAnswer(index) {
            this.selectedAnswer = index;
        },
        
        submitAnswer() {
            if (this.selectedAnswer === null) return;
            
            // Add lock-in animation
            const selectedOption = document.getElementById(`option-${this.selectedAnswer}`);
            selectedOption.classList.add('answer-locked');
            
            clearInterval(this.timerInterval);
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner inline-block w-5 h-5 border-2 border-white border-t-transparent rounded-full"></span> Checking...';

            fetch('{{ route('casual-games.millionaire.answer', [$game, $attempt]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ answer: this.selectedAnswer })
            })
            .then(response => response.json())
            .then(data => {
                if (data.correct) {
                    // Show correct answer animation
                    selectedOption.classList.add('answer-correct');
                    
                    // Trigger confetti
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 },
                        colors: ['#22c55e', '#4ade80', '#86efac']
                    });
                    
                    // Add milestone flash if at safe haven
                    const currentLevel = {{ $attempt->current_question }};
                    if ([5, 10, 15].includes(currentLevel)) {
                        const prizeElement = document.querySelector('.prize-current');
                        if (prizeElement) {
                            prizeElement.classList.add('prize-milestone-flash');
                        }
                        
                        // Extra confetti for milestones
                        setTimeout(() => {
                            confetti({
                                particleCount: 150,
                                spread: 100,
                                origin: { y: 0.5 },
                                colors: ['#eab308', '#fbbf24', '#fde047']
                            });
                        }, 300);
                    }
                    
                    this.showToast(`Correct! You won $${data.prize_won.toLocaleString()}`, 'success');
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    // Show wrong answer animation
                    selectedOption.classList.add('answer-wrong');
                    
                    // Fade out incorrect options
                    document.querySelectorAll('.answer-option').forEach((option, idx) => {
                        if (idx !== data.correct_answer) {
                            option.classList.add('answer-fade-out');
                        } else {
                            option.classList.add('answer-correct');
                        }
                    });
                    
                    this.showToast(`Wrong answer! Final prize: $${data.final_prize.toLocaleString()}`, 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route('casual-games.millionaire.result', [$game, $attempt]) }}';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('An error occurred. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Final Answer';
                selectedOption.classList.remove('answer-locked');
                this.startTimer();
            });
        },
        
        useLifeline(type) {
            fetch('{{ route('casual-games.millionaire.lifeline', [$game, $attempt]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ lifeline: type })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.type === 'fifty_fifty') {
                    // Animate fade-out of removed answers
                    data.remove_indices.forEach(index => {
                        const option = document.getElementById(`option-${index}`);
                        option.classList.add('answer-fade-out');
                        setTimeout(() => {
                            option.style.display = 'none';
                        }, 800);
                    });
                    this.showToast('50:50 lifeline used!', 'success');
                } else if (data.type === 'phone_friend') {
                    // Show phone ringing animation
                    this.phoneRinging = true;
                    setTimeout(() => {
                        this.phoneRinging = false;
                        const option = String.fromCharCode(65 + data.suggested_index);
                        this.phoneFriendSuggestion = `Your friend thinks the answer is ${option} (${data.confidence}% confident)`;
                        this.showToast(`Phone a Friend used!`, 'info');
                    }, 2400);
                } else if (data.type === 'ask_audience') {
                    // Show audience bar chart
                    const votes = [0, 0, 0, 0];
                    Object.keys(data.distribution).forEach(key => {
                        votes[parseInt(key)] = data.distribution[key];
                    });
                    this.audienceVotes = votes;
                    this.showToast('Ask the Audience used!', 'info');
                }
                
                // Mark lifeline as used
                const lifelineBtn = document.getElementById(`lifeline-${type.replace('_', '-')}`);
                lifelineBtn.disabled = true;
                lifelineBtn.classList.add('lifeline-used');
            })
            .catch(error => {
                console.error('Error using lifeline:', error);
                this.showToast('Failed to use lifeline. Please try again.', 'error');
            });
        }
    }
}
</script>
@endsection
