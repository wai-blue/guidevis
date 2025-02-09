# GuideVis

File-based (no SQL) library for various guides (user guide, developer's guide, recipe book, ...).


# Live preview

https://docs.wai.blue/dtxs-digital-twin-data-exchange-standard/
https://developer.hubleto.com

# How to create guide

  * Copy the contents of [default guide](example/default-guide) folder into `/var/www/html/my-first-guide`.
  * In `/var/www/html/my-first-guide` run:  `composer require guidevis`, `npm i tailwind` & * `npm build-css`
  * In your favourite browser navigate to `https://localhost/my-first-guide`.

# Create guide's content

Guide content is located in `/var/www/html/my-first-guide/book/content`. It has two subfolders:

  * `assets` folder contains all assets (mostly images) you will need for your guide
  * `pages` folder contains the Markdown-formatted content of the pages. Check out the [sample.md](example/default-guide/book/content/pages/subpage-1.md) for examples on how to create your own content.


