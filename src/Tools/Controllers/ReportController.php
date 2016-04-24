<?php
namespace Tools\Controllers;

class ReportController extends IndexController
{
    public function dau($params)
    {
        $this->renderTemplate('index.php', ['name' => 'dau']);
    }

    public function payment($params)
    {
        $this->renderTemplate('index.php', ['name' => 'payment']);
    }
}