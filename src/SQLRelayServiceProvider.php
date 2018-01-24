<?php

namespace Shuenn\SQLRelay;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Shuenn\SQLRelay\Database\SQLRelayConnection;
use Shuenn\SQLRelay\Connectors\SQLRelayConnector;

class SQLRelayServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        # 註冊SQLRelay Driver
        app()->bind('db.connector.sqlrelay', SQLRelayConnector::class);

        Connection::resolverFor('sqlrelay', function ($connection, $database, $prefix, $config){
            return new SQLRelayConnection($connection, $database, $prefix, $config);
        });
    }
}
