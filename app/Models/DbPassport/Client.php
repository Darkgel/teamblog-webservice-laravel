<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/3/30
 * Time: 10:44
 */

namespace App\Models\DbPassport;

use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    public $connection = 'db_passport';
}
