<?php declare(strict_types = 1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\School;
use App\Provider\SummaryProvider;

#[
    ApiResource(
        shortName: 'Summary',
        operations: [
            new GetCollection(
                uriTemplate: '/summary/{school}',
                write: false,
            ),
        ],
        provider: SummaryProvider::class,
    ),
]
class SummaryResource
{
    public ?School $school = null;

    public int $languages = 0;

    public int $sport = 0;

    public int $math = 0;

    public int $physics = 0;

    public int $geography = 0;

    public int $chemistry = 0;

    public int $computers = 0;

    public int $music = 0;

    public int $crafts = 0;

    public int $religion = 0;

    public int $art = 0;
}
