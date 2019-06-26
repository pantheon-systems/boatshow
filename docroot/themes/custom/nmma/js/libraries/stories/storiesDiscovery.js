/*jslint regexp: true, nomen: true, sloppy: true */
/*global require, define, alert, applicationConfig, location, document, window,  setTimeout, Countable */

define(['jquery', 'shared', 'youtubeApiStoriesOfDiscovery'], function ($, sharedf, youtubeApi) {

	var module = {};
	var isUSA = sharedf.lang === 'en-us';

	console.log('isUSA', isUSA);

    var viewport = function () {
    	var e = window, a = 'inner';
    	if (!('innerWidth' in window)) {
    		a = 'client';
    		e = document.documentElement || document.body;
    	}
    	return { width: e[a + 'Width'], height: e[a + 'Height'] };
    };

    module.randomImage = function () {
        var bgImages = ['bg-discover-stories', 'bg-story-vazquez', 'bg-story-justin', 'bg-story-jake-owen', 'bg-story-ader-family'],
            bgHolder = $('.js-random-image');

        function changeImage(images, holder) {
            holder.addClass(images[Math.floor(Math.random() * images.length)]);
        }

        changeImage(bgImages, bgHolder);
    };

    module.discoveryParallax = function () {
        function parallaxScroll() {
            var scrolled = $(window).scrollTop();
            $('.js-parallax-bg-1').css('top', (0 - (scrolled * .6)) + 'px');
            $('.js-parallax-bg-2').css('top', (0 - (scrolled * .4)) + 'px');
            $('.js-parallax-bg-3').css('top', (0 - (scrolled * .75)) + 'px');
        }

        if ($('body').hasClass('js-parallax-effect') && viewport().width > 1025) {
            $(document).on('scroll', parallaxScroll);
        }

        $(window).smartresize(function () {
            if (viewport().width > 1025) {
                $(document).on('scroll', parallaxScroll);
            } else {
                $(document).off('scroll', parallaxScroll);
            }
        });
    };

    module.scrollBottom = function () {
        $('.js-scroll-bottom').on('click', function (e) {
            var id = $(this).attr('href');
            var $id = $(id);
            if ($id.size() === 0) {
                return;
            }
            e.preventDefault();
            var pos = $(id).offset().top + 125;
            pos = pos - 95;
            $('body, html').animate({ scrollTop: pos });
        });
    };

    module.videoContainerSize = function () {
        function videoContainerHeight() {
            var bigVideoContainer = $('.js-video-container-big'),
                smallVideoContainer = $('.js-video-container-small'),
                bigWidth = bigVideoContainer.width(),
                smallWidth = smallVideoContainer.width(),
                bigHeight = bigWidth * 0.56,
                smallHeight = smallWidth * 0.56;

            bigVideoContainer.css({ height: bigHeight + 'px' });
            smallVideoContainer.css({ height: smallHeight + 'px' });
        }

        if (viewport().width < 1025) {
            videoContainerHeight();
        }

        $(window).smartresize(function () {
            if (viewport().width < 1025) {
                videoContainerHeight();
            }
        });
    };

    module.randomImageDiscover = function () {
        if ($('body').hasClass('js-parallax-effect') && viewport().width > 1024) {

            function loadImage(imageContainer, imageIndex, imageSize) {
                var img = $("<img />").attr('src', imageIndex.src).attr('width', 'auto').attr('height', 'auto')
                    .on('load', function () {
                        var title = "<h3 class='instagram-title'>" + imageIndex.user + "</h3>",
                            icon = "<img src='/shared-site/static/images/instagram-icon.svg' class='instagram-icon'>",
                            parallaxImageContainer = '<div class="parallax-image-container-' + imageSize + '"></div>';

                        $('' + imageContainer).append(parallaxImageContainer, img[0].outerHTML, title, icon);
                    });
            }
            $.getJSON('/shared-site/static/images/parallax/images.json', function (IMAGE_PATHS) {
                var images = [],
                smallImagesContainer = $('.bg-1').toArray(),
                bigImagesContainer = $('.bg-2').toArray();

                for (var i = 0; i < IMAGE_PATHS.length; i++) {
                    var src = IMAGE_PATHS[i],
                        title = src.substring(src.indexOf("@") + 1).slice(0, -4);

                    if (!isUSA && src.indexOf('vikkimortis.jpg') !== -1) {
                    	continue;
                    }

                    images.push({
                    	src: '/shared-site/static/images/parallax/' + src,
                        url: 'www.google.com',
                        user: title
                    });
                }

                bigImagesContainer.forEach(function (element, key) {
                    var randomNumber = Math.floor(Math.random() * images.length),
                        index = images[randomNumber],
                        key = key + 2;
                    loadImage('.js-parallax-bg-2-' + key, index, 'big');
                    images.splice(images.indexOf(index), 1);
                });

                smallImagesContainer.forEach(function (element, key) {
                    var randomNumber = Math.floor(Math.random() * images.length),
                        index = images[randomNumber],
                        key = key + 1;
                    loadImage('.js-parallax-bg-1-' + key, index, 'small');
                    images.splice(images.indexOf(index), 1);
                });
            });
        }
    };

    module.backgroundImageLanding = function () {
        var container = $('.js-discover-landing');

        if ($('body').hasClass('js-parallax-effect') && viewport().width > 1024) {
            addBackgroundImage(container);
        }

        $(window).smartresize(function () {
            if (viewport().width > 1024) {
                addBackgroundImage(container);
            }
        });

        function addBackgroundImage(element) {
        	var bgTop = $('.page-discovery').hasClass('page-discovery-slim') ? '624px' : '1629px';
        	element.css({
        		'background': 'url("/shared-site/static/styles/images/background-waves.png"),url("/shared-site/static/styles/images/background-gradient.jpg")',
        		'background-repeat': 'no-repeat',
        		'background-size': '100% 20%, 100% 80%',
        		'background-position': '0 0, 0 ' + bgTop
        	});
        }
    };


    module.videoModal = function (videoModalLink) {
    	videoModalLink = videoModalLink || $('.js-video-play');

    	videoModalLink.on('click', function (e) {
    		console.log('clicked', e, $(this).data());
    		e.preventDefault();
    		var self = $(this),
                videoID = self.data('videoid'),
                videoContainer = self.data('videocontainer');

    		if (videoContainer) {
    			youtubeApi.InitializeViewModel(self);
    			return;
    		}
    	});
    };

    var player;
    window.onYouTubeIframeAPIReady = function () {
    	console.log('onYouTubeIframeAPIReady');
        module.videoModal();
    }

    $(document).ready(function () {
    	var htmlClass = $('html')[0].className;

    	module.discoveryParallax();
    	module.scrollBottom();
    	module.randomImageDiscover();
    	module.backgroundImageLanding();
        module.videoContainerSize();
        module.randomImage();
        youtubeApi.InsertYoutubeApiScript();
    });

    return module;
});