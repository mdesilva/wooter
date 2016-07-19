<?php

use Wooter\Wooter\Assetic\Manager\Assetic;
use Wooter\Wooter\Assetic\Loader\AsseticLoader;

function assetic($type, $files, $index=true){
    $data = new Assetic($type, $files, $index);
    return $data;
}

function loadApp($type){
    $data = new AsseticLoader($type);
    return $data;
}