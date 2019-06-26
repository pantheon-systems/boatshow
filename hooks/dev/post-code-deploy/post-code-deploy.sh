#!/bin/bash
#
# Cloud Hook: post-code-deploy
#
# I _think_ this runs in addition to common deployment commands.
# See https://docs.acquia.com/site-factory/extend/hooks/dbupdate/#using-acquia-product-blt
#

site="$1"
env="$2"
# database role. (Not expected to be needed in most hook scripts.)
db_role="$3"
# The public domain name of the website.
domain="$4"

# The websites' document root can be derived from the site/env:
docroot="/var/www/html/$site.$env/docroot"


# Acquia recommends the following two practices:
# 1. Hardcode the drush version.
# 2. When running drush, provide the docroot + url, rather than relying on
#    aliases. This can prevent some hard to trace problems.
DRUSH_CMD="drush8 --root=$docroot --uri=https://$domain"


$DRUSH_CMD cr
