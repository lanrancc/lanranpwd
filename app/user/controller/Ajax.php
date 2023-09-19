<?php
/**
 * Created by PhpStorm.
 * File: Ajax.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\user\controller;

use app\Request;
use app\service\user\UserLogService;
use think\facade\Request as Requests;
use app\service\user\PasswordService;
use app\service\user\UserService;
use think\facade\Session;

class Ajax
{
    /**修改密码
     * @return false|\think\response\Json
     */
    public function changePassword()
    {
        if (Requests::isPost())
        {
            $data = Requests::post();
            return (new UserService())->changePassword($data);
        }
        return false;
    }
    /**注销用户登录
     * @return \think\response\Json
     */
    public function logout(): \think\response\Json
    {
        (new UserService())->logout();
        return json(['code'=>200,'msg'=>'注销登录成功']);
    }
    /**登录
     * @param Request $request
     * @return false|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            return (new UserService())->login($data);
        }
        return false;
    }

    /**新用户注册
     * @param Request $request
     * @return false|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function register(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            return (new UserService())->register($data);
        }
        return false;
    }

    /**获取事件列表
     * @return \think\response\Json
     */
    public function logs(): \think\response\Json
    {
        return json(['code' => 200, 'list' => (new UserLogService())->search(), 'total' => (new UserLogService())->count()]);
    }

    /**获取数据
     * @param $act
     * @param $do
     * @return false|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function data($act = null, $do = null)
    {
        switch ($act){
            case 'password':
                switch ($do){
                    case 'list'://密码本列表
                        return json(['code' => 200, 'list' => (new PasswordService())->search(), 'total' => (new PasswordService())->count()]);
                        break;
                    case 'add'://添加密码本
                        if (Requests::isPost()) {
                            $data = Requests::post();
                            $data['uid'] = Session::get('user.id');
                            return (new PasswordService())->add($data);
                        }
                        break;
                    case 'update'://更新密码本
                        if (Requests::isPost())
                        {
                            $data = Requests::post();
                            $data['update_time'] = time();
                            return (new PasswordService())->updateById($data['id'], $data);
                        }
                        break;
                    case 'delete'://删除密码本
                        if (Requests::isPost()) {
                            $id = Requests::post('id');
                            return (new PasswordService())->deleteById($id);
                        }
                        break;
                }
                break;
        }
        return false;
    }
}