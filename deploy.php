<?php

namespace Deployer;

use function getenv;
use function sprintf;

require 'recipe/symfony.php';

// Config

set('application', 'flux/miguel-bustos');
set('repository', 'ssh://git@gitlab.espaikowo.cat:2222/flux/miguel-bustos.git');
set('branch', 'main');
set('keep_releases', 3);

set('composer_options', '--no-scripts --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader');

add('shared_dirs', [
    'public/media/',
    'public/uploads/',
    'var/sessions/',
]);
set('shared_files', []);

set('writable_dirs', [
    'public/media/',
    'public/uploads/',
    'var',
    'var/cache',
    'var/log',
    'var/sessions',
]);

set('http_user', 'www-data');
set('http_group', 'www-data');

// Hosts
host('s7.flux.cat')
    ->setHostname('s7.flux.cat')
    ->setRemoteUser('root')
    ->setDeployPath('/opt/docker/flux/miguel-bustos/deploy')
    ->setPort(222)
    ->set('writable_mode', 'chown')
    ->set('writable_recursive', true)
    ->set('bin/php', 'docker exec -w /opt/docker/flux/miguel-bustos/deploy/release miguel-bustos-php php')
    ->set('bin/composer', 'docker exec -w /opt/docker/flux/miguel-bustos/deploy/release miguel-bustos-php composer')
    ->set('bin/console', 'docker exec -w /opt/docker/flux/miguel-bustos/deploy/release miguel-bustos-php /opt/docker/flux/miguel-bustos/deploy/release/bin/console')
;

$dumpSymfonyEnvVar = static function (string $name) {
    run(
        sprintf(
            'echo "%s=\"%s\"" >> {{release_path}}/.env.local',
            $name,
            getenv($name),
        ),
    );
};

desc('Dump secrets to .env.local');
task('deploy:env:secrets', static function () use ($dumpSymfonyEnvVar): void {
    run('echo "APP_ENV=prod" > {{release_path}}/.env.local');
    $dumpSymfonyEnvVar('APP_SECRET_PROD');
    $dumpSymfonyEnvVar('BOSS_DNI_PROD');
    $dumpSymfonyEnvVar('GOOGLE_ANALYTICS_ID_PROD');
    $dumpSymfonyEnvVar('PROJECT_URL_BASE_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_NAME_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_ADDRESS_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_CITY_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_ZIP_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_PROVINCE_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_TIN_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_MOBILE_PHONE_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_DELIVERY_ADDRESS_PROD');
    $dumpSymfonyEnvVar('CUSTOMER_URL_PROD');
    $dumpSymfonyEnvVar('FACEBOOK_URL_PROD');
    $dumpSymfonyEnvVar('INSTAGRAM_URL_PROD');
    $dumpSymfonyEnvVar('YOUTUBE_URL_PROD');
    $dumpSymfonyEnvVar('DEVELOPER_NAME_PROD');
    $dumpSymfonyEnvVar('DEVELOPER_URL_PROD');
    $dumpSymfonyEnvVar('MAILER_DSN_PROD');
    $dumpSymfonyEnvVar('GOOGLE_RECAPTCHA_SITE_KEY_PROD');
    $dumpSymfonyEnvVar('GOOGLE_RECAPTCHA_SECRET_PROD');
    $dumpSymfonyEnvVar('EWZ_RECAPTCHA_SECRET_PROD');
    $dumpSymfonyEnvVar('EWZ_RECAPTCHA_SITE_KEY_PROD');
});

desc('Compile assets');
task('deploy:assets:compile', function () {
    run('{{bin/console}} ckeditor:install --tag=4.22.1');
    run('{{bin/console}} assets:install');
    run('{{bin/console}} importmap:install');
    run('{{bin/console}} tailwind:build');
    run('{{bin/console}} asset-map:compile');
});

desc('Compile .env files');
task('deploy:dump-env', function () {
    run('{{bin/composer}} dump-env prod --no-interaction');
});

desc('Cache warmup');
task('deploy:cache:warmup', static function (): void {
    run('{{bin/console}} cache:warmup --env=prod');
});

after('deploy:failed', 'deploy:unlock');

task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:env:secrets',
    'deploy:vendors',
    'deploy:assets:compile',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:dump-env',
    'database:migrate',
    'deploy:symlink',
    'deploy:cleanup',
    'deploy:unlock',
    'deploy:success',
]);
