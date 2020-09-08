<?php

namespace Yarob\LaravelServiceGenerator\Tests\Unit;

use Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Yarob\LaravelServiceGenerator\Tests\TestCase;

class MakeServiceCommandTest extends TestCase
{
    protected $serviceName;
    protected $servicePath;
    protected $serviceInterfacePath;

    public function setUp(): void
    {
        parent::setUp();

        $this->serviceName = "TestService";
        $this->servicePath = app_path("Http/Services/".$this->serviceName.".php");
        $this->serviceInterfacePath = app_path("Http/Services/".$this->serviceName."Interface.php");
        
    }

    /** @test */
    function make_service_command_creates_service_and_service_interface()
    {
        // make sure we're starting from a clean state
        if (File::exists($this->servicePath)) {
            unlink($this->servicePath);
        }

        if (File::exists($this->serviceInterfacePath)) {
            unlink($this->serviceInterfacePath);
        }
        
        $this->assertFalse(File::exists($this->servicePath));
        $this->assertFalse(File::exists($this->serviceInterfacePath));
        
        
        // make the command
        Artisan::call('make:service '.$this->serviceName);

        $this->assertTrue(File::exists($this->servicePath));
        $this->assertTrue(File::exists($this->serviceInterfacePath));

        // when the service is created with the interface, the file of the service should contain the word (implements)
        // which indicates that the service is extending the interface
        $fileContent = file_get_contents($this->servicePath);
        $extendsIncluded = str_contains($fileContent, "implements");
        $this->assertTrue($extendsIncluded);
    }

    /** @test */
    function make_service_command_with_no_interface_option_creates_service_without_interface()
    {
        // make sure we're starting from a clean state
        if (File::exists($this->servicePath)) {
            unlink($this->servicePath);
        }

        if (File::exists($this->serviceInterfacePath)) {
            unlink($this->serviceInterfacePath);
        }
        
        $this->assertFalse(File::exists($this->servicePath));
        $this->assertFalse(File::exists($this->serviceInterfacePath));
        
        
        // make the command
        Artisan::call('make:service '.$this->serviceName.' --no-interface');
        
        $this->assertTrue(File::exists($this->servicePath));
        $this->assertFalse(File::exists($this->serviceInterfacePath));

        // check the content of the generated service file
        $fileContent = file_get_contents($this->servicePath);
        $extendsIncluded = str_contains($fileContent, "implements");
        $this->assertFalse($extendsIncluded);
    }

    /** @test */
    function make_service_command_with_disabling_interface_config_creates_service_without_interface()
    {
        Config::set('laravelServiceGenerator.create_interface_enabled', false);

        // make sure we're starting from a clean state
        if (File::exists($this->servicePath)) {
            unlink($this->servicePath);
        }

        if (File::exists($this->serviceInterfacePath)) {
            unlink($this->serviceInterfacePath);
        }
        
        $this->assertFalse(File::exists($this->servicePath));
        $this->assertFalse(File::exists($this->serviceInterfacePath));
        
        
        // make the command
        Artisan::call('make:service '.$this->serviceName);
        
        $this->assertTrue(File::exists($this->servicePath));
        $this->assertFalse(File::exists($this->serviceInterfacePath));

        // check the content of the generated service file
        $fileContent = file_get_contents($this->servicePath);
        $extendsIncluded = str_contains($fileContent, "implements");
        $this->assertFalse($extendsIncluded);
    }
}