This module is currently disabled and if enabled, you should not later export configuration.

The next step after turning on this module is to go to https://local.nmma.test/admin/config/regional/content-language and check 'Taxonomy Term' and mark all the items under Activities and Boat Types then hit save.
This setting is not exported because it creates a huge amount of 'core field overrides'.

The next step is to run the migration:

* drush @nmma.local migrate:import --group discoverboating_com_concept --update

Other handy commands:

* drush @nmma.local migrate:status --group discoverboating_com_concept
* drush @nmma.local migrate:rollback --group discoverboating_com_concept

The configuration for the migration is store in the config/install/migrate_plus* files of this module. If those files are updated, you will need to run:

drush @nmma.local config-import --partial --source=modules/custom/nmma_migrate/nmma_migrate_concept/config/install --yes

The created content can be found at:
* https://local.nmma.test/admin/structure/taxonomy/manage/activities/overview
* https://local.nmma.test/admin/structure/taxonomy/manage/boat_types/overview

The thing to see here is that the migrations are powered by the CSV's contained in the csv directory of the module. The migrations show that it is possible to migrate activities taxonomy terms that reference boat type taxonomy terms of 2 different languages while only creating one single 'parent' term for both languages instead of 2 different terms.

Pay attention to the CSV files to see how the boat_type reference is stored as the IDs separated by semi-colons. You should be able to change those as you see fit, roll-back, and re-import. 