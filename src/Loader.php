<?php

namespace DocsRenderer;

class Loader {
  public array $env;
  public string $page;

  public string $pageConfigFile;
  public string $pageContentFile;

  public array $pageConfig;
  public string $pageContentMd;

  public \Twig\Environment $twig;

  public function __construct(string $page, array $env) {

    $this->env = $env;
    $this->page = $page;

    if (empty($this->page)) $this->page = 'index';

    $this->pageConfigFile = $this->env['bookRootFolder'] . '/config/' . $this->page . '.yaml';
    $this->pageContentFile = $this->env['bookRootFolder'] . '/content/' . $this->page . '.md';

    if (!is_file($this->pageConfigFile)) throw new \Exception("Page config not found.");
    if (!is_file($this->pageContentFile)) throw new \Exception("Page content not found.");
  }

  public function init() {
    $this->pageConfig = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->pageConfigFile)) ?? [];
    $this->pageContentMd = file_get_contents($this->pageContentFile);

    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($this->env['bookRootFolder'] . '/templates'), // twig loader
      [ 'cache' => FALSE ]
    );
    $this->twig->addExtension(new \Twig\Extension\StringLoaderExtension());

  }

  public function buildTwigParams(): array {
    $contentTemplate = $this->twig->createTemplate($this->renderPageContent());
    return [
      'rootUrl' => $this->env['bookRootUrl'],
      'header' => 'Book',
      'sidebar' => $this->pageConfig['sidebar'] ?? '',
      'content' => $this->twig->render($contentTemplate),
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