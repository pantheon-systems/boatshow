Git and Code Deployment Process
===

These processes are adapted from the [Atlassian writeup of Gitflow Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow)

# Development

## 1. Create a feature branch from 2.x-develop

    $ git fetch -a
    $ git checkout -b feature-featuredescription origin/2.x-develop


## 2. Publish feature branch to github remote

    $ git push -u origin feature-featuredescription

## 3. Make a Pull Request

- Go to [https://github.com/NationalMarine/BoatShows/pulls](https://github.com/NationalMarine/BoatShows/pulls)
- Click 'New pull request'
- Set base to `2.x-develop` (should be the default)
- Set compare to `feature-featuredescription`
- Click 'Create pull request'
- Set reviewers, assignees, etc.

## 4. Deployment to Dev environment

Once the pull request is merged (or **anytime** code is merged into origin/2.x-develop), Travis CI will deploy the code to the `Acquia > Boatshows2 > DEV` environment

---------------------------------------

# Preparing a Release

## 0. Backup databases
    Acquia console

## 1. Create a release branch

    $ git fetch -a
    check github for the last [release](https://github.com/NationalMarine/BoatShows/releases)    
    $ git checkout -b release/v0.0.0 origin/2.x-develop

## 2. Publish release branch to github

    $ git push -u origin release/v0.0.0
    check deployment in Travis and Acquia

## 3. Deployment to STAGE environment

Once the release branch is published to Github, Travis CI will automatically deploy the code to the `Acquia > Boatshows2 > STAGE` environment.

## 4. Testing and code updates

The release should be thoroughly tested on the STAGE environment. Further commits can be added to the release branch on github, which will trigger additional builds to STAGE:

    $ git checkout release/v0.0.0
    $ git commit
    $ git push origin release/0.0.0

Once final approval is received, proceed to the next step.

## 5. Squash and merge into 2.x-master

    $ git checkout 2.x-master
    $ git pull origin 2.x-master
    $ git merge --squash release/v0.0.0
    # When committing, the first line of the commit should be "Release X.Y.Z"
    $ git commit -m "message here"
    $ git tag vX.Y.Z
    $ git push origin 2.x-master
    $ git push --tags

## 6. Deploy to LIVE

See [Deployments to Live](#deployments-to-live) section of this document.

## 7. Merge 2.x-master back into 2.x-develop

    $ git fetch -a
    $ git checkout 2.x-develop
    $ git pull
    $ git merge origin/2.x-master
    $ git push origin 2.x-develop

## 8. Delete the release branch from the remote

    $ git push origin --delete release/0.0.0

---------------------------------------

# Preparing a Hotfix

## 1. Create a hotfix branch

    $ git fetch -a
    $ git checkout -b hotfix/hotfixdescription origin/2.x-master

## 2. Publish hotfix branch to github

    $ git push -u origin hotfix/hotfixdescription

## 3. Deployment to STAGE environment

Once the hotfix branch is published to Github, Travis CI will automatically deploy the code to the `Acquia > Boatshows2 > STAGE` environment.

## 4. Testing and code updates

The hotfix should be thoroughly tested on the STAGE environment. Further commits can be added to the hotfix branch on github, which will trigger additional builds to STAGE:

    $ git checkout hotfix/hotfixdescription
    $ git commit
    $ git push origin hotfix/hotfixdescription

Once final approval is received, proceed to the next step.

## 5. Squash and merge into 2.x-master

    $ git checkout 2.x-master
    $ git pull origin 2.x-master
    $ git merge --squash hotfix/hotfixdescription
    # When committing, the first line of the commit should be "Release X.Y.Z", where Z is the only number incremented due to the hotfix.
    $ git commit
    $ git tag vX.Y.Z
    $ git push origin 2.x-master
    $ git push --tags

## 6. Deploy to LIVE

See [Deployments to Live](#deployments-to-live) section of this document.

## 7. Merge 2.x-master back into 2.x-develop

    $ git fetch -a
    $ git checkout 2.x-develop
    $ git pull
    $ git merge origin/2.x-master
    $ git push origin 2.x-develop

## 8. Delete the hotfix branch from the remote

    $ git push origin --delete hotfix/hotfixdescription

---------------------------------------

# Deployments to LIVE

All deployments to LIVE are manual, and follow the same process:

    $ git checkout 2.x-master
    $ vagrant ssh
    $ composer install
    vagrant$ cd /var/www/boatshow/docroot/themes/custom/boatshow
    vagrant$ npm install && gulp build
    vagrant$ exit
    host$ blt artifact:deploy --branch "master" -n

---------------------------------------

# General Deployment Workflow

Deployments to Acquia Cloud are managed with Travis CI at [https://travis-ci.com/NationalMarine/BoatShows](https://travis-ci.com/NationalMarine/BoatShows). Travis CI deployments are configured using the .travis.yml file in the root of the project. For more information, read the [Travis CI documentation](https://docs.travis-ci.com/).

The build process works as follows:

- Code is merged into one of the deployment targets' github branches (see below)
- Travis detects the changes code in that branch and kicks off a deployment
  - Travis builds the front-end theme using gulp
  - Travis performs a `blt artifact:deploy` to package a deployment artifact, and commits it to the Acquia git repository
  - Logs are stored in the Travis 'Build History' tab for the project
- Acquia's task runner detects the changes to the acquia git repository
  - Acquia's task runner deploys the code to the environment for that branch
  - Acquia's task runner runs any hooks in the {repo}/hooks directory, such as:
    - Import drupal config for each multisite
    - Update drupal database for each multisite
    - Clear drupal cache for each multisite
  - Acquia's task log can be seen on the Acquia 'Application' page for Boatshows2 at [https://cloud.acquia.com/app/develop/applications/e4d0000d-d68a-46e7-87d1-04e334983a55](https://cloud.acquia.com/app/develop/applications/e4d0000d-d68a-46e7-87d1-04e334983a55)

## Deployment targets

- LIVE (e.g. www.miamiboatshow.com or live2.miamiboatshow.com)
  - github branch: 2.x-master
  - acquia git branch: master

- STAGE (e.g. stage2.miamiboatshow.com)
  - github branches: release/* hotfix/*
  - acquia git branch: stage

- DEV (e.g. dev2.miamiboatshow.com)
  - github branch: 2.x-develop
  - acquia git branch: dev

## Manual deployments

BLT will package up the code and dependencies into a folder named "deploy" then commit and push the code to the specified branch of the Acquia git repository, which is specified in the "blt/blt.yml" file under the git remotes settings.

In the examples below, you can see there are some additional steps to build the theme (gulp build) before running artifact:deploy. Travis handles these for us when not relying on manual builds.

This command should be run from outside the vagrant VM. It **can** be run from inside vagrant, but it may take up to 10x longer to complete.

You may run the `artifact:deploy` task with the --dry-run flag to test things out before actually pushing code to the remote environment.

```console
# Manually deploy to Acquia "dev" environment (deprecated by Travis CI procedure)
host$ git checkout 2.x-develop
host$ composer install
host$ vagrant ssh
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp build
vm$ exit
host$ blt artifact:deploy --branch "dev" -n

# Manually deploy to Acquia "stage" environment (deprecated by Travis CI procedure)
host$ git checkout 2.x-master
host$ composer install
host$ vagrant ssh
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp build
vm$ exit
host$ blt artifact:deploy --branch "stage" -n

# Manually deploy to Acquia "live" environment
host$ git checkout 2.x-master
host$ composer install
host$ vagrant ssh
vm$ cd /var/www/boatshow/docroot/themes/custom/boatshow
vm$ npm install && gulp build
vm$ exit
host$ blt artifact:deploy --branch "master" -n
```

# More About Travis CI



TODO: travis.yml, post deployment scripts
