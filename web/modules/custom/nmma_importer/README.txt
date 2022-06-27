NMMA Importer Module


INTRODUCTION
------------

The NMMA Importer module is designed to retrieve JSON from a remote source
for various dynamic content types on NMMA including:
    - Businesses
    - Accessory Manufactures (and associated Taxonomy terms)
    - Youth Boating Programs
    - Certified Manufacturers

This module currently retrieves data from an AWS installation where queries
on the client's database are stored in JSON format flat files.

The middleware layer module itself can be found above docroot at 'middleware
.' (This is something like an API, although technically, it isn't very smart
or even very api-like. It really is just a workaround for Acquia's inability
to install a driver.)

Since the middleware layer is as completely basic as possible, refreshing the
 values stored there is done via ultimate_cron yml files stored in
 /docroot/module/custom/nmma_importer/config/optional directory.

The module also provides a includes a drush command for refreshing data on the
middlewaresource layer. The command alias is 'nmma-rs'. You can also refresh
individual files on the middleware layer by adding a 'type' flag. For
example, 'nmma-rs --type=businesses.' Running `drush nmma-rs` updates all
values. The list of type flags includes:

drush nmma-rs --type=acc_mfrs
drush nmma-rs --type=acc_terms
drush nmma-rs --type=businesses
drush nmma-rs --type=youth_programs
drush nmma-rs --type=brands
drush nmma-rs --type=certified

REALLY IMPORTANT: Because of current Isobar security, you can only successfully
connect to the middleware layer through the Isobar VPN, or from IP
addresses on the Acquia Environments. It should be noted, however that the
pulic IP addresses listed by Acquia do not appear to be the actual addresses
of the requests originating from Acquia. At the moment, these addresses are:

204.236.255.192
54.210.225.228



NOTES ON CRON
---------------

Drupal's Ultimate Cron module provides a few advantages over writing a queue
worker plugin. Chiefly, this approach provides a simple way to manually force
 a single cron task through the drupal UI, and allows (potentially) more
 granular configuration for the cron tasks themselves via the UI. To change
 these values, visit

 /admin/config/system/cron

You can use drush to manually update the configuration provided by ultimate
cron config yml files by running:

`drush config-import --partial
--source=modules/custom/nmma_importer/config/optional --yes`


IMPORTANT:
---------------
The scripts that handle importing content from middleware to drupal are
hardcoded with ip address values whitelisted by Isobar IT. (There are two ip
addresses allowed: One for calls originating from the Isobar VPN, another
address for IP's originating at Acquia.)

If you are doing local development, you will need to update configuration
values to use Isobar IPs (instead of the default Acquia values) and have an
active VPN connection. You can update this by changing the files in this
module's /config/install directory.

An Isobar-origin client call would look like this:

http://10.111.60.190:22000/middleware/index
.php?action=acc_mfrs&auth=v34-542-741

An Acquia-origin Ip call would look like this:

http://34.237.30.192:22000/middleware/index
.php?action=acc_mfrs&auth=v34-542-741



HELPFUL
-----------

drush commands to manually import dynamic content (example):
drush mim (migration name)

list all migrations:
drush ms

drush commands to import the cron job values:

drush config-import --partial
--source=modules/custom/nmma_importer/config/optional --yes

drush commands to delete cron config values (example):
drush cdel ultimate_cron.job.nmma_refresh_accessories
