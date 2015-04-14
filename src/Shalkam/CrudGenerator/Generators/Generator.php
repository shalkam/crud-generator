<?php

namespace Shalkam\CrudGenerator\Generators;

/**
 * Description of Generator
 *
 * @author mostafa
 */
class Generator {

    public static function get($name) {
        switch ($name) {
            case 'model':
                $class = new \Shalkam\CrudGenerator\Generators\ModelGenerator();
                break;
            case 'controller':
                $class = new \Shalkam\CrudGenerator\Generators\ControllerGenerator();
                break;
            case 'view':
                $class = new \Shalkam\CrudGenerator\Generators\ViewGenerator();
                break;
            case 'migration':
                $class = new \Shalkam\CrudGenerator\Generators\MigrationGenerator();
                break;
            case 'form':
                $class = new \Shalkam\CrudGenerator\Generators\FormGenerator();
                break;
            default:
                $class = new \Shalkam\CrudGenerator\Generators\ModelGenerator();
                break;
        }
        return $class;
    }

}
