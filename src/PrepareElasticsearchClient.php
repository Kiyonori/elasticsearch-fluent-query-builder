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
     * @param  string[]  $hosts
     *
     * @throws AuthenticationException
     */
    public function execute(
        array $hosts,
        bool $sslVerification = false,
        ?string $username = null,
        ?string $password = null,
    ): Client {
        if (self::$client === null) {
            $clientBuilder = ClientBuilder::create()
                ->setHosts($hosts)
                ->setSSLVerification($sslVerification);

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
