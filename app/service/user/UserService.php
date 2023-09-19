<?php
/**
 * Created by PhpStorm.
 * File: UserService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\user;

use app\model\user\UserModel;
use app\service\BaseService;
use app\validate\AccountValidate as UserValidate;
use think\exception\ValidateException;
use think\facade\Event;
use think\facade\Session;

class UserService extends BaseService
{
    public function changePassword($data = [])
    {
        $row = $this->dao->where(['id'=>Session::get('user.id')])->find();
        try {
            validate(UserValidate::class)->scene('changePassWord')->check($data);
        } catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        if (md5($data['oldpass']) != $row['password']) return json(['code'=>201,'msg'=>'旧密码不正确']);
        if (md5($data['password']) == $row['password']) return json(['code'=>201,'msg'=>'新密码不能与旧密码一致']);
        $row->save(['password'=>md5($data['password'])]);
        $this->logout();
        return json(['code'=>200,'msg'=>'修改成功，请重新登录']);
    }
    /**注销当前登录
     * @return void
     */
    public function logout(): void
    {
        //注销登录事件
        Event::trigger('UserEventLogout',['id'=>Session::get('user.id')]);
        session('user_auth',null);
    }
    /**判断是否登录
     * @return array|false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkLogin()
    {
        // 获取session
        $cookies = session('user_auth');
        if (empty($cookies)) return false;
        if (!$row = $this->getUserById($cookies)) return false;
        return $row;
    }
    /**获取用户信息
     * @param $sid
     * @return UserModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($sid)
    {
        return $this->dao->where('sid',$sid)->find();
    }
    /**新用户注册
     * @param $data
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function register($data): \think\response\Json
    {
        //验证用户数据
        try {
            validate(UserValidate::class)->scene('reg')->check($data);
        } catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        // 判断用户是否已注册
        if ($this->dao->where('account',$data['account'])->find()) {
            return json(['code' => 201, 'msg' => '该用户已注册本站']);
        }
        // 验证成功后 开始注册
        $this->dao->save([
            'account' => $data['account'],
            'password' => md5($data['password']),
            'qq' => $data['qq'],
            'error_num'=>5,
            'create_time' => time(),
            'reg_ip' => request()->ip(),
            'status' => 1,
        ]);
        // 注册事件
        Event::trigger('UserEventRegister',['id'=>$this->dao->id]);
        // 注册成功
        return json(['code'=>200,'msg'=>'注册成功']);
    }
    /**用户登录
     * @param $data
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($data)
    {
        //验证用户数据
        try {
            validate(UserValidate::class)->scene('login')->check($data);
        } catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        // 判断数据
        if (!$row = $this->dao->where('account',$data['account'])->find())
        {
            return json(['code'=>201,'msg'=>'用户名不存在']);
        }

        if ($row['password'] != md5($data['password']))
        {
            return json(['code'=>201,'msg'=>'密码错误']);
        }
        if (!$row['status'])
        {
            return json(['code'=>201,'msg'=>'该用户已被封禁']);
        }
        // 登生成sid
        $sid = md5($data['account'].time().rand(1,999));
        // 用session保存
        session('user_auth',$sid);
        // 更新到数据库
        $row->save(['sid'=>$sid]);
        // 登录事件
        Event::trigger('UserEventLogin',$row);
        return json(['code'=>200,'msg'=>'登录成功']);
    }

    /**
     * 用户构造方法
     */
    public function __construct()
    {
        $this->dao = new UserModel();
    }
}