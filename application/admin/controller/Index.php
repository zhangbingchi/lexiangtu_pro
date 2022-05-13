<?php

namespace app\admin\controller;


class Index extends Admin {

    use \traits\controller\Jump;

    public function index() {

        $admin = admin_is_login();
        if (!$admin) {
            return view('login/login');
        }
        $this->assign('admin', $admin);

        return view();
    }

    public function home() {
        return view();
    }

}
