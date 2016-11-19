<?php

namespace app;

use app\system\System;

require '../config/autoload.php';

$system = new System();
$system->run();