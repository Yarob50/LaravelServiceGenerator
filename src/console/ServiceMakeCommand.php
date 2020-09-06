<?php

namespace Yarob\LaravelServiceGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = '/stubs/service.stub';
        return $this->resolveStubPath($stub);
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('laravelServiceGenerator.service_dir_path','\Http\Services');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['no-interface', null, InputOption::VALUE_NONE, 'Creates A Service Only Without An Interface'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // call the parent handle which will be in charge of creating the service class
        parent::handle();

        // to create the interface with the service, two conditions should be met: the first one
        // is that there the option (--no-interface) is not passed with the command && the second one
        // is that the value of (create_interface_enabled) is not set to false in the config file
        $noInterface = $this->option('no-interface');
        $createInterfaceEnabled = config('laravelServiceGenerator.create_interface_enabled',true);
        if (!$noInterface && $createInterfaceEnabled) {
            // and then, if the create interface is enabled, then create the service interface by executing the command of make:service-interface where
            // name will be the same name of the service but with adding Interface word
            $this->call('make:service-interface', [
                'name' => $this->getNameInput().'Interface'
            ]);
        }
        
    }
}
