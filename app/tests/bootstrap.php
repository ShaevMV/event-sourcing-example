<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
         // выполняет команду "php bin/console cache:clear"
        passthru(sprintf(
                 'APP_ENV=%s php "%s/../bin/console" cache:clear --no-warmup',
                 $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'],
                 __DIR__
          ));

    }
