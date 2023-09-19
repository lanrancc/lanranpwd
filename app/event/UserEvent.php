<?php
/**
 * Created by PhpStorm.
 * File: UserEvent.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\event;

use app\service\user\UserLogService;

class UserEvent
{
    protected $eventPrefix = 'UserEvent';

    /**注销登录事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onLogout($param = []): void
    {
        (new UserLogService())->record($param['id'],'注销','注销用户登录');
    }

    /**添加密码本事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onAdd($param = []): void
    {
        (new UserLogService())->record($param['id'],'添加','添加密码本记录');
    }

    /**更新密码本事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onUpdate($param = []): void
    {
        (new UserLogService())->record($param['id'],'更新','更新密码本记录');
    }

    /**删除密码本事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onDelete($param = []): void
    {
        (new UserLogService())->record($param['id'],'删除','删除密码本记录');
    }

    /**新用户注册密码本事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onRegister($param = []): void
    {
        (new UserLogService())->record($param['id'],'注册','新用户注册');
    }

    /**用户登录密码本事件
     * @param $param
     * @return void
     * @throws \Exception
     */
    public function onLogin($param = []): void
    {
        // 执行相应方法
        // 用户登录日志
        (new UserLogService())->record($param['id'],'登录','普通登录');
        // 其他...
    }
}