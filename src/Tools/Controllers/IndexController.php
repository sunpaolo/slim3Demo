<?php
namespace Tools\Controllers;

use Lib\BaseController;
use Lib\Util\Config;
use Respect\Validation\Validator;

/*
 * tools的controller基类
 */
class IndexController extends BaseController
{
    /*
     * 模板渲染
     */
    protected function renderTemplate($template, array $data)
    {
        $menuModel = new \Tools\Models\Menu();
        $menus = $menuModel->getMenus('admin');
        $tplData = [
            'menu' => $this->view->fetch('layout/menu.php', ['menus' => $menus]),
            'content' => $this->view->fetch($template, $data),
        ];
        $this->view->render($this->response, 'layout/default.php', $tplData);
    }

    protected function getUser()
    {
        $session = new \Lib\Session();
        return $session->get('user');
    }

    public function login($params)
    {
        $account = $params['account'] ?: '';
        $password = $params['password'] ?: '';
        $remember = $params['remember'] ? true : false;
        if ($account == '111' && $password == '111') {
            $session = new \Lib\Session();
            $session->set('user', $account);
            //TODO 存入cookie
            if ($remember) {
            }
            //$this->renderTemplate('index.php', $params);
            //return;
            return $this->response->withRedirect('/');
        }
        $this->render('login.php', $params);
    }

    public function logout($params)
    {
        $session = new \Lib\Session();
        $session->destroy();
        $this->render('login.php', $params);
    }

    public function index($params)
    {
        $user = $this->getUser();
        if (!$user) {
            $this->render('login.php', $params);
            return;
        }
        $this->renderTemplate('index.php', $params);
    }

}