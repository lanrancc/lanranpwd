<?php
/**
 * Created by PhpStorm.
 * File: Ajax.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\admin\controller;

use app\model\admin\AdminModel;
use app\Request;
use app\service\admin\AdminLogService;
use app\service\admin\AdminService;
use app\service\admin\NoticeService;
use Exception;
use think\facade\Db;
use think\facade\Request as Requests;
use think\facade\Session;

class Ajax
{
    /**修改密码
     * @return bool|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function changePassword(){
        if (Requests::isPost())
        {
            $data = Requests::post();
            return (new AdminService())->changePassword($data);
        }
        return false;
    }
    /**更新网站配置
     * @param Request $request
     * @return false|\think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function saveConfig(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            return (new AdminModel())->configSet($data);
        }
        return false;
    }
    /**获取事件列表
     * @return \think\response\Json
     */
    public function logs(): \think\response\Json
    {
        $admin_id = 1;
        return json(['code' => 200, 'list' => (new AdminLogService())->search($admin_id), 'total' => (new AdminLogService())->count($admin_id)]);
    }
    /**注销管理员登录
     * @return \think\response\Json
     */
    public function logout(): \think\response\Json
    {
        (new AdminService())->logout();
        return json(['code'=>200,'msg'=>'注销登录成功']);
    }

    /**管理员登录
     * @param Request $request
     * @return false|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            return (new AdminService())->login($data);
        }
        return false;
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
            case 'notice':
                switch ($do){
                    case 'list'://公告列表
                        return json(['code' => 200, 'list' => (new NoticeService())->search(), 'total' => (new NoticeService())->count()]);
                        break;
                    case 'add'://添加公告
                        if (Requests::isPost()) {
                            $data = Requests::post();
                            $data['uid'] = Session::get('user.id');
                            return (new NoticeService())->add($data);
                        }
                        break;
                    case 'update'://更新公告
                        if (Requests::isPost())
                        {
                            $data = Requests::post();
                            return (new NoticeService())->updateById($data['id'], $data);
                        }
                        break;
                    case 'delete'://删除公告
                        if (Requests::isPost()) {
                            $id = Requests::post('id');
                            return (new NoticeService())->deleteById($id);
                        }
                        break;
                }
                break;
            case 'userlist':
                switch ($do){
                    case 'list':
                        return json(['code' => 200, 'list' => (new AdminModel())->userList(), 'total' => Db::name('users')->field('id')->count()]);
                        break;
                    case 'pass'://改密
                        if (Requests::isPost()) {
                            $id = Requests::post('id');
                            return (new AdminModel())->pass($id);
                        }
                        break;
                    case 'delete'://删除用户
                        if (Requests::isPost()) {
                            $id = Requests::post('id');
                            return (new AdminModel())->deleteUserById($id);
                        }
                        break;
                    case 'status'://修改状态
                        if (Requests::isPost()) {
                            $data = Requests::post();
                            $id = $data['id'];
                            $act = $data['act'];
                            $value = $data['value'];
                            if ($act === 'status') {
                                return (new AdminModel())::updateStatusById($id, [$act => $value]);
                            }
                        }
                        break;
                }
                break;
        }
        return false;
    }
}