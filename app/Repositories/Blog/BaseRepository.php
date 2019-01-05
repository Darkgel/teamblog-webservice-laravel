<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/5
 * Time: 15:29
 */

namespace App\Repositories\Blog;


use App\Repositories\AppRepository;

class BaseRepository extends AppRepository
{
    //1代表查询时包含“deleted_at”不为null的数据，0则反之
    const WITH_DELETED = 1;
    const WITHOUT_DELETED = 0;
}
