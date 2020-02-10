<?php
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:33
 */
namespace Http\repository;

use bootstrap\facades\Config;
use Carbon\Carbon;
use bootstrap\facades\Redis;
use Http\model\Information;

class InformationRepository extends BaseRepository
{
    public function byId($id)
    {
        return Information::find($id);
    }

    // 原生demo
//    public function demo($custom_id, $game_id)
//    {
//        $in = implode(',', [Information::LIST_PUBLIC_STATUS, Information::NEWS_PUBLIC_STATUS]);
//        $sql = 'SELECT i.*, c.category_name, id.body as body FROM ' . Information::TABLE . ' as i '
//            . ' LEFT JOIN ' . Category::TABLE . ' as `c` '
//            . ' ON i.category_id = `c`.id '
//            . ' LEFT JOIN ' . InformationDetail::TABLE . ' as id '
//            . ' ON id.info_id = i.id '
//            . ' WHERE i.custom_id = :custom_id '
//            . ' AND i.game_id = :game_id '
//            . " AND i.status IN ($in)";
//
//        $params = [
//            ':game_id'   => $game_id,
//            ':custom_id' => $custom_id,
//        ];
//        $informationDetail = Model::query($sql, $params);
//        $informationDetail = empty($informationDetail) ? [] : $informationDetail[0];
//        return $informationDetail;
//    }
}