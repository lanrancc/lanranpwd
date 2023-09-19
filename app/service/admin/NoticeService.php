<?php
/**
 * Created by PhpStorm.
 * File: NoticeService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\admin;

use app\model\admin\NoticeModel;
use app\service\BaseService;
use think\facade\Request;


class NoticeService extends BaseService
{
    public function deleteById($id): \think\response\Json
    {
        if ($this->dao->where('id',$id)->delete()){
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
        if (empty($data['title'] || $data['content'])){
            return json(['code'=>201,'msg'=>'所有项不能为空']);
        }
        if ($this->dao->save($data)) {
            return json(['code' => 200, 'msg' => '添加成功']);
        }
        return json(['code'=>201,'msg'=>'添加失败']);
    }
    /**统计公告
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function count(): int
    {
        return $this->dao->select()->count();
    }
    /**公告列表分页
     * @return mixed
     */
    public function search()
    {
        $page = Request::post('page');
        $pageSize = Request::post('pageSize');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        return $this->dao->page($page,$pageSize)->order('id desc')->select();
    }
    /**
     * 后台事件构造方法
     */
    public function __construct()
    {
        $this->dao = new NoticeModel();
    }
}