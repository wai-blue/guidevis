<?php

require(__DIR__ . '/vendor/autoload.php');

spl_autoload_register(function($className) {
  if (str_starts_with($className, 'DocsRenderer')) {
    $className = str_replace('\\', '/', $className);
    $className = str_replace('DocsRenderer', '', $className);
    $className = trim($className, '/');

    require_once(__DIR__ . '/src/' . $className . '.php');
    
  }
});

$route = $_GET['route'] ?? '';
$options = [
  'booksRootUrl' => '/github/ceremonycrm-docs/books',
  'booksRootFolder' => __DIR__ . '/books',
];

try {
  $renderer = new \DocsRenderer\Loader($route, $options);
  $renderer->init();
  echo $renderer->render();
} catch (\Exception $e) {
  echo $e->getMessage();
}