<?php
require_once __DIR__ . '/../Symfony/Component/ClassLoader/UniversalClassLoader.php';

use \Symfony\Component\ClassLoader\UniversalClassLoader;

$classLoader = new UniversalClassLoader();
$classLoader->registerNamespace('Symfony', __DIR__ . DIRECTORY_SEPARATOR . '..');
$classLoader->registerNamespace('Icone', __DIR__ . DIRECTORY_SEPARATOR . '..');
$classLoader->register();
?>