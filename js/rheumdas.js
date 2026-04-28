
function submitForm(exportType) {
  $(document).ready(function () {
    $('#export-type').val(exportType);
    $('#disease-activity-score-form').submit();
  });
}

var hideKeyboard = function () {
  document.activeElement.blur();
  var inputs = document.querySelectorAll('input');
  for (var i = 0; i < inputs.length; i++) {
    inputs[i].blur();
  }
};

$(document).ready(function () {

  // Resize iframe on window resize event
  // var resizeTimer;
  // $(window).resize(function() {
  //   clearTimeout(resizeTimer);
  //   resizeTimer = setTimeout(resizeIframe, 100);
  // });


  $('#email-trigger').on('click', function (e) {
    $('#email-submission').fadeIn();
    e.preventDefault();
  });

  // hiding the iOS keyboard when a user taps the “Done” or “Go” button
  $(document).on("keyup", "input", function (event) {
    event.preventDefault();
    // If enter is pressed then hide keyboard.
    if (event.keyCode == 13) {
      $("input").blur();
      calculateDAS();
      return false;
    }
  });

  // $('input, textarea').focus(function(){
  //   this.selectionStart = this.selectionEnd = this.value.length;
  // });


  // jQuery UI Sliders
  // -----------------------

  // Initialize the sliders + slider pips
  // -----
  $(".additional-measures-fields .slider")
    .slider({
      max: 10,
      step: 1,
      change: function (event, ui) {
        // Update the text inputs when the slider value has changed:
        // -----
        targetSliderID = event.target.id; // get slider id 
        targetInputID = targetSliderID.substring(0, targetSliderID.indexOf('-')); // get input id
        // console.log(targetInputID);
        var newVal = $("#" + targetSliderID).slider("value"); // get the new value             
        if (!isNaN(newVal)) { // give the input the new value unless it is NaN
          $('#' + targetInputID).val(newVal);
        }
        calculateDAS();
      }
    })
    .slider("pips", {
      step: 1,
      // labels: { first: "0 - Very Well", last: "Very Poor - 10" }
      labels: { first: "", last: "" }
    })
    .slider("float");

  // Update the slider value to match the input value:
  // -----
  $('#ptgh').change(function () {
    if (!isNaN($(this).val())) {
      if ($(this).val()) { // check if input has a value
        $("#ptgh-slider").slider("value", parseInt($(this).val()));
      }
      else { // if input value is empty then set slider to 0
        $("#ptgh-slider").slider("value", parseInt(0));
      }
    }
  });
  $('#phgh').change(function () {
    if (!isNaN($(this).val())) {
      if ($(this).val()) { // check if input has a value
        $("#phgh-slider").slider("value", parseInt($(this).val()));
      }
      else { // if input value is empty then set slider to 0
        $("#phgh-slider").slider("value", parseInt(0));
      }
    }
  });


  // Tooltips
  // -----------------------

  // Initialize tooltips that show the formulas of the different Disease Activity Scores

  $('abbr.info').tooltipster({
    interactive: true,
    trigger: 'click',
    // animation: 'grow',
    delay: 0,
    speed: 200
  });


  // Trigger DAS calculation on input change
  // -----------------------------------------

  $('input').on('input', function () {
    // console.log('an input changed.');
    calculateDAS();
  });

});

// Joint Scores
// -----------------------

// Change value of joint score inputs whenever a joint is marked on the homunculus:

function populateJointScores(tenderscore, swollenscore, tender28score, swollen28score, swollenJoints, tenderJoints, tenderswollenJoints) {
  // alert('number of tender joints: ' + tender + '\nnumber of swollen joints: ' + swollen);
  // alert('number of das28 joints: ' + das28);
  $('#68-tender').val(tenderscore);
  $('#68-swollen').val(swollenscore);
  $('#28-tender').val(tender28score);
  $('#28-swollen').val(swollen28score);

  console.log('swollen joint IDs: ' + swollenJoints);
  console.log('tender joint IDs: ' + tenderJoints);
  console.log('tenderswollen joint IDs: ' + tenderswollenJoints);

  $('#tender-joint-list').val(tenderJoints);
  $('#swollen-joint-list').val(swollenJoints);
  $('#tenderswollen-joint-list').val(tenderswollenJoints);
  calculateDAS();
}

function calculateDAS() {

  // console.log('calculating...');

  var tender28 = parseFloat($('#28-tender').val()) || 0;
  var swollen28 = parseFloat($('#28-swollen').val()) || 0;
  var ESR = parseFloat($('#esr').val()) || 0;
  var pagh = parseFloat($('#ptgh').val()) || 0;
  var phgh = parseFloat($('#phgh').val()) || 0;
  var CRP = parseFloat($('#crp').val()) || 0;
  var sdaiCRP = (CRP / 10) || 0;
  // console.log('tender28 = ' + tender28);
  // console.log('swollen28 = ' + swollen28);
  // console.log('ESR = ' + ESR);
  // console.log('CRP = ' + CRP);
  // console.log('pagh = ' + pagh);
  // console.log('phgh = ' + phgh);


  // -----------------------
  // DAS28 Calculation
  // -
  // 0.56*sqrt(tender28) + 0.28*sqrt(swollen28) + 0.70*ln(ESR) + 0.014*GH

  var das28;
  var das28rating;

  das28 = (0.56 * Math.sqrt(tender28)) + (0.28 * Math.sqrt(swollen28)) + (0.70 * Math.log(ESR)) + (0.014 * (pagh * 10));
  das28 = Number(das28.toFixed(2));

  if (isFinite(das28)) {
    $('#das28-score').text(das28);
    $('#das28-score-input').val(das28);

    if (das28 > 0 && das28 <= 2.6) {
      das28rating = 'Remission';
    }
    else if (das28 > 2.6 && das28 <= 3.2) {
      das28rating = 'Low';
    }
    else if (das28 > 3.2 && das28 <= 5.1) {
      das28rating = 'Moderate';
    }
    else if (das28 > 5.1) {
      das28rating = 'High';
      // color: #FF262A;
      // font-weight: 500;
    }
    $('#das28-rating').text(das28rating).removeClass().addClass(das28rating);
    $('#das28-rating-input').val(das28rating);
  }
  else {
    das28 = 0;
    $('#das28-score').text('-');
    $('#das28-score-input').val(0);
    $('#das28-rating').text('-').removeClass();
    $('#das28-rating-input').val(0);
  }


  // -----------------------
  // DAS28-CRP Calculation
  // - 
  // 0.56*sqrt(TJC28) + 0.28*sqrt(SJC28) + 0.36*ln(CRP+1) + 0.014*GH + 0.96

  var das28crp;
  var das28crprating;


  if (CRP) {
    das28crp = (0.56 * Math.sqrt(tender28)) + (0.28 * Math.sqrt(swollen28)) + (0.36 * (Math.log(CRP + 1))) + (0.014 * (pagh * 10)) + 0.96;
    console.log('das28crp = ' + das28crp);
    das28crp = Number(das28crp.toFixed(2));
    console.log('das28crp = ' + das28crp);
    $('#das28crp-score').text(das28crp);
    $('#das28crp-score-input').val(das28crp);

    if (das28crp > 0 && das28crp <= 2.6) {
      das28crprating = 'Remission';
    }
    else if (das28crp > 2.6 && das28crp <= 3.2) {
      das28crprating = 'Low';
    }
    else if (das28crp > 3.2 && das28crp <= 5.1) {
      das28crprating = 'Moderate';
    }
    else if (das28crp > 5.1) {
      das28crprating = 'High';
      // color: #FF262A;
      // font-weight: 500;
    }
    $('#das28crp-rating').text(das28crprating).removeClass().addClass(das28crprating);
    $('#das28crp-rating-input').val(das28crprating);
  }
  else {
    $('#das28crp-score').text('-');
    $('#das28crp-score-input').val('-');
    $('#das28crp-rating').text('-').removeClass();
    $('#das28crp-rating-input').val('-');
  }





  // -----------------------
  // SDAI Calculation
  // -
  // SJC28 + TJC28 + PaGH+ PhGH + CRP

  var sdaiScore;
  var sdaiScorerating;

  sdaiScore = tender28 + swollen28 + pagh + phgh + sdaiCRP;
  sdaiScore = Number(sdaiScore.toFixed(2));
  $('#sdai-score').text(sdaiScore);
  $('#sdai-score-input').val(sdaiScore);

  if (sdaiScore > 0 && sdaiScore <= 3.3) {
    sdaiScorerating = 'Remission';
  }
  else if (sdaiScore > 3.3 && sdaiScore <= 11) {
    sdaiScorerating = 'Low';
  }
  else if (sdaiScore > 11 && sdaiScore <= 26) {
    sdaiScorerating = 'Moderate';
  }
  else if (sdaiScore > 26) {
    sdaiScorerating = 'High';
    // color: #FF262A;
    // font-weight: 500;
  }
  $('#sdai-rating').text(sdaiScorerating).removeClass().addClass(sdaiScorerating);
  $('#sdai-rating-input').val(sdaiScorerating);


  // -----------------------
  // CDAI Calculation
  // -
  // SJC28 + TJC28 + PaGH+ PhGH

  var cdaiScore;
  var cdaiScorerating;

  cdaiScore = tender28 + swollen28 + pagh + phgh;
  cdaiScore = Number(cdaiScore.toFixed(2))
  $('#cdai-score').text(cdaiScore);
  $('#cdai-score-input').val(cdaiScore);

  if (cdaiScore > 0 && cdaiScore <= 3.3) {
    cdaiScorerating = 'Remission';
  }
  else if (cdaiScore > 3.3 && cdaiScore <= 11) {
    cdaiScorerating = 'Low';
  }
  else if (cdaiScore > 11 && cdaiScore <= 26) {
    cdaiScorerating = 'Moderate';
  }
  else if (cdaiScore > 26) {
    cdaiScorerating = 'High';
    // color: #FF262A;
    // font-weight: 500;
  }
  $('#cdai-rating').text(cdaiScorerating).removeClass().addClass(cdaiScorerating);
  $('#cdai-rating-input').val(cdaiScorerating);


}