# BLT and Dependency Management

This project uses Acquia BLT.

## Additional Resources

Additional [BLT documentation](http://blt.readthedocs.io) may be useful. You may also access a list of BLT commands by running this:

```console
vm$ blt
```

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

All project and Drupal (module, themes, libraries) dependencies are managed via Composer. The management strategy is based on [The Drupal Project](https://github.com/drupal-composer/drupal-project). (Note: npm is used to manage some dependencies of the boatshows theme)

Modules, themes, and other contributed Drupal projects can be added as dependencies in the root `composer.json` file.

For step-by-step instructions on how to update dependencies, see [dependency-management.md](dependency-management.md).
