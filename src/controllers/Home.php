<?php

namespace controllers;

use core\routing\Controller;
use core\twig\TwigConfigure;

class Home extends Controller
{
    public function indexAction(): void
    {
        echo TwigConfigure::getTwigEnvironment()->render('index.twig', ['data' => 'teszt']);
    }

    protected function before()
    {
        echo 'before';
    }

    protected function after()
    {
        echo 'after';
    }
}
