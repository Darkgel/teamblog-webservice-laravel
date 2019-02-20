<?php

namespace App\Listeners;

use Laravel\Passport\Events\RefreshTokenCreated;

class PruneOldTokens
{
    /**
     * 请求新的refreshToken时使旧的token失效
     *
     * Handle the event.
     *
     * @param  RefreshTokenCreated  $event
     * @return void
     */
    public function handle(RefreshTokenCreated $event)
    {
        \DB::connection('db_blog')->table('oauth_refresh_tokens')
            ->where('id', '<>', $event->refreshTokenId)
            ->where('access_token_id', '<>', $event->accessTokenId)
            ->update(['revoked' => true]);
    }
}
