<?php
namespace app\index\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    /**渲染首页模板
     * @return string
     */
    public function index():string
    {
        return View::fetch('/index');
    }

}
