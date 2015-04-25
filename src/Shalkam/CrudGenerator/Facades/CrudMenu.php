<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Shalkam\CrudGenerator\Facades;

/**
 * Description of Menu
 *
 * @author mostafa
 */
use Menu;

class CrudMenu {

    private static function getMenuItems() {
        $cfg = app_path() . '/menu.json';
        $data = null;
        if (file_exists($cfg)) {
            $data = file_get_contents($cfg);
            $data = json_decode($data, TRUE);
        }
        return $data;
    }

    public static function render() {
        $menu = Menu::handler('main')
                ->addClass('sidebar-menu');
        foreach (self::getMenuItems() as $route => $menuItems) {
            $items = Menu::items();
            foreach ($menuItems as $itemRoute => $itemName) {
                $items->add($itemRoute, '<i class="fa fa-dashboard"></i> <span>' . $itemName . '</span>');
            }
            $items->addClass('treeview-menu');
            $menu->raw('<a href="#">
                    <i class="fa fa-dashboard"></i> <span>' . $route . '</span> <i class="fa fa-angle-left pull-right"></i>
                </a>', $items);
        }
        $menu->getItemsAtDepth(0)->addClass('treeview');
        return $menu->render();
    }

    public static function breadcrumbs() {
        $menu = Menu::handler('main')
                ->addClass('sidebar-menu');
        foreach (self::getMenuItems() as $route => $menuItems) {
            $items = Menu::items();
            foreach ($menuItems as $itemRoute => $itemName) {
                $items->add($itemRoute, '<span>' . $itemName . '</span>');
            }
            $menu->raw('<a href="#"><span>' . $route . '</span></a>', $items);
        }
        return $menu->breadcrumbs()
                        ->setElement('ol')
                        ->addClass('breadcrumb');
    }

}
