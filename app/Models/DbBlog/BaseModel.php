<?php
/**
 * 某个数据库下所有model的基类，请在此处添加库层面相关的代码，如数据库连接
 *
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:29
 */

namespace App\Models\DbBlog;

use App\Models\AppModel;

class BaseModel extends AppModel
{
    protected $connection = 'db_blog';
}
