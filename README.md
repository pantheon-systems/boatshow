# Boat Shows

This is the home of [National Marine Manufacturers Association](https://www.nmma.org) ([NMMA](https://www.nmma.org)) [boat show websites](https://www.boatshows.com) and related websites.

## Resources

- [JIRA](https://sandstormdesign.atlassian.net/projects/NMMA/issues)
- [GitHub Repo](https://github.com/NationalMarine/BoatShows)
- [Acquia Cloud subscription](https://cloud.acquia.com/app/develop/applications/f2e0f526-ca95-47ff-a614-a415ef43ecda)
- [TravisCI](https://travis-ci.com/NationalMarine)

### Further Reading

- [Local Development General Requirements](docs/local_requirements.md)

---

## Getting Started

This project is based on BLT, an open-source project template and tool that enables building, testing, and deploying Drupal installations following Acquia Professional Services best practices. While this is one of many methodologies, it is our recommended methodology.

This solution requires a handful of dependencies that must exist on your local machine for the project to work. These include Vagrant, Virtual Box, Ansible, Drush, and composer. The following notes will help you install these dependencies to get up and running.

### Overview

- Review the [Required / Recommended Skills](https://docs.acquia.com/blt/) for working with a BLT project.
- Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [System Requirements](http://blt.readthedocs.io/en/latest/INSTALL/#system-requirements).
- Request access to organization that owns the project repo in GitHub (if needed).
- Fork the project repository in GitHub.
- Request access to the Acquia Cloud Environment for your project (if needed).
- Setup a SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key).
  - [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
  - [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)
- Clone the repository. By default, Git names this "origin" on your local.

  ```console
  host$ git clone git@github.com:NationalMarine/BoatShows.git
  ```

- Primary development branch: develop
- Local environment: DrupalVM
- Architecture: Drupal multisite

---

## Setup Local Environment

BLT provides an automation layer for testing, building, and launching Drupal 8 applications. For ease when updating codebase it is recommended to use  Drupal VM. If you prefer, you can use another tool such as Docker, [DDEV](https://blt.readthedocs.io/en/latest/alternative-environment-tips/ddev.md), [Docksal](https://blt.readthedocs.io/en/latest/alternative-environment-tips/docksal.md), [Lando](https://blt.readthedocs.io/en/latest/alternative-environment-tips/lando.md), (other) Vagrant, or your own custom LAMP stack, however support is very limited for these solutions.

### Tools you will need

The following dependencies must first be installed and available to the command line on your local machine. See [Local Development General Requirements](docs/local_requirements.md) for more info on how to check versions and install these.

- [Ansible](http://docs.ansible.com/intro_installation.html) >= 2.2.x
- [Composer](https://getcomposer.org/doc/00-intro.md) >= 1.8.x
- [Drush](http://www.drush.org/en/master) = 9.x
- [Node.js](https://nodejs.org/en/) = 9.11.x
- [PHP](http://php.net/manual/en/install.php) = 7.2.x
- [Vagrant](https://www.vagrantup.com/downloads.html) >= 2.2.x
- [VirtualBox](https://www.virtualbox.org/wiki/Downloads) >= 6.0.x

**NOTE:** *If using macOS, the preferred method of installing these dependencies is with [Homebrew](http://brew.sh/), [Homebrew Cask](https://caskroom.github.io/) and [NVM](https://github.com/creationix/nvm).*

```console
host$ brew install ansible composer php72 nvm
host$ brew tap caskroom/cask
host$ brew cask install virtualbox vagrant
host$ nvm install 9.11.2
host$ nvm use 9.11.2
```

**NODE:** *It may be necessary to add PHP 7.2 to your path variable. If you installed via Homebrew, you should be able to use these lines:*

  ```console
  export PATH="/usr/local/opt/php@7.2/bin:$PATH"
  export PATH="/usr/local/opt/php@7.2/sbin:$PATH"
  ```

It is recommended to install the following Composer plugins for a faster and easier setup.

- [prestissimo](https://github.com/hirak/prestissimo)

```console
host$ composer global require hirak/prestissimo
```

It is recommended to install the following Vagrant plugins for a faster and easier setup.

- [vagrant-hostsupdater (REQUIRED)](https://github.com/cogitatio/vagrant-hostsupdater)
- [vagrant-cachier](https://github.com/fgrehm/vagrant-cachier)
- [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest)

```console
host$ vagrant plugin install vagrant-cachier
host$ vagrant plugin install vagrant-vbguest
host$ vagrant plugin install vagrant-hostsupdater
```

### About Drupal VM

The Boatshows websites utilizes [Drupal VM](http://www.drupalvm.com/) for local Drupal development, built with Vagrant + Ansible + VirtualBox.

It will install the following on an Ubuntu 16.04 Linux VM:

- [Apache](https://httpd.apache.org/) 2.4.x
- [PHP](http://php.net/) 7.2.x
- [MySQL](https://www.mysql.com/products/community/) 5.7.x
- [Drupal](https://www.drupal.org/) 8.x (version defined in [composer.json](../composer.json))

Along with some configurable extra utilities listed in the `drupalvm/config.yml` option `installed_extras`:

- [Adminer](https://www.adminer.org/)
- [Drupal Console](https://drupalconsole.com/)
- [Drush](http://www.drush.org/en/master/)
- [MailHog](https://github.com/mailhog/MailHog)
- [Node.js](https://nodejs.org/en/) 6.x
- [Selenium](http://www.seleniumhq.org/) (for [Behat](http://behat.org/en/latest/) testing)
- [Apache SOLR](http://lucene.apache.org/solr/) 5.5.3
- [XDebug](https://xdebug.org/)

Full [Drupal VM](http://www.drupalvm.com/) documentation is available at [http://docs.drupalvm.com/](http://docs.drupalvm.com/).

## INSTALLATION STEPS

For a general list of steps, follow the steps below:

### Clone down the repo to your local/dev machine

```console
host$ git clone git@github.com:NationalMarine/Boatshows.git
```

### Disable tracking permissions in git for this repo

```console
host$ cd path/to/freshly/cloned/repo
host$ git config core.fileMode false
```

### Checkout the **develop** branch

```console
host$ git checkout develop
```

### Install Composer dependencies (Warning: this can take some time based on internet speeds)

```console
host$ composer install
```

### Setup VM

Setup the VM with the configuration from this repository's configuration files.

```console
host$ vagrant up
```

**Note:** *If there are any errors during the course of running `vagrant up`, and it drops you back to your command prompt, just run `vagrant provision` to continue building the VM from where you left off. If there are still errors, after doing this a few times, work with the project Tech Lead to resolve.*

To prevent headaches, from your project's root directory, run the following commands:

```console
host$ sudo chmod -R +w docroot/sites/
```

**NOTE:** *You can also have Vagrant automatically assign an available IP address to your VM if you install the `auto_network` plugin (`vagrant plugin install vagrant-auto_network`), and set `vagrant_ip` to `0.0.0.0` inside a `drupalvm/local.config.yml` file.*

### SSH into your VM

SSH into your localized Drupal VM environment automated with the BLT launch and automation tools.

```console
host$ vagrant ssh
```

### Setup a local blt alias

If the blt alias is not available (try `$ which blt`) use this command inside vagrant (one time only).

```console
vm$ composer run-script blt-alias
```

### Setup local Drupal sites with an empty database

Use BLT to setup the sites for local development. These will be empty shell sites until content is synced down. TODO: we should have a shell script which does this for us.

**NOTE**: If this gives you an error about the database not existing "Failed to drop or create the database" OR any other errors, you may either need to run `host$ vagrant provision` again to install the databases, or you may need to delete all of the local files that BLT has generated inside the sites directory and start from scratch. To do this, run `host$ rm -rf path/to/repo/docroot/sites` and then `host$ git checkout path/to/repo/docroot/sites`

```console
vm$ blt setup -n --site=template
vm$ blt setup -n --site=atlanta
vm$ blt setup -n --site=chicago
vm$ blt setup -n --site=kansascity
vm$ blt setup -n --site=nashville
```

### Sync local Drupal sites from dev content

```console
vm$ blt sync:refresh -v --site=template
vm$ blt sync:files -v --site=template

vm$ blt sync:refresh -v --site=atlanta
vm$ blt sync:files -v --site=atlanta

vm$ blt sync:refresh -v --site=chicago
vm$ blt sync:files -v --site=chicago

vm$ blt sync:refresh -v --site=kansascity
vm$ blt sync:files -v --site=kansascity

vm$ blt sync:refresh -v --site=nashville
vm$ blt sync:files -v --site=nashville
```

**NOTE**: You must have Senior Developer access to the Acquia application. To diagonose any BLT setup related issue run `blt doctor` from within VM.

### Build the front-end theme

```console
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp
```

**NOTE**: If NPM stalls out during during the node-gyp rebuild command, you can hit ctrl-c and then run `npm update` again before redoing the `npm install && gulp` command. [Reference](https://github.com/sass/node-sass/issues/1579#issuecomment-263048192)

### Log into your site with drush

Access the site and do necessary work by running the following commands.

```console
vm$ cd docroot
vm$ drush @chicago.local uli
vm$ drush @atlanta.local uli
```

### Export Config

If you have made changes on a multisite which need to be shared with the team, e.g. for the chicago site:

```console
vm$ cd docroot
vm$ drush -l chicago cex -y
```

### Import Config

If you need to import changes on a multisite which are different in your local environment branch from what has been synced down dev, e.g. for chicago:

```console
vm$ cd docroot
vm$ drush -l chicago cim -y
```

## Other Notes

- To shut down the virtual machine, enter `vagrant halt` in the Terminal in from the root of the project repo. To destroy it completely (if you want to save a little disk space, or want to rebuild it from scratch with `vagrant up` again), type in `vagrant destroy`.
- You can modify configuration options of the VM for all users of the project, by editing the variables within `box/config.yml`. To modify options only for your local machine, create a `box/local.config.yml` file. See the [default.config.yml](https://github.com/geerlingguy/drupal-vm/blob/master/default.config.yml) from the Drupal VM repo for reference.

---

## Other Local Setup Steps

1. Set up frontend build and theme.
By default BLT sets up a site with the lightning profile and a cog base theme. You can choose your own profile before setup in the blt.yml file. If you do choose to use cog, see [Cog's documentation](https://github.com/acquia-pso/cog/blob/8.x-1.x/STARTERKIT/README.md#create-cog-sub-theme) for installation.
See [BLT's Frontend docs](https://blt.readthedocs.io/en/latest/frontend/) to see how to automate the theme requirements and frontend tests.
After the initial theme setup you can configure `blt/blt.yml` to install and configure your frontend dependencies with `blt setup`.
2. Pull Files locally.
Use BLT to pull all files down from your Cloud environment.

    ```console
    vm$ blt drupal:sync:files
    ```

3. Sync the Cloud Database.

If you have an existing database you can use BLT to pull down the database from your Cloud environment.

   ```console
   vm$ blt sync
   ```

---

## Additional Resources

Additional [BLT documentation](http://blt.readthedocs.io) may be useful. You may also access a list of BLT commands by running this:

```console
vm$ blt
```

Note the following properties of this project:

- Primary development branch: develop
- Local environments:
  - Atlanta Boat Show
    - url: https://local.atlantaboatshow.com
    - alias: @chicago.local
  - Chicago Boat Show
    - url: https://local.chicagoboatshow.com
    - alias: @chicago.local
  - Kansas City Sport Show
    - url: https://local.kansascitysportshow.com
    - alias: @kansascity.local
  - Nashville
    - url: https://local.nashvilleboatshow.com
    - alias: @nashville.local
  - Template
    - url: https://local.template.boatshows.com
    - alias: @template.local

## Working With a BLT Project

BLT projects are designed to instill software development best practices (including git workflows).

Our BLT Developer documentation includes an [example workflow](http://blt.readthedocs.io/en/latest/readme/dev-workflow/#workflow-example-local-development).

### Important Configuration Files

BLT uses a number of configuration (`.yml` or `.json`) files to define and customize behaviors. Some examples of these are:

- `blt/blt.yml`
- `blt/local.blt.yml`
- `box/config.yml` (if using Drupal VM)
- `drush/sites` (contains Drush aliases for this project)
- `composer.json` (includes required components, including Drupal Modules, for this project)

## Repository architecture

“How is the code organized, and why?”

The repository architecture is driven by a set of core principles:

- Project dependencies should never be committed directly to the repository
- The code that is deployed to production should be fully validated, tested, sanitized, and free of non-production tools
- Common project tasks should be fully automated and repeatable, independent of environment

Consequently, there are a few aspects of this project’s architecture and workflow that may be unfamiliar to you.

- Drupal core, contrib modules, themes, and third parties libraries are not committed to the repository. Contrib directories are .gitignored and populated during build artifact generation.
- The repository is never pushed directly to the cloud. Instead, changes to the repository on GitHub trigger tests to be run via continuous integration with Travis CI. Changes that pass testing will automatically cause a build artifact to be created and deployed to the cloud.
- [Common project tasks](project-tasks.md) are executed via a build tool (Phing) so that they can be executed exactly the same in all circumstances.

### Directory structure

The following is an overview of the purpose of each top level directory in the project template:

  ```console
  root
    ├── blt      - Contains custom build config files for CI solutions. E.g., Phing configuration.
    ├── drush    - Contains drush configuration that is not site or environment specific.
    ├── docroot  - The Drupal docroot.
    ├── hooks    - Contains [Acquia Cloud hooks](https://github.com/acquia/cloud-hooks).
    ├── modules  - Contains custom and contrib modules.
    ├── patches  - Contains private patches to be used by composer.json.
    ├── profiles - Contains contrib and custom profiles.
    ├── readme   - Contains high level project documentation.
    ├── reports  - Contains output of automated tests; is .gitignored.
    ├── scripts  - Contains a variety of utility scripts.
    ├── tests    - Contains project-level test files and configuration.
    ├── themes   - Contains custom and contrib themes.
    ├── vendor   - Contains built composer dependencies; is .gitignored.
  ```

## Dependency Management

All project and Drupal (module, themes, libraries) dependencies are managed via Composer. The management strategy is based on [The Drupal Project](https://github.com/drupal-composer/drupal-project).

Modules, themes, and other contributed Drupal projects can be added as dependencies in the root `composer.json` file.

For step-by-step instructions on how to update dependencies, see [dependency-management.md](dependency-management.md).
