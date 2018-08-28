<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 0:13
 */

namespace app\index\controller;


use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;

class Order extends Base
{
    /**
     * @param $userid
     * @return string
     * @throws DataNotFoundException
     * @throws DbException 获取订单列表
     * @throws ModelNotFoundException
     */
    public function getOrderList($userid)
    {
        $order_time = Db::table('userscan')
            ->whereTime('createtime', 'd')
            ->where('userid', $userid)
            ->select();
        return $this->json_encoding(true, 200, '成功', $order_time);
    }

    /**
     * @param $userid
     * @return string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * 根据用户id查询订单
     */
    public function getPackageStation($userid)
    {
        $user_packet = Db::table('userscan')
            ->where('userid', $userid)
            ->select();
        return $this->json_encoding(true,200,'查询成功',$user_packet);
    }

    /**
     * @param $input
     * @return string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * 模糊查询订单编号
     */
    public function searchOrder($input)
    {
        if (!($input == null)) {
            $search_order = Db::table('userscan')
                ->whereLike('ordernum', '%' . $input . '%')
                ->select();
            return $this->json_encoding(true, 200, '查询成功', $search_order);
        } else {
            return $this->json_encoding(true, 200, '查询成功', "");
        }
    }
}