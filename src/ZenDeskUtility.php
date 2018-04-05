<?php
namespace NomorePackage\zendeskclient;

abstract class ZenDeskUtility
{

    protected $client;

    public function __construct()
    {
        $this->client = new ZenDeskClient();
    }


//    abstract protected function get();
//
//    abstract protected function getAll();
//
//    abstract protected function create();
//
//    abstract protected function update();
//
//    abstract protected function delete();

}