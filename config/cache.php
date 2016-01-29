<?php

return [
    'driver' => 'memcached',
    'servers' => [
        ['host' => 'localhost', 'port' => 11211, 'weight' => 1]
    ],
    'options' => [
        Memcached::OPT_DISTRIBUTION => Memcached::DISTRIBUTION_CONSISTENT,
        Memcached::OPT_LIBKETAMA_COMPATIBLE => TRUE,
        Memcached::OPT_BINARY_PROTOCOL => TRUE,
        Memcached::OPT_COMPRESSION => TRUE,
        Memcached::OPT_PREFIX_KEY => '',
        Memcached::OPT_CONNECT_TIMEOUT => 300,
    ]
];