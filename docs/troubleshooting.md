Troubleshooting
===

Use this document to track common troubleshooting steps that might not belong anywhere else.

# Config Import/Config Ignore/Config Split

## UnknownExtensionException during Drush Config Import [Sandstorm Jira: NMMA-213]

The error:
> Drupal\Core\Extension\Exception\UnknownExtensionException: The module gtm does not exist. in Drupal\Core\Extension\ExtensionList->getPathname() (line 520 of /mnt/www/html/discoverboatdev/docroot/core/lib/Drupal/Core/Extension/ExtensionList.php).

This seems to happen when we are removing a module from config_ignore during a new deployment. In this case we had already added gtm.settings to config_ignore, but then were attempting to push some changes up to dev which removed `gtm.settings` from the config_ignore list, and also deleted the gtm module.

My workaround was:

Manually remove the affected config entry from the deployment target admin page at /admin/config/development/configuration/ignore. If deploying to DEV2 for 16 sites, we would need to do this 16 times. I did it for miami and newyork

Run config import twice for each multisite e.g:

    vm$ drush @miami.dev2 cim -y
    vm$ drush @miami.dev2 cim -y
    vm$ drush @newyork.dev2 cim -y
    vm$ drush @newyork.dev2 cim -y

(it’s possible that the first cim -y command should have been a cr, just to fix issues with the gtm module suddenly going missing)

The initial report on https://www.drupal.org/project/config_ignore/issues/2989021 recommends using drupal console to import the config_ignore config before running a full config import, I will try that approach to see if it works well.

# Caching

Drupal implements several layers of caching. Many of these need to be disabled on developers' local instances to speed up local development testing. It's important to test the sites with caching enabled, which is why it is fully enabled on dev instances. Developers may also find it helpful to enable caching on their locals to debug any caching related issues.

## CSS/JS optimization admin page

Performance settings controlling caching of CSS and JS can be managed in the Drupal UI at /admin/config/development/performance, any changes to which can be exported to config files.

## Controlling local caching

- docroot/sites/settings/local.settings.php
  - CSS/JS optimization caching
    - $config['system.performance']['css']['preprocess']
    - $config['system.performance']['js']['preprocess']
    - $config['advagg.settings']['enabled']
  - Render caches
    - $settings['cache']['bins']['render']
    - $settings['cache']['bins']['dynamic_page_cache']
  - Miscellaneous
    - $settings['cache']['bins']['bootstrap']
    - $settings['cache']['bins']['discovery']
    - $settings['cache']['bins']['config']
- docroot/sites/development.services.yml
  - Twig Caching
    - parameters > twig.config > cache
    
