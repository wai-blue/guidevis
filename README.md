# GuideVis

Lightweight library for visualizing guides:

  * user guide
  * developer guide
  * support FAQs
  * ...

# Prerequisities

  * PHP 8.x
  * Tailwind (`npm i tailwind`)

# How to create own guide

## Step 1: Initialize project's folder

We recommend you to start with the default configuration. Copy the contents of [default guide](example/default-guide) folder into `/var/www/html/my-first-guide`.

## Step 2: Install required components

In `/var/www/html/my-first-guide` run:

  * `composer require guidevis`
  * `npm i tailwind`
  * `npm build-css`

## Step 3: Open the guide in browser

In your favourite browser navigate to `https://localhost/my-first-guide`.

# Step 4: Create your content

Guide content is located in `/var/www/html/my-first-guide/book/content`. It has two subfolders:

  * `assets` folder contains all assets (mostly images) you will need for your guide
  * `pages` folder contains the Markdown-formatted content of the pages. Check out the [sample.md](example/default-guide/book/content/pages/sample.md) for examples on how to create your own content.


