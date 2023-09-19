<?php
/**
 * Created by PhpStorm.
 * File: NoticeModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model\admin;

use app\model\BaseModel;

class NoticeModel extends BaseModel
{
    protected $pk = 'id';
    protected $name = 'notice';
    protected $autoWriteTimestamp = true;
}