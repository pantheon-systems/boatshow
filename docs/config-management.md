Drupal Configuration Management
===

# Config Management Commands

## Export Config

If you have made changes on a multisite which need to be shared with the team:

```console
vm$ drush @miami.local cex -y
```

## Import Config

If you need to import changes on a multisite which are different in your local environment branch from what has been synced down dev:

```console
vm$ drush @chicago.local cim -y
```

# About Config Ignore

All of the multisites share a common set of configuration, which is maintained in config/default. Each time a deployment happens, the 'active configuration store' in the deployment target's database is destroyed and replaced with the config from the files stored in the repository using the `drush config-import` command.

The config ignore module provides a list of config items that should not be overwritten during a configuration import or export. The list of ignored configs is stored in the `ignored_config_entities` property of [config/default/config_ignore.settings.yml](config_ignore.settings.yml), or you can manage it via the drupal UI at /admin/config/development/configuration/ignore .

The `config_ignore.settings` config entity must be imported first before running a general `drush config-import`. Otherwise, config-import will not know which config entities are ignored. This pre-import is handled using a script at `tools/import-config-ignore-settings.php`, which is called automatically during deployments.

If you need to run the pre-import on your local machine for any reason, you can use the following:

    vm$ cd /var/www/boatshow/docroot
    vm$ drush -l {multisite} php-script ../tools/import-config-ignore-settings.php
