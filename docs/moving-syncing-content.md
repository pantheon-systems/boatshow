Moving/Syncing Content
===

### Sync dev content to local

```console
# Sync single multisite (db only)
vm$ blt nmma:sync -n --site=miami

# Sync single multisite (db + files)
vm$ blt nmma:sync -n --site=miami --sync-files

# Sync single multisite (files only)
vm$ blt drupal:sync:files -n --site=miami

# Sync all multisites (db only)
vm$ blt nmma:sync-all -n

# Sync all multisites (db + files)
vm$ blt nmma:sync-all -n --sync-files

# Sync all multisites (files only)
# gotcha! this doesn't exist yet

```

### Copying files between sites on the same environment:

```console
vm$ drush @[CITY_ALIAS].stage2 ssh
acquia$ rsync -arv ./sites/[CITY_ALIAS]/files/ ./sites/[CITY_ALIAS]/files/
# For rsync, the first path is the source path, the second path is the destination
```

### Reset permissions on a files directory (set files to 664, directories to 775)

```console
vm$ drush @[CITY_ALIAS].stage2 ssh
acquia$ cd ./sites/[CITY_ALIAS]/files/
acquia$ find . -type f -exec chmod 664 {} \;
acquia$ find . -type d -exec chmod 775 {} \;
```
