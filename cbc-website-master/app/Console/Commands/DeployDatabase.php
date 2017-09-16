<?php namespace CityByCitizen\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeployDatabase extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'deploy:db';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $content = File::get(storage_path('sql/'.$this->argument('file').'.sql'));
        $statements = preg_split('/;\s*\r?\n/', $content);
        $count = count($statements);
        $i = 0;

        $this->comment('Reset database');
        $this->call('migrate:refresh');

        $this->comment('Deploying SQL database');
        foreach ($statements as $smt) {
            if ($smt != '') DB::statement($smt);
            $this->comment(++$i.'/'.$count);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['file', InputArgument::REQUIRED, 'SQL file to execute'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
