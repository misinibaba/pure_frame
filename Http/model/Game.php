<?php

namespace Http\model;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Game extends Eloquent
{
    protected $table = 'games';

    const PUBLIC_STATUS = 1;
    const HIDE_STATUS = 0;
}
