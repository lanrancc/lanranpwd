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
    Route::any('/register','index/register');
    Route::any('/index','panel/index');
    Route::any('/passwordList','panel/passwordList');
    Route::any('/randKey','randKey/index');
    Route::any('/notepad','notepad/index');
    Route::rule('/data/[:act]', 'panel/data');
    Route::rule('ajax/data/[:act]/[:do]', 'ajax/data');
});
