#!/bin/bash

site="$1"
target_env="$2"

# Go to the path from where drush commands can be executed.
repo_root="/var/www/html/$site.$target_env"
export PATH=$repo_root/vendor/bin:$PATH
cd $repo_root

echo "New code has been committed to Discoverboat DEV environment."
echo "Running drush config-import on default site."
drush @discoverboatus.dev cim --source=../config/default -y
echo "Running drush updatedb on default site."
drush @discoverboatus.dev updb --entity-updates -y
echo "Running drush config-split-import on default site."
drush @discoverboatus.dev csim dev -y
echo "Running drush cache-rebuild on default site."
drush @discoverboatus.dev cr
