<?php
/**
 * Created by PhpStorm.
 * File: AdminEvent.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\event;

use app\service\admin\AdminLogService;

class AdminEvent
{
    protected $eventPrefix = 'AdminEvent';
    public function onLogin($param = [])
    {
        // 用户登录日志
        (new AdminLogService())->record($param['id'],'登录','普通登录');
        // 其他...
    }
}