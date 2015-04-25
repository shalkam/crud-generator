<?php

namespace Shalkam\CrudGenerator\Base;

use Kris\LaravelFormBuilder\Form;
use DB;

class BaseForm extends Form {

    public $table;
    private $columnTofield = [
        'int' => 'text',
        'double' => 'text',
        'tinytext' => 'text',
        'decimal' => 'text',
        'text' => 'textarea',
        'timestamp' => 'datetime-local',
        'datetime' => 'datetime-local',
        'date' => 'date',
        'varchar' => 'text',
        'tinyint' => 'checkbox',
    ];

    public function buildForm() {
        $this->columnsToFields();
    }

    private function columnsToFields() {
        $table_info_columns = DB::select(DB::raw('SHOW COLUMNS FROM ' . $this->getModel()->getTable()));

        foreach ($table_info_columns as $column) {
            if (in_array($column->Field, $this->getModel()->getFillable())) {
                $type = $column->Type;
                if (stristr($type, '(', TRUE)) {
                    $type = stristr($type, '(', TRUE);
                }
                $attr = [
                    'label' => $column->Field
                ];
                if ($this->columnTofield[$type] == 'textarea') {
                    $attr['attr']['class'] = 'textCkedit';
                }
                $this->add($column->Field, $this->columnTofield[$type], $attr);
            }
        }
    }

}
