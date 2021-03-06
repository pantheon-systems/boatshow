# Drupal Lightning
![Lightning logo of a bolt of lightning](https://raw.githubusercontent.com/acquia/lightning/8.x-3.x/lightning-logo.png)

[![Build Status](https://travis-ci.org/acquia/lightning.svg?branch=8.x-3.x)](https://travis-ci.org/acquia/lightning)

## November 2021: So long and thanks for all the fish!
Acquia is **ending support for the Lightning distribution in November 2021**, simultaneously with Drupal 8. At that time, Lightning 3, 4, and 5 will cease receiving any security updates or bug fixes. It is possible to safely uninstall Lightning from your site; please see [the official announcement](https://www.acquia.com/blog/acquia-lightning-eol-2021-acquia-cms-future), [FAQ for site owners](https://support.acquia.com/hc/en-us/articles/1500006393601-Frequently-Asked-Questions-FAQ-regarding-End-of-Support-for-Acquia-Lightning), and [developer instructions](https://github.com/acquia/lightning/wiki/Uninstalling-Lightning) for more information.

---

Lightning's mission is to enable developers to create great authoring
experiences and empower editorial teams.

You'll notice that Lightning appears very sparse out of the box. This is by
design. We want to empower editorial teams and enable developers to jump-start
their site builds. That means that a developer should never have to undo
something that Lightning has done. So we started with a blank slate and
justified each addition from there.

## Installing Lightning
The preferred way to install Lightning is using our
[Composer-based project template][template]. It's easy!

```
$ composer self-update
$ composer create-project acquia/lightning-project MY_PROJECT
```

If you don't want to use Composer, you can install Lightning the traditional way
by downloading a tarball from Lightning's [GitHub releases page](https://github.com/acquia/lightning/releases).
(Please note that the tarball generated by Drupal.Org's packager does not
include required Composer dependencies and should not be used without following
the special instructions found there.)

You can customize your installation by creating a [sub-profile which uses
Lightning as its base profile][sub-profile documentation]. Lightning includes a
Drupal Console command (`lightning:subprofile`) which will generate a
sub-profile for you.

#### Installing from exported config
Lightning can be installed from a set of exported configuration (e.g., using the
--existing-config option with `drush site:install`). This method of installation
is fully supported and tested.

## What Lightning Does
Through custom, contrib, and core modules plus configuration, Lightning aims to
target four functional areas:

### Media
The current version of media includes the following functionality:

* A preconfigured Text Format (Rich Text) with CKEditor WYSIWYG.
* A media button (indicated by a star -- for now) within the WYSIWYG that
  launches a custom media widget.
* The ability to place media into the text area and have it fully embedded as it
  will appear in the live entity. The following media types are currently
  supported:
  * Tweets
  * Instagram posts
  * Videos (YouTube and Vimeo supported out of the box)
  * Images
* Drag-and-drop bulk image uploads.
* Image cropping.
* Ability to create new media through the media library (/media/add)
* Ability to embed tweets, Instagrams, and YouTube/Vimeo videos directly into
  CKEditor by pasting the video URL

#### Extending Lightning Media (Contributed Modules)
Drupal community members have contributed several modules which integrate
Lightning Media with additional third-party media services. These modules are
not packaged with Lightning or maintained by Acquia, but they are stable and you
can use them in your Lightning site:

  * [Facebook](https://www.drupal.org/project/lightning_media_facebook)
  * [Imgur](https://www.drupal.org/project/lightning_media_imgur)
  * [Flickr](https://www.drupal.org/project/lightning_media_flickr)
  * [500px](https://www.drupal.org/project/lightning_media_d500px)
  * [SoundCloud](https://www.drupal.org/project/lightning_media_soundcloud)
  * [Tumblr](https://www.drupal.org/project/lightning_media_tumblr)
  * [Spotify](https://www.drupal.org/project/lightning_media_spotify)
  * [Pinterest](https://www.drupal.org/project/lightning_media_pinterest)  

### Layout
Lightning includes a Landing Page content type which allows editors to create
and place discrete blocks of content in any order and layout they wish using an
intuitive, accessible interface. Lightning also allows site builders to define
default layouts for content types using the same interface - or define multiple
layouts and allow editors to choose which one to use for each post.

### Workflow
Lightning includes tools for building organization-specific content workflows.
Out of the box, Lightning gives you the ability to manage content in one of four
workflow states (draft, needs review, published, and archived). You can create
as many additional states as you like and define transitions between them. It's
also possible to schedule content to be transitioned between states at a
specific future date and time.

### API-First
Lightning ships with several modules which, together, quickly set up Drupal to
deliver data to decoupled applications via a standardized API. By default,
Lightning installs the OpenAPI and JSON:API modules, plus the Simple OAuth
module, as a toolkit for authentication, authorization, and delivery of data
to API consumers. Currently, Lightning includes no default configuration for
any of these modules, because it does not make any assumptions about how the
API data will be consumed, but we might add support for standard use cases as
they present themselves.

If you have PHP's OpenSSL extension enabled, Lightning can automatically create
an asymmetric key pair for use with OAuth.

## Resources
Demonstration videos for each of our user stories can be found [here][demo_videos].

Please use the [Drupal.org issue queue][issue_queue] for latest information and
to request features or bug fixes.

## Known Issues
* There are a few known issues when using the Claro administrative theme with
  various Lightning components.
  See https://github.com/acquia/lightning/pull/660#pullrequestreview-331654008
  for more information.

### Media
* If you upload an image into an image field using the new image browser, you
  can set the image's alt text at upload time, but that text will not be
  replicated to the image field. This is due to a limitation of Entity Browser's
  API.
* Some of the Lightning contributed media modules listed above might not yet be
  compatible with the Core Media entity.
* Using the bulk upload feature in environments with a load balancer might
  result in some images not being saved.

### Inherited profiles
Drush is not aware of the concept of inherited profiles and as a result, you
will be unable to uninstall dependencies of any parent profile using Drush. You
can still uninstall these dependencies via the UI at "/admin/modules/uninstall".
We have provided patches [here](https://www.drupal.org/node/2902643)
for Drush which allow you to uninstall dependencies of parent profiles.

* [Drush 9 inherited profile dependencies patch](https://www.drupal.org/files/issues/2902643-2--drush-master.patch).

## Contributing
Issues are tracked on [drupal.org][issue_queue]. Contributions can be provided
either as traditional patches or as pull requests on our [GitHub clone][github].

Each Lightning component also has a drupal.org issue queue:

* [API](https://www.drupal.org/project/issues/lightning_api)
* [Core](https://www.drupal.org/project/issues/lightning_core)
* [Layout](https://www.drupal.org/project/issues/lightning_layout)
* [Media](https://www.drupal.org/project/issues/lightning_media)
* [Workflow](https://www.drupal.org/project/issues/lightning_workflow)

For more information on local development, see CONTRIBUTING.md.

[issue_queue]: https://www.drupal.org/project/issues/lightning "Lightning Issue Queue"
[meta_release]: https://www.drupal.org/node/2670686 "Lightning Meta Releases Issue"
[template]: https://github.com/acquia/lightning-project "Composer-based project template"
[d.o_semver]: https://www.drupal.org/node/1612910
[lightning_composer_project]: https://github.com/acquia/lightning-project
[demo_videos]: http://lightning.acquia.com/blog/lightning-user-stories-demonstrations "Lightning user story demonstration videos"
[sub-profile documentation]: https://github.com/acquia/lightning/wiki/Lightning-as-a-Base-Profile "Lightning sub-profile documentation"
[github]: https://github.com/acquia/lightning "GitHub clone"
