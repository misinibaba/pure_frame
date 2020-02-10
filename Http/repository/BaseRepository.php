<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:33
 */
namespace Http\repository;

use component\Redis;
use Http\model\Category;
use Http\model\Information;

class BaseRepository
{
    public function generateCacheKey($target, $conditions = [])
    {
        $targetKey = $this->getKey($target, '');
        $cacheKey  = $this->getKey($conditions, '');

        if ($cacheKey) {
            return trim($targetKey, '|') . '|' . trim($cacheKey, '|');
        } else {
            return trim($targetKey, '|');
        }
    }

    public function getKey($conditions, $cacheKey)
    {
        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $cacheKey = $this->getKey($value, $cacheKey);
                $cacheKey .= '|';
            } else {
                $cacheKey .= $key . ':' . $value . '|';
            }
        }
        return $cacheKey;
    }

}