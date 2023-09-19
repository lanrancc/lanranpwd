<?php
/**
 * Created by PhpStorm.
 * File: AdminLogModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model\logs;

use app\model\BaseModel;

class AdminLogModel extends BaseModel
{
    protected $pk = 'id';
    protected $name = 'admin_logs';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
}