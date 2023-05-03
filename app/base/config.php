<?php

const CONFIG_CONNECTION = [
    "host"=>"localhost",
    "dbname"=>"cn93875_candy",
    "username"=>"cn93875_candy",
    "password"=>"0000",
    "config"=>[
        \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ]
    ];
    // cn93875_candy