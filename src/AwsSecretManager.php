<?php

namespace Mhdriz1\AwsSecretManager;

use Aws\Exception\AwsException;
use Aws\SecretsManager\SecretsManagerClient;

class AwsSecretManager
{
    /**
     * @return array
     */
    public static function get(string $values): array
    {
        try {

            $args = [
                'SecretId'     => $values,
            ];

            $result = self::getClient()->getSecretValue($args);

            return json_decode($result->get('SecretString'), true);

        }  catch (AwsException $e) {

        }

        return [];
    }

    public static function all(): array
    {
        $result = [];

        foreach (self::getAllList() as $secret) {
            $result[$secret] = self::get($secret);
        }

        return $result;
    }

    private static function getAllList() : array
    {
        $secretList = [];
        $nextToken  = null;

        try {

            while(true) {
                $args = [];

                if($nextToken) {
                    $args['NextToken'] = $nextToken;
                }

                $result = self::getClient()->listSecrets($args);

                foreach ($result->get('SecretList') as $secret) {
                    $secretList[] = $secret['Name'];
                }

                $nextToken    = $result->get('NextToken');

                if($nextToken == null) {
                    break;
                }
            }

        }  catch (AwsException $e) {

        }

        return $secretList;
    }

    /**
     * @return SecretsManagerClient
     */
    public static function getClient(): SecretsManagerClient
    {
        return new SecretsManagerClient([
            'profile' => config('secret-manager.profile'),
            'version' => config('secret-manager.version'),
            'region'  => config('secret-manager.region'),
        ]);
    }
}