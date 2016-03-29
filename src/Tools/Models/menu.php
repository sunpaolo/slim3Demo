<?php
namespace Tools\Models;

class Menu
{
    public function getMenus($role = 'admin')
    {
        $menus = [
            'User' => [
                ['name' => 'User Data', 'url' => 'user/getUser', 'perms' => ['admin']],
                ['name' => 'Payment Data', 'url' => 'user/getPayment', 'perms' => ['admin']],
            ],
            'Logs' => [
                ['name' => 'Error Logs', 'url' => 'log/errorLogs', 'perms' => ['admin']],
            ],
            'Report' => [
                ['name' => 'DAU', 'url' => 'report/dau', 'perms' => ['admin']],
                ['name' => 'Payment', 'url' => 'report/payment', 'perms' => ['admin']],
            ],
        ];

        foreach ($menus as $title => $subMenu) {
            foreach ($subMenu as $id => $menu) {
                if (!in_array($role, $menu['perms'])) {
                    unset($subMenu[$menus][$id]);
                }
            }
        }

        return $menus;
    }
}