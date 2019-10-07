#!/bin/bash

site="$1"
target_env="$2"

# Go to the path from where drush commands can be executed.
repo_root="/var/www/html/$site.$target_env/docroot"
#export PATH=$repo_root/vendor/bin:$PATH
cd $repo_root

echo "New code has been deployed to Boatshows2 DEV environment."

echo "======== multisite: miami ========"

echo "Running drush config-import"
drush -l miami cim vcs -y

echo "Running drush updatedb"
drush -l miami updb --entity-updates -y

echo "Running drush cache-rebuild"
drush -l miami cr

echo "======== multisite: newyork ========"

echo "Running drush config-import"
drush -l newyork cim vcs -y

echo "Running drush updatedb"
drush -l newyork updb --entity-updates -y

echo "Running drush cache-rebuild"
drush -l newyork cr

echo "Complete!"
