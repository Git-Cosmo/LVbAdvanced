@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Prize Ladder (Right Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Game Area -->
        <div class="lg:col-span-3">
            <!-- Current Question -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 mb-6">
                <div class="text-center mb-6">
                    <span class="text-sm dark:text-dark-text-tertiary">Question {{ $attempt->current_question }} of 15</span>
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright mt-2">{{ $question->question }}</h2>
                </div>

                <!-- Answer Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($question->options as $index => $option)
                        <button onclick="selectAnswer({{ $index }})" 
                                id="option-{{ $index }}"
                                class="answer-option p-4 text-left border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-blue transition-colors dark:text-dark-text-bright">
                            <span class="font-semibold mr-2">{{ chr(65 + $index) }}:</span>
                            <span>{{ $option }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button onclick="submitAnswer()" 
                            id="submit-btn"
                            disabled
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

            <!-- Lifelines -->
            <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
                <h3 class="font-semibold dark:text-dark-text-bright mb-4">Lifelines</h3>
                <div class="grid grid-cols-3 gap-4">
                    <button onclick="useLifeline('fifty_fifty')" 
                            id="lifeline-fifty-fifty"
                            {{ !$attempt->hasLifeline('fifty_fifty') ? 'disabled' : '' }}
                            class="p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
                        <div class="text-2xl mb-2">✂️</div>
                        <div class="text-sm dark:text-dark-text-secondary">50:50</div>
                    </button>
                    <button onclick="useLifeline('phone_friend')" 
                            id="lifeline-phone-friend"
                            {{ !$attempt->hasLifeline('phone_friend') ? 'disabled' : '' }}
                            class="p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
                        <div class="text-2xl mb-2">📞</div>
                        <div class="text-sm dark:text-dark-text-secondary">Phone Friend</div>
                    </button>
                    <button onclick="useLifeline('ask_audience')" 
                            id="lifeline-ask-audience"
                            {{ !$attempt->hasLifeline('ask_audience') ? 'disabled' : '' }}
                            class="p-4 text-center border-2 dark:border-dark-border-primary rounded-lg hover:border-accent-purple transition-colors disabled:opacity-30 disabled:cursor-not-allowed">
                        <div class="text-2xl mb-2">👥</div>
                        <div class="text-sm dark:text-dark-text-secondary">Ask Audience</div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Prize Ladder -->
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
                        <div class="flex items-center justify-between p-2 rounded {{ $attempt->current_question == $level ? 'bg-yellow-500/20 border border-yellow-500' : 'dark:bg-dark-bg-tertiary' }} {{ in_array($level, [5, 10]) ? 'font-semibold' : '' }}">
                            <span class="text-sm dark:text-dark-text-secondary">{{ $level }}</span>
                            <span class="text-sm dark:text-dark-text-bright">${{ number_format($prizes[$level]) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedAnswer = null;

function selectAnswer(index) {
    selectedAnswer = index;
    document.querySelectorAll('.answer-option').forEach(btn => {
        btn.classList.remove('border-accent-blue', 'bg-accent-blue/10');
    });
    const selected = document.getElementById(`option-${index}`);
    selected.classList.add('border-accent-blue', 'bg-accent-blue/10');
    document.getElementById('submit-btn').disabled = false;
}

function submitAnswer() {
    if (selectedAnswer === null) return;
    
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Checking...';

    fetch('{{ route('casual-games.millionaire.answer', [$game, $attempt]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ answer: selectedAnswer })
    })
    .then(response => response.json())
    .then(data => {
        if (data.correct) {
            alert(`Correct! You won $${data.prize_won.toLocaleString()}`);
            window.location.reload();
        } else {
            alert(`Wrong answer! Final prize: $${data.final_prize.toLocaleString()}`);
            window.location.href = '{{ route('casual-games.millionaire.result', [$game, $attempt]) }}';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Final Answer';
    });
}

function useLifeline(type) {
    fetch('{{ route('casual-games.millionaire.lifeline', [$game, $attempt]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ lifeline: type })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.type === 'fifty_fifty') {
            data.remove_indices.forEach(index => {
                document.getElementById(`option-${index}`).style.display = 'none';
            });
        } else if (data.type === 'phone_friend') {
            const option = String.fromCharCode(65 + data.suggested_index);
            alert(`Your friend thinks the answer is ${option} (${data.confidence}% confident)`);
        } else if (data.type === 'ask_audience') {
            let message = 'Audience votes:\n';
            Object.keys(data.distribution).forEach(key => {
                message += `${String.fromCharCode(65 + parseInt(key))}: ${data.distribution[key]}%\n`;
            });
            alert(message);
        }
        document.getElementById(`lifeline-${type.replace('_', '-')}`).disabled = true;
    })
    .catch(error => {
        console.error('Error using lifeline:', error);
        alert('Failed to use lifeline. Please try again.');
    });
}
</script>
@endsection
