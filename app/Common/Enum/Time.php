<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:23
 */

namespace Enum;

final class Time
{
    //单位为秒
    const SECOND = 1;
    const SECOND_ONE_MINUTE = 60;
    const SECOND_TEN_MINUTE = 600;
    const SECOND_HALF_HOUR = 1800;
    const SECOND_ONE_HOUR = 3600;
    const SECOND_HALF_DAY = 43200;
    const SECOND_DAY = 86400;
    const SECOND_WEEK = 604800;

    //单位为分钟
    const MINUTE = 1;
    const MINUTE_TEN_MINUTE = 10;
    const MINUTE_HALF_HOUR = 30;
    const MINUTE_ONE_HOUR = 60;
    const MINUTE_HALF_DAY = 720;
    const MINUTE_DAY = 1440;
    const MINUTE_WEEK = 10080;

    //单位为小时
    const HOUR = 1;
    const HOUR_HALF_HOUR = 0.5;
    const HOUR_HALF_DAY = 12;
    const HOUR_DAY = 24;
    const HOUR_WEEK = 168;

    //单位为天
    const DAY = 1;
    const DAY_WEEK = 7;

    //单位为月
    const MONTH = 1;
    const MONTH_YEAR = 12;
}
