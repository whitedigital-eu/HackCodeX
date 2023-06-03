<?php declare(strict_types = 1);

use App\Constants\Enum\Environment;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    if (Environment::DEV->value === $routes->env()) {
        $routes
            ->import('@WebProfilerBundle/Resources/config/routing/wdt.xml')
            ->prefix('/_wdt');

        $routes
            ->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')
            ->prefix('/_profiler');
    }
};
