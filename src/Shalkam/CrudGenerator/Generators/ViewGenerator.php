<?php

namespace Shalkam\CrudGenerator\Generators;

/**
 * Description of ViewGenerator
 *
 * @author mostafa
 */
class ViewGenerator {

    public function make($params) {
        $path = base_path('resources/views/') . $params['modelsLower'];
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $this->parseTpl('edit', $params);
        $this->parseTpl('details', $params);
        $this->parseTpl('list', $params);
    }

    private function parseTpl($tpl, $params) {
        $path = base_path('resources/views/') . $params['modelsLower'];
        $file = file_get_contents(__DIR__ . '/../Tpl/Views/' . $tpl . '.blade.txt');
        $file = str_replace('$MODEL_NAME$', $params['name'], $file);
        $file = str_replace('$MODEL_NAME_PLURAL$', $params['models'], $file);
        file_put_contents($path . '/' . $tpl . '.blade.php', $file);
    }

}
