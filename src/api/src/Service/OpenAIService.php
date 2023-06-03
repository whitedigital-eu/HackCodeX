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

    public function test(): string
    {
    }
}
