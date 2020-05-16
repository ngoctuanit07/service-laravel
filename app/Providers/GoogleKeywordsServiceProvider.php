<?php

namespace App\Providers;
use App\Console\Commands\FetchCommand;
use Illuminate\Support\ServiceProvider;

class GoogleKeywordsServiceProvider extends ServiceProvider {
    /**
    * Register services.
    *
    * @return void
    */

    public function register() {
        //
        $this->_basicRegister();

        $this->_commandsRegister();

    }

    private function _basicRegister()  {
       // echo base_path('config/laravel-google-keywords.php'); die;
        $configPath = base_path('config/laravel-google-keywords.php');
        $this->mergeConfigFrom( $configPath, 'laravel-google-keywords' );
        $this->publishes( [
            $configPath => config_path( 'laravel-google-keywords.php' )
        ], 'config' );
    }

    private function _commandsRegister()  {
        foreach ( $this->commandsList() as $name => $class ) {
            $this->initCommand( $name, $class );
        }
    }
    protected function commandsList()
    {
        return [
            'fetch' => FetchCommand::class,
        ];
    }

    private function initCommand($name, $class)
    {
        $this->app->singleton("command.laravel-google-keywords.{$name}", function($app) use ($class) {
            return new $class($app);
        });

        $this->commands("command.laravel-google-keywords.{$name}");
    }

    /**
    * Bootstrap services.
    *
    * @return void
    */

    public function boot() {
        //
        $this->loadMigrations();
    }
    protected function loadMigrations()
    {
        $migrationPath = __DIR__.'/../database/migrations';
        $this->publishes([
            $migrationPath => base_path('database/migrations'),
        ], 'migrations');
    }
    /**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
            'laravel-google-keywords',
            'command.laravel-google-keywords.fetch',
        ];
	}
}
