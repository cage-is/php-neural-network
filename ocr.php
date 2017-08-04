<?php
require_once(__DIR__ . '/autoload.php');

use Logging\LogLevelEnum;
use Logging\Logger;
use Train\Train;
use Layers\Layer;
use Train\TrainNumbers;


Logger::setLevel(LogLevelEnum::DEBUG);
new TrainNumbers();
