<?php

namespace Shalkam\CrudGenerator\Generators;

/**
 * Description of ModelGenerator
 *
 * @author mostafa
 */
class ModelGenerator {

    public function make($params) {
        $file = file_get_contents(__DIR__ . '/../Tpl/Model.txt');
        $file = $this->parseTpl($file, $params);
        if (!file_exists(app_path() . '/Models/')) {
            mkdir(app_path() . '/Models/', 0777, true);
        }
        file_put_contents(app_path() . '/Models/' . $params['name'] . '.php', $file);

        return $params['name'] . '.php';
    }

    private function parseTpl($file, $params) {
        $fields = $this->parseFields($params['fields']);
        $file = str_replace('$NAMESPACE$', $params['namespace'], $file);
        $file = str_replace('$MODEL_NAME$', $params['name'], $file);
        $file = str_replace('$TABLE_NAME$', $params['table'], $file);
        $file = str_replace('$FIELDS$', implode(",\n\t\t", $fields['fillable']), $file);
        $file = str_replace('$RULES$', implode(",\n\t\t", $fields['rules']), $file);
        $file = str_replace('$SORTABLE$', implode(",\n\t\t", $fields['sortable']), $file);
        return $file;
    }

    private function parseFields($fields) {
        $rules = [];
        foreach ($fields as $field) {
            if (!empty($field['validations'])) {
                $rule = '"' . $field['fieldName'] . '" => "' . $field['validations'] . '"';
                $rules[] = $rule;
            }
        }
        
        $fillable = [];
        foreach ($fields as $field) {
            $fillable[] = '"' . $field['fieldName'] . '"';
        }

        $sortable = [];
        foreach ($fields as $field) {
            if ($field['sortable']) {
                $sortable[] = '"' . $field['fieldName'] . '"';
            }
        }

        return ['fillable' => $fillable, 'rules' => $rules, 'sortable' => $sortable];
    }

}
