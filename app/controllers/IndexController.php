<?php

declare(strict_types=1);



class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if (!isset($_SESSION['userId'])) {
            $this->response->redirect('/user/login');
        }
    }
}
