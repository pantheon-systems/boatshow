var BoatListViewModel = function () {
  var parent = this;

  function boatViewModel(item) {
    var self = this;
    self.Id = item.Id;
    self.PluralName = item.PluralName;
    self.Slug = ko.observable(item.Slug);
    self.Activities = ko.observable(item.activities);
    self.Propulsions = ko.observable(item.propulsions);
    self.MaxCapacity = ko.observable(item.maxCapacity);
    self.MinLength = ko.observable(item.minLength);
    self.MaxLength = ko.observable(item.maxLength);
    self.PriceMax = ko.observable(item.priceMax);
    self.PriceMin = ko.observable(item.priceMin);
    self.IsTrailerable = ko.observable(item.isTrailerable);
    //self.ImageUrl = "https://discoverboating.s3.amazonaws.com/boat-selector/buying/" + self.Slug() + ".jpg?v=2015-03-02";
    self.ImageUrl = item.Image;
    self.BoatDetailsUrl = ko.observable(item.BoatDetailsUrl);
    self.BoatClass = "boat-box";
    self.CustomCss = ko.observable();
    self.DivId = "boat-" + self.Id;
    self.IsComparable = ko.observable(item.isComparable);

    self.EmbeddedBoatDetailsUrl = ko.computed(function () {
      return boatFinder.constants.boatDetailsPageUrl + self.BoatDetailsUrl().replace(boatFinder.constants.buyingBoatPagePrefix, "");
    });

    self.ActivityNames = ko.computed(function() {
      var names = parent.GetActivityNames(self.Activities());
      return names;
    });

    self.PropulsionNames = ko.computed(function () {
      var names = parent.GetPropulsionNames(self.Propulsions());
      return names;
    });

    self.MaxCapacityLabel = ko.computed(function() {
      var number = boatFinder.lang.n_a;
      if (self.MaxCapacity() != 'undefined' && self.MaxCapacity() != 0) {
        number = self.MaxCapacity() + " max";
      }
      return number;
    });

    self.LengthLabel = ko.computed(function () {
      var label = '';
      if (boatFinder.isCanada) {
        label = Math.round(self.MinLength() * boatFinder.constants.feetToMeter) + '-' +
          Math.round(self.MaxLength() * boatFinder.constants.feetToMeter) +
          ' m <br />(' + self.MinLength() + '-' + self.MaxLength() + ' '
          + boatFinder.lang.ft + ')';
      }
      else {
        label = self.MinLength() + "–" + self.MaxLength() + " ft";
      }
      return label;
    });

    self.PriceLabel = ko.computed(function () {
      var label = "jQuery" + self.PriceMin() + "k–jQuery";
      if (self.PriceMax() >= 1000) {
        label = label + self.PriceMax()/1000 + "m";
      } else {
        label = label + self.PriceMax() + "k";
      }
      return label;
    });

    self.TrailableLabel = ko.computed(function () {
      var label = boatFinder.lang.no;
      if (self.IsTrailerable()) {
        label = boatFinder.lang.yes;
      }
      return label;
    });

    self.ComparisonActiveClass = ko.computed(function () {
      var isActive = self.IsComparable() ? " active" : "",
        numberOfComparables = parent.comparison.NumberOfComparableBoats(),
        isEnabled = "";
      if (self.IsComparable()) {
        isEnabled = numberOfComparables > 1 ? "" : "disabled";
      } else {
        return isActive;
      }

      return isActive +  " " + isEnabled;
    }, self);

    self.CompareLabel = ko.computed(function() {
      var label = boatFinder.lang.Compare,
        numberOfComparables = parent.comparison.NumberOfComparableBoats();

      if (self.IsComparable()) {
        switch(numberOfComparables) {
          case 1:
            label = boatFinder.lang.select_another_boat_to_compare;
            break;
          case 2:
            label = boatFinder.lang.compare_2_boats;
            break;
          case 3:
            label = boatFinder.lang.compare_3_boats;
            break;
          case 4:
            label = boatFinder.lang.compare_4_boats;
            break;
        }
      }
      return label;
    }, self);

    self.CompareTrigger = function (item, event) {
      var target = event.target;
      var comparableBoats = parent.comparison.ComparableBoats();

      var comparableCount = 0;

      if (comparableBoats != 'undefined') {
        comparableCount = comparableBoats.length;
      }

      if (comparableCount < 2 && self.IsComparable()) {
        jQuery('.modal-close').click();
      }

      if (comparableCount >= 4 && !self.IsComparable()) {
        ui.showComparisonAlert(target);
      } else {
        self.IsComparable(!self.IsComparable());
      }

      parent.comparison.UpdatePrintLink();
    };

    self.OpenComparison = function(item, event) {
      if (!self.IsComparable()) {
        self.CompareTrigger(item, event);
        return;
      }
      parent.comparison.CompareTrigger(item, event);
    };

    self.IsVisible = ko.computed(function () {
      var visible = true;
      if (parent.filters.NumberOfActiveFilters() == 0) {
        return true;
      }

      var activities = parent.filters.GetActivityFilters();
      if (activities.length > 0) {
        visible = false;
        jQuery.each(activities, function(i, activity) {
          if (jQuery.inArray(activity.Id, self.Activities()) > -1) {
            visible = true;
          }
        });
        if (!visible) { return false; }
      }

      var capacity = parent.filters.GetCapacityFilter();
      if (typeof capacity != 'undefined') {
        visible = self.MaxCapacity() >= capacity || self.MaxCapacity() === 0;
        if (!visible) { return false; }
      }

      var length = parent.filters.GetLengthFilter();
      if (typeof length != 'undefined') {
        visible = (self.MinLength() <= length.MaxLength || length.MaxLength === boatFinder.constants.maxBoatLength) &&
          self.MaxLength() >= length.MinLength;
        if (!visible) { return false; } else return true;
      }

      var price = parent.filters.GetPriceFilter();
      if (typeof price != 'undefined') {
        visible = ((self.PriceMin() <= price.Max || price.Max === boatFinder.constants.priceMax) && self.PriceMax() >= price.Min);
        if (!visible) {return false;}
      }

      var propulsionList = parent.filters.GetPropulsionFilters();
      if (propulsionList.length > 0) {
        visible = false;
        jQuery.each(propulsionList, function (i, propulsion) {
          if (jQuery.inArray(propulsion.Id, self.Propulsions()) > -1) {
            visible = true;
          }
        });
        if (!visible) { return false; }
      }

      var trailerabilityList = parent.filters.GetTrailerabilityFilters();
      if (trailerabilityList.length > 0) {
        visible = false;
        if (trailerabilityList.length == 2) {
          visible = true;
        } else {
          if (self.IsTrailerable()) {
            visible = trailerabilityList[0].Id == 2;
          } else {
            visible = trailerabilityList[0].Id == 1;
          }
        }
      }

      return visible;
    }, self);
  }

  function filtersViewModel() {
    var filter = this;

    filter.activityList = ko.observableArray();
    filter.propulsionList = ko.observableArray();
    filter.maxCapacity = ko.observable();
    filter.boatLength = ko.observable();
    filter.boatPrice = ko.observable();
    filter.trailerabilityList = ko.observableArray();
    filter.NumberOfActiveFilters = ko.observable(0);
    filter.ShowReset = ko.computed(function() {
      return filter.NumberOfActiveFilters() > 0;
    });

    filter.AddTrailerability = function (id, name) {
      var item = {};
      item.Id = id;
      item.Name = name;
      filter.trailerabilityList.push(new trailerabilityViewModel(item));
    };
    filter.AddTrailerability(1, boatFinder.lang.Keep_it_at_a_marina);
    filter.AddTrailerability(2, boatFinder.lang.Trailer_it_around);

    filter.triggerFilterReset = function() {
      var activities = filter.GetActivityFilters();
      var propulsionItems = filter.GetPropulsionFilters();
      var trailerabilityItems =filter.GetTrailerabilityFilters();

      jQuery.each(activities, function(i, activity) {
        activity.removeFilter();
      });

      jQuery.each(propulsionItems, function (i, item) {
        item.removeFilter();
      });

      jQuery.each(trailerabilityItems, function (i, item) {
        item.removeFilter();
      });

      filter.maxCapacity.removeFilter();
      filter.boatPrice.removeFilter();
      filter.boatLength.removeFilter();

      filter.NumberOfActiveFilters(0);
    };

    filter.IncreaseActiveFiltersCount = function () {
      filter.NumberOfActiveFilters(filter.NumberOfActiveFilters() + 1);
    };
    filter.DecreaseActiveFiltersCount = function () {
      var current = filter.NumberOfActiveFilters();
      if (current > 0) {
        filter.NumberOfActiveFilters(current - 1);
      }
    };

    filter.GetActivityFilters = function() {
      var activities = ko.utils.arrayFilter(filter.activityList(), function(activity) {
        return activity.IsActiveFilter();
      });
      return activities;
    };

    filter.GetPropulsionFilters = function() {
      var propulsionItems = ko.utils.arrayFilter(filter.propulsionList(), function (item) {
        return item.IsActiveFilter();
      });
      return propulsionItems;
    };

    filter.GetTrailerabilityFilters = function() {
      var trailerabilityItems = ko.utils.arrayFilter(filter.trailerabilityList(), function (item) {
        return item.IsActiveFilter();
      });
      return trailerabilityItems;
    };

    filter.GetCapacityFilter = function() {
      var capacity;
      if (filter.maxCapacity.MaxCapacity() > 0) {
        capacity = filter.maxCapacity.MaxCapacity();
      }
      return capacity;
    };

    filter.GetLengthFilter = function () {
      var length;
      if ((filter.boatLength.MinLength() > boatFinder.constants.minBoatLength) || filter.boatLength.MaxLength() < boatFinder.constants.maxBoatLength) {
        length = {};
        length.MinLength = parseInt(filter.boatLength.MinLength());
        length.MaxLength = parseInt(filter.boatLength.MaxLength());
      }
      return length;
    };

    filter.GetPriceFilter = function () {
      var price;
      if ((filter.boatPrice.MinPrice() > 0) || (filter.boatPrice.MaxPrice() < boatFinder.constants.priceMax)) {
        price = {};
        price.Min = parseInt(filter.boatPrice.MinPrice());
        price.Max = parseInt(filter.boatPrice.MaxPrice());
      }
      return price;
    };

    filter.GetActiveFilters = function() {
      var filterList = {};
      filterList.ActivityFilters = filter.GetActivityFilters();
      filterList.PropulsionFilters = filter.GetPropulsionFilters();
      filterList.TrailerabilityFilters = filter.GetTrailerabilityFilters();
      filterList.CapacityFilter = filter.GetCapacityFilter();
      filterList.LengthFilter = filter.GetLengthFilter();
      filterList.PriceFilter = filter.PriceFilter();
      return filterList;
    };

    filter.NumberOfActiveBoats = ko.computed(function () {
      var number = 0;
      var visibleBoats = ko.utils.arrayFilter(parent.boatList(), function (item) {
        return item.IsVisible();
      });
      if (visibleBoats != undefined) {
        number = visibleBoats.length;
      }
      return number.toString();
    });
  }



  function capacityViewModel(item) {
    var self = this;

    self.MaxCapacity = ko.observable(item);

    self.Label = ko.computed(function () {
      var label = self.MaxCapacity();

      if (self.MaxCapacity() == boatFinder.constants.maxPassengers) {
        return label + '+';
      } else {
        return label;
      }
    });

    self.IsActiveFilter = ko.computed(function () {
      var active = false;
      if (self.MaxCapacity() > 0) {
        active = true;
      }
      return active;
    });

    self.IsActiveFilter.subscribe(function(oldValue) {
      if (self.MaxCapacity() > 0 && oldValue === false ) {
        parent.filters.IncreaseActiveFiltersCount();
      }

      if (self.MaxCapacity() == 0 && oldValue === true) {
        parent.filters.DecreaseActiveFiltersCount();
      }

    }, self, "beforeChange");

    self.CompareLabel = ko.computed(function() {
      return "max " + self.Label() + " " + boatFinder.lang.passengers;
    });

    self.RemoveFilterGTM = ko.computed(function() {
      return "Boat Finder - Filter Clear - " + self.CompareLabel();
    });

    self.removeFilter = function (data, event) {
      self.MaxCapacity(0);
      selectors.passengersSlider.val(0, true);
    };

    self.UpdateActiveFilterCount = function(increase) {
      if (increase) {
        parent.filters.IncreaseActiveFiltersCount();

      } else {
        parent.filters.DecreaseActiveFiltersCount();
      }
    };
  }

  function boatLengthViewModel(item) {
    var self = this;

    self.MinLength = ko.observable(item.Min);
    self.MaxLength = ko.observable(item.Max);

    self.IsActiveFilter = ko.computed(function() {
      var active = false;
      if ((self.MinLength() > boatFinder.constants.minBoatLength) || self.MaxLength() < boatFinder.constants.maxBoatLength) {
        active = true;
      }
      return active;
    });

    self.removeFilter = function (data, event) {
      self.MinLength(boatFinder.constants.minBoatLength);
      self.MaxLength(boatFinder.constants.maxBoatLength);
      boatFinder.selectors.boatLengthSlider.val([self.MinLength(), self.MaxLength()], true);
    };

    self.MinLabel = ko.computed(function () {
      var label = formatLabel(self.MinLength());
      return label;
    });

    self.MaxLabel = ko.computed(function () {
      var label = formatLabel(self.MaxLength());
      return label;
    });

    self.CompareLabel = ko.computed(function () {
      if (boatFinder.isCanada === 'true') {
        return boatFinder.lang.length + ' ' + Math.round(self.MinLength() * boatFinder.constants.feetToMeter) + '-' + Math.round(self.MaxLength() * boatFinder.constants.feetToMeter) + ' m (' + self.MinLength() + '-' + self.MaxLength() + ' ' + boatFinder.lang.ft + ')';
      }
      else {
        return boatFinder.lang.length + ' ' + self.MinLength() + '-' + self.MaxLabel();
      }
    });

    self.RemoveFilterGTM = ko.computed(function() {
      return "Boat Finder - Filter Clear - " + self.CompareLabel();
    });

    function formatLabel(val) {
      var label = val;
      if (val == boatFinder.constants.maxBoatLength) {
        if (boatFinder.isCanada === 'true') {
          label = Math.round(label * boatFinder.constants.feetToMeter) + ' m (' + label + ' ' + boatFinder.lang.ft + ')';
        } else {
          label = label + '+ ft';
        }
      } else {
        if (boatFinder.isCanada === 'true') {
          label = Math.round(label * boatFinder.constants.feetToMeter) + ' m (' + label + ' ' + boatFinder.lang.ft + ')';
        }
        else {
          label = label + ' ft';
        }
      }
      return label;
    }

    self.IsActiveFilter.subscribe(function (oldValue) {
      if (((self.MinLength() > boatFinder.constants.minBoatLength) || self.MaxLength() < boatFinder.constants.maxBoatLength) && oldValue === false) {
        parent.filters.IncreaseActiveFiltersCount();
      }
      if ((self.MinLength() == boatFinder.constants.minBoatLength) && self.MaxLength() == boatFinder.constants.maxBoatLength && oldValue === true) {
        parent.filters.DecreaseActiveFiltersCount();
      }

    }, self, "beforeChange");
  }

  function boatPriceViewModel(item) {
    var self = this;

    self.MinPrice = ko.observable(item.Min);
    self.MaxPrice = ko.observable(item.Max);

    self.IsActiveFilter = ko.computed(function() {
      var active = false;

      if ((self.MinPrice() > 0) || (self.MaxPrice() < boatFinder.constants.priceMax)) {
        active = true;
      }

      return active;
    });

    self.MinLabel = ko.computed(function () {
      var label = formatLabel(self.MinPrice());
      return label;
    });

    self.MaxLabel = ko.computed(function () {
      var label = formatLabel(self.MaxPrice());
      return label;
    });

    self.CompareLabel = ko.computed(function() {
      return "price " + self.MinLabel() + " - " + self.MaxLabel();
    });

    self.removeFilter = function (data, event) {
      self.MinPrice(boatFinder.constants.priceMin);
      self.MaxPrice(boatFinder.constants.priceMax);
      boatFinder.selectors.priceRangeSlider.val([self.MinPrice(), self.MaxPrice()], true);
    };

    function formatLabel(val) {
      var label = val;
      if (val == boatFinder.constants.priceMax) {
        label = 'jQuery' + label/boatFinder.constants.priceMax + 'm+';
      } else {
        label = 'jQuery' + label + 'k';
      }

      return label;
    }

    self.IsActiveFilter.subscribe(function (oldValue) {

      if (((self.MinPrice() > 0) || (self.MaxPrice() < boatFinder.constants.priceMax)) && oldValue === false) {
        parent.filters.IncreaseActiveFiltersCount();
      }

      if ((self.MinPrice() == 0) && self.MaxPrice() == boatFinder.constants.priceMax && oldValue === true) {
        parent.filters.DecreaseActiveFiltersCount();
      }

    }, self, "beforeChange");

  }

  function activityViewModel(item) {
    var self = this;

    self.Id = item.Id;
    self.Name = ko.observable(item.Name);
    self.ShortDescription = item.ShortDescription;
    self.Slug = item.Slug;
    self.IsSelected = ko.observable(item.isSelected === undefined ? false : item.isSelected);

    self.ActiveClass = ko.computed(function () {
      return (self.IsSelected() === true ? "toggle-wrapper active" : "toggle-wrapper");
    }, self);

    self.GTM = ko.computed(function() {
      return "Boat Finder - Activities Selected - " + self.Name();
    });

    self.triggerClick = function (data, event) {
      self.IsSelected(!self.IsSelected());
    };

    self.IsActiveFilter = ko.computed(function () {
      return self.IsSelected();
    });

    self.CompareLabel = ko.computed(function () {
      return self.Name();
    });

    self.RemoveFilterGTM = ko.computed(function() {
      return "Boat Finder - Filter Clear - " + self.CompareLabel();
    });

    self.removeFilter = function(data, event) {
      self.triggerClick();
    };

    self.IsActiveFilter.subscribe(function () {
      if (!self.IsSelected()) {
        parent.filters.DecreaseActiveFiltersCount();
      } else {
        parent.filters.IncreaseActiveFiltersCount();
      }
    }, self);
  }

  function propulsionViewModel(item) {
    var self = this;

    self.Id = item.Id;
    self.Name = ko.observable(item.Name);
    self.ShortDescription = item.ShortDescription;
    self.Slug = item.Slug;
    self.IsSelected = ko.observable(item.IsSelected === undefined ? false : item.IsSelected);

    self.ActiveClass = ko.computed(function () {
      return (self.IsSelected() === true ? "toggle-wrapper active" : "toggle-wrapper");
    });

    self.GTM = ko.computed(function() {
      return "Boat Finder - Propulsion Selected - " + self.Name();
    });

    self.triggerClick = function (data, event) {
      self.IsSelected(!self.IsSelected());
    };

    self.IsActiveFilter = ko.computed(function () {
      return self.IsSelected();
    });

    self.CompareLabel = ko.computed(function () {
      return self.Name();
    });

    self.RemoveFilterGTM = ko.computed(function() {
      return "Boat Finder - Filter Clear - " + self.CompareLabel();
    });

    self.removeFilter = function (data, event) {
      self.triggerClick();
    };

    self.IsActiveFilter.subscribe(function () {
      if (!self.IsSelected()) {
        parent.filters.DecreaseActiveFiltersCount();
      } else {
        parent.filters.IncreaseActiveFiltersCount();
      }
    }, self);
  }

  function trailerabilityViewModel(item) {
    var self = this;

    self.Id = item.Id;
    self.Name = ko.observable(item.Name);
    self.IsSelected = ko.observable(item.IsSelected === undefined ? false : item.IsSelected);

    self.ActiveClass = ko.computed(function () {
      return (self.IsSelected() === true ? "toggle-wrapper active" : "toggle-wrapper");
    });

    self.GTM = ko.computed(function() {
      return "Boat Finder - Trailerable Selected - " + self.Name();
    });

    self.triggerClick = function () {
      self.IsSelected(!self.IsSelected());
    };

    self.IsActiveFilter = ko.computed(function () {
      return self.IsSelected();
    });

    self.CompareLabel = ko.computed(function () {
      return self.Name();
    });

    self.RemoveFilterGTM = ko.computed(function() {
      return "Boat Finder - Filter Clear - " + self.CompareLabel();
    });

    self.removeFilter = function () {
      self.triggerClick();
    };

    self.IsActiveFilter.subscribe(function () {
      if (!self.IsSelected()) {
        parent.filters.DecreaseActiveFiltersCount();
      } else {
        parent.filters.IncreaseActiveFiltersCount();
      }
    }, self);
  }

  function comparisonViewModel() {
    var self = this;

    self.GetComparableBoatByIndex = function(number) {
      var index = number - 1;
      var boat;
      if (self.ComparableBoats().length >= number) {
        boat = self.ComparableBoats()[index];
      }
      return boat;
    };

    self.ComparableBoats = ko.computed(function () {
      var comparableBoats = ko.utils.arrayFilter(parent.boatList(), function (item) {
        return item.IsComparable();
      });
      return comparableBoats;
    });

    self.ComparableBoatsSelected = ko.computed(function(){
      if(self.ComparableBoats().length > 0){
        return true;
      }
      return false;
    });

    self.ComparableBoatsLength = ko.computed(function(){
      return self.ComparableBoats().length;
    });

    self.emptyComparisonSlot = ko.computed(function(){
      if(self.ComparableBoats().length < 4){
        return true;
      }
      return false;
    });

    self.slotsLeft = ko.computed(function(){
      return 4 - self.ComparableBoats().length;
    });

    self.slotsLeftPlural = ko.computed(function(){
      if(4 - self.ComparableBoats().length > 1){
        return 'boats';
      }
      return 'boat';
    });

    self.ComparableBoatViewModel = function (number, boat) {
      var model = this;
      var ordinal = function () {
        switch (number) {
          case 1:
            return boatFinder.lang.st;
          case 2:
            return boatFinder.lang.nd;
          case 3:
            return boatFinder.lang.rd;
          case 4:
            return boatFinder.lang.th;
        }
        return "";
      };

      model.Boat = ko.observable();

      if (boat != undefined) {
        model.Boat = ko.observable(boat);
      }

      model.PluralName = ko.computed(function() {
        return model.Boat() == undefined ? "" : model.Boat().PluralName;
      });
      model.BoatDetailsUrl = ko.computed(function () {
        return model.Boat() == undefined ? "" : model.Boat().BoatDetailsUrl();
      });
      model.Number = number;
      model.NumberLabel = number + "<sup>" + ordinal() + "</sup> " + boatFinder.lang.boat;
      model.ActiveClass = ko.computed(function () {
        return model.Boat() == undefined ? "" : "active";
      });

      // console.log("comparable boat view model");
      // console.log(model);
    };

    self.ComparableBoatsViewModel = ko.observableArray();

    self.ComparableBoats.subscribe(function (changes) {
      jQuery.each(self.ComparableBoatsViewModel(), function (index, value) {
        var number = value.Number;
        var boat = self.GetComparableBoatByIndex(number);
        var newValue = new self.ComparableBoatViewModel(number, boat);
        self.ComparableBoatsViewModel.replace(value, newValue);
      });
    });

    self.InitializeComparableBoatsViewModel = function (numberOfComparables) {
      for (var i = 0; i < numberOfComparables; i++) {
        self.ComparableBoatsViewModel.push(new self.ComparableBoatViewModel(i + 1));
      }
    };

    self.InitializeComparableBoatsViewModel(4);

    self.GetComparableBoatIdArray = function() {
      var idArr = [];
      if (self.ComparableBoats() === undefined || self.ComparableBoats().length < 1) {
        return idArr;
      }
      jQuery.each(self.ComparableBoats(), function(index, value) {
        idArr.push(value.Id);
      });
      return idArr;
    };

    self.ComparisonCookie = function() {
      var idArr = [];
      if (self.ComparableBoats() === undefined || self.ComparableBoats().length < 1) {
        jQuery.removeCookie(boatFinder.cookies.comparisonCookie);
        return;
      }
      idArr = self.GetComparableBoatIdArray();
      boatFinder.core.setComparisonCookieValue(idArr);
    };

    self.NumberOfComparableBoats = ko.computed(function () {
      return self.ComparableBoats().length;
    });

    self.CanBeCompared = ko.computed(function () {
      return self.NumberOfComparableBoats() >= 2;
    });

    self.CanBeComparedClass = ko.computed(function () {
      return self.CanBeCompared() ? "" : "disabled";
    });

    self.DesktopComparisonMessage = ko.computed(function () {
      var numberOfComparables = self.NumberOfComparableBoats(),
        message;
      if (numberOfComparables == 0) {
        message = "Add the boat types you like to your dock to compare later.";
      }
      if (numberOfComparables == 1) {
        message = "Please select at least two boats from the list below for comparison.";
      }
      if (numberOfComparables >= 2) {
        boatFinder.selectors.compareError.hide();
      }
      return message;
    });

    self.ShowAddAnotherBoat = ko.computed(function () {
      return self.NumberOfComparableBoats() < 4;
    });

    self.OpenComparisonDockClass = ko.computed(function() {
      if (self.NumberOfComparableBoats() > 0) {
        return "active";
      }
      return "";
    });

    self.EmptySpaceMessage = ko.computed(function() {
      var message;
      switch (self.NumberOfComparableBoats()) {
        case 1:
          message = boatFinder.lang.You_have_room_3;
          break;
        case 2:
          message = boatFinder.lang.You_have_room_2;
          break;
        case 3:
          message = boatFinder.lang.You_have_room_1;
          break;
      }
      return message;
    });

    self.PrintLink = ko.observable();

    self.UpdatePrintLink = function() {
      var idArr = self.GetComparableBoatIdArray();
      var printLink = "/shared-site/pages/buying/print.aspx?boats=";
      if (idArr.length > 0) {
        printLink = printLink + idArr.join('|');
      }
      self.PrintLink(printLink);
    };

    self.CompareTrigger = function(item, event) {
      var selfButton = jQuery(event.target);
      if (!self.CanBeCompared()) {
        boatFinder.selectors.compareError.hide();
        boatFinder.selectors.compareError.show().delay(5000).fadeOut();
        return;
      }

      self.UpdatePrintLink();

      selfButton.openModal({
        url: '#compare-modal-content',
        title: 'Compare Boats', //window.NMMA_LANG.compare_boats
        className: 'modal-compare',
        width: 'auto',
        onLoad: function () {
          console.log('MODAL ONLOAD FIRED');
          var modalContent = jQuery('.modal-content');
          jQuery('.modal-title').after(jQuery(boatFinder.selectors.printButton).html());

          ko.applyBindings(boatFinder.viewModel, jQuery('.modal-compare')[0]);
          modalContent.find('.compare-wrapper').show();

          jQuery('.block-nmma-boat-finder').hide();
          //jQuery(selectors.printButton).attr('href', parent.comparison.PrintLink());
          jQuery('.js-mobile-compare-slider').slick({
            dots: false,
            arrows: true,
            infinite: true,
          });

          window.scrollTo(0, 0);

          viewport = function(){
            var e = window, a = 'inner';
            if (!('innerWidth' in window)) {
              a = 'client';
              e = document.documentElement || document.body;
            }
            return { width: e[a + 'Width'], height: e[a + 'Height'] };
          };

          if (viewport().width > 991) {
            jQuery('.modal-context').css('top', jQuery('.node--view-mode-full').offset().top + 'px');
            jQuery('.node--view-mode-full').css('height', jQuery('.modal-context').height() + 'px');
          } else {
            jQuery('.modal-context').css('height', jQuery('body').height() + 'px');
          }
        },
        onClose: function() {
          jQuery('.node--view-mode-full').css('height', 'auto');
          jQuery('.block-nmma-boat-finder').show();
        }
      });
    };
  }

  parent.boatList = ko.observableArray();
  parent.filters = new filtersViewModel();
  parent.comparison = new comparisonViewModel;

  parent.BoatsHaveRendered = ko.observable(false);

  // self.boatListLength = ko.computed(function(){
  //   return parent.boatList.length();
  // });

  self.widenSearchMessageVisible = ko.computed(function () {
    var number = 0;
    var visibleBoats = ko.utils.arrayFilter(parent.boatList(), function (item) {
      return item.IsVisible();
    });
    if (visibleBoats != undefined) {
      number = visibleBoats.length;
    }
    return number === 0 && parent.BoatsHaveRendered();
  });


  parent.AddBoat = function (boat) {
    parent.boatList.push(new boatViewModel(boat));
  };

  parent.AddCapacity = function (item) {
    parent.filters.maxCapacity = new capacityViewModel(item);
  };

  parent.AddBoatLength = function (min, max) {
    var item = {};
    item.Min = min;
    item.Max = max;
    parent.filters.boatLength = new boatLengthViewModel(item);
  };

  parent.UpdateBoatLength = function (min, max, init) {
    parent.filters.boatLength.MinLength(min);
    parent.filters.boatLength.MaxLength(max);
    if (typeof dataLayer === 'object' && true === init) {
      dataLayer.push({
        'event': 'boat finder',
        'category': 'boat finder',
        'action': 'boat length selected',
        'label': 'min: ' + parseInt(min) + 'ft max: ' + parseInt(max) + 'ft'
      });
    }
  };

  parent.UpdateCapacity = function (item, init) {
    parent.filters.maxCapacity.MaxCapacity(item);
    if (typeof dataLayer === 'object' && true === init) {
      dataLayer.push({
        'event': 'boat finder',
        'category': 'boat finder',
        'action': 'passengers selected',
        'label': parseInt(item)
      });
    }
  };

  parent.AddActivity = function (activity) {
    parent.filters.activityList.push(new activityViewModel(activity));
  };

  parent.AddPropulsion = function (propulsion) {
    parent.filters.propulsionList.push(new propulsionViewModel(propulsion));
  };

  parent.AddBoatPrice = function(min, max) {
    var item = {};
    item.Min = min;
    item.Max = max;
    parent.filters.boatPrice = new boatPriceViewModel(item);
  };

  parent.UpdateBoatPrice = function(min, max) {
    parent.filters.boatPrice.MinPrice(min);
    parent.filters.boatPrice.MaxPrice(max);
  };

  parent.BoatsAfterRender = function () {
    var loadingWrapper = jQuery('.loading-wrapper');
    if (loadingWrapper.length > 0) {
      loadingWrapper.remove();
    }
    parent.BoatsHaveRendered(true);
  };

  parent.GetActivityNames = function(idList) {
    var names = [];
    if (idList == 'undefined') {
      return names;
    }
    jQuery.each(parent.filters.activityList(), function(i, activity) {
      jQuery.each(idList, function(ii, item) {
        if (activity.Id == item) {
          names.push(activity.Name());
        }
      });
    });
    return names;
  };

  parent.GetPropulsionNames = function (idList) {
    var names = [];
    if (idList == 'undefined') {
      return names;
    }
    jQuery.each(parent.filters.propulsionList(), function (i, propulsion) {
      jQuery.each(idList, function (ii, item) {
        if (propulsion.Id == item) {
          names.push(propulsion.Name());
        }
      });
    });
    return names;
  };

  parent.AddCapacity(0);
  parent.AddBoatLength(boatFinder.constants.minBoatLength, boatFinder.constants.maxBoatLength);
  parent.AddBoatPrice(boatFinder.constants.priceMin, boatFinder.constants.priceMax);
};