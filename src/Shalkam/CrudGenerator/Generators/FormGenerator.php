<?php

namespace Shalkam\CrudGenerator\Generators;

class FormGenerator {

    public function make($params) {
        $path = app_path('Forms/');
        if (!file_exists($path))
            mkdir($path, 0755, true);
        $file = file_get_contents(__DIR__ . '/../Tpl/Form.txt');
        $file = $this->parseTpl($file, $params);

        file_put_contents($path . $params['name'] . '.php', $file);
        
        return $params['name'] . '.php';
    }

    private function parseTpl($file, $params) {
        $fields = $this->parseFields($params['fields']);
        $file = str_replace('$NAMESPACE$', $params['namespace'], $file);
        $file = str_replace('$MODEL_NAME$', $params['name'], $file);
        $file = str_replace('$FIELDS$', implode("\n\t\t", $fields), $file);
        return $file;
    }

    private function parseFields($fields) {
        $formFields = [];

        foreach ($fields as $field) {
            $singleFieldStr = "//->modify('" . $field['fieldName'] . "', 'text', [])";
            $formFields[] = $singleFieldStr . "\n";
        }

        return $formFields;
    }

}
