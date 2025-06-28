<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

final class PrepareElasticsearchClient
{
    private static ?Client $client = null;

    /**
     * Elasticsearch とやりとりするインスタンスを返す
     *
     * この時点で、まだ接続は発生していません
     *
     * @throws AuthenticationException
     */
    public function execute(): Client
    {
        if (self::$client === null) {
            $clientBuilder = ClientBuilder::create()
                ->setHosts(
                    hosts: config('my-elasticsearch.hosts'),
                )
                ->setSSLVerification(
                    config(
                        'my-elasticsearch.ssl_verification',
                        default: false
                    )
                );

            $username = config('my-elasticsearch.user_name');
            $password = config('my-elasticsearch.password');

            if (is_string($username) && is_string($password)) {
                $clientBuilder->setBasicAuthentication(
                    username: $username,
                    password: $password,
                );
            }

            self::$client = $clientBuilder->build();
        }

        return self::$client;
    }
}
