<?php

namespace controllers;

use core\routing\Controller;

class Posts extends Controller
{
    public function indexAction(): void
    {
        echo 'posts/index';
     var_dump($_GET);
    }

    public function addNewAction(): void
    {
        echo 'posts/new';
    }

    public function editAction(): void
    {
       var_dump($this->routeParams);
    }
}
