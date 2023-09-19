<?php
/**
 * Created by PhpStorm.
 * File: PasswordValidate.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\validate;

use think\Validate;

class PasswordValidate extends Validate
{
    protected $rule = [
        'title' => 'require|min:3|max:30',
        'desc' => 'require|min:3|max:255',
        'username' => 'require|min:3|max:30',
        'password' => 'require|min:3|max:30',
        'weburl' => 'require|min:3|max:60',
    ];
    protected $message = [];
}