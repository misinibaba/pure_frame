<?php
namespace Http\model;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:18
 */
class Information extends Eloquent
{
    protected $table = 'informations';
    protected $fillable = ['id', 'title', 'game_id', 'custom_id', 'category_id', 'title', 'image_url', 'author', 'status', 'start_at', 'end_at', 'info_type'];

    const LIST_PUBLIC_STATUS = 3; // 公开到列表
    const NEWS_PUBLIC_STATUS = 2; // 不公开到列表
    const HIDE_STATUS = 1; //未公开
    const DELETED = -1; // 已删除

    // 字段对应值
    const ID = 'info_id';
    const CATEGORY_ID = 'category_id';
    const CATEGORY_NAME = 'category_name';
    const TITLE = 'title';
    const START = 'start_at';
    const END = 'end_at';
    const BANNER_URL = 'image_url';
    const GAME_ID = 'game_id';
    const INFO_TYPE = 'info_type';

    //公告---分类
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //公告--内容
    public function informationDetail()
    {
        return $this->hasOne(InformationDetail::class, 'info_id');
    }

    //公告--游戏
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}