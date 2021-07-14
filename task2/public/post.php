<?php 
declare(strict_types=1);

if (! \defined('PROJECT_DIR')) {
    \define('PROJECT_DIR', \realpath($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '..'));
}

require_once \implode(DIRECTORY_SEPARATOR, [PROJECT_DIR, 'src', 'App.php']);

$app = new \App();
echo $app->init();
