<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/28
 * Time: 14:24
 */

namespace app\index\controller;


use think\Db;
use think\Session;

class User extends Base
{
    public $empty = array();

    /***
     * @param $username
     * @param $password
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 用户登陆
     */
    public function login($username, $password)
    {
        $user_login = Db::table('user')
            ->where('username', $username)
            ->where('password', $password)
            ->select();
        if ($user_login) {
            return $this->json_encoding(true, 200, '登陆成功', $user_login);
        } else {
            return $this->json_encoding(false, 201, '账号或密码错误', $user_login);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 用户上传头像
     */

    public function loadHead($id)
    {
        $file = request()->file('image');
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $img_url = $info->getSaveName();
                $img_url_replace = str_replace('\\', '/', $img_url);
                $update_avart = Db::table('user')
                    ->where('id', $id)
                    ->update(['head' => 'http://122.152.231.185/CurrierBrother/public/uploads/' . $img_url_replace]);
                if ($update_avart){
                    $user_infor = Db::table('user')
                        ->where('id', $id)
                        ->select();
                    return $this->json_encoding(true, 200, '上传成功', $user_infor);
                }else{
                    return $this->json_encoding(false, 201, '上传失败', $this->empty);
                }
            } else {
                return $this->json_encoding(false, 201, '上传失败', $this->empty);
            }
        } else {
            return $this->json_encoding(false, 203, '上传失败', $this->empty);
        }
    }

    public function register($username, $password, $tel)
    {
        $user_insert = [
            'username' => $username,
            'password' => $password,
            'usertel' => $tel
        ];
        $single_user = Db::table('user')
            ->where('username', $username)
            ->find();
        if ($single_user) {
            return $this->json_encoding(false, 203, '用户已存在', '');
        } else {
            $insert_success = Db::table('user')
                ->insert($user_insert, true);
            if ($insert_success) {
                $user_infor = Db::table('user')
                    ->where('username', $username)
                    ->select();
                return $this->json_encoding(true, 200, '注册成功', $user_infor);
            } else {
                return $this->json_encoding(false, 201, '注册失败', '');
            }
        }

    }

    public function queryUserInfor($id)
    {
        $user_infor = Db::table('user')
            ->where('id', $id)
            ->select();
        if ($user_infor) {
            return $this->json_encoding(true, 200, '登陆成功', $user_infor);
        } else {
            return $this->json_encoding(false, 201, '账号或密码错误', $user_infor);
        }
    }
}