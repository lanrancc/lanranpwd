<?php
/**
 * Created by PhpStorm.
 * File: BaseModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model;

use think\Model;

class BaseModel extends Model
{
    /**获取一条数据
     * @param $where
     * @param $order
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getOne($where,$order = 'desc') : array
    {
        $row = $this->where($where)->order($this->pk,$order)->find();
        return $row?$row->toArray():[];
    }
}