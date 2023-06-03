<?php declare(strict_types = 1);

use App\Constants\Enum\Environment;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config, ContainerConfigurator $container): void {
    $config
        ->httpMethodOverride(true)
        ->trustedProxies('127.0.0.1, REMOTE_ADDR')
        ->trustedHeaders(['x-forwarded-for', 'x-forwarded-host', 'x-forwarded-proto', 'x-forwarded-port', 'x-forwarded-prefix', ])
        ->secret('%env(APP_SECRET)%')
        ->phpErrors()
            ->log();

    $config
        ->session()
//            ->handlerId(NativeFileSessionHandler::class)
            ->cookieSecure(true)
            ->cookieSamesite(Cookie::SAMESITE_LAX)
            ->gcMaxlifetime('%env(SESSION_LIFETIME)%');

    $config
        ->validation()
            ->emailValidationMode(Email::VALIDATION_MODE_HTML5);

    $config
        ->defaultLocale('%locale%')
        ->translator()
            ->fallbacks(['lv', 'ru', 'en', ])
            ->defaultPath('%kernel.project_dir%/translations');

    $config
        ->router()
            ->utf8(true);

    $config
        ->uid()
            ->defaultUuidVersion(7)
            ->timeBasedUuidVersion(7);

    if (in_array($container->env(), [Environment::DEV->value, Environment::TEST->value], true)) {
        $config
            ->validation()
            ->notCompromisedPassword()
            ->enabled(false);

        if (Environment::TEST->value === $container->env()) {
            $config
                ->test(true)
                ->phpErrors()
                    ->log(false);

            $config
                ->session()
                    ->gcMaxlifetime(30);
        }
    }
};
