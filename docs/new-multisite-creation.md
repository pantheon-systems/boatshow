New Multisite Creation
===

## Adding a new multisite



### Tracking the site

- Add the site to the [NMMA Boat Show Sites Manifest](https://docs.google.com/spreadsheets/d/1n9BI6TAf_Q-Tkf-vaB2lLgLaCF92iCQxgTHX0uQrTFw/edit#gid=0)
  - Choose a multisite machine name up front

### Acquia Changes

- Create a database for the multisite on each environment
  - Navigate to `Acquia > Boatshows2 > DEV` > Databases and create a new database named `{multisite}`
  - Navigate to `Acquia > Boatshows2 > STAGE` > Databases and create a new database named `{multisite}`
  - Navigate to `Acquia > Boatshows2 > PROD` > Databases and create a new database named `{multisite}`
- Register the domain for the multisite on each environment
  - Navigate to `Acquia > Boatshows2 > DEV` > Domains and create the dev domain e.g. dev2.miamiboatshow.com
  - Navigate to `Acquia > Boatshows2 > STAGE` > Domains and create the stage domain e.g. stage2.miamiboatshow.com
  - Navigate to `Acquia > Boatshows2 > PROD` > Domains and create the prod domains e.g. www.miamiboatshow.com and live2.miamiboatshow.com

### Code Changes

See commit `3ec7715b [NMMA-213] stlouis multisite` ([github](https://github.com/NationalMarine/BoatShows/commit/3ec7715bb2770d2cb21dc5512259152529a7d894)) for an example of a new multisite being set up in code.

- Edit `blt/blt.yml`:
  - Add multisite machine name to `multisites[]`
- Edit `box/config.yml`:
  - Add multisite to `apache_vhosts[]` by copying another entry
  - Add multisite to `mysql_databases[]` by copying another entry
- Edit `docroot/sites/sites.php`
  - Copy another multisite's section, and update the URLs and machine names
- Clone `docroot/sites/{multisite}` from another multisite
  - Edit `dorcroot/sites/{multisite}/blt.yml`
    - Update `project.local.hostname`
    - Update `project.machine_name`
    - Update `project.human_name`
  - Ensure that any of the `*.settings.php` files for the new multisite are properly configured
- Clone and edit `docroot/themes/custom/boatshow/sass/city-{multisite}.scss` from an existing file
  - Configure variables for the new site
- Clone and edit `drush/sites/{multisite}.site.yml` from another file
  - Alter `*.uri` values to point to new URIs
- Commit to 2.x-develop branch and push to github to trigger a deployment. NOTE: This deployment will throw some errors in the acquia log because drush won't have a database to operate on for the new multisite, but it will complete.

### Content Duplication

We will use the local vagrant multisite as a staging instance (it is not possible to copy directly between remote hosts) to copy data from an existing multisite's PROD environment into the DEV, STAGE and PROD environments for the new multisite.

Before using your local to move content around, you will need to re-provision vagrant to add the new database and vhost:

    vm$ exit
    host$ vagrant provision
    host$ vagrant ssh

Now run the following commands to copy from your source multisite to your destination multisite. Note that this does not sync private files.

    # Set variables for your source and target multisite machine names

    vm$ export SOURCE_MULTISITE=miami
    vm$ export DEST_MULTISITE=europa

    # Copy content and files from SOURCE PROD to TARGET LOCAL:
    vm$ drush -y sql-sync @${SOURCE_MULTISITE}.live2 @${DEST_MULTISITE}.local
    vm$ drush -y rsync @${SOURCE_MULTISITE}.live2:%files @${DEST_MULTISITE}.local:%files

    # Copy content and files from TARGET LOCAL to TARGET DEV:
    vm$ drush -y sql-sync @${DEST_MULTISITE}.local @${DEST_MULTISITE}.dev2
    vm$ drush -y rsync @${DEST_MULTISITE}.local:%files @${DEST_MULTISITE}.dev2:%files

    # Copy content and files from TARGET LOCAL to TARGET STAGE:
    vm$ drush -y sql-sync @${DEST_MULTISITE}.local @${DEST_MULTISITE}.stage2
    vm$ drush -y rsync @${DEST_MULTISITE}.local:%files @${DEST_MULTISITE}.stage2:%files

    # Copy content and files from TARGET LOCAL to TARGET PROD:
    vm$ drush -y sql-sync @${DEST_MULTISITE}.local @${DEST_MULTISITE}.live2
    vm$ drush -y rsync @${DEST_MULTISITE}.local:%files @${DEST_MULTISITE}.live2:%files

### Set up other developers with the multisite

The new multisite will need to be set up on other developers' local vms. They can each follow these steps.

    # Pull the latest from the 2.x-develop branch
    host$ git checkout 2.x-develop
    host$ git pull

    # Provision Drupal VM:
    host$ vagrant provision

    # Sync files and content from DEV to LOCAL (e.g. for europa)
    host$ vagrant ssh
    vm$ blt nmma:sync -n --site=europa --sync-files
