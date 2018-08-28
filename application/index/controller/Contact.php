<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/26/026
 * Time: 14:04
 */

namespace app\index\controller;


use think\Db;

class Contact extends Base
{
    public $empty = array();

    /**
     * @param $uid
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbExceptionc
     * 查询好友
     */
    public function queryContactByUid($uid)
    {
        $query_user = Db::table('user')
            ->whereLike('username', '%' . $uid . '%')
            ->field('username,head,id,identity')
            ->select();
        if ($query_user) {
            return $this->json_encoding(true, 200, '查询成功', $query_user);
        } else {
            return $this->json_encoding(false, 201, '查询失败', $this->empty);
        }

    }

    /**
     * @param $pid
     * @param $uid
     * @return string
     * 添加新的好友
     */
    public function setUserContact($pid, $uid)
    {
        $user_contact = [
            'pid' => $pid,
            'uid' => $uid
        ];
        $user_insert = Db::table('contact')
            ->insert($user_contact, true);
        if ($user_insert) {
            return $this->json_encoding(true, 200, "添加成功", $this->empty);
        } else {
            return $this->json_encoding(false, 201, "添加失败", $this->empty);
        }
    }

    /**
     * @param $uid
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取好友列表
     */
    public function queryContactList($uid)
    {
        $contact_list = Db::table('contact')
            ->where('pid', $uid)
            ->select();
        $single_contact_arr = array();
        if ($contact_list) {
            foreach ($contact_list as $key) {
                $single_contact = Db::table('user')
                    ->where('id', $key['uid'])
                    ->field('username,head')
                    ->find();
                array_push($single_contact_arr, $single_contact);
            }
            return $this->json_encoding(true, 200, "添加成功", $single_contact_arr);
        } else if (sizeof($contact_list == 0)) {
            return $this->json_encoding(false, 203, "添加失败", $this->empty);
        } else {
            return $this->json_encoding(false, 201, "添加失败", $this->empty);
        }

    }
}