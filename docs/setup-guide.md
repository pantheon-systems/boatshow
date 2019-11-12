Setup Guide
===

Follow this guide to get setup for development on this project

- Review the [Required / Recommended Skills](https://docs.acquia.com/blt/) for working with a BLT project.
- Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [System Requirements](http://blt.readthedocs.io/en/latest/INSTALL/#system-requirements).
- Request access to organization that owns the project repo in GitHub (if needed).
- Request access to the Acquia Cloud Environment for your project (if needed).
- Setup a SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key).
  - [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
  - [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)
- Clone the repository. By default, Git names this "origin" on your local.

  ```console
  host$ git clone git@github.com:NationalMarine/BoatShows.git
  ```


## Getting Started

This project is based on BLT, an open-source project template and tool that enables building, testing, and deploying Drupal installations following Acquia Professional Services best practices. While this is one of many methodologies, it is our recommended methodology.

This solution requires a handful of dependencies that must exist on your local machine for the project to work. These include Vagrant, Virtual Box, Ansible, Drush, and composer. The following notes will help you install these dependencies to get up and running.

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
host$ git clone -b 2.x-develop git@github.com:NationalMarine/Boatshows.git
```

### Disable tracking permissions in git for this repo

```console
host$ cd path/to/freshly/cloned/repo
host$ git config core.fileMode false
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

If the above command does not work, here is a workaround:
https://github.com/acquia/blt/issues/288#issuecomment-511552693
Add the code in the comment to your "~/.bashrc "file.

### Sync dev content (db and files) to local

```console
vm$ blt nmma:sync-all -n --sync-files
```

### Build the front-end theme

```console
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp
```

### Log in to drupal

Get a one time login link for a multisite
```
vm$ drush @{multisite}.local uli
```

## Notable Gulp Tasks for Local Development

### Watch

```console
vm$ gulp watch        # Watch SCSS and JS files
vm$ gulp watch:sass   # Watch SCSS files only
vm$ gulp watch:js     # Watch JS files only
```

### Build
Compile/minify/lint SCSS and JS files

```console
vm$ gulp build # Compile/minify/lint SCSS and JS files
vm$ gulp # The default 'gulp' command by itself is set to run 'gulp build'
```
