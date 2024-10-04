<?php

namespace DocsRenderer;

class Loader {
  public string $route;
  public array $env;
  public string $book;
  public string $page;

  public string $pageConfigFile;
  public string $pageContentFile;

  public array $pageConfig;
  public string $pageContentMd;

  public \Twig\Environment $twig;

  public function __construct(string $route, array $env) {

    $this->route = $route;
    $this->env = $env;

    $this->book = substr($route, 0, strpos($route, '/'));
    $this->page = substr($route, strpos($route, '/') + 1);

    if (empty($this->page)) $this->page = 'index';

    $this->pageConfigFile = $this->env['booksRootFolder'] . '/' . $this->book . '/config/' . $this->page . '.yaml';
    $this->pageContentFile = $this->env['booksRootFolder'] . '/' . $this->book . '/content/' . $this->page . '.md';

    if (empty($this->route)) throw new \Exception("No route.");
    if (!is_dir($this->env['booksRootFolder'] . '/' . $this->book)) throw new \Exception("Unknown book.");
    if (!is_file($this->pageConfigFile)) throw new \Exception("Page config not found.");
    if (!is_file($this->pageContentFile)) throw new \Exception("Page content not found.");
  }

  public function init() {
    $this->pageConfig = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->pageConfigFile)) ?? [];
    $this->pageContentMd = file_get_contents($this->pageContentFile);

    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($this->env['booksRootFolder'] . '/' . $this->book . '/templates'), // twig loader
      [ 'cache' => FALSE ]
    );
    $this->twig->addExtension(new \Twig\Extension\StringLoaderExtension());

  }

  public function buildTwigParams(): array {
    return [
      'rootUrl' => $this->env['rewriteBase'] . 'books/' . $this->book,
      'header' => 'Book: '. $this->book,
      'sidebar' => $this->pageConfig['sidebar'] ?? '',
      'content' => $this->renderPageContent(),
      'footer' => date('Y-m-d H:i:s'),
    ];
  }

  public function renderPageContent() {
    $parser = new \Parsedown();
    return $parser->text($this->pageContentMd);
  }

  public function render() {
    return $this->twig->render(
      ($this->pageConfig['template'] ?? 'no-template-configured') . '.twig',
      $this->buildTwigParams()
    );
  }
}