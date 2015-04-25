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

    public static function init() {
        return new CrudMenu();
    }

    private function getMenuItems() {
        $cfg = app_path() . '/menu.json';
        $data = null;
        if (file_exists($cfg)) {
            $data = file_get_contents($cfg);
            $data = json_decode($data, TRUE);
        }
        return $data;
    }

    private function getBreadcrumbsItems() {
        $data = [];
        foreach ($this->getMenuItems() as $route => $menuItems) {
            $data[] = ['name' => $route, 'id' => $route];
        }
        return $data;
    }

    public function render() {
        $menu = \Menu\Menu::handler('main')
                ->addClass('sidebar-menu');
        foreach ($this->getMenuItems() as $route => $menuItems) {
            $items = \Menu\Menu::items('main');
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

    public function breadcrumbs() {
        $menu = \Menu\Menu::handler('breadcrumbs');
        foreach ($this->getMenuItems() as $route => $menuItems) {
            $items = \Menu\Menu::items('breadcrumbs');
            foreach ($menuItems as $itemRoute => $itemName) {
                $items->add($itemRoute, $itemName);
            }
            $menu->add($route, $route, $items);
        }
        return $menu->breadcrumbs(function($itemLists) {
                            return $itemLists[1];
                        })
                        ->setElement('ol')
                        ->addClass('breadcrumb');
    }

}
