<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name BehaviourRouter
 * @file behaviour_router.php 
 * @version 1.0.0
 * @date 29-04-20170426 08:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Behaviours;

class BehaviourRouter
{
    private $sPathRoot;
    private $oPagedata;
    
    public function __construct(ComponentPagedata $oPagedata)
    {
        $this->sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->oAppMain = $oPagedata;
    }//__construct

    
}//BehaviourRouter
