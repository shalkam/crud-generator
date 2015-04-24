<?php

namespace Shalkam\CrudGenerator\Generators;

use Illuminate\Filesystem\Filesystem;

/**
 * Description of ModelGenerator
 *
 * @author mostafa
 */
class ControllerGenerator {

    public function make($params) {
        $file = file_get_contents(__DIR__ . '/../Tpl/Controller.txt');
        $file = $this->parseTpl($file, $params);
        $path = app_path('Http/Controllers/');
        file_put_contents($path . $params['name'] . 'Controller.php', $file);
        file_put_contents(app_path('Http/') . 'routes.php', "\nRoute::resource('{$params['modelsLower']}', '{$params['name']}Controller');", FILE_APPEND);
        $this->menu($params['modelsLower']);
        return $params['name'] . 'Controller.php';
    }

    private function menu($route) {
        $cfg = app_path() . '/menu.json';
        if (file_exists($cfg)) {
            $data = file_get_contents($cfg);
            $data = json_decode($data, TRUE);
            if (!isset($data[$route])) {
                $data[$route] = [$route => 'List', $route . '/create' => 'New'];
            }
        } else {
            $data = [$route => [$route => 'List', $route . '/create' => 'New']];
        }
        return file_put_contents($cfg, json_encode($data));
    }

    private function parseTpl($file, $params) {
        $file = str_replace('$NAMESPACE$', $params['namespace'], $file);
        $file = str_replace('$MODEL_NAME$', $params['name'], $file);
        $file = str_replace('$MODEL_NAME_PLURAL_LOWER$', $params['modelsLower'], $file);
        return $file;
    }

}
