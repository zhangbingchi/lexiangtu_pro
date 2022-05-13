<?php

namespace app\admin\controller;

class Login extends \app\common\controller\Base {

    /**
     * @title 退出
     */
    public function logout() {

        cookie('admin', null);

        session('admin', null);

        $this->success('退出成功', url('admin/login/login'));
    }

    /**
     * @title 登录
     * @return type
     */
    public function login() {
        if (request()->isPost()) {
            //  后端验证
            $post = request()->post();
            foreach ($post as $key => $value) {
                $post[$key] = trim($value);
            }

            $msg = model('system_user')->login($post);
            if (empty($msg)) {
                $this->success('', url('admin/index/index'));
            } else {
                $this->error($msg);
            }
        } else {
            return view();
        }
    }
}
