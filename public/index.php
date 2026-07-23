<?php

require '../core/Database.php';
require '../core/Model.php';
require '../core/Controller.php';
require '../models/Page.php';
require '../controllers/PageController.php';
require '../core/Router.php';

$router = new Router();
$router->route();