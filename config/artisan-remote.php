<?php

return [
    'commands' => [
        \Illuminate\Foundation\Console\UpCommand::class,
        \Illuminate\Foundation\Console\DownCommand::class,
        \Illuminate\Cache\Console\ClearCommand::class,
        \App\Console\Commands\GenerateSitemap::class,
        \App\Console\Commands\RunMeilisearch::class,
        \Spatie\Backup\Commands\BackupCommand::class,
        \Spatie\Backup\Commands\CleanupCommand::class,
    ],
    'auth' => [
        env('CLIENT_ARTISAN_REMOTE_API_KEY') => [
            \Illuminate\Foundation\Console\UpCommand::class,
            \Illuminate\Foundation\Console\DownCommand::class,
            \Illuminate\Cache\Console\ClearCommand::class,
            \App\Console\Commands\GenerateSitemap::class,
            \App\Console\Commands\RunMeilisearch::class,
            \Spatie\Backup\Commands\BackupCommand::class,
            \Spatie\Backup\Commands\CleanupCommand::class,
        ],
    ],
    'route_prefix' => 'artisan-remote',
];
