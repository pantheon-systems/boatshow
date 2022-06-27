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

 // Atlanta
 $sites['local.atlantaboatshow.com'] = 'atlanta';
 $sites['dev2.atlantaboatshow.com'] = 'atlanta';
 $sites['stage2.atlantaboatshow.com'] = 'atlanta';
 $sites['live2.atlantaboatshow.com'] = 'atlanta';
 $sites['www.atlantaboatshow.com'] = 'atlanta';

 // Atlantic City
 $sites['local.acboatshow.com'] = 'atlanticcity';
 $sites['dev2.acboatshow.com'] = 'atlanticcity';
 $sites['stage2.acboatshow.com'] = 'atlanticcity';
 $sites['live2.acboatshow.com'] = 'atlanticcity';
 $sites['www.acboatshow.com'] = 'atlanticcity';

 // Baltimore
 $sites['local.baltimoreboatshow.com'] = 'baltimore';
 $sites['dev2.baltimoreboatshow.com'] = 'baltimore';
 $sites['stage2.baltimoreboatshow.com'] = 'baltimore';
 $sites['live2.baltimoreboatshow.com'] = 'baltimore';
 $sites['www.baltimoreboatshow.com'] = 'baltimore';

 // Chicago
 $sites['local.chicagoboatshow.com'] = 'chicago';
 $sites['dev2.chicagoboatshow.com'] = 'chicago';
 $sites['stage2.chicagoboatshow.com'] = 'chicago';
 $sites['live2.chicagoboatshow.com'] = 'chicago';
 $sites['www.chicagoboatshow.com'] = 'chicago';

 // Chicagoland
 $sites['local.chicagoland.sportshows.com'] = 'chicagoland';
 $sites['dev2.chicagoland.sportshows.com'] = 'chicagoland';
 $sites['stage2.chicagoland.sportshows.com'] = 'chicagoland';
 $sites['live2.chicagoland.sportshows.com'] = 'chicagoland';
 $sites['chicagoland.sportshows.com'] = 'chicagoland';

 // Kansas City
 $sites['local.kansascitysportshow.com'] = 'kansascity';
 $sites['dev2.kansascitysportshow.com'] = 'kansascity';
 $sites['stage2.kansascitysportshow.com'] = 'kansascity';
 $sites['live2.kansascitysportshow.com'] = 'kansascity';
 $sites['www.kansascitysportshow.com'] = 'kansascity';

 // Louisville
 $sites['local.louisvilleboatshow.com'] = 'louisville';
 $sites['dev2.louisvilleboatshow.com'] = 'louisville';
 $sites['stage2.louisvilleboatshow.com'] = 'louisville';
 $sites['live2.louisvilleboatshow.com'] = 'louisville';
 $sites['www.louisvilleboatshow.com'] = 'louisville';

// Miami
$sites['local.miamiboatshow.com'] = 'miami';
$sites['dev2.miamiboatshow.com'] = 'miami';
$sites['stage2.miamiboatshow.com'] = 'miami';
$sites['live2.miamiboatshow.com'] = 'miami';
$sites['www.miamiboatshow.com'] = 'miami';

// Minneapolis
$sites['local.minneapolisboatshow.com'] = 'minneapolis';
$sites['dev2.minneapolisboatshow.com'] = 'minneapolis';
$sites['stage2.minneapolisboatshow.com'] = 'minneapolis';
$sites['live2.minneapolisboatshow.com'] = 'minneapolis';
$sites['www.minneapolisboatshow.com'] = 'minneapolis';

// Nashville
$sites['local.nashvilleboatshow.com'] = 'nashville';
$sites['dev2.nashvilleboatshow.com'] = 'nashville';
$sites['stage2.nashvilleboatshow.com'] = 'nashville';
$sites['live2.nashvilleboatshow.com'] = 'nashville';
$sites['www.nashvilleboatshow.com'] = 'nashville';

// Northwest
$sites['local.northwestsportshow.com'] = 'northwest';
$sites['dev2.northwestsportshow.com'] = 'northwest';
$sites['stage2.northwestsportshow.com'] = 'northwest';
$sites['live2.northwestsportshow.com'] = 'northwest';
$sites['www.northwestsportshow.com'] = 'northwest';

// Norwalk
$sites['local.boatshownorwalk.com'] = 'norwalk';
$sites['dev2.boatshownorwalk.com'] = 'norwalk';
$sites['stage2.boatshownorwalk.com'] = 'norwalk';
$sites['live2.boatshownorwalk.com'] = 'norwalk';
$sites['www.boatshownorwalk.com'] = 'norwalk';

// New England
$sites['local.newenglandboatshow.com'] = 'newengland';
$sites['dev2.newenglandboatshow.com'] = 'newengland';
$sites['stage2.newenglandboatshow.com'] = 'newengland';
$sites['live2.newenglandboatshow.com'] = 'newengland';
$sites['www.newenglandboatshow.com'] = 'newengland';

// New York
$sites['local.nyboatshow.com'] = 'newyork';
$sites['dev2.nyboatshow.com'] = 'newyork';
$sites['stage2.nyboatshow.com'] = 'newyork';
$sites['live2.nyboatshow.com'] = 'newyork';
$sites['www.nyboatshow.com'] = 'newyork';

// Saltwater
$sites['local.saltwater.sportshows.com'] = 'saltwater';
$sites['dev2.saltwater.sportshows.com'] = 'saltwater';
$sites['stage2.saltwater.sportshows.com'] = 'saltwater';
$sites['live2.saltwater.sportshows.com'] = 'saltwater';
$sites['saltwater.sportshows.com'] = 'saltwater';

// sportshows
$sites['local.sportshows.com'] = 'sportshows';
$sites['dev2.sportshows.com'] = 'sportshows';
$sites['stage2.sportshows.com'] = 'sportshows';
$sites['live2.sportshows.com'] = 'sportshows';
$sites['www.sportshows.com'] = 'sportshows';

// St. Louis
$sites['local.stlouisboatshow.com'] = 'stlouis';
$sites['dev2.stlouisboatshow.com'] = 'stlouis';
$sites['stage2.stlouisboatshow.com'] = 'stlouis';
$sites['live2.stlouisboatshow.com'] = 'stlouis';
$sites['www.stlouisboatshow.com'] = 'stlouis';


// Suffern
$sites['local.suffern.sportshows.com'] = 'suffern';
$sites['dev2.suffern.sportshows.com'] = 'suffern';
$sites['stage2.suffern.sportshows.com'] = 'suffern';
$sites['live2.suffern.sportshows.com'] = 'suffern';
$sites['suffern.sportshows.com'] = 'suffern';

// Tampa
$sites['local.tampaboatshow.com'] = 'tampa';
$sites['dev2.tampaboatshow.com'] = 'tampa';
$sites['stage2.tampaboatshow.com'] = 'tampa';
$sites['live2.tampaboatshow.com'] = 'tampa';
$sites['www.tampaboatshow.com'] = 'tampa';
