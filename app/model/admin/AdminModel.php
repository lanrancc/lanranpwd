<?php
/**
 * Created by PhpStorm.
 * File: AdminModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model\admin;

use app\model\BaseModel;
use think\facade\Db;
use think\facade\Request;

class AdminModel extends BaseModel
{
    protected $pk = 'id';
    protected $name = 'admins';
    protected $autoWriteTimestamp = true;

    /**根据id修改用户状态
     * @param $id
     * @param $data
     * @return \think\response\Json
     */
    public static function updateStatusById($id, $data = []): \think\response\Json
    {
        if (Db::name('users')->where('id',$id)->update($data)){
            return json(['code'=>200,'msg'=>'修改成功']);
        }
        return json(['code'=>201,'msg'=>'修改失败']);
    }
    /**根据id删除用户
     * @param $id
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function deleteUserById($id){
        if (Db::name('users')->where('id',$id)->delete()){
            return json(['code'=>200,'msg'=>'删除成功']);
        }
        return json(['code'=>201,'msg'=>'删除失败']);
    }
    /**更改用户密码
     * @param $id
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function pass($id){
        $password = uniqid('lxy');
        Db::name('users')->where('id',$id)->update(['password'=>md5($password)]);
        return json(['code'=>200,'msg'=>'密码为：'.$password]);
    }
    /**获取用户列表
     * @return array|\think\Collection|Db[]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function userList()
    {
        $page = Request::post('page');
        $pageSize = Request::post('pageSize');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        return  Db::name('users')->page($page,$pageSize)->order('id asc')->select();
    }
    /**更新网站配置
     * @param $data
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     */
    public function configSet($data = []){
        foreach ($data as $k => $value) {
            Db::table('lxy_configs')->update(['key'=>$k,'value'=>$value]);
        }
        return json(['code'=>200,'msg'=>'保存成功']);
    }
}