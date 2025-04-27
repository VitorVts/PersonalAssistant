<?php

require 'vendor/autoload.php';

use App\Controllers\WebhookController;

$controller = new WebhookController();
$controller->handle();

