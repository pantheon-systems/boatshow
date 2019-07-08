<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Configuration file for multi-site support and directory aliasing feature.
 *
 * This file is required for multi-site support and also allows you to define a
 * set of aliases that map hostnames, ports, and pathnames to configuration
 * directories in the sites directory. These aliases are loaded prior to
 * scanning for directories, and they are exempt from the normal discovery
 * rules. See default.settings.php to view how Drupal discovers the
 * configuration directory when no alias is found.
 *
 * Aliases are useful on development servers, where the domain name may not be
 * the same as the domain of the live server. Since Drupal stores file paths in
 * the database (files, system table, etc.) this will ensure the paths are
 * correct when the site is deployed to a live server.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/sites.php'.
 *
 * Aliases are defined in an associative array named $sites. The array is
 * written in the format: '<port>.<domain>.<path>' => 'directory'. As an
 * example, to map https://www.drupal.org:8080/mysite/test to the configuration
 * directory sites/example.com, the array should be defined as:
 * @code
 * $sites = array(
 *   '8080.www.drupal.org.mysite.test' => 'example.com',
 * );
 * @endcode
 * The URL, https://www.drupal.org:8080/mysite/test/, could be a symbolic link
 * or an Apache Alias directive that points to the Drupal root containing
 * index.php. An alias could also be created for a subdomain. See the
 * @link https://www.drupal.org/documentation/install online Drupal installation guide @endlink
 * for more information on setting up domains, subdomains, and subdirectories.
 *
 * The following examples look for a site configuration in sites/example.com:
 * @code
 * URL: http://dev.drupal.org
 * $sites['dev.drupal.org'] = 'example.com';
 *
 * URL: http://localhost/example
 * $sites['localhost.example'] = 'example.com';
 *
 * URL: http://localhost:8080/example
 * $sites['8080.localhost.example'] = 'example.com';
 *
 * URL: https://www.drupal.org:8080/mysite/test/
 * $sites['8080.www.drupal.org.mysite.test'] = 'example.com';
 * @endcode
 *
 * @see default.settings.php
 * @see \Drupal\Core\DrupalKernel::getSitePath()
 * @see https://www.drupal.org/documentation/install/multi-site
 */

 /*  local */
$sites['local.atlanta.com']     = 'atlanta';
$sites['local.atlanticcity.com']      = 'atlanticcity';
$sites['local.baltimore.com']      = 'baltimore';
$sites['local.boatshows.com']     = 'boatshow';
$sites['local.chicago.com']      = 'chicago';
$sites['local.kansascity.com']     = 'kansascity';
$sites['local.louisville.com']      = 'louisville';
$sites['local.minneapolis.com']      = 'minneapolis';
$sites['local.miami.com']     = 'miami';
$sites['local.nashville.com']     = 'nashville';
$sites['local.newengland.com']      = 'newengland';
$sites['local.newyork.com']      = 'newyork';
$sites['local.northwest.com']      = 'northwest';
$sites['local.norwalk.com']      = 'norwalk';
$sites['local.sportshows.com']      = 'sportshows';
$sites['local.stlouis.com']      = 'stlouis';
$sites['local.tampa.com']      = 'tampa';

/* dev */
$sites['dev.atlantaboatshow.com']     = 'atlanta';
$sites['dev.acboatshow.com']          = 'atlanticcity';
$sites['dev.baltimoreboatshow.com']   = 'baltimore';
$sites['template.boatshows.com']     = 'boatshow';
$sites['dev.chicagoboatshow.com']     = 'chicago';
$sites['dev.kansascitysportshow.com'] = 'kansascity';
$sites['dev.louisvilleboatshow.com']  = 'louisville';
$sites['dev.minneapolisboatshow.com'] = 'minneapolis';
$sites['dev.miamiboatshow.com']   = 'miami';
$sites['dev.nashvilleboatshow.com']   = 'nashville';
$sites['dev.newenglandboatshow.com']  = 'newengland';
$sites['dev.nyboatshow.com']          = 'newyork';
$sites['dev.northwestsportshow.com']  = 'northwest';
$sites['dev.boatshownorwalk.com']  = 'norwalk';
$sites['dev.sportshows.com']     = 'sportshows';
$sites['dev.stlouisboatshow.com']     = 'stlouis';
$sites['dev.tampaboatshow.com']     = 'tampa';

/* stage */
$sites['stage.atlantaboatshow.com']     = 'atlanta';
$sites['stage.acboatshow.com']          = 'atlanticcity';
$sites['stage.baltimoreboatshow.com']   = 'baltimore';
$sites['stage.chicagoboatshow.com']     = 'chicago';
$sites['stage.kansascitysportshow.com'] = 'kansascity';
$sites['stage.louisvilleboatshow.com']  = 'louisville';
$sites['stage.minneapolisboatshow.com'] = 'minneapolis';
$sites['stage.miamiboatshow.com']   = 'miami';
$sites['stage.nashvilleboatshow.com']   = 'nashville';
$sites['stage.newenglandboatshow.com']  = 'newengland';
$sites['stage.nyboatshow.com']          = 'newyork';
$sites['stage.northwestsportshow.com']  = 'northwest';
$sites['stage.boatshownorwalk.com']  = 'norwalk';
$sites['stage.sportshows.com']     = 'sportshows';
$sites['stage.stlouisboatshow.com']     = 'stlouis';
$sites['stage.tampaboatshow.com']     = 'tampa';

/* prod */
$sites['atlantaboatshow.com']     = 'atlanta';
$sites['acboatshow.com']          = 'atlanticcity';
$sites['baltimoreboatshow.com']   = 'baltimore';
$sites['chicagoboatshow.com']     = 'chicago';
$sites['kansascitysportshow.com'] = 'kansascity';
$sites['louisvilleboatshow.com']  = 'louisville';
$sites['minneapolisboatshow.com'] = 'minneapolis';
$sites['miamiboatshow.com']   = 'miami';
$sites['nashvilleboatshow.com']   = 'nashville';
$sites['newenglandboatshow.com']  = 'newengland';
$sites['nyboatshow.com']          = 'newyork';
$sites['northwestsportshow.com']  = 'northwest';
$sites['boatshownorwalk.com']  = 'norwalk';
$sites['sportshows.com']     = 'sportshows';
$sites['stlouisboatshow.com']     = 'stlouis';
$sites['tampaboatshow.com']     = 'tampa';
