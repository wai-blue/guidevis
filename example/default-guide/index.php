<?php

require('vendor/autoload.php');
require('env.php');

$page = $_GET['page'] ?? '';
$templateConfig = [
  'notFoundPage' => [
    'pageTemplate' => 'not-found',
    'elementTemplates' => [
      'header' => 'header',
      'sidebar' => 'sidebar',
      'footer' => 'footer',
    ],
  ],
  'defaultPageConfig' => [
    'pageTemplate' => 'main',
    'elementTemplates' => [
      'header' => 'header',
      'sidebar' => 'sidebar',
      'footer' => 'footer',
      'onThisPage' => 'on-this-page',
    ],
  ],
];

try {
  $renderer = new \WaiBlue\GuideVis\Loader($page, $env, $templateConfig);
  $renderer->init();
  echo $renderer->render();
} catch (\Exception $e) {
  echo $e->getMessage();
}