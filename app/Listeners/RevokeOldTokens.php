<?php

namespace App\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;

class RevokeOldTokens
{
    /**
     * 请求新的accessToken时使旧的token失效
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        \DB::connection('db_blog')->table('oauth_access_tokens')
            ->where('id', '<>', $event->tokenId)
            ->where('user_id', $event->userId)
            ->where('client_id', $event->clientId)
            ->update(['revoked' => true]);
    }
}
