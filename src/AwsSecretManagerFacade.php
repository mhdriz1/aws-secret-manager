<?php

namespace Mhdriz1\AwsSecretManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mhdriz1\AwsSecretManager\Skeleton\SkeletonClass
 */
class AwsSecretManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'secret-manager';
    }
}
