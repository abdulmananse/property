<?php

namespace App\Providers;

use Google_Client;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Storage;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function($app, $config) {
            $client = new Google_Client();
            $client->setAuthConfigFile('../storage/driver-credentials.json');
            //$client->setClientId($config['clientId']);
            //$client->setClientSecret($config['clientSecret']);
            //$client->refreshToken($config['refreshToken']);
            $service = new \Google_Service_Drive($client);
            
            $options = [];
            if(isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, '0BxyUri92yc71T0J5Y1JzOFBTMlU', $options);
            // dd($adapter);
            return new Filesystem($adapter);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}