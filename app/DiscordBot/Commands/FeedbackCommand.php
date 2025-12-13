<?php

namespace App\DiscordBot\Commands;

use Discord\Builders\Components\ActionRow;
use Discord\Builders\Components\Button;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Message;
use Discord\Parts\Interactions\Interaction;
use Illuminate\Support\Facades\Log;

class FeedbackCommand extends BaseCommand
{
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'feedback';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Submit feedback to the website team';
    }

    /**
     * Execute the feedback command.
     */
    public function execute(Message $message, string $args): void
    {
        // Create an interactive button message
        $builder = MessageBuilder::new()
            ->setContent('📝 **Submit Feedback**\n\nClick the button below to open the feedback form!')
            ->addComponent(
                ActionRow::new()->addComponent(
                    Button::new(Button::STYLE_PRIMARY)
                        ->setLabel('Open Feedback Form')
                        ->setCustomId('feedback_button_' . $message->author->id)
                )
            );

        $message->channel->sendMessage($builder)->then(function (Message $sentMessage) use ($message) {
            Log::info('Feedback button sent', [
                'user' => $message->author->username,
                'message_id' => $sentMessage->id,
            ]);
        });

        // Note: Modal interaction handling would be registered in the Discord bot service
        // This demonstrates the button component which can trigger modals
        // Full modal implementation requires interaction handlers to be set up
    }

    /**
     * Handle the feedback button interaction (would be called from interaction handler).
     */
    public function handleFeedbackButton(Interaction $interaction): void
    {
        // This is where modal would be shown
        // Modal form would include:
        // - Feedback Type (select: Bug Report, Feature Request, General Feedback)
        // - Subject (text input)
        // - Description (paragraph text input)
        // - Contact Email (optional text input)
        
        // For now, we'll send a simple response
        $contactUrl = route('contact', [], true); // Generate absolute URL
        $interaction->respondWithMessage(
            MessageBuilder::new()
                ->setContent('✅ Thank you for your interest in providing feedback! ' . 
                           'Please visit our website at ' . $contactUrl . ' to submit detailed feedback.')
                ->setEphemeral(true)
        );

        Log::info('Feedback button clicked', [
            'user' => $interaction->user->username,
            'user_id' => $interaction->user->id,
        ]);
    }
}
