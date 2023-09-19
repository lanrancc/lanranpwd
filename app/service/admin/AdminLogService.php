<?php
/**
 * Created by PhpStorm.
 * File: AdminLogService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\admin;

use app\model\logs\AdminLogModel;
use app\service\BaseService;
use Exception;
use think\db\exception\DbException;
use think\facade\Request;

class AdminLogService extends BaseService
{
    /**统计管理员事件
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function count($admin_id): int
    {
        return $this->dao->where('admin_id',$admin_id)->select()->count();
    }
    /**事件分页
     * @param $admin_id
     * @return AdminLogModel[]|array|\think\Collection
     * @throws DbException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function search($admin_id)
    {
        $page = Request::post('page');
        $pageSize = Request::post('pageSize');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        return $this->dao->where('admin_id',$admin_id)->page($page,$pageSize)->order('id desc')->select();
    }
    /**
     * 获取日志记录列表
     * @author: Lxy <756048855@qq.com>
     * @param $user_id
     * @param null $where
     * @param int $pageSize
     * @param $request
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function LogList($admin_id): \think\Paginator
    {
        $list = $this->dao->where('admin_id',$admin_id)
            ->where(null)->order('id desc')
            ->paginate(15,false);

        return $list;
    }
    /**
     * 日志记录
     * @author: Lxy <756048855@qq.com>
     * @param $admin_id
     * @param $action
     * @param $remark
     * @throws Exception
     */
    public function record($admin_id,$action,$remark)
    {
        $data = [
            'admin_id' => $admin_id,
            'action' => $action,
            'remark' => $remark,
            'ip' => request()->ip(),
            'create_time' => time(),
            'url' => request()->url(),
            'data' => json_encode(request()->isPost()?request()->post():request()->get()),
        ];
        try {
            $this->dao->insert($data);
        } catch (DbException $e)
        {
            throw new Exception('用户行为日志记录失败!数据库操作失败'.$e->getMessage());
        }
    }

    /**
     * 后台事件构造方法
     */
    public function __construct()
    {
        $this->dao = new AdminLogModel();
    }
}