<?php
/**
 * Created by PhpStorm.
 * File: AccountValidate.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\validate;

use think\Validate;

class AccountValidate extends Validate
{
    protected $rule = [
        'account' => 'require|min:5|max:25',
        'password' => 'require|min:6|alphaNum|max:18',
        'repass' => 'require|confirm:password',
        'qq' => 'require|number|max:10',
        'captcha|验证码'=>'require|captcha',
        'oldpass' => 'require|min:6|alphaNum|max:18',
        'cpass' => 'require|min:6|alphaNum|max:18',
        'mail' => 'require|email',
    ];

    protected $message = [
        'account.require' => '用户名不能为空',
        'account.min' => '请输入不低于5位的用户名',
        'account.max' => '请输入5-25位的用户名',
        'password.require' => '密码不能为空',
        'password.min' => '请输入不低于6位的用户密码',
        'password.max' => '请输入6-16位的用户密码',
        'password.alphaNum' => '密码只能是字母和数字！',
        'qq.require' => 'QQ号码不能为空',
        'oldpass.require' => '原密码不能为空',
        'oldpass.min' => '请输入不低于6位的用户密码',
        'oldpass.max' => '请输入6-18位的用户密码',
        'oldpass.alphaNum' => '密码只能是字母和数字！',
        'cpass' => '两次输入的密码不一致',
        'cpass.require' => '二次密码确认不能为空',
    ];

    protected $scene = [
        'login' => ['account', 'password'],
        'reg' => ['account', 'password', 'repass', 'qq'],
        'changePassWord'=>['oldpass','password','cpass'],
        'find'=> ['mail','captcha'],
        'reset' => ['password','repass'],
    ];
}