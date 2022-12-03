<?php

require __DIR__ . '/vendor/autoload.php';


use Gustavovinicius\Mkfig\Renderer\PHPRenderer;

$app = new Gustavovinicius\Mkfig\App();

$app->setRender(new PHPRenderer);

require __DIR__ . '/router.php';

$app->run();
