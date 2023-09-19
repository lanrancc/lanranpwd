<?php
/**
 * Created by PhpStorm.
 * File: Index.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\user\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    /**用于跳转
     * @return \think\response\Redirect
     */
    public function index(): \think\response\Redirect
    {
        return redirect('/user/index');
    }

    /**用户登录模板
     * @return string
     */
    public function login(): string
    {
        return View::fetch('/login');
    }

    /**新用户注册模板
     * @return string
     */
    public function register(): string
    {
        return View::fetch('/register');
    }
}