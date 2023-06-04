<?php declare(strict_types = 1);

namespace App\Service;

use OpenAI;
use OpenAI\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OpenAIService
{
    private readonly Client $ai;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->ai = OpenAI::client($bag->get('api_key'));
    }

    public function generateImageBasedOnPrompt(string $prompt): string
    {
        $image = $this->ai->images()->create([
            'prompt' => $prompt,
            'n' => 1,
        ]);

        return $image->data[0]->url;
    }

    public function generateImageGenerationPromptBasedOnCharacteristics(array $characteristics): string
    {
        $response = $this->ai->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Give me an image description, that is no longer than 30 words and does not include humans, based on these characteristics: ' . implode(', ',
                        $characteristics),
                ],
            ],
        ]);

        return $response->choices[0]->message->content;
    }
}
