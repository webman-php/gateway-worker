<?php

use Webman\GatewayWorker\Gateway;
use Webman\GatewayWorker\BusinessWorker;
use Webman\GatewayWorker\Register;

return [
    'register' => [
        'handler'     => Register::class,
        'listen'      => 'text://0.0.0.0:7100',
        'count'       => 1, // Must be 1
        'constructor' => []
    ],
    'ws-gateway' => [
        'handler'     => Gateway::class,
        'listen'      => 'websocket://0.0.0.0:7200',
        'count'       => cpu_count(),
        'reloadable'  => false,
        'constructor' => ['config' => [
            'lanIp'           => '127.0.0.1',
            'startPort'       => 2300,
            'pingInterval'    => 25,
            'pingData'        => '{"type":"ping"}',
            'registerAddress' => '127.0.0.1:7100',
            'onConnect'       => function(){},
        ]]
    ],
    'worker' => [
        'handler'     => BusinessWorker::class,
        'count'       => cpu_count() * 2,
        'constructor' => ['config' => [
            'eventHandler'    => plugin\webman\gateway\Events::class,
            'name'            => 'BusinessBusinessWorker',
            'registerAddress' => '127.0.0.1:7300',
        ]]
    ],
];
