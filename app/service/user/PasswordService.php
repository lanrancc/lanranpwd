<?php
/**
 * Created by PhpStorm.
 * File: PasswordModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\user;

use app\model\user\PasswordModel;
use app\service\BaseService;
use app\validate\PasswordValidate;
use think\exception\ValidateException;
use think\facade\Event;
use think\facade\Request;
use think\facade\Session;

class PasswordService extends BaseService
{
    /**统计
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function count(): int
    {
        $user_id = Session::get('user.id');
        return $this->dao->where('uid',$user_id)->select()->count();
    }

    /**根据id删除数据
     * @param $id
     * @return \think\response\Json
     */
    public function deleteById($id): \think\response\Json
    {
        if ($this->dao->where('id',$id)->delete()){
            // 删除事件
            Event::trigger('UserEventDelete',['id'=>Session::get('user.id')]);
            return json(['code'=>200,'msg'=>'删除成功']);
        }
        return json(['code'=>201,'msg'=>'删除失败']);
    }
    /**根据id更新数据
     * @param $id
     * @param $data
     * @return \think\response\Json
     */
    public function updateById($id, $data = []): \think\response\Json
    {
        if ($this->dao->where('id', $id)->save($data)) {
            Event::trigger('UserEventUpdate', ['id' => Session::get('user.id')]);
            return json(['code' => 200, 'msg' => '修改成功']);
        }
        return json(['code' => 201, 'msg' => '修改失败']);
    }

    /**添加数据
     * @param $data
     * @return \think\response\Json
     */
    public function add($data = []): \think\response\Json
    {
        try {
            validate(PasswordValidate::class)->check($data);
        }catch (ValidateException $e){
            return json(['code'=>201,'msg'=>$e->getMessage()]);
        }
        if ($this->dao->save($data)) {
            Event::trigger('UserEventAdd',['id'=>Session::get('user.id')]);
            return json(['code' => 200, 'msg' => '添加成功']);
        }
        return json(['code'=>201,'msg'=>'添加失败']);
    }
    /**密码本分页
     * @return PasswordModel[]|array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function search()
    {
        $user_id = Session::get('user.id');
        $page = Request::post('page');
        $pageSize = Request::post('pageSize');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        return $this->dao->where('uid',$user_id)->page($page,$pageSize)->order('id asc')->select();
    }

    /**
     * 密码本构造方法
     */
    public function __construct()
    {
        $this->dao = new PasswordModel();
    }
}