<?php
namespace Http\model;
use Illuminate\Database\Eloquent\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: s3916dev
 * Date: 2019/4/4
 * Time: 16:18
 */
class InformationDetail extends Eloquent
{
    protected $table = 'information_detail';
    protected $fillable = ['id', 'info_id', 'body'];

    public function user()
    {
        return $this->belongsTo(Information::class);
    }
}