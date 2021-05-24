<?php

namespace controllers\admin;

use core\routing\Controller;

class Users extends Controller
{
    public function indexAction()
    {
        echo 'users';
    }

    protected function before()
    {

    }
}