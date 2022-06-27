 var loanCalculator = {};

  loanCalculator.calculateMonthlyPayment = function(loanAmount, interestRate, loanTerm) {
    var monthlyInterestRate = interestRate / 12,
      totalPayments = 12 * loanTerm,
      totalInterest = 1;

    if (interestRate > 1) {
      throw 'Interest rate can be only in rage of 0..1';
    }

    for (var i = 0; i < totalPayments; i++) {
      totalInterest *= (1 + monthlyInterestRate);
    }

    return loanAmount * totalInterest * monthlyInterestRate / (totalInterest - 1);
  };

  loanCalculator.calculateLoanAmount = function(desiredMonthlyPayment, interestRate, loanTerm) {
    var totalMonths = 12 * loanTerm,
      monthlyInterestRate = interestRate / 12;

    if (interestRate > 1) {
      throw 'Interest rate can be only in rage of 0..1';
    }

    return Math.round(desiredMonthlyPayment / monthlyInterestRate) * (1 - Math.pow(1 / (1 + monthlyInterestRate), totalMonths));
  };

  loanCalculator.calculateMonthlyPaymentUi = function () {
    if (!jQuery('#LoanAmountForm').valid()) {
      return true;
    }

    var jQueryloanCalculator = jQuery('.js-monthly-calculator'),
      loanAmount = parseFloat(jQueryloanCalculator.find(':input[name="loan"]').val()),
      interestRate = parseFloat(jQueryloanCalculator.find(':input[name="interest-rate"]').val()) / 100,
      loanTerm = parseFloat(jQueryloanCalculator.find(':input[name="loan-term"]').val()),
      jQuerycalculationResult = jQueryloanCalculator.find('.js-calculation-result'),
      errors = [];

    if (isNaN(loanAmount) || loanAmount == 0) { errors.push({ fieldName: 'loan', message: 'Please enter a valid loan amount' }); }
    if (isNaN(interestRate) || interestRate == 0) { errors.push({ fieldName: 'interest-rate', message: 'Please enter a valid interest rate' }); }
    if (isNaN(loanTerm) || loanTerm == 0) { errors.push({ fieldName: 'loan-term', message: 'Please enter a valid loan term' }); }

    if (errors.length > 0) {
      loanCalculator.displayErrors(jQueryloanCalculator, errors);
      return false;
    }

    jQuerycalculationResult.text('$' + loanCalculator.calculateMonthlyPayment(loanAmount, interestRate, loanTerm).toFixed(2));
  };

  loanCalculator.calculateLoanAmountUi = function () {
    if (!jQuery('#PaymentAmountForm').valid()) {
      return true;
    }

    var jQueryloanCalculator = jQuery('.js-amount-calculator'),
      monthlyPayment = parseFloat(jQueryloanCalculator.find(':input[name="month-payment"]').val()),
      interestRate = parseFloat(jQueryloanCalculator.find(':input[name="interest-rate"]').val()) / 100,
      loanTerm = parseFloat(jQueryloanCalculator.find(':input[name="loan-term"]').val()),
      jQuerycalculationResult = jQueryloanCalculator.find('.js-calculation-result'),
      errors = [];

    if (isNaN(monthlyPayment) || monthlyPayment == 0) {
      errors.push({ fieldName: 'month-payment', message: 'Please enter a valid monthly payment' });
    }
    if (isNaN(interestRate) || interestRate == 0) {
      errors.push({ fieldName: 'interest-rate', message: 'Please enter a valid interest rate' });
    }
    if (isNaN(loanTerm) || loanTerm == 0) {
      errors.push({ fieldName: 'loan-term', message: 'Please enter a valid loan term' });
    }

    if (errors.length > 0) {
      loanCalculator.displayErrors(jQueryloanCalculator, errors);
      return false;
    }

    jQuerycalculationResult.text('$' + loanCalculator.calculateLoanAmount(monthlyPayment, interestRate, loanTerm).toFixed(2));
  };

  loanCalculator.bindEventHandlers = function() {
    jQuery('.js-calculate-monthly').on('click', function () { loanCalculator.calculateMonthlyPaymentUi(); });
    jQuery('.js-calculate-amount').on('click', function () { loanCalculator.calculateLoanAmountUi(); });
  };

  loanCalculator.displayErrors = function(jQueryform, errors) {
    var errorMessages = [];

    jQuery.each(errors, function(i, e) {
      if (typeof e !== 'undefined') {
        errorMessages.push(e.message);
      }
    });

    alert(errorMessages.join('\n'));
  };

  loanCalculator.init = function () {
    // loanCalculator.loanTabs();
    // jQuery('.loan-calc-wrapper').tabs();
    // loanCalculator.renderInterestRateSelect(0, 15);
    // loanCalculator.renderLoanTermSelect(0, 20);
    loanCalculator.bindEventHandlers();
    //shared.bindValidation('#LoanAmountForm');
    // jQuery('#LoanAmountForm #interest-rate').rules("add", { greaterThanZero: true });
    // jQuery('#LoanAmountForm #loan-term').rules("add", { greaterThanZero: true });

    //shared.bindValidation('#PaymentAmountForm');
    // jQuery('#PaymentAmountForm #interest-rate').rules("add", { greaterThanZero: true });
    // jQuery('#PaymentAmountForm #loan-term').rules("add", { greaterThanZero: true });

    jQuery('#LoanAmountForm').on('submit', function(e) {
      e.preventDefault();
    });

    jQuery('#PaymentAmountForm').on('submit', function (e) {
      e.preventDefault();
    });

    jQuery("#loan-calc-wrapper select").trigger("chosen:updated");
  };

  jQuery(function () {
    loanCalculator.init();
  });