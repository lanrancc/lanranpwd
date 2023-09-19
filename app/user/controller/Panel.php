<?php
/**
 * Created by PhpStorm.
 * File: Panel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\user\controller;

use app\BaseController;
use app\middleware\CheckUserLogin;
use app\model\user\PasswordModel;
use app\service\user\UserLogService;
use think\facade\Session;
use think\facade\View;


class Panel extends BaseController
{
    protected $middleware = [CheckUserLogin::class];//中间件检测用户是否登录
    public function index(UserLogService $userLogService): string
    {
        $user_id = Session::get('user.id');//从session获取uid
        $list = $userLogService->LogList($user_id);//获取事件列表
        $count_day = (new PasswordModel())->where('uid',$user_id)->whereDay('create_time')->select()->count();//统计今天添加的记录
        $count_pwd = (new PasswordModel())->where('uid',$user_id)->select()->count();//根据uid统计全部添加的记录
        return View::fetch('/index',['title'=>'用户中心','list'=>$list,'count_pwd'=>$count_pwd,'count_day'=>$count_day]);
    }

    /**输出模板
     * @param $act
     * @return string|void
     */
    public function data($act = null)
    {
        switch ($act)
        {
            case 'passwordList':
                return View::fetch('/list',['title'=>'密码管理中心']);
                break;
            case 'randKey':
                return View::fetch('/rand_key',['title'=>'密码生成']);
                break;
            case 'changePassword':
                return View::fetch('/changePassword',['title'=>'修改密码']);
                break;
        }
        $this->error('参数有误');
    }
}