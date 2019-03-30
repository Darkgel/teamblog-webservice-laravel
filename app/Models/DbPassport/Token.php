<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/3/30
 * Time: 10:44
 */

namespace App\Models\DbPassport;

use Laravel\Passport\Token as BaseToken;

class Token extends BaseToken
{
    public $connection = 'db_passport';
}
