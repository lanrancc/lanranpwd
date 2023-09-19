<?php
/**
 * Created by PhpStorm.
 * File: Index.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    /**用于跳转
     * @return \think\response\Redirect
     */
    public function index(): \think\response\Redirect
    {
        return redirect('/admin/index');
    }

    /**输出登录页模板
     * @return string
     */
    public function login(): string
    {
        return View::fetch('/login');
    }
}