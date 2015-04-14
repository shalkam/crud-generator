<?php

namespace Shalkam\CrudGenerator\Generators;

class MigrationGenerator {

    public function make($params) {
        $path = base_path('database/migrations/');
        $file = file_get_contents(__DIR__ . '/../Tpl/Migration.txt');
        $file = $this->parseTpl($file, $params);
        $template = $this->parseTpl($file, $params);
        $fileName = date('Y_m_d_His') . "_" . "create_" . $params['table'] . "_table.php";
        $filePath = $path . $fileName;
        file_put_contents($filePath, $template);
        return $fileName;
    }

    private function parseTpl($file, $params) {
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $params['models'], $file);

        $templateData = str_replace('$TABLE_NAME$', $params['table'], $templateData);

        $templateData = str_replace('$FIELDS$', $this->generateFieldsStr($params['fields']), $templateData);

        return $templateData;
    }

    private function generateFieldsStr($fields) {
        $fieldsStr = "\$table->increments('id');\n";

        foreach ($fields as $field) {
            $fieldsStr .= $this->createField($field);
        }
        $fieldsStr .= "\t\t\t\$table->timestamps();";
        return $fieldsStr;
    }

    private function createField($field) {
        $fieldStr = "\t\t\t\$table->" . $field['fieldType'] . "('" . $field['fieldName'] . "'";

        if (!empty($field['fieldTypeParams'])) {
            foreach ($field['fieldTypeParams'] as $param) {
                $fieldStr .= ", " . $param;
            }
        }

        $fieldStr .= ")";

        if (!empty($field['fieldOptions'])) {
            foreach ($field['fieldOptions'] as $option) {
                if ($option == 'primary')
                    $fieldStr .= "->primary()";
                elseif ($option == 'unique')
                    $fieldStr .= "->unique()";
                else
                    $fieldStr .= "->" . $option;
            }
        }

        if (!empty($fieldStr))
            $fieldStr .= ";\n";

        return $fieldStr;
    }

}
