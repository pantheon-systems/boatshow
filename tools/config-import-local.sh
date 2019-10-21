#!/bin/bash

cd /var/www/boatshow/docroot

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


for MULTISITE in $(blt blt:config:get multisites)
do
  echo "======== begin multisite: ${MULTISITE} ========"

  echo "Importing config ignore settings"
  drupal --uri=$MULTISITE config:import:single --file=../config/default/config_ignore.settings.yml

  echo "Running drush config-import"
  drush -l $MULTISITE cim sync -y

  echo "======== end multisite: ${MULTISITE} ========"
done



