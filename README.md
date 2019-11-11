# Boat Shows

This is the home of [National Marine Manufacturers Association](https://www.nmma.org) ([NMMA](https://www.nmma.org)) [boat show websites](https://www.boatshows.com) and related websites.

## Project Resources

- [JIRA](https://sandstormdesign.atlassian.net/projects/NMMA/issues)
- [GitHub Repo](https://github.com/NationalMarine/BoatShows)
- [Acquia Cloud subscription](https://cloud.acquia.com/app/develop/applications/f2e0f526-ca95-47ff-a614-a415ef43ecda)
- [TravisCI](https://travis-ci.com/NationalMarine)

### Further Reading

This readme serves as an entry point to the project documentation. Please refer to additional documentation in the 'docs' directory for more detail.

- [Local Development General Requirements](docs/local_requirements.md)
- [Setup Guide](docs/setup-guide)
- [BLT and Dependency Management](docs/blt-and-dependency-management.md)
- [Drupal Configuration Management](docs/config-management.md)
- [Git and Code Deployment Process](docs/git-and-code-deployment-process.md)
- [New Multisite Creation](docs/new-multisite-creation.md)
- [Troubleshooting](docs/troubleshooting.md)

---

### Build the front-end theme

```console
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp
```

**NOTE**: If NPM stalls out during during the node-gyp rebuild command, you can hit ctrl-c and then run `npm update` again before redoing the `npm install && gulp` command. [Reference](https://github.com/sass/node-sass/issues/1579#issuecomment-263048192)

### Log into your site with drush

Access the site and do necessary work by running the following:

```console
vm$ drush @miami.local uli
```

This also works for remote environments which you have ssh access to:

```console
vm$ drush @miami.dev2 uli
```

**NOTE**: You must have Senior Developer access to the application you are logging into. To diagonose any BLT setup related issue run `blt doctor` from within VM.

## Other Notes

- To shut down the virtual machine: `host$ vagrant halt`
- To destroy it completely (if you want to save a little disk space, or want to rebuild it from scratch with `vagrant up` again): `host$ vagrant destroy`
- You can modify configuration options of the VM for all users of the project, by editing the variables within `box/config.yml`. To modify options only for your local machine, create a `box/local.config.yml` file. See the [default.config.yml](https://github.com/geerlingguy/drupal-vm/blob/master/default.config.yml) from the Drupal VM repo for reference.
