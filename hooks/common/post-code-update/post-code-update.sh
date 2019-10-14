#!/bin/bash

site="$1"
target_env="$2"

# Go to the path from where drush commands can be executed.
repo_root="/var/www/html/$site.$target_env/docroot"
#export PATH=$repo_root/vendor/bin:$PATH
cd $repo_root

echo "New code has been deployed to $site.$target_env environment."

for MULTISITE in "miami" "newyork"
do
  echo "======== begin multisite: ${MULTISITE} ========"

  echo "Running drush config-import"
  drush -l $MULTISITE cim sync -y

  echo "Running drush updatedb"
  drush -l $MULTISITE updb -y

  echo "Running drush cache-rebuild"
  drush -l $MULTISITE cr

  echo "======== end multisite: ${MULTISITE} ========"
done

echo "Complete!"
