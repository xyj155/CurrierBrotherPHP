<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 0:54
 */

namespace app\index\controller;


use think\Controller;

class Base extends Controller
{
    /***-
     * @param $success
     * @param $code
     * @param $msg
     * @param $data
     * @return string
     * json 统一格式化
     */
    public function json_encoding($success, $code, $msg, $data)
    {
        $json_arr = ['success' => $success,
            'code' => $code,
            'msg' => $msg,
            'data' => $data];
        return json_encode($json_arr);
    }
}