#!/bin/bash

site="$1"
target_env="$2"

# Setup BLT alias
function blt() {
  if [[ ! -z ${AH_SITE_ENVIRONMENT} ]]; then
    PROJECT_ROOT="/var/www/html/${AH_SITE_GROUP}.${AH_SITE_ENVIRONMENT}"
  elif [ "`git rev-parse --show-cdup 2> /dev/null`" != "" ]; then
    PROJECT_ROOT=$(git rev-parse --show-cdup)
  else
    PROJECT_ROOT="."
  fi

  if [ -f "$PROJECT_ROOT/vendor/bin/blt" ]; then
    $PROJECT_ROOT/vendor/bin/blt "$@"

  # Check for local BLT.
  elif [ -f "./vendor/bin/blt" ]; then
    ./vendor/bin/blt "$@"

  else
    echo "You must run this command from within a BLT-generated project."
    return 1
  fi
}

# Go to the path from where drush commands can be executed.
repo_root="/var/www/html/$site.$target_env/docroot"
#export PATH=$repo_root/vendor/bin:$PATH
cd $repo_root

echo "New code has been deployed to $site.$target_env environment."

for MULTISITE in $(blt blt:config:get multisites)
do
  echo "======== begin multisite: ${MULTISITE} ========"

  echo "Running drush cache-rebuild 1/2"
  drush -l $MULTISITE cr

  echo "Running Module Missing Message Fixer"
  drush -l $MULTISITE module-missing-message-fixer:fix --all

  echo "Importing config ignore settings"
  drush -l $MULTISITE php-script ../tools/import-config-ignore-settings.php

  echo "Running drush config-import"
  drush -l $MULTISITE cim sync -y

  echo "Running drush updatedb"
  drush -l $MULTISITE updb -y

  echo "Running drush cache-rebuild 2/2"
  drush -l $MULTISITE cr

  echo "======== end multisite: ${MULTISITE} ========"
done

echo "Complete!"
