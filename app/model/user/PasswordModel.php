<?php
/**
 * Created by PhpStorm.
 * File: PasswordModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model\user;

use app\model\BaseModel;

class PasswordModel extends BaseModel
{
    protected $pk = 'id';
    protected $name = 'pwd';
    protected $autoWriteTimestamp = true;
}