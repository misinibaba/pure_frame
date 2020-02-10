<?php
namespace Http\repository;

use bootstrap\facades\Config;
use Carbon\Carbon;
use component\Redis;
use Http\model\InformationDetail;

class InformationDetailRepository extends BaseRepository
{

    public function byId($id)
    {
        $cacheKey = $this->generateCacheKey(['type' => 'information', 'id' => $id]);
        $info = json_decode(Redis::get($cacheKey), true);
        if (empty($category)) {
            $info = InformationDetail::find($id);
            Redis::set($cacheKey, json_encode($info));
        }

        return $info;
    }
}