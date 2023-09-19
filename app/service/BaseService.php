<?php
/**
 * Created by PhpStorm.
 * File: BaseService.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\service;

class BaseService
{
    protected $dao;
    protected $update_id;
    /**
     * 仅更新
     * @author: Lxy <756048855@qq.com>
     * @param $where
     * @param $data
     * @return bool
     */
    public function onlyUpdate($where,$data)
    {
        // 判断条件
        if ($row = $this->dao->where($where)->find())
        {
            $this->update_id = $row->id;
            $row->save($data);
            return true;
        }
        return false;
    }

    /**
     * 删除单条数据
     * @author: Lxy <756048855@qq.com>
     * @param $where
     * @return mixed
     */
    public function delOne($where)
    {
        // 先查询再删除
        return $this->dao->where($where)->delete();
    }

    /**
     * 获取单条数据
     * @author: Lxy <756048855@qq.com>
     * @param $where
     * @return mixed
     */
    public function getOne($where)
    {
        return $this->dao->where($where)->find();
    }
}