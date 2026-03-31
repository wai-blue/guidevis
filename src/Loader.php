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

  public array $appliedRoutes = [];

  public array $bookIndex;

  public \Twig\Environment $twig;

  public bool $debugSearch = false;

  public string $searchPage = 'search';

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
    $this->applyRouter();

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
    if ($page === $this->searchPage) return true;
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
    $stripped = $this->stripMarkdown($line);
    foreach (explode(" ", trim($stripped)) as $word) {
      $word = trim(strtolower($word));
      if (empty($word)) continue;
      if (!isset($this->bookIndex[$priority])) $this->bookIndex[$priority] = [];
      if (!isset($this->bookIndex[$priority][$word])) $this->bookIndex[$priority][$word] = [];
      $this->bookIndex[$priority][$word][] = [
        'page' => $page,
        'snippet' => $stripped,
      ];
    }
  }

  public function buildBookIndex(): void
  {
    if (!empty($this->bookIndex)) return;
    $this->bookIndex = [];
    foreach ($this->bookConfig['pages'] as $page => $pageData) {
      $pageContent = $this->getPageContent($page);
      $lines = explode("\n", $pageContent);
      foreach ($lines as $line) {
        $line = trim($line);
        if (\str_starts_with($line, "# ")) $this->addToBookIndex($page, trim($line, '# '), 1);
        elseif (\str_starts_with($line, "## ")) $this->addToBookIndex($page, trim($line, '## '), 2);
        elseif (\str_starts_with($line, "### ")) $this->addToBookIndex($page, trim($line, '### '), 3);
        elseif (!empty($line)) $this->addToBookIndex($page, $line, 4); // body text
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

  public function applyRouter()
  {
    if (isset($this->bookConfig['router']) && is_array($this->bookConfig['router'])) {
      foreach ($this->bookConfig['router'] as $pagePattern => $page) {
        if (preg_match($pagePattern, $this->page)) {
          $this->appliedRoutes[$pagePattern] = $this->page;
          $this->page = $page;
        }
      }
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
      'searchPage' => $this->searchPage,
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
    if ($this->page === $this->searchPage) {
        $query = $_GET['q'] ?? '';
        $pageData['searchResults'] = $this->search($query);
        $pageData['query'] = $query;
        $pageData['debugSearch'] = $this->debugSearch;
    }
    
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
    $content = preg_replace('/<a href="(http.*?)">/', '<a href="$1" target="_blank"><i class="fas fa-up-right-from-square" style="font-size:0.5em"></i>&nbsp;', $content);
    $content = preg_replace('/<h2>(.*)<\/h2>/', '<h2><a name="$1" href="#$1" style="opacity:0.2;margin-right:0.2em"><i class="fas fa-link"></i></a> $1</h2>', $content);
    // $content = preg_replace('/<h([13456])>(.*)<\/h([13456])>/', '<h$1><a name="$2" href="#$2" style="opacity:0.2;margin-right:0.2em"><i class="fas fa-link"></i></a> $2</h$1>', $content);

    $vars['content'] = $content;

    return $this->twig->render(
      'pages/' . $config['pageTemplate'] . '.twig',
      $vars
    );
  }

  public function search(string $query): array
  {
    $this->buildBookIndex();

    $query = strtolower(trim($query));

    if (empty($query)) return [];

    $stopwords = ['the', 'a', 'an', 'is', 'are', 'was', 'and', 'or', 'in', 'to', 'of', 'for', 'with', 'on', 'at'];
    $queryWords = array_values(array_filter(explode(' ', $query), fn($w) => strlen($w) >= 2 && !in_array($w, $stopwords)));
    if (empty($queryWords)) return [];

    // first find all pages that contain ALL query words
    $matchingPages = null;

    foreach ($queryWords as $queryWord) {
      $pagesWithThisWord = [];
      foreach ($this->bookIndex as $priority => $words) {
        foreach ($words as $word => $items) {
          if (str_contains($word, $queryWord)) {
            foreach ($items as $item) {
              $pagesWithThisWord[$item['page']] = true;
            }
          }
        }
      }
      if ($matchingPages === null) {
        $matchingPages = $pagesWithThisWord;
      } else {
        $matchingPages = array_intersect_key($matchingPages, $pagesWithThisWord);
      }
    }

    // exclude source-code pages
    $matchingPages = array_filter(
      $matchingPages,
      fn($v, $k) => !str_starts_with($k, 'source-code/'),
      ARRAY_FILTER_USE_BOTH
    );

    $results = [];
    foreach (array_keys($matchingPages) as $page) {
      $title = $this->bookConfig['pages'][$page]['title'] ?? $page;

      // highlight title
      $titleDisplay = $title;
      if (stripos($titleDisplay, $query) !== false) {
        $titleDisplay = preg_replace(
          '/(' . preg_quote($query, '/') . ')/i',
          '<mark style="background-color:#bbf7d0;font-weight:bold;padding:1px 4px;border-radius:3px;color:#14532d;">$1</mark>',
          $titleDisplay
        );
      } else {
        foreach ($queryWords as $hw) {
          $titleDisplay = preg_replace(
            '/(' . preg_quote($hw, '/') . ')/i',
            '<mark style="background-color:#fef08a;font-weight:bold;padding:1px 4px;border-radius:3px;color:#1e3a5f;">$1</mark>',
            $titleDisplay
          );
        }
      }

      // collect unique matching lines for this page
      $matchingLines = [];
      foreach ($this->bookIndex as $priority => $words) {
        foreach ($words as $word => $items) {
          // check if this word matches ANY query word
          $wordMatches = false;
          foreach ($queryWords as $queryWord) {
            if (str_contains($word, $queryWord)) {
              $wordMatches = true;
              break;
            }
          }
          if (!$wordMatches) continue;
          
          foreach ($items as $item) {
            if ($item['page'] !== $page) continue;
            $lineKey = md5($item['snippet']);
            if (!isset($matchingLines[$lineKey])) {
              $matchingLines[$lineKey] = [
                'snippet' => $item['snippet'],
                'priority' => $priority,
              ];
            } else if ($priority < $matchingLines[$lineKey]['priority']) {
              $matchingLines[$lineKey]['priority'] = $priority;
            }
          }
        }
      }

      // best priority = best among matching lines
      $bestPriority = 4;
      foreach ($matchingLines as $lineData) {
        if ($lineData['priority'] < $bestPriority) {
          $bestPriority = $lineData['priority'];
        }
      }

      // collect up to 3 snippets
      $snippets = [];
      foreach ($matchingLines as $lineData) {
        if (count($snippets) >= 3) break;
        $snippet = $lineData['snippet'];
        $matchPos = false;
        foreach ($queryWords as $qw) {
          $pos = stripos($snippet, $qw);
          if ($pos !== false) {
            $matchPos = $pos;
            break;
          }
        }
        if ($matchPos === false) continue;

        $start = max(0, $matchPos - 80);
        $end = min(strlen($snippet), $matchPos + 80);
        $snip = ($start > 0 ? '...' : '') . substr($snippet, $start, $end - $start) . ($end < strlen($snippet) ? '...' : '');

        // skip snippet if it's the same as the title
        $cleanSnip = trim(substr($snippet, $start, $end - $start));
        if (strtolower($cleanSnip) === strtolower(trim($title))) continue;

        if (stripos($snip, $query) !== false) {
          $snip = preg_replace(
            '/(' . preg_quote($query, '/') . ')/i',
            '<mark style="background-color:#bbf7d0;font-weight:bold;padding:1px 4px;border-radius:3px;color:#14532d;">$1</mark>',
            $snip
          );
        } else {
          foreach ($queryWords as $hw) {
            $snip = preg_replace(
              '/(' . preg_quote($hw, '/') . ')/i',
              '<mark style="background-color:#fef08a;font-weight:bold;padding:1px 4px;border-radius:3px;color:#1e3a5f;">$1</mark>',
              $snip
            );
          }
        }

        if (!in_array($snip, $snippets)) {
          $snippets[] = $snip;
        }
      }

      $results[$page] = [
        'page' => $page,
        'title' => $title,
        'titleDisplay' => $titleDisplay,
        'url' => $this->getPageUrl($page),
        'priority' => $bestPriority,
        'snippets' => $snippets,
        'count' => count($matchingLines),
        'boost' => 0,
      ];
    }

    // apply boosts
    foreach ($results as $page => $result) {
      $pageContent = strtolower($this->getPageContent($page));
      $pageTitle = strtolower($result['title']);

      if (str_contains($pageContent, $query)) {
        $results[$page]['boost'] += 50;
      }

      if (str_contains($pageTitle, $query)) {
        $results[$page]['boost'] += 200;
      } else {
        $allWordsInTitle = true;
        foreach ($queryWords as $qw) {
          if (!str_contains($pageTitle, $qw)) {
            $allWordsInTitle = false;
            break;
          }
        }
        if ($allWordsInTitle) {
          $results[$page]['boost'] += 100;
        }
      }

      // //for auto generated guide in hubleto
      // if (str_starts_with($page, 'source-code/')) {
      //   $results[$page]['boost'] -= 1000;
      // }

    }

    usort($results, function($a, $b) {
      $priorityA = max(1, $a['priority']);
      $priorityB = max(1, $b['priority']);
      $scoreA = ($a['count'] * $a['count'] / $priorityA) + $a['boost'];
      $scoreB = ($b['count'] * $b['count'] / $priorityB) + $b['boost'];
      return $scoreB <=> $scoreA;
    });

    foreach ($results as $page => $result) {
      $priority = max(1, $result['priority']);
      $results[$page]['score'] = round( ($result['count'] * $result['count'] / max(1, $result['priority'])) + $result['boost'], 2 );
    }

    return array_slice($results, 0, 20);
  }

  public function stripMarkdown(string $line): string
  {
    // Skip ASCII art / box drawing characters
    if (preg_match('/[║╔╗╚╝╠╣╦╩╬─│┌┐└┘├┤┬┴┼═]/', $line)) return '';

    // Skip directory tree lines
    if (preg_match('/^[├└│\s]+[─]+/', $line)) return '';

    // Skip code block markers
    if (str_starts_with($line, '```')) return '';
    // Remove images first (before links)
    $line = preg_replace('/!\[.*?\]\(.*?\)/', '', $line);
    // Remove standard links - keep text
    $line = preg_replace('/\[([^\]]*)\]\([^)]*\)/', '$1', $line);
    // Remove __path/url__ custom links (only those containing /)
    $line = preg_replace('/__[^_]*\/[^_]*__/', '', $line);
    // Remove table syntax
    if (str_starts_with(trim($line), '|')) {
      $line = preg_replace('/\|/', ' ', $line);
      $line = preg_replace('/\s+/', ' ', trim($line));
    }
    // Remove headings
    $line = preg_replace('/^#{1,6}\s+/', '', $line);
    // Remove bold and italic
    $line = preg_replace('/\*{1,3}(.*?)\*{1,3}/', '$1', $line);
    $line = preg_replace('/_{1,3}(.*?)_{1,3}/', '$1', $line);
    // Remove inline code
    $line = preg_replace('/`([^`]*)`/', '$1', $line);
    // Remove blockquotes
    $line = preg_replace('/^>\s+/', '', $line);
    // Clean up extra whitespace
    $line = preg_replace('/\s+/', ' ', $line);

    // For table rows, strip link URLs but keep link text
    if (str_starts_with(trim($line), '|')) {
      // keep link text, remove URL: [text](url) -> text
      $line = preg_replace('/\[([^\]]*)\]\([^)]*\)/', '$1', $line);
      // remove custom __url__ links entirely
      $line = preg_replace('/__[^_]*__/', '', $line);
      // remove | separators
      $line = preg_replace('/\|/', ' ', $line);
      $line = preg_replace('/\s+/', ' ', trim($line));
    }

    $line = strip_tags($line);

    return trim($line);
  }

}