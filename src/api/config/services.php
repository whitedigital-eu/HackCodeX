<?php declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->parameters()
        ->set('locale', '%env(LOCALE)%')
        ->set('container.dumper.inline_factories', true)
        ->set('api_key', '%env(API_KEY)%');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/*')
        ->exclude([__DIR__ . '/../src/{DependencyInjection,Entity,Migrations,Tests,Utils,Kernel.php}']);
};
