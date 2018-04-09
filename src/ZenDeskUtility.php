<?php
namespace NomorePackage\Zendeskclient;

abstract class ZenDeskUtility
{

    protected $client;

    public function __construct()
    {
        $this->client = new ZenDeskClient();
    }

    public function count($results){

        return $results['count'];
    }

    public function listTickets($results){

        try{
            return $results['tickets'];
        }catch(\Exception $e){
            return $results['results'];
        }
    }

    public function listUsers($results){
        return $results['users'];
    }

    public function findRequester($requesters, $id){

        foreach ($requesters as $requester):
            if($requester->id == $id) return $requester;
        endforeach;

        return null;
    }

}