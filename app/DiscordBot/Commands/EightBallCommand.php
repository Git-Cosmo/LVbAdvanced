<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Log;

class EightBallCommand extends BaseCommand
{
    /**
     * Magic 8-ball responses.
     */
    protected array $responses = [
        // Positive responses
        'It is certain.',
        'It is decidedly so.',
        'Without a doubt.',
        'Yes - definitely.',
        'You may rely on it.',
        'As I see it, yes.',
        'Most likely.',
        'Outlook good.',
        'Yes.',
        'Signs point to yes.',
        
        // Non-committal responses
        'Reply hazy, try again.',
        'Ask again later.',
        'Better not tell you now.',
        'Cannot predict now.',
        'Concentrate and ask again.',
        
        // Negative responses
        'Don\'t count on it.',
        'My reply is no.',
        'My sources say no.',
        'Outlook not so good.',
        'Very doubtful.',
    ];

    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return '8ball';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Ask the magic 8-ball a question';
    }

    /**
     * Execute the 8-ball command.
     */
    public function execute(Message $message, string $args): void
    {
        $question = trim($args);
        
        if (empty($question)) {
            $message->reply('❌ Please ask a question! Example: `!8ball Will I win my next game?`');
            return;
        }
        
        $answer = $this->responses[array_rand($this->responses)];
        
        $response = "🎱 **Question:** {$question}\n**Answer:** {$answer}";
        
        $message->reply($response);
        
        Log::info('8-ball command executed', [
            'user' => $message->author->username,
            'question' => $question,
            'answer' => $answer,
        ]);
    }
}
