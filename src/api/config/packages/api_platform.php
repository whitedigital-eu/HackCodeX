<?php declare(strict_types = 1);

use App\Constants\Enum\Definition;
use App\Constants\Enum\Environment;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\ApiPlatformConfig;

return static function (ApiPlatformConfig $config, ContainerConfigurator $container): void {
    $config
        ->title('HackCodeX')
        ->showWebby(false)
        ->enableReDoc(false);

    $config
        ->mapping()
        ->paths([
            '%kernel.project_dir%/src/ApiResource',
            '%kernel.project_dir%/src/Entity',
        ]);

    $formats = [
        'json' => Definition::TYPE_JSON->value,
        'jsonld' => Definition::TYPE_JSONLD->value,
        'html' => Definition::TYPE_HTML->value,
    ];

    foreach ($formats as $key => $value) {
        $config
            ->formats($key)
            ->mimeTypes([$value]);
    }

    $config
        ->patchFormats('json')
        ->mimeTypes([Definition::TYPE_JSON_MERGE->value, ]);

    $config
        ->swagger()
        ->versions(3);

    $config
        ->defaults()
        ->paginationEnabled(true)
        ->paginationClientEnabled(true)
        ->paginationItemsPerPage(30)
        ->paginationClientItemsPerPage(true)
        ->denormalizationContext(['allow_extra_attributes' => true, ]);

    if (Environment::DEV->value !== $container->env()) {
        $config
            ->enableDocs(false)
            ->enableProfiler(false);
    }
};
