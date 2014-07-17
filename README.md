Yii 2 page size selector for grid and list view
===============================================
Adds a page size selector to grid views and list views.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nkovacs/yii2-pagesizer "*"
```

or add

```
"nkovacs/yii2-pagesizer": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, replace `\yii\grid\GridView` with `\nkovacs\pagesizer\GridView` and `\yii\widgets\ListView` with `\nkovacs\pagesizer\ListView`.

You can use `{pagesizer}` inside the `$layout` property to customize the page sizer widget's placement, and the `$pageSizer` property to customize
the page sizer widget.
