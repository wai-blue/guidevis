<?php

namespace WaiBlue\GuideVis;

class Loader {
  public array $env;
  public string $page;

  public string $configFile;
  public string $pageContentFile;

  public array $bookConfig;
  public array $pageConfig;
  public string $pageContentMd;

  public \Twig\Environment $twig;

  public function __construct(string $page, array $env)
  {

    $this->env = $env;
    $this->page = $page;

    if (empty($this->page)) $this->page = $this->env['homePage'];

    $this->configFile = $this->env['bookRootFolder'] . '/config.yaml';
    $this->pageContentFile = $this->env['bookRootFolder'] . '/content/pages/' . $this->page . '.md';

    if (!is_file($this->configFile)) throw new \Exception("Page config not found.");
  }

  public function init()
  {
    $this->bookConfig = $this->loadBookConfig();

    $this->performRedirects();

    $this->pageConfig = $this->loadPageConfig();
    $this->pageContentMd = @file_get_contents($this->pageContentFile);

    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($this->env['bookRootFolder'] . '/templates'), // twig loader
      [ 'cache' => FALSE ]
    );
    $this->twig->addExtension(new \Twig\Extension\StringLoaderExtension());
    $this->twig->addFunction(new \Twig\TwigFunction('dump', function($var) { var_dump($var); }));
    $this->twig->addFunction(new \Twig\TwigFunction('markdown', function($md) {
      $parser = new \Parsedown();
      return $parser->text($md);
    }));

  }

  public function pageExists(string $page): bool
  {
    return isset($this->bookConfig['pages'][$this->page]) && is_array($this->bookConfig['pages'][$this->page]);
  }


  public function loadBookConfig(): array
  {
    return \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->configFile)) ?? [];
  }

  public function loadPageConfig(): array
  {
    if (!$this->pageExists($this->page)) {
      return $this->env['notFoundPage'];
    } else {
      return array_merge($this->env['defaultPageConfig'] ?? [], $this->bookConfig['pages'][$this->page] ?? []);
    }
  }

  public function getPageUrl(string $page)
  {
    return $this->env['guideRootUrl'] . '/' . $page;
  }

  public function performRedirects()
  {
    if (isset($this->bookConfig['redirects'][$this->page])) {
      $redirect = $this->bookConfig['redirects'][$this->page];
      header('Location: ' . $this->getPageUrl($redirect['newPage']), $redirect['code']);
    }
  }

  public function getBreadcrumbs(string $page, array $toc, array $levels = []): array
  {
    $parentPages = [];
    foreach ($toc as $item) {
      if ($item['page'] == $page) {
        $parentPages[] = $item['page'];
        break;
      } else if (isset($item['children']) && is_array($item['children'])) {
        $tmp = $this->getBreadcrumbs($page, $item['children'], $levels);
        if (count($tmp) > 0) {
          $parentPages = array_merge([$item['page']], $tmp);
          break;
        }
      }
    }

    return $parentPages;
  }

  public function getOnThisPage(string $mdContent): array
  {
    $lines = explode("\n", $mdContent);
    $onThisPage = [];
    $currentH2 = '';
    $h3list = [];

    foreach ($lines as $line) {
      $line = trim($line);
      if (str_starts_with($line, '## ')) {
        if (!empty($currentH2)) {
          $onThisPage[$currentH2] = $h3list;
          $h3list = [];
        }

        $currentH2 = trim($line, '# ');
      }

      if (str_starts_with($line, '### ')) {
        $h3list[] = trim($line, '# ');
      }
    }

    $onThisPage[$currentH2] = $h3list;

    return $onThisPage;
  }

  public function getPageVars(array $pageData = []): array
  {
    return [
      'env' => $this->env,
      'guideRootUrl' => $this->env['guideRootUrl'],
      'bookRootUrl' => $this->env['bookRootUrl'],
      'bookConfig' => $this->bookConfig,
      'page' => $this->page,
      'breadcrumbs' => $this->getBreadcrumbs($this->page, $this->bookConfig['tableOfContents'] ?? []),
      'onThisPage' => $this->getOnThisPage($this->pageContentMd),
      'footer' => date('Y-m-d H:i:s'),
      'data' => $pageData,
    ];
  }

  public function preparePageContentTemplate()
  {
    $parser = new \Parsedown();
    return $parser->text($this->pageContentMd);
  }

  public function render(array $pageData = [])
  {
    $config = $this->pageConfig;
    $vars = $this->getPageVars($pageData);

    $vars['elements'] = [];
    foreach ($config['elementTemplates'] ?? [] as $element => $elementTemplate) {
      $vars['elements'][$element] = $this->twig->render(
        'elements/' . $elementTemplate . '.twig',
        $vars,
      );
    }

    $mdParser = new \Parsedown();
    $content = $mdParser->text($this->twig->render(
      $this->twig->createTemplate($this->pageContentMd),
      $vars
    ));
    $content = preg_replace('/<h([1-9])>(.*)<\/h([1-9])>/', '<a name="$2"></a>$0', $content);

    $vars['content'] = $content;

    return $this->twig->render(
      'pages/' . $config['pageTemplate'] . '.twig',
      $vars
    );
  }
}