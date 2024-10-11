<?php

namespace WaiBlue\GuideVis;

class Loader {
  public array $env;
  public string $page;
  public array $pageData;

  public string $configFile;
  public string $pageContentFile;

  public array $pageConfig;
  public string $pageContentMd;

  public \Twig\Environment $twig;

  public function __construct(string $page, array $env, array $pageData)
  {

    $this->env = $env;
    $this->page = $page;
    $this->pageData = $pageData;

    if (empty($this->page)) $this->page = 'index';

    $this->configFile = $this->env['bookRootFolder'] . '/config.yaml';
    $this->pageContentFile = $this->env['bookRootFolder'] . '/content/pages/' . $this->page . '.md';

    if (!is_file($this->configFile)) throw new \Exception("Page config not found.");
    if (!is_file($this->pageContentFile)) throw new \Exception("Page content not found.");
  }

  public function init()
  {
    $this->pageConfig = $this->loadPageConfig();
    $this->pageContentMd = file_get_contents($this->pageContentFile);

    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($this->env['bookRootFolder'] . '/templates'), // twig loader
      [ 'cache' => FALSE ]
    );
    $this->twig->addExtension(new \Twig\Extension\StringLoaderExtension());

  }

  public function loadPageConfig()
  {
    $bookConfig = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->configFile)) ?? [];

    return array_merge($bookConfig[$this->page], $this->env['defaultPageConfig'] ?? []);
  }

  public function getPageVars(): array
  {
    return [
      'guideRootUrl' => $this->env['guideRootUrl'],
      'bookRootUrl' => $this->env['bookRootUrl'],
      'page' => $this->page,
      'footer' => date('Y-m-d H:i:s'),
      'data' => $this->pageData,
    ];
  }

  public function preparePageContentTemplate()
  {
    $parser = new \Parsedown();
    return $parser->text($this->pageContentMd);
  }

  public function render()
  {
    $config = $this->pageConfig;
    $vars = $this->getPageVars();

    $vars['elements'] = [];
    foreach ($config['elementTemplates'] ?? [] as $element => $elementTemplate) {
      $vars['elements'][$element] = $this->twig->render(
        'elements/' . $elementTemplate . '.twig',
        $vars,
      );
    }
    $vars['content'] = $this->twig->render(
      $this->twig->createTemplate(
        $this->preparePageContentTemplate()
      ),
      $vars
    );

    return $this->twig->render(
      'pages/' . $config['pageTemplate'] . '.twig',
      $vars
    );
  }
}