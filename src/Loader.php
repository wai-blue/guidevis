<?php

namespace WaiBlue\GuideVis;

class Loader {
  protected array $assetTypes = [
    'image' => ['gif', 'png', 'jpg', 'jpeg', 'svg'],
  ];
  public array $env;
  public string $page;

  public string $bookConfigFile;

  public array $bookConfig;
  public array $pageConfig;
  public array $templateConfig;
  public string $pageContentMd;

  public array $bookIndex;

  public \Twig\Environment $twig;

  public function __construct(string $page, array $env, array $templateConfig)
  {

    $this->env = $env;
    $this->page = $page;
    $this->templateConfig = $templateConfig;

    $this->bookConfigFile = $this->env['bookRootFolder'] . '/config.yaml';
  }

  public function init()
  {
    $this->bookConfig = $this->loadBookConfig();

    if (empty($this->page)) $this->page = $this->bookConfig['homePage'];

    $this->performRedirects();

    $this->pageConfig = $this->loadPageConfig();
    $this->pageContentMd = $this->getPageContent($this->page);

    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($this->env['templateRootFolder']), // twig loader
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
    return isset($this->bookConfig['pages'][$page]) && is_array($this->bookConfig['pages'][$page]);
  }

  public function getPageContent(string $page): string
  {
    $pageContentFile = $this->env['bookRootFolder'] . '/content/pages/' . $page . '.md';
    return is_file($pageContentFile) ? file_get_contents($pageContentFile) : '';
  }

  public function findPageInTableOfContents(string $page, $toc = null): array
  {
    if ($toc === null) $toc = $this->bookConfig['tableOfContents'];

    $result = [];
    foreach ($toc as $tocPage) {
      if ($tocPage['page'] == $page) {
        $result = $tocPage;
        break;
      } elseif (is_array($tocPage['chilren'])) {
        $tmpResult = $this->findPageInTableOfContents($page, $tocPage['children']);
        if ($tmpResult !== []) {
          $result = $tmpResult;
          break;
        }
      }
    }

    return $result;
  }

  public function walkTableOfContents($callback, $toc = null)
  {
    if ($toc === null) $toc = $this->bookConfig['tableOfContents'];

    foreach ($toc as $tocPage) {
      $callback($tocPage);
      if (isset($tocPage['children']) && is_array($tocPage['children'])) {
        $this->walkTableOfContents($callback, $tocPage['children']);
      }
    }
  }

  public function loadPagesFromContent(string $contentFolder, string $pagePrefix = ''): array
  {
    $pages = [];

    foreach (scandir($contentFolder) as $filename) {
      if ($filename[0] === '.') continue;

      $filePath = $contentFolder . '/' . $filename;

      $pages[trim($pagePrefix . '/' . pathinfo($filename, PATHINFO_FILENAME), '/')] = [
        'title' => pathinfo($filename, PATHINFO_FILENAME),
      ];

      if (is_dir($filePath)) {
        $subPages = $this->loadPagesFromContent($filePath, $pagePrefix . '/' . $filename);
        $pages = array_merge($pages, $subPages);
      }
    }

    foreach ($pages as $page => $pageData) {
      $content = $this->getPageContent($page);

      $lines = explode("\n", $content);
      foreach ($lines as $line) {
        $line = trim($line);
        if (\str_starts_with($line, "# ")) {
          $pages[$page]['title'] = trim($line, '# ');
          break;
        }
      }

      if (empty($pages[$page]['title'])) $pages[$page]['title'] = $page;
    }

    return $pages;
  }

  public function loadBookConfig(): array
  {
    if (!is_file($this->bookConfigFile)) throw new \Exception("Page config not found.");
    $bookConfig = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($this->bookConfigFile)) ?? [];

    foreach ($bookConfig['tableOfContents'] as $key => $page) {
      if (isset($page['json'])) $bookConfig['tableOfContents'][$key] = json_decode($page['json'], true);
    }

    $bookConfig['pages'] = array_merge(
      $this->loadPagesFromContent($this->env['bookRootFolder'] . '/content/pages'),
      $bookConfig['pages'] ?? [],
    );

    return $bookConfig;
  }

  public function loadPageConfig(): array
  {
    if (!$this->pageExists($this->page)) {
      $config = $this->templateConfig['notFoundPage'];
    } else {
      $config = array_merge($this->templateConfig['defaultPageConfig'] ?? [], $this->bookConfig['pages'][$this->page] ?? []);
    }

    $toc = [];
    $this->walkTableOfContents(function($page) use(&$toc) {
      if ($page['page'] == $this->page) {
        $toc = $page;
        if (!empty($toc['prev'])) $toc['prevPageData'] = $this->bookConfig['pages'][$toc['prev']] ?? [];
        if (!empty($toc['next'])) $toc['nextPageData'] = $this->bookConfig['pages'][$toc['next']] ?? [];
      }
    });

    // $toc = [];
    // foreach ($this->bookConfig['tableOfContents'] as $key => $page) {
    //   if ($page['page'] == $this->page) {
    //     $toc = $page;
    //     if (!empty($toc['prev'])) $toc['prevPageData'] = $this->bookConfig['pages'][$toc['prev']] ?? [];
    //     if (!empty($toc['next'])) $toc['nextPageData'] = $this->bookConfig['pages'][$toc['next']] ?? [];
    //   }
    // }

    $config['tocData'] = $toc;

    return $config;
  }

  public function addToBookIndex(string $page, string $line, int $priority): void
  {
    foreach (explode(" ", trim($line)) as $word) {
      $word = trim(strtolower($word));
      if (!isset($this->bookIndex[$priority])) $this->bookIndex[$priority] = [];
      if (!isset($this->bookIndex[$priority][$word])) $this->bookIndex[$priority][$word] = [];
      $this->bookIndex[$priority][$word][] = $page;
    }
  }

  public function buildBookIndex(): void
  {
    $this->bookIndex = [];
    foreach ($this->bookConfig['pages'] as $page => $pageData) {
      $pageContent = $this->getPageContent($page);
      $lines = explode("\n", $pageContent);
      foreach ($lines as $line) {
        $line = trim($line);
        if (\str_starts_with($line, "# ")) $this->addToBookIndex($page, trim($line, '# '), 1);
        if (\str_starts_with($line, "## ")) $this->addToBookIndex($page, trim($line, '## '), 2);
        if (\str_starts_with($line, "### ")) $this->addToBookIndex($page, trim($line, '### '), 3);
      }
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
      'templateRootUrl' => $this->env['templateRootUrl'],
      'bookRootUrl' => $this->env['bookRootUrl'],
      'bookConfig' => $this->bookConfig,
      'page' => $this->page,
      'pageConfig' => $this->pageConfig,
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

  public function renderAsset(string $asset) {
    if (\str_contains($asset, '..')) return '';

    $assetFile = $this->env['bookRootFolder'] . '/content/' . $asset;
    if (!\file_exists($assetFile)) return '';

    $assetType = strtolower(\pathinfo($assetFile, PATHINFO_EXTENSION));
    if (in_array($assetType, $this->assetTypes['image'])) {
      switch ($assetType) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg": case "jpg": $ctype="image/jpeg"; break;
        case "svg": $ctype="image/svg+xml"; break;
        default: return ''; break;
      }

      header('Content-type: ' . $ctype);
      return file_get_contents($assetFile);
    } else {
      return '';
    }
  }

  public function render(array $pageData = [])
  {
    if (\str_starts_with($this->page, 'assets')) return $this->renderAsset($this->page);

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