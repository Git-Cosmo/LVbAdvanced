<?php

namespace App\DiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TriviaCommand extends BaseCommand
{
    protected Discord $discord;

    public function __construct(Discord $discord)
    {
        $this->discord = $discord;
    }
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'trivia';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Get a random gaming trivia question';
    }

    /**
     * Execute the trivia command.
     */
    public function execute(Message $message, string $args): void
    {
        try {
            // Fetch a trivia question from Open Trivia Database (video games category)
            $response = Http::timeout(5)->get('https://opentdb.com/api.php', [
                'amount' => 1,
                'category' => 15, // Video Games category
                'type' => 'multiple',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['results'][0])) {
                    $trivia = $data['results'][0];
                    $question = html_entity_decode($trivia['question']);
                    $correctAnswer = html_entity_decode($trivia['correct_answer']);
                    $incorrectAnswers = array_map('html_entity_decode', $trivia['incorrect_answers']);
                    
                    // Shuffle answers
                    $allAnswers = array_merge([$correctAnswer], $incorrectAnswers);
                    shuffle($allAnswers);
                    
                    // Format answers with letters
                    $answersText = '';
                    $letters = ['A', 'B', 'C', 'D'];
                    foreach ($allAnswers as $index => $answer) {
                        $answersText .= "\n{$letters[$index]}. {$answer}";
                    }
                    
                    $difficulty = ucfirst($trivia['difficulty']);
                    
                    $questionText = "🎮 **Gaming Trivia ({$difficulty})**\n\n{$question}{$answersText}\n\n*Answer will be revealed in 30 seconds...*";
                    
                    $message->channel->sendMessage($questionText);
                    
                    // Use Discord's event loop timer for async delay
                    $this->discord->getLoop()->addTimer(30, function () use ($message, $correctAnswer) {
                        $message->channel->sendMessage("✅ **Correct Answer:** {$correctAnswer}");
                    });
                    
                    Log::info('Trivia command executed', [
                        'user' => $message->author->username,
                        'channel' => $message->channel_id,
                    ]);
                } else {
                    $message->reply('❌ No trivia question available. Please try again later.');
                }
            } else {
                $message->reply('❌ Failed to fetch trivia question. Please try again later.');
                Log::warning('Trivia API returned non-successful response', [
                    'status' => $response->status(),
                ]);
            }
        } catch (\Exception $e) {
            $message->reply('❌ An error occurred while fetching trivia question.');
            Log::error('Trivia command failed', [
                'error' => $e->getMessage(),
                'user' => $message->author->username,
            ]);
        }
    }
}
