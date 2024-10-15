# GuideVis

Lightweight library for visualizing guides:

  * user guide
  * developer guide
  * support FAQs
  * ...

# Requires

  * PHP 8.x
  * Tailwind (`npm i tailwind`)

# How to create own guide

To create own guide, install the guidevis with composer (`composer required guidevis`) and create following folder structure in the same folder where you installed guidevis:

  * book/
    * content/
      * images/
      * pages/
    * templates/
      * pages/
      * elements/

# How to create new page

  * add page to config.yaml:pages
  * add page to config.yaml:sidebar, if required
  * create book/content/pages/PAGE_NAME.md file and put page content here in Markdown format