<?php

namespace App\Repositories;

use App\Repositories\CommitesRepositoriesInterface;

class GithubCommitesRepositories implements CommitesRepositoriesInterface 
{
    
    private $client;
    private $userName;
    private $repoName;
    private $branchName;

    public function __construct(\Github\Client $client)
    {
      $this->client = $client;
      $this->userName = env('GITHUB_USERNAME');
      $this->branchName = env('GITHUB_BRANCHNAME');
      $this->repoName = env('GITHUB_REPONAME');
    }
    
    public function allCommites()
    {
        return $this->client->api('repo')->commits()->all($this->userName, $this->repoName, ['sha' => $this->branchName]); 
    }
    
    public function getLastCommit()
    {
        return $this->getCommitById(0);
    }
    
    public function getLastCommitParameter($name)
    {
        return $this->getParameter($name,$this->getCommitById(0));
    }
        
    private function getCommitById($id)
    {
        if(array_key_exists($id, $this->allCommites())){
            return $this->allCommites()[0];
        }
        return abort(404);
    }
    
    private function getParameter($name, array $commit) : string
    {
        if(array_key_exists($name, $commit)){
            return $commit[$name];
        }
        return abort(404);
    }
    
    public function setBranch($name)
    {
        $this->branchName = $name;
    }
    
    public function setRepo($name)
    {
        $this->repoName = $name;
    }
    
    public function setUser($name)
    {
        $this->userName = $name;
    }
}