<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/3/30
 * Time: 10:44
 */

namespace App\Models\DbPassport;

use Laravel\Passport\PersonalAccessClient as BasePersonalAccessClient;

class PersonalAccessClient extends BasePersonalAccessClient
{
    public $connection = 'db_passport';
}
