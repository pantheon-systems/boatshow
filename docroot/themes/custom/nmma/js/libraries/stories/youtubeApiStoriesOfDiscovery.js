define(['jquery', 'knockout', 'videoViewModel', 'fitVids', 'jqueryModal'], function ($, ko, videoViewModel) {

    var module = {};

    var playerAndViewModelMap = {};

    module.InitializeViewModel = function (clickedPlayButton) {
        var videoId = clickedPlayButton.data("videoid");
        var trackingEnabled = clickedPlayButton.data("videotracking") && clickedPlayButton.data("videotracking") === true;

        var parentContainer = clickedPlayButton.closest('.video-img-container');

        console.log('parentContainer', parentContainer);
        console.log(parentContainer.find('.video-container'));
        
        if (parentContainer) {
            parentContainer.find('.video-container').addClass('is-active');
            parentContainer.find('.story-content, .icon-play').addClass('is-active');
        } else {
            parentContainer = $("modal-video");
        }

        console.log('videoId');
        console.log(videoId, trackingEnabled, parentContainer.find('.js-video-container'));

        var viewModel = new videoViewModel(videoId, trackingEnabled, parentContainer.find('.js-video-container'));

        console.log('vm', viewModel);

        playerAndViewModelMap[parentContainer.find('.js-video-container').data('player-id')] = viewModel;

        ko.applyBindings(viewModel, parentContainer[0]);
    };

    module.InsertYoutubeApiScript = function () {
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    };

    PlayerReady = function (playerId, key) {
        playerAndViewModelMap[playerId].PlayerReady();
    };

    PlayerStateChange = function (playerId, state) {
        playerAndViewModelMap[playerId].PlayerStateChange(state);
    };

    return module;
});
