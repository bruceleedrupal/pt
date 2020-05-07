<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use EasyWeChat\OpenPlatform\Authorizer\Auth\AccessToken;

/**
 * Class ServiceProvider.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class WechatProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['authorizer_access_token'] = function ($app) {
            return new AccessToken($app);
        };

        
    }
}
