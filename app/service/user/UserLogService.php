<?php
/**
 * Created by PhpStorm.
 * File: UserLogService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service\user;

use app\model\logs\UserLogModel;
use app\service\BaseService;
use Exception;
use think\facade\Request;
use think\facade\Session;

class UserLogService extends BaseService
{
    /**统计用户事件
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function count(): int
    {
        $user_id = Session::get('user.id');
        return $this->dao->where('user_id',$user_id)->select()->count();
    }

    /**事件分页
     * @return UserLogModel[]|array|\think\Collection
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
        return $this->dao->where('user_id',$user_id)->page($page,$pageSize)->order('id asc')->select();
    }
    /**获取日志记录列表
     * @param $user_id
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function LogList($user_id): \think\Paginator
    {
        $list = $this->dao->where('user_id',$user_id)
            ->where(null)->order('id desc')
            ->paginate(15,false);

        return $list;
    }

    /**日志记录
     * @param $user_id
     * @param $action
     * @param $remark
     * @return void
     * @throws Exception
     */
    public function record($user_id,$action,$remark): void
    {
        $data = [
            'user_id' => $user_id,//用户id
            'action' => $action,//操作
            'remark' => $remark,//注明
            'ip' => request()->ip(),//ip
            'create_time' => time(),//创建时间戳
//            'url' => request()->url(),
//            'data' => json_encode(request()->isPost()?request()->post():request()->get()),
        ];
        try {
            $this->dao->insert($data);
        } catch (\Exception $e)
        {
            throw new Exception('用户行为日志记录失败!数据库操作失败'.$e->getMessage());
        }
    }

    /**
     * 用户事件构造方法
     */
    public function __construct()
    {
        $this->dao = new UserLogModel();
    }
}