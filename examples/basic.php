<?php

require('vendor/autoload.php');

$route = $_GET['route'] ?? '';
$options = [
  'bookRootFolder' => __DIR__ . '/book',
  'bookRootUrl' => '/book',
];

$pageData = ['randVar' => rand(1000, 9999)];

try {
  $renderer = new \WaiBlue\GuideVis\Loader($route, $options, $pageData);
  $renderer->init();
  echo $renderer->render();
} catch (\Exception $e) {
  echo $e->getMessage();
}