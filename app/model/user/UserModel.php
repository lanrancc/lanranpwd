<?php
/**
 * Created by PhpStorm.
 * File: UserModel.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\model\user;

use app\model\BaseModel;

class UserModel extends BaseModel
{
    protected $pk = 'id';
    protected $name = 'users';
    protected $autoWriteTimestamp = true;
}