<?php
/**
 * Created by PhpStorm.
 * File: AdminService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\admin;

use app\model\admin\AdminModel;
use app\service\BaseService;
use app\validate\AccountValidate as AdminValidate;
use think\exception\ValidateException;
use think\facade\Event;

class AdminService extends BaseService
{
    /**修改密码
     * @param array $data
     * @return \think\response\Json|true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function changePassword(array $data = [])
    {
        $row = $this->dao->where(['id'=>1])->find();
        try {
            validate(AdminValidate::class)->scene('changePassWord')->check($data);
        } catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        if (md5($data['oldpass']) != $row['password']) return json(['code'=>201,'msg'=>'旧密码不正确']);
        if (md5($data['password']) == $row['password']) return json(['code'=>201,'msg'=>'新密码不能与旧密码一致']);
        $row->save(['password'=>md5($data['password'])]);
        $this->logout();
        return json(['code'=>200,'msg'=>'修改成功，请重新登录']);
    }
    /**注销管理员登录
     * @return void
     */
    public function logout(): void
    {
        session('admin_auth',null);
    }
    /**测是否登录管理员
     * @return AdminModel|array|false|mixed|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkLogin()
    {
        //获取session
        $cookies = session('admin_auth');
        if (empty($cookies)) return false;
        if (!$row = $this->getInfoBySid($cookies)) return false;
        return $row;
    }

    /**根据sid找对应数据
     * @param $sid
     * @return AdminModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getInfoBySid($sid)
    {
        return $this->dao->where('sid',$sid)->find();
    }

    /**管理员登陆
     * @param $data
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($data): \think\response\Json
    {
        //验证数据
        try {
            validate(AdminValidate::class)->scene('login')->check($data);
        } catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        //判断数据
        if (!$row = $this->dao->where('account',$data['account'])->find()) {
            return json(['code'=>201,'msg'=>'管理员不存在']);
        }
        if ($row['password'] != md5($data['password'])) {
            return json(['code'=>201,'msg'=>'密码错误']);
        }
        //生成sid
        $sid = md5($data['account'].time().rand(1,999));
        //用session保存
        session('admin_auth',$sid);
        // 更新到数据库
        $row->save(['sid'=>$sid]);
        //登录事件
        Event::trigger('AdminEventLogin',$row);
        return json(['code'=>200,'msg'=>'登录成功']);
    }

    /**
     * 后台构造方法
     */
    public function __construct(){
        $this->dao = new AdminModel();
    }
}