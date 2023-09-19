<?php
/**
 * Created by PhpStorm.
 * File: LoadConfigs.php
 * User: lanran <756048855@qq.com>
 *生活不止眼前的苟且，还有代码和远方
 */

namespace app\middleware;

use think\facade\Config;
use think\facade\Db;

class LoadConfigs
{
    public function handle($request, \Closure $next)
    {
        $rows = Db::table('lxy_configs')->field(true)->cache(false)->select();
        $config = array();
        foreach ($rows as $row) {
            $config[$row['key']] = $row['value'];
        }
        config::set($config, 'lxy');

        return $next($request);
    }
}