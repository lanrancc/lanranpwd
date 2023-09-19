<?php
/**
 * Created by PhpStorm.
 * File: CheckLogin.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\middleware;

use app\service\user\UserService;
use think\facade\Session;
use think\facade\View;

class CheckUserLogin
{
    /**
     * 使用前置中间件 获取用户登录信息
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Redirect
     */
    public function handle($request, \Closure $next)
    {
        if (!$info = (new UserService())->checkLogin())
        {
            View::assign(['msg' => '请登录后再访问', 'url' => '/user/login']);
            exit(View::fetch('../common/alert'));
        }
        // 储存信息
        if ($info) {
            session::set('user', $info->toArray());
        }

        //进入控制器
        return $next($request);
    }

    /**
     * 结束调度
     * @param \think\Response $response
     * @return void
     */
    public function end(\think\Response $response)
    {

    }
}