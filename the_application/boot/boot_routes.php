<?php
//pr("boot_routes.php 1.0.1");
use \TheApplication\Components\ComponentRouter as R;

R::add("/helper-slug:/examples/","Homes","examples");
R::add("/helper-slug:/","Homes","code");
R::add("/versions/","Homes","versions");
R::add("/download/download:/","Homes","download");