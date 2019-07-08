## Installation

### 1 - Install project dependencies

The following dependencies must first be installed and available to the command line on your local machine.

  * [Ansible](http://docs.ansible.com/intro_installation.html) 2.2.x
  * [Composer](https://getcomposer.org/doc/00-intro.md) 1.7.x
  * [Drush](http://www.drush.org/en/master) 9.x
  * [Node.js](https://nodejs.org/en/) 9.11.x
  * [PHP](http://php.net/manual/en/install.php) 7.1+
  * [Vagrant](https://www.vagrantup.com/downloads.html) 2.2.0
  * [VirtualBox](https://www.virtualbox.org/wiki/Downloads) 5.2.22+

**NOTE:** *If using macOS, the preferred method of installing these dependencies is with [Homebrew](http://brew.sh/), [Homebrew Cask](https://caskroom.github.io/) and [NVM](https://github.com/creationix/nvm).*

```bash
brew install ansible composer php72 nvm
brew tap caskroom/cask
brew cask install virtualbox vagrant
nvm install 9.11.2
nvm use 9.11.2
```

### 2 - Install Composer plugins (Optional)

It is recommended to install the following Composer plugins for a faster and easier setup.

  * [prestissimo](https://github.com/hirak/prestissimo)

```bash
composer global require hirak/prestissimo
```

### 3 - Install Vagrant plugins (Optional)

It is recommended to install the following Vagrant plugins for a faster and easier setup.

  * [vagrant-cachier](https://github.com/fgrehm/vagrant-cachier)
  * [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater)
  * [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest)

```bash
vagrant plugin install vagrant-cachier
vagrant plugin install vagrant-vbguest
vagrant plugin install vagrant-hostsupdater
```

### 4 - Clone the project repo and install Composer dependencies.

In a local folder, where you like to keep project repos, clone the repo and install the Composer dependencies.

```bash
git clone git@github.com:NationalMarine/Boatshows.git
cd Boatshows
git checkout develop
composer install
```

### 5 - Build the Virtual Machine

From the root of this project repo, run `vagrant up`, and let Vagrant and Ansible do their magic.

**Note:** *If there are any errors during the course of running `vagrant up`, and it drops you back to your command prompt, just run `vagrant provision` to continue building the VM from where you left off. If there are still errors, after doing this a few times, work with the project Tech Lead to resolve.*

To prevent headaches, from your project's root directory, run the following commands:
```
$ sudo chmod +w docroot/sites/default/
$ sudo chmod +w docroot/sites/default/settings.php
$ git reset --hard origin/develop

To use BLT or Drush commands with your site, you will have to SSH into your VM by running `vagrant ssh` from your project directory

Finish setup by SSH'ing into your VM and running:

`blt setup` for the primary/default site (boatshows)

### 6 - Configure your host machine to access the VM

  1. Open your browser and access [http://dashboard.local.boatshows.com](http://dashboard.local.boatshows.com). This will take you to the Drupal VM Dashboard. If this does not take you to the dashboard page try restarting apache by SSHing into the VM.

  ```bash
  vagrant ssh
  sudo apachectl restart
  ```

  **NOTE:** *You can also have Vagrant automatically assign an available IP address to your VM if you install the `auto_network` plugin (`vagrant plugin install vagrant-auto_network`), and set `vagrant_ip` to `0.0.0.0` inside a `drupalvm/local.config.yml` file.*

  2. If you did not install the Vagrant 'hostupdater' plugin noted above, you will need to [edit your hosts file](http://www.rackspace.com/knowledge_center/article/how-do-i-modify-my-hosts-file), adding the lines provided on the dashboard page. If you did install Vagrant 'hostsupdater', then this should have been done for you.

  3. Open your browser and access [http://dashboard.local.opa.com/](http://dashboard.local.opa.com/) to ensure your hosts file edits worked.

### 7 - Install the Drupal site on the VM with BLT

  1. Add the BLT alias:

  ```bash
  composer blt-alias
  ```

  2. Pull down the latest database from Acquia Cloud and get the site running locally. **NOTE:** *You will need proper access configured on your Acquia account and have added [a public SSH key to your profile](https://docs.acquia.com/cloud/ssh/enable/add-key).*

  Copy your SSH keys with access to the Acquia application into the ~/.ssh folder inside the VM.  The keys must be named id_rsa and id_rsa.pub inside the VM (regardless of what they are named on your host machine).

  Sync up to the Acquia sites by running the following:

  ```bash
  blt sync:refresh
  blt sync:files
  ```

  3. Upon a successful installation of the site, go to your browser and access [http://local.boatshows.com](http://local.boatshows.com).

  4. To log into the site, use drush to generate a one time login.

  ```bash
  drush uli
  ```

**NOTE**: You must have Senior Developer access to the Acquia application. To diagonose any BLT setup related issue run `blt doctor` from within VM.

## Other Notes

  * To shut down the virtual machine, enter `vagrant halt` in the Terminal in from the root of the project repo. To destroy it completely (if you want to save a little disk space, or want to rebuild it from scratch with `vagrant up` again), type in `vagrant destroy`.
  * You can modify configuration options of the VM for all users of the project, by editing the variables within `box/config.yml`. To modify options only for your local machine, create a `box/local.config.yml` file. See the [default.config.yml](https://github.com/geerlingguy/drupal-vm/blob/master/default.config.yml) from the Drupal VM repo for reference.

# Repository architecture

“How is the code organized, and why?”

The repository architecture is driven by a set of core principles:

* Project dependencies should never be committed directly to the repository
* The code that is deployed to production should be fully validated, tested, sanitized, and free of non-production tools
* Common project tasks should be fully automated and repeatable, independent of environment

Consequently, there are a few aspects of this project’s architecture and workflow that may be unfamiliar to you.

* Drupal core, contrib modules, themes, and third parties libraries are not committed to the repository. Contrib directories are .gitignored and populated during build artifact generation.
* The repository is never pushed directly to the cloud. Instead, changes to the repository on GitHub trigger tests to be run via continuous integration with Travis CI. Changes that pass testing will automatically cause a build artifact to be created and deployed to the cloud.
* [Common project tasks](project-tasks.md) are executed via a build tool (Phing) so that they can be executed exactly the same in all circumstances.

## Directory structure

The following is an overview of the purpose of each top level directory in the project template:

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

## Dependency Management

All project and Drupal (module, themes, libraries) dependencies are managed via Composer. The management strategy is based on [The Drupal Project](https://github.com/drupal-composer/drupal-project).

Modules, themes, and other contributed Drupal projects can be added as dependencies in the root `composer.json` file.

For step-by-step instructions on how to update dependencies, see [dependency-management.md](dependency-management.md).
