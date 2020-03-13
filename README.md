# Catalog-Easy
You can use different layouts, to organize your pages, and create some kind of catalog or portfolio with pagination and sorting.

Demo and docs can be found here
`http://ts-addons.my-sitelab.com/Catalog_Easy`

## Features:
- six layouts (list, 2 columns, 3 columns, portfolio gallery responsive,carousel,sortable portfolio);
- posibility to specify layout for every page;
- gadget and admin page for options;
- ajax and non ajax pagination;
- sorting buttons;
- sorting by category;
- build in navigation for pages.

## Usage:
- possible to use section or gadget;
- include catalog section on page, edit it.
- gadget suppozed to work in File Include Section(add new section type file include withg gadget Catalog Easy);
- edit aditional options in admin page. If you need diferent layout for another pages for gadget - use page manager in admin part;
- add class short_info to any section on child page to specify short info that appears in layout or set to take it from content;
- for sortable portfolio you need to add attribute data-filter with value name of category( or names separeted by space) to one section on your Child page.


# Fork's changelog
- Fixed php error when selecting souse "another page" for gallery 'Portfolio'
- Fixed tab height calculation in gallery 'Portfolio'
- Add atribute 'data-title' to div.wmg-thumbnail-content
- Fixed broken arrow in gallery 'Portfolio' when tabs folding is turned off
- Support OwlCarousel for carousel mode (set number of items in row to 0)
- Ignore non-page elements in menu
- Support swipe for the carousel
- Bootstrap 3 and 4 support
- Tabs folding when switching in the gallery 'Portfolio' is turned off
- Catalog_Easy.php is PHP 7.x warnings and errors friendly


## Origin Changelog
- version 1.8.4 support for private/hidden pages, hash links in sortable portfolio(#category_name), two words data filter support, readmore link options, option - take image only from text areas. editor styles, bug fixes.
- version 1.8.3 fix images overlap
- version 1.8.2 - added possibility to set image for every page, image don't need to be on page to display in catalog(look in menu options), added more options in section for Sortable Portfolio, short info - do not show option.
- version 1.8.1 - categories for Sortable Portfolio can be set for page in Typesetter Page Manager. Also categories for sortable portfolio now present in section edit.
- version 1.8 - plugin now can include navigation(prev/parent/next) on pages that used in catalog, feature new catalog easy section, unlimited catalogs on page, new options for pages selection (first, last, random) and pages grouping(direct childs, from another page, another menu group),new design admin part, new page manager for gadget, option non ajax pagination, many inner changes and fixes, TS5 ready.
- version 1.7.2 - new options for short info (can be taken from content or from section with class short_info), display or no carousel title, fix bug whith short info when no image on page, add autocomplite in special options, add separeted options for size of catalog thumbnail.
- version 1.7.1 - support resized images, for Catalog generated image thumbnails
- version 1.7 - added possibility to use Catalog generated image thumbnails(look in Special options); fix colorbox in sortable portfolio .
- version 1.6.1b - fatal error with special page fix.
- version 1.6 - bugs and notices fix, added possibility to use gadget on page that don't have direct child pages(
Class not must be exactly short_info. Now can use short_info as a part of class, example "col-lg-6 short_info"
- version 1.5 - added Sortable Portfolio Layout with possibility to sort item by category.
- version 1.4 - added Carousel Layout, admin side change,individual options for every layout, image now linked to childpage.
- version 1.3 - added possibility to sort items (ascending and descending by title name ), little css fix.
- version 1.2 - added Portfolio Gallery responsive Layout.
- version 1.0a - fix some erors and notices.
