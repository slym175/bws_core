<?php

namespace Bws\Core\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CoreMakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $module_names = $this->ask('Enter module name (Ex: Product Post ...): ');
        $module_names = explode(" ", $module_names);
        $this->call('module:make', ['name' => $module_names]);
        foreach ($module_names as $module_name) {
            $module_name_repository = $module_name.'Repository';
            $module_name_repository_interface = $module_name_repository.'Interface';
            if($this->confirm('Generate model?', false)) {
                $module_migration = $this->confirm('Do you want to create module migration', true);
                $module_fillable = $this->ask('Enter fillable field: ');
                $this->call('module:make-model', [
                    'model' => $module_name,
                    'module' => $module_name,
                    '--fillable' => $module_fillable,
                    '--migration' => $module_migration
                ]);
                $this->call('module:make-repository-interface', [
                    'repository_interface' => $module_name_repository_interface,
                    'module' => $module_name,
                ]);
                $this->call('module:make-repository', [
                    'repository' => $module_name_repository,
                    'module' => $module_name,
                ]);
                $requests = [
                    'List'.$module_name.'Request',
                    'Create'.$module_name.'Request',
                    'Store'.$module_name.'Request',
                    'Show'.$module_name.'Request',
                    'Edit'.$module_name.'Request',
                    'Update'.$module_name.'Request',
                    'Delete'.$module_name.'Request',
                ];
                foreach ($requests as $request) {
                    $this->call('module:make-request', [
                        'name' => $request,
                        'module' => $module_name
                    ]);
                }
            }
        }
        $this->call('optimize');
        (new Process(['composer', 'dump-autoload'], base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
