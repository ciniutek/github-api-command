<?php

namespace App\Repositories;

interface CommitesRepositoriesInterface 
{
    public function allCommites();

    public function getLastCommit();
    
    public function getLastCommitParameter($name);
    
    public function setRepo($name);
    
    public function setBranch($name);
    
    public function setUser($name);
}