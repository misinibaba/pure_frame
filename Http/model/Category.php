<?php
namespace Http\model;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:18
 */
class Category extends Eloquent
{
    protected $table = 'category';
    protected $fillable = ['id', 'custom_id', 'game_id', 'status', 'category_name'];

    const PUBLIC_STATUS = 1;
    const HIDE_STATUS = 0;
}