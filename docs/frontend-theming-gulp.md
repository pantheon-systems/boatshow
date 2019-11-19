Frontend Theming and Gulp
===

## SCSS Architecture

The theming of the multisites is intended to be done primarily by setting different values for the scss variables of each city's stylesheet, with a minimal number of custom css rules written for each site. This was designed to make stylesheets easy to differentiate and also easy to maintain across a family of ~20 themes.

- All scss lives in the theme directory at `docroot/themes/custom/boatshow/sass`
- Default values for variables are set in `_variables-default.scss`
- The shared styles betwween all sites are loaded via `styles.scss`, which is both included in the city-specific stylesheets and also rendered independently to be used for cities which do not have a city-specific stylesheet configured for any reason.
- Each city site has a file names city-{multisite}.scss, which consists of 3 sections:
  1. City Override Variables: Set overrides for variable values (WITHOUT the !default flag)
  2. Include Stylesheet: Include the styles.scss, which loads in all of the site styles
  3. City Override CSS Rules: Write CSS rules specifically for this site.
- Stylesheets are loaded by drupal in the boatshow.theme:boatshow_library_info_alter hook

## Notable Gulp Tasks for Local Development

### Watch

```console
vm$ gulp watch        # Watch SCSS and JS files
vm$ gulp watch:sass   # Watch SCSS files only
vm$ gulp watch:js     # Watch JS files only
```

### Build
Compile/minify/lint SCSS and JS files

```console
vm$ gulp build # Compile/minify/lint SCSS and JS files
vm$ gulp # The default 'gulp' command by itself is set to run 'gulp build'
```
