<?php
namespace Http\repository;

use bootstrap\facades\Redis;
use Http\model\Game;

class GameRepository extends BaseRepository
{
    //查找指定
    public function byCustomId($customId)
    {
        $cacheKey = $this->generateCacheKey(['type' => 'game', 'custom_id' => $customId]);
        $game = json_decode(Redis::get($cacheKey), true);
        if (empty($game)) {
            $game = Game::find(['custom_id' => $customId])->first();
            if ($game) {
                Redis::set($cacheKey, json_encode($game->toArray()));
            }
        }
        return $game;
    }

    //拿到所有
    public function getGameList($gameId)
    {
        $cacheKey = $this->generateCacheKey(['type' => 'gameList', 'gameId' => $gameId]);
        $games = json_decode(Redis::get($cacheKey), true);
        if (empty($games)) {
            $games = Game::where('status', Game::PUBLIC_STATUS)->latest('id')->get()->toArray();
            Redis::set($cacheKey, json_encode($games));
        }

        return $games;
    }
}