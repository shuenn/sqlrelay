<?php

namespace Shuenn\SQLRelay\Connectors;

use Illuminate\Database\Connectors\MySqlConnector;

class SQLRelayConnector extends MySqlConnector
{
    /**
     * Create a DSN string from a configuration.
     *
     * Chooses socket or host/port based on the 'unix_socket' config value.
     *
     * @param  array   $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        return "sqlrelay:host={$config['host']};port={$config['port']};socket={$config['socket']};tries=0;retrytime=1;debug=0";
    }
}
