@extends('layouts.app')

@section('content')
<div x-data="wordScrambleGame()" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="toast.type === 'success' ? 'bg-green-500' : toast.type === 'error' ? 'bg-red-500' : 'bg-blue-500'" 
             class="rounded-lg shadow-lg p-4 text-white">
            <p x-text="toast.message"></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Game Area -->
        <div class="lg:col-span-3">
            <!-- Progress Header -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-sm dark:text-dark-text-tertiary">Word <span x-text="currentWordNum"></span> of {{ $totalWords }}</span>
                        <div class="text-3xl font-bold text-purple-500 mt-1" x-text="formatScore(totalScore)"></div>
                    </div>
                    <div class="text-center">
                        <span class="text-sm dark:text-dark-text-tertiary">Time Left</span>
                        <div class="text-3xl font-bold mt-1" 
                             :class="timeLeft <= 10 ? 'text-red-500 animate-pulse' : 'text-green-500'"
                             x-text="timeLeft + 's'"></div>
                    </div>
                </div>
            </div>

            <!-- Word Display -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 mb-6">
                <!-- Category & Icon -->
                <div class="text-center mb-6">
                    <div class="text-6xl mb-2" x-text="categoryIcon"></div>
                    <span class="px-3 py-1 text-sm rounded bg-purple-500/20 text-purple-400" x-text="categoryLabel"></span>
                </div>

                <!-- Scrambled Word -->
                <div class="text-center mb-8">
                    <div class="text-5xl font-bold dark:text-dark-text-bright tracking-widest mb-4">
                        {{ $word->scrambled_word }}
                    </div>
                    
                    <!-- Hint Display -->
                    <div x-show="hintShown" x-transition class="text-2xl text-yellow-500 font-mono mb-4" x-text="hintText"></div>
                    <div x-show="customHintShown" x-transition class="text-sm text-blue-400 italic" x-text="customHintText"></div>
                </div>

                <!-- Answer Input -->
                <div class="max-w-md mx-auto mb-6">
                    <input type="text" 
                           x-model="answer"
                           @keyup.enter="submitAnswer()"
                           placeholder="Type your answer here..."
                           class="w-full px-4 py-3 bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg text-center text-2xl font-semibold dark:text-dark-text-bright uppercase focus:border-purple-500 focus:outline-none"
                           autofocus>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 max-w-md mx-auto">
                    <button @click="submitAnswer()" 
                            :disabled="!answer"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        Submit
                    </button>
                    <button @click="useHint()" 
                            :disabled="hintUsedCount >= 2"
                            class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                        💡 Hint <span x-show="hintUsedCount > 0" x-text="'(' + hintUsedCount + ')'"></span>
                    </button>
                    <button @click="skipWord()" 
                            class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                        Skip
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Sidebar -->
        <div class="lg:col-span-1">
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 sticky top-4">
                <h3 class="font-semibold dark:text-dark-text-bright mb-4">Progress</h3>
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="dark:text-dark-text-tertiary">Solved</span>
                        <span class="text-green-500 font-bold" x-text="wordsSolved"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="dark:text-dark-text-tertiary">Skipped</span>
                        <span class="text-yellow-500 font-bold" x-text="wordsSkipped"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="dark:text-dark-text-tertiary">Hints Used</span>
                        <span class="text-blue-500 font-bold" x-text="totalHintsUsed"></span>
                    </div>
                </div>

                <div class="border-t dark:border-dark-border-primary pt-4">
                    <div class="text-center">
                        <div class="text-sm dark:text-dark-text-tertiary mb-1">Current Score</div>
                        <div class="text-3xl font-bold text-purple-500" x-text="formatScore(totalScore)"></div>
                    </div>
                </div>

                <!-- Score Info -->
                <div class="mt-6 p-3 dark:bg-dark-bg-tertiary rounded text-xs dark:text-dark-text-tertiary space-y-1">
                    <div>Base: {{ $game->points_per_word }} pts</div>
                    <div>Time bonus: up to 50%</div>
                    <div>Hint penalty: -{{ $game->hint_penalty }} pts</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function wordScrambleGame() {
    return {
        answer: '',
        timeLeft: {{ $game->time_per_word }},
        timerInterval: null,
        totalScore: {{ $attempt->total_score }},
        currentWordNum: {{ $attempt->current_word_index + 1 }},
        wordsSolved: {{ $attempt->words_solved }},
        wordsSkipped: {{ count($attempt->skipped_words ?? []) }},
        totalHintsUsed: {{ $attempt->hints_used }},
        hintUsedCount: 0,
        hintShown: false,
        hintText: '',
        customHintShown: false,
        customHintText: '',
        categoryIcon: '{{ $word->category_icon }}',
        categoryLabel: '{{ ucfirst(str_replace('_', ' ', $word->category)) }}',
        startTime: Date.now(),
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
                    this.showToast('Time is up! Skipping to next word...', 'error');
                    setTimeout(() => this.skipWord(), 2000);
                }
            }, 1000);
        },
        
        formatScore(score) {
            return score.toLocaleString() + ' pts';
        },
        
        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => {
                this.toast.show = false;
            }, 3000);
        },
        
        submitAnswer() {
            if (!this.answer) return;
            
            clearInterval(this.timerInterval);
            const timeTaken = Math.floor((Date.now() - this.startTime) / 1000);

            fetch('{{ route('casual-games.word-scramble.solve', [$game, $attempt]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    answer: this.answer,
                    time_taken: timeTaken,
                    hints_used: this.hintUsedCount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.correct) {
                    this.showToast(`Correct! +${data.score} points`, 'success');
                    this.totalScore = data.total_score;
                    this.wordsSolved++;
                    this.totalHintsUsed += this.hintUsedCount;
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    this.showToast(`Wrong! The answer was: ${data.correct_answer}`, 'error');
                    setTimeout(() => window.location.reload(), 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('An error occurred. Please try again.', 'error');
                this.startTimer();
            });
        },
        
        useHint() {
            if (this.hintUsedCount >= 2) return;
            
            this.hintUsedCount++;
            
            fetch('{{ route('casual-games.word-scramble.hint', [$game, $attempt]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.hintShown = true;
                this.hintText = data.hint;
                if (data.custom_hint) {
                    this.customHintShown = true;
                    this.customHintText = data.custom_hint;
                }
                this.showToast(`Hint revealed! -${data.penalty} points`, 'info');
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('Failed to get hint.', 'error');
            });
        },
        
        skipWord() {
            clearInterval(this.timerInterval);
            
            fetch('{{ route('casual-games.word-scramble.skip', [$game, $attempt]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.wordsSkipped++;
                this.showToast('Word skipped!', 'info');
                setTimeout(() => window.location.reload(), 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('Failed to skip word.', 'error');
            });
        }
    }
}
</script>
@endsection
