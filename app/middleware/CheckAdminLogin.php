<?php
/**
 * Created by PhpStorm.
 * File: CheckAdminLogin.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\middleware;

use app\service\admin\AdminService;
use think\facade\View;

class CheckAdminLogin
{
    /**
     * 使用前置中间件 获取用户登录信息
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Redirect
     */
    public function handle($request, \Closure $next)
    {
        if (!$info = (new AdminService())->checkLogin())
        {
            View::assign(['msg' => '请登录后再访问', 'url' => '/admin/login']);
            exit(View::fetch('../common/alert'));
        }
        //进入控制器
        $request->adminInfo = $info;
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