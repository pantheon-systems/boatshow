(function ($, Drupal) {
  Drupal.behaviors.nmma_seo_data_attributes = {

    context: '',

    attach: function attach(context, settings) {
      // This will load each time behaviors are attached.

      Drupal.behaviors.nmma_seo_data_attributes.context = context;
      // Get all elements that are hyper links or have the class add-gtm. Filter
      // further that the data-gtm-tracking attribute is empty or not set.
      // Elements that already have the data-gtm-tracking will be tracked on
      // click. Our goal is to use other attributes of the element to determine
      // a proper data-gtm-tracking tag for it.
      var $elements = $('.add-gtm:not([data-gtm-tracking]), .add-gtm[data-gtm-tracking=""], a:not([data-gtm-tracking]), a[data-gtm-tracking=""]', context);
      $.each($elements, function() {
        contextualSetDataGtmTracking($(this));
      });

      customElementsSetDataGtmTracking();

      // videoTracking();
    }
  };

  /**
   * Add GTM events in response to html5 video events.
   */
  function videoTracking() {
    switch (currentPage()) {
      case 'employers':
        // Do nothing, this is the only page the event listener should fire on.
        break;
      default:
        return;

    }

    var context = Drupal.behaviors.nmma_seo_data_attributes.context;
    var $videos = $('video', context);
    if ($videos.once().length > 0) {
      $.each($videos, function() {
        var $video = $(this);
        if ($video.hasClass('jquery-background-video')) {
          return;
        }

        this.addEventListener("playing", function () {
          dataLayer.push({
            'event': 'Video',
            'Category': 'Video',
            'Action': 'Start',
            'Label': 'Employers - nmma total care'
          });
        }, true);
        this.addEventListener("ended", function() {
          dataLayer.push({
            'event': 'Video',
            'Category': 'Video',
            'Action': 'End',
            'Label': 'Employers - nmma total care'
          });
        }, true);
      });
    }
  }

  /**
   * Add data-gtm-tracking to elements that are not easy to find or set by
   * context.
   */
  function customElementsSetDataGtmTracking() {
    var context = Drupal.behaviors.nmma_seo_data_attributes.context;
    // Articles and resources topic select.
    $('select#edit-topicselect option', context).once().each(function() {
      var $option = $(this);
      $option.attr('data-gtm-tracking', 'Articles - Filter - ' + $option.text());
    });
    return;
    // The close button for the talk to us form.
    // DO NOT pass context to this. It does not include the close button.
    var $modalTitle = $('.ui-dialog-title');
    if ($modalTitle.length && $modalTitle.text() == 'Talk to Us') {
      // We've found the label next to the button, get the button.
      // no description was in the document.
      setDataGtmTracking($modalTitle.next(), 'Talk to Us Form', 'Close', '');
    }
    var $submitButton = $('form.webform-submission-contact-form .webform-button--submit', context);
    if ($submitButton.length && $submitButton.val() == 'Send Inquiry') {
      if ($submitButton.once().length > 0) {
        setDataGtmTracking($submitButton, 'Talk to Us Form', 'Send inquiry', '');
      }
    }

    // Paragraph: Expandable Two Column Box.
    function expandableTwoColumBox(overlayText) {
      var $element = $();
      var $factBoxContainer = $('.paragraph--type--expandable-two-column-box .fact-box-container', context);
      if ($factBoxContainer.length) {
        $.each($factBoxContainer.find('.card .overlay .content div').children(), function() {
          var $textElement = $(this);
          if ($textElement.text().trim() == overlayText) {
            var $parents = $textElement.parentsUntil('.fact-box-container');
            if ($parents.length) {
              $element = $parents.last();
              return false;
            }
          }
        })
      }
      return $element;
    }

    // Paragraph: Multibox.
    function multiBox(titleText) {
      var $element = $();
      var $multiBoxContainer = $('.paragraph--type--multibox', context);
      if ($multiBoxContainer.length) {
        $.each($multiBoxContainer.find('.fact .title__wrapper .title h2 div'), function() {
          var $textElement = $(this);
          if ($textElement.text().trim() == titleText) {
            var $parents = $textElement.parentsUntil('.overlay');
            if ($parents.length) {
              $element = $parents.last();
              return false;
            }
          }
        })
      }
      return $element;
    }

    // Paragraph: Faq.
    function faq(titleText) {
      var $element = $();
      var $faqContainer = $('.paragraph--type--faq', context);
      if ($faqContainer.length) {
        $.each($faqContainer.find('.faq-item strong'), function() {
          var $textElement = $(this);
          if ($textElement.text().trim() == titleText) {
            $element = $textElement.parent();
            return false;
          }
        })
      }
      return $element;
    }

    var $element = $();
    switch (currentPage()) {
      case 'home':
        $element = expandableTwoColumBox('LEARN MORE ABOUT');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'home', 'texas health');
        }
        $element = expandableTwoColumBox('GET TO KNOW');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'home', 'UT Southwestern');
        }
        $element = multiBox('Purpose-Driven Network');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'home', 'Purpose-Driven Network');
        }
        $element = multiBox('Managing Total Cost of Care');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'home', 'Managing Total Cost');
        }
        $element = multiBox('Innovative Employer Solutions');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'home', 'Innovative Employer Solutions');
        }
        break;

      case 'patients':
        $element = multiBox('Health Coverage Through An Employer');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'for patients', 'health coverage through an employer');
        }
        $element = multiBox('Health Coverage Through Medicare');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'for patients', 'health coverage through medicare');
        }
        break;

      case 'doctors':
        $element = multiBox('Physician-Driven Healthcare Model');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'for doctors', 'Physician-Driven healthcare model');
        }
        $element = multiBox('An Inclusive Structure');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'for doctors', 'An Inclusive Structure');
        }
        $element = multiBox('The Importance of the Patient-Provider Relationship');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'for doctors', 'The Importance of the patient-provider relationship');
        }
        break;

      case 'our-leadership-team':
        $element = expandableTwoColumBox('Barclay Berdan, FACHE');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Co-Chair, southwestern health resources CEO');
        }
        $element = expandableTwoColumBox('Daniel K. Podolsky, M.D.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Co-Chair, southwestern health resources president');
        }
        $element = expandableTwoColumBox('Marinan Williams, M.S.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Senior Executive Officer, Market Relations');
        }
        $element = expandableTwoColumBox('Daniel Varga, M.D.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Senior Executive Officer, Physician Network');
        }
        $element = expandableTwoColumBox('Suresh Gunasekaran, M.B.A.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Senior Executive Officer, Population Health Services Company');
        }
        $element = expandableTwoColumBox('Mack Mitchell, M.D.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'Chief Medical Officer, Physician Network');
        }
        $element = expandableTwoColumBox('John J. Warner, M.D.');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'our leadership team', 'CEO, UT Southwestern University Hospitals');
        }
        $element = faq('What does this network mean for North Texans?');
        if ($element.length) {
          setDataGtmTracking($element, 'FAQ', 'our leadership team', 'what does this network mean for north texans');
        }
        $element = faq('What are patient and consumer benefits?');
        if ($element.length) {
          setDataGtmTracking($element, 'FAQ', 'our leadership team', 'what are patient and consumer benefits');
        }
        $element = faq('What are the benefits for doctors and providers?');
        if ($element.length) {
          setDataGtmTracking($element, 'FAQ', 'our leadership team', 'what are the benefits for doctors and provides');
        }
        $element = faq('What is the relationship between UT Southwestern and Texas Health Resources?');
        if ($element.length) {
          setDataGtmTracking($element, 'FAQ', 'our leadership team', 'what is the relationship between UT southwestern and Texas Health Resources');
        }
        break;

      case 'leading-edge-care':
        $element = expandableTwoColumBox('See Our Highly');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'Leading edge care', 'see our highly recognized clinical services');
        }
        $element = expandableTwoColumBox('Learn More About');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'Leading edge care', 'learn more about our primary care services');
        }
        break;

      case 'population-health-services':
        $element = multiBox('Patient Navigation');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'population health services', 'Patient Navigation');
        }
        $element = multiBox('Care Management');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'population health services', 'Care Management');
        }
        $element = multiBox('Care Coordination');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'population health services', 'Care Coordination Team');
        }
        $element = multiBox('Post-Acute Care');
        if ($element.length) {
          setDataGtmTracking($element, 'Fact Box', 'population health services', 'Post-Acute Care');
        }
        break;

    }
  }

  function setDataGtmTracking($element, category, action, label) {
    $element.attr(
        'data-gtm-tracking',
      category + ' - ' + action + ' - ' + label
    );
  }

  /**
   * Add data-gtm-tracking to a specific element by the contextual elements
   * around it.
   *
   * @param $element
   */
  function contextualSetDataGtmTracking($element) {
    // Do not place tracking on add to any share link, tracking is already
    // added.
    if ($element.hasClass('a2a_dd')) {
      return;
    }

    // These values are explicit data attributes on elements on the page.
    // They will override any contextual attributes set below.
    var explicitAttributes = {
      category: getAttributeValue($element, 'data-gtm-tracking-category'),
      action: getAttributeValue($element, 'data-gtm-tracking-action'),
      label: getAttributeValue($element, 'data-gtm-tracking-label')
    };
    // These are values assigned based on context of the link. They will be
    // overridden by the explicit attributes if set.
    var contextualAttributes = {
      category: '',
      action: '',
      label: ''
    };

    var $parents = $element.parents();
    // Sub Navigation.
    if ($parents.hasClass('megamenu__drawer')) {
      contextualAttributes.category = 'Navigation';
      contextualAttributes.label = 'Sub Menu';
    }
    // Mobile Menu.
    else if ($parents.hasClass('mobile-nav')) {
      contextualAttributes.category = 'Navigation';
      contextualAttributes.label = 'Sub Menu';
    }
    // Footer.
    else if ($parents.hasClass('footer') && $parents.is('footer')) {
      contextualAttributes.category = 'Navigation';
      contextualAttributes.label = 'footer';
    }
    // Might also like.
    else if ($parents.hasClass('view-display-id-boat_type_you_might_also_like')) {
      contextualAttributes.category = 'Navigation';
      contextualAttributes.label = 'Similar Boats';
    }
    // Brands for boat types.
    else if ($parents.hasClass('view-display-id-brands_for_boat_type_pages')) {
      contextualAttributes.category = 'Manufacturer Referral';
    }
    // Related content.
    else if ($parents.hasClass('view-id-related_content_view')) {
      contextualAttributes.label = 'Featured Articles';
    }
    // Boat type brands.
    else if ($parents.hasClass('js-boat-brand-drawer-content boat-brand__drawer-content')) {
      contextualAttributes.category = 'Manufacturer Referral';
    }

    // Video links in different section will all have the category of Video.
    if ($parents.hasClass('video-container')) {
      contextualAttributes.category = 'Video';
    }

    var path = '';
    var extension = '';
    var external = false;
    if ($element.is('a')) {
      path = $element.prop('href');
      extension = $element.prop('href').split('.').pop();
      // Now that setting the purpose is over, let this block override it if an
      // external link is detected.
      /*if ($element.prop('hostname') !== location.hostname && location.hostname.length) {
        external = true;
      }*/
    }

    // External link category is always this.
    /*if (external) {
      contextualAttributes.category = 'Outbound Link click';
    } else if (!contextualAttributes.category.length) {
      // Default category for an internal link that nothing is set for.
      contextualAttributes.category = 'Navigation';
    }*/
    if (!contextualAttributes.category.length) {
      // Default category for an internal link that nothing is set for.
      contextualAttributes.category = 'Navigation';
    }

    // Override the footer schedule appointment links to be unique per their
    // title and href.
    if (contextualAttributes.label === 'footer' && $element.prop('title') === 'Request An Appointment') {
      var href = $element.prop('href');
      if (href.indexOf('texashealth') !== -1) {
        contextualAttributes.category = 'Schedule an Appointment';
        contextualAttributes.action = 'Texas';
      } else if (href.indexOf('utswmedicine') !== -1) {
        contextualAttributes.category = 'Schedule an Appointment';
        contextualAttributes.action = 'UTS';
      }
    }

    // A default label for any click.
    if (!contextualAttributes.label.length) {
      contextualAttributes.label = 'Inline';
    }

    // If this is a link and the action has not been set.
    if (!contextualAttributes.action.length && $element.is('a')) {
      // Use the link text for the action.
      contextualAttributes.action = $element.text().trim();
    }

    // Force PDF download links to be this. Had to place after the description
    // since these don't have it.
    if (extension === 'pdf') {
      contextualAttributes.category = 'Download';
      contextualAttributes.label = path;
      contextualAttributes.action = '';
    }

    if (contextualAttributes.category.length && contextualAttributes.label.length && contextualAttributes.action.length) {
      //console.log(contextualAttributes);
    }

    // Set any missing explicit attributes with the contextual attribute.
    if (!explicitAttributes.category.length && contextualAttributes.category.length) {
      explicitAttributes.category = contextualAttributes.category;
    }
    if (!explicitAttributes.label.length && contextualAttributes.label.length) {
      explicitAttributes.label = contextualAttributes.label;
    }
    if (!explicitAttributes.action.length && contextualAttributes.action.length) {
      explicitAttributes.action = contextualAttributes.action;
    }

    // If all explicit attributes have been set, set the data-gtm-tracking
    // property on the element.
    if (explicitAttributes.category.length && explicitAttributes.label.length) {
      setDataGtmTracking($element, explicitAttributes.category, explicitAttributes.action, explicitAttributes.label);
    }

  }

  function getAttributeValue($element, attribute) {
    var value = $element.attr(attribute);
    return typeof (value) === 'string' ? value : ''
  }

  /**
   * Take a relative path and turn into a description.
   *
   * @param path
   * @returns {string}
   */
  function transformPathToDescription(path) {
    path = transformInternalUrlToRelative(path);
    switch (path) {
      case '/':
        return 'home';
    }

    return path;
  }

  function transformInternalUrlToRelative(url) {
    return url.replace(window.location.protocol + '//' + window.location.hostname, '');
  }

  function currentPage() {
    switch (window.location.pathname) {
      case '/':
      case '/our-story':
        return 'home';

      case '/patients':
        return 'patients';

      case '/doctors':
        return 'doctors';

      case '/our-leadership-team':
        return 'our-leadership-team';

      case '/leading-edge-care':
        return 'leading-edge-care';

      case '/population-health-services':
        return 'population-health-services';

      case '/employers':
        return 'employers';

      default:
        return '';
    }
  }



})(jQuery, Drupal);
