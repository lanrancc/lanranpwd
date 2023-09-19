<?php
/**
 * Created by PhpStorm.
 * File: System.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\admin\controller;

use app\BaseController;
use app\middleware\CheckAdminLogin;
use app\model\user\PasswordModel;
use app\model\user\UserModel;
use app\Request;
use app\service\admin\AdminLogService;
use think\facade\View;

class System extends BaseController
{
    protected $middleware = [CheckAdminLogin::class];//中间件判断管理员是否登录

    /**输出仪表盘模板
     * @param Request $request
     * @param AdminLogService $adminLogService
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index(Request $request, AdminLogService $adminLogService): string
    {
        $admin_id = $request->adminInfo['id'];//获取管理员id
        $list = $adminLogService->LogList($admin_id);//获取事件列表
        $dayCount = (new PasswordModel())->whereDay('create_time')->select()->count();//统计今天添加的密码本
        $pwdCount = (new PasswordModel())->select()->count();//统计密码本数量
        $userCount = (new UserModel())->select()->count();//统计全部用户
        return View::fetch('',['title'=>'仪表盘','list' => $list,'dayCount'=>$dayCount,'pwdCount'=>$pwdCount,'userCount'=>$userCount]);
    }

    /**输出模板
     * @param $act
     * @return string|void
     */
    public function data($act = null)
    {
        switch ($act)
        {
            case 'userlist':
                return View::fetch('system/data/userlist',['title'=>'用户列表']);
                break;
            case 'setting':
                return View::fetch('system/data/setting',['title'=>'网站信息配置']);
                break;
            case 'noticelist':
                return View::fetch('system/data/noticelist',['title'=>'公告列表']);
                break;
            case 'changePassword':
                return View::fetch('system/data/changePassword',['title'=>'修改密码']);
                break;
        }
        $this->error('参数有误');
    }
}