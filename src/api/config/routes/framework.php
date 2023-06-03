<?php declare(strict_types = 1);

use App\Constants\Enum\Environment;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    if (Environment::DEV->value === $routes->env()) {
        $routes
            ->import('@FrameworkBundle/Resources/config/routing/errors.xml')
            ->prefix('/_error');
    }
};
