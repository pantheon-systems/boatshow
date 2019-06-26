function onYouTubeIframeAPIReady() {
  Drupal.behaviors.videoModal.InitializeViewModel();
}

(function ($, Drupal) {
  Drupal.behaviors.videoModal = {
    attach: function attach(context, settings) {
      $('.js-video-modal').on('click', function (e) {
        e.preventDefault();
        Drupal.behaviors.videoModal.openVideoModal($(this));
      });
    },

    viewModel: {},

    clickedElement: {},

    openVideoModal: function (el) {
      Drupal.behaviors.videoModal.clickedElement = el;

      if (typeof YT === "undefined") {
        $.getScript('//www.youtube.com/player_api');
      } else {
        Drupal.behaviors.videoModal.InitializeViewModel();
      }
    },

    InitializeViewModel: function () {
      Drupal.behaviors.videoModal.clickedElement.openModal({
        templateId: 'video-template',
        width: 'auto'
      });

      var videoId = Drupal.behaviors.videoModal.clickedElement.data("videoid");
      var trackingEnabled = Drupal.behaviors.videoModal.clickedElement.data("videotracking") && Drupal.behaviors.videoModal.clickedElement.data("videotracking") === true;

      Drupal.behaviors.videoModal.viewModel = new Drupal.behaviors.videoModal.videoViewModel(videoId, trackingEnabled);

      var koEle = document.getElementById('modal-video');
      ko.cleanNode(koEle);
      ko.applyBindings(Drupal.behaviors.videoModal.viewModel, koEle);
      $('.video-holder').fitVids();
    },

    videoViewModel: function (videoId, trackingEnabled) {
      var self = this;
      self.intervalId = null;
      self.TrackingEnabled = ko.observable(trackingEnabled);
      self.VideoId = ko.observable(videoId);
      self.VideoTitle = ko.observable();
      self.VideoLink = ko.computed(function () {
        return "http://www.youtube.com/watch?v=" + self.VideoId();
      });

      self.Player = new YT.Player('video-iframe', {
        playerVars: { autoplay: 1, controls: 0, showinfo: 1, rel: 0, modestbranding: 1 },
        videoId: videoId,
        events: {
          'onReady': Drupal.behaviors.videoModal.PlayerReady,
          'onStateChange': Drupal.behaviors.videoModal.PlayerStateChange
        }
      });

      self.PlayerState = ko.observable();

      self.FormatNumberLength = function (num, length) {
        var r = "" + num;
        while (r.length < length) {
          r = "0" + r;
        }
        return r;
      };

      self.ConvertSecondsToTimeStamp = function (seconds) {
        if (typeof seconds === 'undefined' || seconds < 1) {
          return "";
        }

        var minutes = Math.floor(seconds / 60);
        var leftSeconds = (seconds - minutes * 60).toFixed(0);
        leftSeconds = self.FormatNumberLength(leftSeconds, 2);

        return minutes + ":" + leftSeconds;
      };

      self.TotalLength = ko.observable(0);

      self.TotalLengthLabel = ko.computed(function () {
        return self.ConvertSecondsToTimeStamp(self.TotalLength());
      }, self);

      self.CurrentTime = ko.observable(0);

      self.CurrentTimeLabel = ko.computed(function () {
        return self.ConvertSecondsToTimeStamp(self.CurrentTime());
      }, self);

      self.ProgressPercent = function (current, total) {
        var percent = 0;

        if (current == 0 || total == 0) {
          return percent;
        }

        if (current >= total) {
          percent = 100;
          return percent;
        }

        percent = current / total * 100;

        return percent;
      };

      self.CurrentTimeProgressStyle = ko.computed(function () {
        var style = "width:" + self.ProgressPercent(self.CurrentTime(), self.TotalLength()) + "%;";
        return style;
      }, self);

      self.IsPlaying = ko.observable(!self.isTouchDevice);

      self.PauseClass = ko.computed(function () {
        return self.IsPlaying() ? "pause" : "";
      }, self);

      self.TriggerPlayPause = function () {
        if (self.IsPlaying()) {
          self.Player.pauseVideo();
        } else {
          self.Player.playVideo();
        }
      };

      self.TriggerPause = function () {
        if (self.IsPlaying()) {
          self.Player.pauseVideo();
        }

        return true;
      };

      // Progress
      self.IsProgressDrag = ko.observable(false);

      self.TriggerProgress = function (data, e) {
        var position = e.pageX,
          touch;

        if (self.isTouchDevice) {
          if (e.originalEvent.targetTouches !== undefined) {
            touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            position = touch.pageX;
          } else {
            return;
          }
        }

        self.IsProgressDrag(true);
        self.UpdateProgress(position);
      }

      self.UpdateProgress = function (xPosition) {
        var videoProgressTotal = $('#video-progress-total'),
          position = xPosition - videoProgressTotal.offset().left,
          percentage = 100 * (position / videoProgressTotal.width());

        if (percentage > 100) {
          percentage = 100;
        }

        if (percentage < 0) {
          percentage = 0;
        }

        self.Player.seekTo(self.TotalLength() * percentage / 100);
      };

      self.BindProgressEvents = function () {
        $(document).on('mouseup', function (e) {
          if (self.IsProgressDrag()) {
            self.IsProgressDrag(false);
            self.UpdateProgress(e.pageX);
          }
        });

        $(document).on('mousemove', function (e) {
          if (self.IsProgressDrag()) {
            self.UpdateProgress(e.pageX);
          }
        });
      }

      // Volume
      self.IsVolumeDrag = ko.observable(false);

      self.TriggerVolume = function (data, e) {
        var position = e.pageX,
          touch;


        if (self.isTouchDevice) {
          if (e.originalEvent.targetTouches !== undefined) {
            touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            position = touch.pageX;
          } else {
            return;
          }
        }

        self.IsVolumeDrag(true);
        e.preventDefault();
        self.UpdateVolume(position);
      };

      self.UpdateVolume = function (xPosition) {
        var videoVolumeTotal = $('#video-volume-total'),
          videoVolumeCurrent = $('#video-volume-current'),
          position = xPosition - videoVolumeTotal.offset().left,
          percentage = 100 * (position / videoVolumeTotal.width());

        if (percentage > 100) {
          percentage = 100;
        }
        if (percentage < 0) {
          percentage = 0;
        }

        videoVolumeCurrent.css('width', (percentage + '%'));
        self.Player.setVolume(percentage);
      }

      self.BindVolumeEvents = function () {
        $(document).on('mouseup', function (e) {
          if (self.IsVolumeDrag()) {
            self.IsVolumeDrag(false);
            self.UpdateVolume(e.pageX);
          }
        });

        $(document).on('mousemove', function (e) {
          if (self.IsVolumeDrag()) {
            self.UpdateVolume(e.pageX);
          }
        });
      }

      // Fullscreen
      self.IsFullScreen = ko.observable(false);
      self.FullScreenClass = ko.computed(function () {
        return self.IsFullScreen() ? 'is-fullscreen' : '';
      });

      self.TriggerFullScreen = function () {
        self.IsFullScreen(!self.IsFullScreen());
      };

      // State
      self.PlayerStateChange = function (state) {
        self.PlayerState(state);

        if (state.data == YT.PlayerState.PLAYING && !self.IsPlaying()) {
          self.IsPlaying(true);
        }

        if (state.data == YT.PlayerState.PAUSED && self.IsPlaying()) {
          self.IsPlaying(false);
        }

        if (state.data == YT.PlayerState.ENDED) {
          self.IsPlaying(false);
        }

        if (self.TrackingEnabled() === true) {
          self.GATracking(state.data);
        }
      };

      self.PlayerReady = function () {
        self.TotalLength(self.Player.getDuration());
        self.VideoTitle(self.Player.getVideoData().title);
        self.Player.setVolume(80);
        self.StartInterval();
        self.BindVolumeEvents();
        self.BindProgressEvents();
      };

      self.UpdateInterval = ko.observable();

      self.StartInterval = function () {
        self.UpdateInterval = setInterval(self.UpdateUI, 100);
      };

      self.StopInterval = function () {
        clearInterval(self.UpdateInterval);
      };

      self.UpdateUI = function () {
        self.CurrentTime(self.Player.getCurrentTime());

        if (self.TotalLength() == 0) {
          self.TotalLength(self.Player.getDuration());
        }
      };

      // --------------------------------------
      // -------   GA tracking  ---------------
      //---------------------------------------

      self.GATracking = function (state) {
        var key = self.VideoId();
        switch (state) {
          case YT.PlayerState.PLAYING:
            ga('send', 'event', key + ' - video', 'Started', key + ' - video tracking');
            dataLayer.push({'event': 'started'});
            self.GAStartPlayTracking(key);
            break;
          case YT.PlayerState.ENDED:
            self.GAStopPlayTracking();
            ga('send', 'event', key + ' - video', 'Completed', key + ' - video tracking');
            dataLayer.push({'event': 'completed'});
            break;
        }
      };

      self.GAStartPlayTracking = function (key) {
        self.GAStopPlayTracking();

        var intervalTime = 5,
          intervalCount = 4,
          intervalRatio = 1 / 4,
          intervalMarkers = [intervalCount],
          duration = self.Player.getDuration();

        intervalMarkers[0] = 0;

        for (var i = 1; i < intervalCount; i++) {
          intervalMarkers[i] = i * intervalRatio * duration;
        }

        self.intervalId = setInterval(function () {
          var time = self.Player.getCurrentTime();

          $.each(intervalMarkers, function (index, item) {
            if (((item - time) < intervalTime) && (item - time) > 0) {
              var percent = intervalRatio * index * 100 + '%',
                percentNum = intervalRatio * index * 100;
              ga('send', 'event', key + ' - video', 'Watched ' + percent, key + ' - video tracking');
              dataLayer.push({'event': 'watched' + percentNum});
              intervalMarkers[index] = 0;
            }
          });

        }, intervalTime * 1000);
      };

      self.GAStopPlayTracking = function () {
        if (self.intervalId != undefined) {
          clearInterval(self.intervalId);
        }
      };
      return self;
    },

    isTouchDevice: function () {
      return (('ontouchstart' in window)
        || (navigator.MaxTouchPoints > 0)
        || (navigator.msMaxTouchPoints > 0));
    },

    PlayerReady: function (key) {
      Drupal.behaviors.videoModal.viewModel.PlayerReady();
    },

    PlayerStateChange: function (state) {
      Drupal.behaviors.videoModal.viewModel.PlayerStateChange(state);
    }

  };
})(jQuery, Drupal);
