<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

//开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。
// require_once APP_PATH . '/Common/Common/addon.php'; //加载插件相关公共函数库
require_once APP_PATH . '/Common/Common/developer.php'; //加载开发者二次开发公共函数库

/**
 * 根据配置类型解析配置
 * @param  string $type  配置类型
 * @param  string  $value 配置值
 */
function parse_attr($value, $type = null)
{
    switch ($type) {
        default: //解析"1:1\r\n2:3"格式字符串为数组
            $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
            if (strpos($value, ':')) {
                $value = array();
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            } else {
                $value = $array;
            }
            break;
    }
    return $value;
}


/**
 * 根据用户ID获取用户信息
 * @param  integer $id 用户ID
 * @param  string $field
 * @return array  用户信息
 * @author jry <598821125@qq.com>
 */
function get_user_info($id, $field)
{
    if (D('Admin/Module')->where('name="User" and status="1"')->count()) {
        $user_onject = D('User/User');
    } else {
        $user_onject = D('Admin/User');
    }
    $userinfo = $user_onject->find($id);
    if (!$field) {
        return $userinfo;
    }
    if ($userinfo[$field]) {
        return $userinfo[$field];
    } else {
        return false;
    }
}
