<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Main\TheFrameworkComponent
 * @file theframework_component.php
 * @version 1.0.0
 * @date 08-10-2017 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Components;

use TheFramework\Components\ComponentFile;

class TheFrameworkComponent extends TheFramework
{
    public function __construct()
    {
        //Inicia sesion, carga el dispositivo remoto y el flag de llamada de la consola
        parent::__construct();
        $this->oLog = new ComponentFile();
    }
    //=================================
    //             GETS
    //=================================    
    

    //=================================
    //             SETS
    //=================================
}//TheFrameworkComponent