<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=ukpp_lubangsa_test",
                "username" => "root",
                "password" => "admin"
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=ukpp",
                "username" => "root",
                "password" => "admin"
            ]
        ]
    ];
}
