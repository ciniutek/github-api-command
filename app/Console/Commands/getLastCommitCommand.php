<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\GithubCommitesRepositories;

class getLastCommitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repo:get-last-commit-sha {--service=} {repo} {branch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get last commit Sha from branch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    private $commitRepository;
    
    private $allowedService = [
        'github' => true
    ];
    
    public function __construct(GithubCommitesRepositories $commitRepository)
    {
        parent::__construct();
        $this->commitRepository = $commitRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {         
        
        $ex_repo = $this->checkRepoName();
        
        $user = $ex_repo[0];
        $repo = $ex_repo[1];
        $branch = $this->argument('branch');
        $service = $this->option('service');
        
        $this->checkAllowedService($service);
        
        $this->commitRepository->setRepo($repo);
        $this->commitRepository->setBranch($branch);
        $this->commitRepository->setUser($user);
        $commit = $this->commitRepository->getLastCommitParameter('sha');
                
        $this->info($commit);
    }
    
    private function checkAllowedService($service)
    {
        if($service != null && !array_key_exists($service, $this->allowedService))
        {
            $this->error('Unknown service '.$service.'!'); 
            exit;
        }
    }
    
    private function checkRepoName()
    {
        $name = explode('/',$this->argument('repo'));
        
        if(count($name) != 2)
        {
            $this->error('Bad repo name!'); 
            exit;
        }
    }
}
