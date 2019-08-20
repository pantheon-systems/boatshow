#!/bin/bash

site="$1"
target_env="$2"

# Go to the path from where drush commands can be executed.
repo_root="/var/www/html/$site.$target_env/docroot"
#export PATH=$repo_root/vendor/bin:$PATH
cd $repo_root

echo "New code has been deployed to Boatshows2 STAGE environment."
echo "Running drush config-import on Miami site."
#drush @miami.dev2 cim vcs -y
drush -l miami cim vcs -y
echo "Running drush updatedb on Miami site."
#drush @miami.dev2 updb --entity-updates -y
drush -l miami updb --entity-updates -y
#echo "Running drush config-split-import on default site."
#drush @discoverboatus.dev csim dev -y
echo "Running drush cache-rebuild on default site."
#drush @miami.dev2 cr
drush -l miami cr
