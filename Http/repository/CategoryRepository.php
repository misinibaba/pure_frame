<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:33
 */
namespace Http\repository;

use bootstrap\facades\Config;
use bootstrap\facades\Redis;
use Http\model\Category;

class CategoryRepository extends BaseRepository
{
    public function byId($id)
    {
        $cacheKey = $this->generateCacheKey(['type' => 'category', 'id' => $id]);
        $category = json_decode(Redis::get($cacheKey), true);
        if (empty($category)) {
            $category = Category::find($id);
            Redis::set($cacheKey, json_encode($category->toArray()));
        }

        return $category;
    }


    public function getCategoryList($gameId)
    {
        $cacheKey = $this->generateCacheKey(['type' => 'categoryList', 'gameId' => $gameId]);
        $categories = json_decode(Redis::get($cacheKey), true);
        if (empty($categories)) {
            $categories = Category::latest('id')->where('game_id', $gameId)->get()->toArray();
            Redis::set($cacheKey, json_encode($categories));
        }

        return $categories;

    }
}