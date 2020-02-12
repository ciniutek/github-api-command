<?php

namespace App\Http\Controllers;

use App\Repositories\GithubCommitesRepositories;

class GithubController extends Controller
{

    private $commitRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GithubCommitesRepositories $commitRepository) 
    {
        $this->commitRepository = $commitRepository;
        $this->commitRepository->setRepo('multilevel-menu-laravel');
        $this->commitRepository->setBranch('master');
    }
    
    public function showAllCommites()
    {
        $commits = $this->commitRepository->allCommites();        
        return response()->json($commits);
    }
    
    public function showLastCommit()
    {        
        $commit = $this->commitRepository->getLastCommit();  
        return response()->json($commit);
    }
    
    public function showLastCommitParameter($name)
    {
        $commit = $this->commitRepository->getLastCommitParameter($name);  
        return $commit;
    }
  
}