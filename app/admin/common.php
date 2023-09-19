<?php
/**
 * Created by PhpStorm.
 * File: common.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */
if (!function_exists('adminInfo'))
{
    function adminInfo($key)
    {
        return app()->make(\app\Request::class)->adminInfo[$key];
    }
}