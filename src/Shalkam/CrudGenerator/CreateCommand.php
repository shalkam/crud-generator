<?php

namespace Shalkam\CrudGenerator;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Shalkam\CrudGenerator\Generators\Generator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:crud';

    /**
     * The model name.
     *
     * @var string
     */
    protected $model;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new CRUD in MVC pattern.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $model = ucfirst(strtolower($this->argument('model')));
        $models = Str::plural($model);
        $table = strtolower(Str::snake($models));
        $modelsLower = strtolower($models);
        $fields = $this->getInputFields();
        $modelGen = Generator::get('model')->make([
            'name' => $model,
            'namespace' => 'App\Models',
            'table' => $table,
            'fields' => $fields,
        ]);
        $this->info("\nModel : {$modelGen} Created.");
        $controllerGen = Generator::get('controller')->make([
            'name' => $model,
            'namespace' => 'App\Http\Controllers',
            'modelsLower' => $modelsLower,
        ]);
        $this->info("\nController : {$controllerGen} Created.");
        $this->info("\nRoute : {$modelsLower} Added.");
        $viewGen = Generator::get('view')->make([
            'name' => $model,
            'modelsLower' => $modelsLower,
            'models' => $models,
        ]);
        $this->info("\nView : {$modelsLower} Created.");

        $migrationGen = Generator::get('migration')->make([
            'models' => $models,
            'table' => $table,
            'fields' => $fields,
        ]);
        $this->info("\nMigration Created:");
        $this->comment($migrationGen);

        $formGen = Generator::get('form')->make([
            'name' => $model,
            'models' => $models,
            'fields' => $fields,
            'namespace' => 'App\Forms',
        ]);
        $this->info("\nForm Created:");
        $this->comment($formGen);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('model', InputArgument::REQUIRED, 'Model name.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL,
                'Model name.', null],
        ];
    }

    public function getInputFields() {
        $fields = [];

        $this->info("Specify fields for the model (skip id & timestamp fields, will be added automatically)");
        $this->info("Left blank to finish");

        while (true) {
            $fieldInputStr = $this->ask("Field:");

            if (empty($fieldInputStr))
                break;

            $fieldInputs = explode(":", $fieldInputStr);

            if (sizeof($fieldInputs) < 2) {
                $this->error("Invalid Input. Try again");
                continue;
            }

            $fieldName = $fieldInputs[0];

            $fieldTypeOptions = explode(",", $fieldInputs[1]);
            $fieldType = $fieldTypeOptions[0];
            $fieldTypeParams = [];
            if (sizeof($fieldTypeOptions) > 1) {
                for ($i = 1; $i < sizeof($fieldTypeOptions); $i++)
                    $fieldTypeParams[] = $fieldTypeOptions[$i];
            }

            $fieldOptions = [];
            if (sizeof($fieldInputs) > 2)
                $fieldOptions[] = $fieldInputs[2];

            $validations = $this->ask("Enter validations: ");

            $field = [
                'fieldName' => $fieldName,
                'fieldType' => $fieldType,
                'fieldTypeParams' => $fieldTypeParams,
                'fieldOptions' => $fieldOptions,
                'validations' => $validations
            ];

            $fields[] = $field;
        }

        return $fields;
    }

}
