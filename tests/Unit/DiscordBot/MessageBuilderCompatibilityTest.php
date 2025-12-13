<?php

namespace Tests\Unit\DiscordBot;

use Discord\Builders\MessageBuilder;
use Discord\Builders\Components\Button;
use Tests\TestCase;

/**
 * Test that MessageBuilder can use addComponent without fatal errors.
 * This test specifically addresses the issue with ComponentsTrait type mismatch.
 */
class MessageBuilderCompatibilityTest extends TestCase
{
    public function test_message_builder_can_add_component_without_error(): void
    {
        // This would previously throw a fatal error:
        // "Declaration of Discord\Builders\MessageBuilder::addComponent(Discord\Builders\Components\ComponentObject $component): 
        // Discord\Builders\MessageBuilder must be compatible with Discord\Builders\ComponentsTrait::addComponent($component)"
        
        $builder = MessageBuilder::new();
        $button = Button::new(Button::STYLE_PRIMARY);
        $button->setLabel('Test Button');
        
        // Should not throw a fatal error
        $result = $builder->addComponent($button);
        
        // Builder should return itself for chaining
        $this->assertInstanceOf(MessageBuilder::class, $result);
    }

    public function test_message_builder_can_chain_component_additions(): void
    {
        $builder = MessageBuilder::new()
            ->setContent('Test message')
            ->addComponent(
                Button::new(Button::STYLE_PRIMARY)->setLabel('Button 1')
            );
        
        $this->assertInstanceOf(MessageBuilder::class, $builder);
    }
}
