<?php
/**
 * Created by PhpStorm.
 * File: index.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */
use think\facade\Route;

Route::group(static function(){
    Route::any('/login','index/login');
    Route::any('/index','system/index');
    Route::rule('/data/[:act]', 'system/data');
    Route::rule('ajax/data/[:act]/[:do]', 'ajax/data');
});
