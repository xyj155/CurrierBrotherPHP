<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/8/008
 * Time: 11:17
 */

namespace app\index\controller;


use think\Db;

class Feedback extends Base
{
    public function UserFeedBack($im, $username, $id, $content)
    {
        $feed_back = [
            'im' => $im,
            'username' => $username,
            'userid' => $id,
            'content' => $content
        ];
        $feed_back_db = Db::table('feedback')
            ->insert($feed_back);
        if ($feed_back_db) {
            return $this->json_encoding(true, 200, '提交成功',null);
        } else {
            return $this->json_encoding(false, 201, '提交失败',null);
        }

    }
}