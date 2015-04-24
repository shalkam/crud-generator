# CrudGenerator
Creates CRUD in MVC pattern for Laravel 5

#Installation
Using composer:
``` php
composer require "shalkam/crud-generator":"dev-master"
```

Add Service providers to `config/app.php`
``` php
'Shalkam\CrudGenerator\CrudGeneratorServiceProvider'
//For column sortable package 
'Kyslik\ColumnSortable\ColumnSortableServiceProvider',
//For Menu package
'Menu\MenuServiceProvider',
```

Add The Menu Facade to `config/app.php`
``` php
'Menu' => 'Menu\Menu',
```

#Basic Usage
Simply Use this artisan command
``` sh
php artisan make:crud ModelName
```
You can replace "ModelName" with a singular model name in CamelCase

Then all you've got to do is to fill in the fields in this format fieldId:fieldType
Field Type corresponds to field types in table schema used in a migration file.
