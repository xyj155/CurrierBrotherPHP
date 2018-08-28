<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 22:12
 */

namespace app\index\controller;


use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;

class Push extends Base
{

    /**
     * @return string、
     * 获取推送列表
     */
    public function newsPush()
    {
        try {
            $push_data = Db::table('push')
                ->order('date', 'desc')
                ->select();
            return $this->json_encoding(true, 200, '请求成功', $push_data);
        } catch (DataNotFoundException $e) {
            return $this->json_encoding(false, 200, $e->getMessage(), '');
        } catch (ModelNotFoundException $e) {
            return $this->json_encoding(false, 200, $e->getMessage(), '');
        } catch (DbException $e) {
            return $this->json_encoding(false, 200, $e->getMessage(), '');
        }

    }
}