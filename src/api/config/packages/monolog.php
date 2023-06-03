<?php declare(strict_types = 1);

use App\Constants\Enum\Environment;
use Monolog\Level;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Config\MonologConfig;

return static function (MonologConfig $config, ContainerConfigurator $container): void {
    $config
        ->channels([
            $deprecation = 'deprecation',
        ]);

    $config
        ->handler('main')
        ->type('stream')
        ->path('%kernel.logs_dir%/%kernel.environment%.log')
        ->level(Level::Debug->getName())
        ->channels()
            ->elements([
                '!event',
                '!' . $deprecation,
            ]);

    $config
        ->handler('console')
        ->type('console')
        ->processPsr3Messages(false)
        ->channels()
            ->elements([
                '!event',
                '!doctrine',
                '!console',
                '!' . $deprecation,
            ]);

    $config
        ->handler($deprecation)
        ->type('stream')
        ->path('%kernel.logs_dir%/%kernel.environment%-deprecation.log')
        ->channels()
            ->elements([
                $deprecation,
            ]);

    if (Environment::TEST->value === $container->env()) {
        $config
            ->handler('main')
            ->type('fingers_crossed')
            ->actionLevel(Level::Error->getName())
            ->handler('nested')
            ->excludedHttpCode(Response::HTTP_NOT_FOUND)
            ->excludedHttpCode(Response::HTTP_METHOD_NOT_ALLOWED)
            ->channels()
                ->elements([
                    '!event',
                    '!' . $deprecation,
                ]);

        $config
            ->handler('nested')
            ->type('stream')
            ->path('%kernel.logs_dir%/%kernel.environment%.log')
            ->level(Level::Debug->getName());
    }

    if (in_array($container->env(), [Environment::PROD->value, Environment::STAGE->value, ], true)) {
        $config
            ->handler('main')
            ->type('fingers_crossed')
            ->actionLevel(Level::Error->getName())
            ->handler('nested')
            ->excludedHttpCode(Response::HTTP_NOT_FOUND)
            ->excludedHttpCode(Response::HTTP_METHOD_NOT_ALLOWED)
            ->bufferSize(50)
            ->channels()
                ->elements([
                    '!' . $deprecation,
                    '!event',
                ]);

        $config
            ->handler('nested')
            ->type('rotating_file')
            ->path('%kernel.logs_dir%/%kernel.environment%-app.log')
            ->level(Level::Debug->getName())
            ->formatter('monolog.formatter.json');

        $config
            ->handler('console')
            ->type('console')
            ->processPsr3Messages(false)
            ->channels()
                ->elements([
                    '!event',
                    '!doctrine',
                    '!' . $deprecation,
                ]);

        $config
            ->handler($deprecation)
            ->type('null')
            ->channels()
                ->elements([
                    $deprecation,
                ]);
    }
};
