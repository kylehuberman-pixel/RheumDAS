<?php require_once 'lib/csrf.php'; ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RheumDAS - Disease activity score calculator for Arthritis Care Providers</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php csrf_meta(); ?>

  <!-- **** Favicons **** -->
  <!-- Windows 8 Tile -->
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicons/alberta-rheumatology-favicon-144x144.png">
  <!-- For iPad with high-resolution Retina display running iOS ≥ 7: -->
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="images/favicons/alberta-rheumatology-favicon-152x152.png">
  <!-- For iPad with high-resolution Retina display running iOS ≤ 6: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/favicons/alberta-rheumatology-favicon-144x144.png">
  <!-- For iPhone with high-resolution Retina display running iOS ≥ 7: -->
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/favicons/alberta-rheumatology-favicon-120x120.png">
  <!-- For iPhone with high-resolution Retina display running iOS ≤ 6: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/favicons/alberta-rheumatology-favicon-114x114.png">
  <!-- For first- and second-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favicons/alberta-rheumatology-favicon-72x72.png">
  <!-- Everyone else -->
  <link rel="icon" href="images/favicons/alberta-rheumatology-favicon-32x32.png" sizes="32x32">

  <!-- Fonts -->
  <link type="text/css" rel="stylesheet" href="https://fast.fonts.net/cssapi/cacc2a75-dfca-4d8a-809d-a6cf299fc224.css" />
  <link rel="stylesheet" href="css/rheumdas-fontastic/styles.css">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/tooltipsterv4.css" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
  <link rel="stylesheet" href="style.css?v=1.3">

  <style type="text/css">
    .tooltipster-content {
      padding: 8px;
      font-weight: 200;
      font-size: 12px;
      letter-spacing: .5px;
    }
  </style>

  <!--[if lt IE 10]>
          <style type="text/css">
            #svg-iframe{
              height:535px;
            }
          </style>
        <![endif]-->

  <!-- Scripts -->
  <script src="js/vendor/modernizr-2.6.2.min.js"></script>

  <!--[if gt IE 9]><!-->
  <script language="javascript" type="text/javascript">
    function resizeIframe(obj) {
      obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
  </script>
  <!--<![endif]-->

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZP6KP6Q3B4"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ZP6KP6Q3B4');
  </script>

</head>

<body>
  <!--[if lt IE 9]>
          <p class="browsehappy">You are using an outdated web browser. This website may not display or function properly. <br>Please <a style="text-decoration: underline" href="http://browsehappy.com/?locale=en">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


  <header id="site-header">
    <div class="container">
      <div class="logo-image">
        <a href="https://rheumdas.com">
          <img src="images/rheumdas-logo.svg" alt="RheumDAS Logo">
        </a>
      </div>
      <h1 style="visibility: hidden;">RheumDAS</h1>
      <h2 class="subtitle">
        Disease activity score calculator for Arthritis Care Providers
      </h2>
    </div>
  </header>
  <nav id="general-menu">
    <div class="container">
      <div class="row">
        <p class="active">RheumDAS Calculator</p>
        <a href="/HAQ_DI/">RheumHAQ Calculator</a>
      </div>
    </div>
  </nav>
  <div id="main" class="container">
    <div class="row">

      <form id="disease-activity-score-form" action="export-canvas.php" method="post">
        <?php echo csrf_field(); ?>


        <div class="holder">
          <section class="box medium homunculus">
            <header>
              <h3>Select Joints</h3>
            </header>
            <div class="contents">
              <p>Tap or click on the joints that are swollen.</p>

              <iframe id="svg-iframe" src="svg.html" width="100%" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"> </iframe>

              <dl class="legend">
                <dt class="tender"></dt>
                <dd>Tender</dd>

                <dt class="swollen"></dt>
                <dd>Swollen</dd>

                <dt class="tenderswollen"></dt>
                <dd>Tender &amp; Swollen</dd>
              </dl>


              <input type="hidden" name="tender-joint-list" id="tender-joint-list" value="">
              <input type="hidden" name="swollen-joint-list" id="swollen-joint-list" value="">
              <input type="hidden" name="tenderswollen-joint-list" id="tenderswollen-joint-list" value="">

            </div>
          </section>

          <section class="box joint-scores clearfix">
            <header>
              <h3>Joint Scores</h3>
            </header>
            <div class="contents">
              <div class="joint-scores-fields" id="28-joint-scores-fields">
                <h4>28 Joint Scores</h4>

                <div class="table">
                  <div class="cell">
                    <label for="28-tender">Tender:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" name="28-tender" id="28-tender">
                  </div>
                </div>

                <div class="table">
                  <div class="cell">
                    <label for="28-swollen">Swollen:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" name="28-swollen" id="28-swollen">
                  </div>
                </div>

              </div>

              <hr class="divider">

              <div class="joint-scores-fields" id="68-joint-scores-fields">
                <h4>66/68 Joint Scores</h4>


                <div class="table">
                  <div class="cell">
                    <label for="68-tender">Tender:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" name="68-tender" id="68-tender">
                  </div>
                </div>

                <div class="table">
                  <div class="cell">
                    <label for="68-swollen">Swollen:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" name="68-swollen" id="68-swollen">
                  </div>
                </div>

              </div>

              <div class="clearfix"></div>

            </div>
          </section>

          <section class="box additional-measures">
            <header>
              <h3>Additional Measures</h3>
            </header>
            <div class="contents">
              <div class="additional-measures-fields" id="additional-measures-fields">

                <!-- ESR -->

                <div class="table">
                  <div class="cell">
                    <label for="esr">ESR (mm/hr):</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" max="200" name="esr" id="esr">
                  </div>
                </div>

                <!-- CRP -->

                <div class="table">
                  <div class="cell">
                    <label for="crp">
                      CRP (mg/L):
                      <abbr rel="tooltip" class="info icon" title="If your CRP results are in mg/dL, input a value 10x your result so it is in mg/L.">
                        <span class="icon-help-circled"></span>
                      </abbr>
                    </label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" max="300" name="crp" id="crp">
                  </div>
                </div>

                <!-- Patient Global Health -->

                <div class="table pgh">
                  <div class="cell">
                    <label for="ptgh">Patient Global Health:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" max="10" name="ptgh" id="ptgh">
                  </div>
                </div>

                <div class="slider-container">
                  <div class="slider" id="ptgh-slider"></div>
                  <span class="slider-label first">
                    0 - Very well
                  </span>
                  <span class="slider-label last">
                    Very poor - 10
                  </span>
                </div>

                <!-- Physician Global Health -->

                <div class="table pgh">
                  <div class="cell">
                    <label for="phgh">Physician Global Health:</label>
                  </div>
                  <div class="cell">
                    <input type="number" min="0" max="10" name="phgh" id="phgh">
                  </div>
                </div>

                <div class="slider-container">
                  <div class="slider" id="phgh-slider"></div>
                  <span class="slider-label first">
                    0 - Very well
                  </span>
                  <span class="slider-label last">
                    Very poor - 10
                  </span>
                </div>


              </div>
            </div>
          </section>
        </div> <!-- .holder -->

        <section class="box disease-activity-scores">
          <header>
            <h3>Disease Activity Scores</h3>
          </header>
          <div class="contents">
            <div class="disease-activity-scores-fields">

              <div class="table">

                <div class="table-row">
                  <div class="cell das-label">
                    <span>DAS28</span> <abbr rel="tooltip" class="info icon" title="0.56*sqrt(tender28) + 0.28 * sqrt(swollen28) + 0.70 * ln(ESR) + 0.014 * GH"><span class="icon-help-circled"></span></abbr>
                  </div>
                  <div class="cell das-score">
                    <span id="das28-score">-</span>
                    <input type="hidden" id="das28-score-input" name="das28-score" value="">
                  </div>
                  <div class="cell das-rating">
                    <span id="das28-rating">-</span>
                    <input type="hidden" id="das28-rating-input" name="das28-rating" value="">
                  </div>
                </div>

                <div class="table-row">
                  <div class="cell das-label">
                    <span>DAS28-CRP <abbr rel="tooltip" class="info icon" title="0.56*sqrt(TJC28) + 0.28*sqrt(SJC28) + 0.36*ln(CRP+1) + 0.014*GH + 0.96"><span class="icon-help-circled"></span></abbr></span>
                  </div>
                  <div class="cell das-score">
                    <span id="das28crp-score">-</span>
                    <input type="hidden" id="das28crp-score-input" name="das28crp-score" value="">
                  </div>
                  <div class="cell das-rating">
                    <span id="das28crp-rating">-</span>
                    <input type="hidden" id="das28crp-rating-input" name="das28crp-rating" value="">
                  </div>
                </div>

                <div class="table-row">
                  <div class="cell das-label">
                    <span>SDAI <abbr rel="tooltip" class="info icon" title="SJC28 + TJC28 + PaGH+ PhGH + CRP"><span class="icon-help-circled"></span></abbr></span>
                  </div>
                  <div class="cell das-score">
                    <span id="sdai-score">-</span>
                    <input type="hidden" id="sdai-score-input" name="sdai-score" value="">
                  </div>
                  <div class="cell das-rating">
                    <span id="sdai-rating">-</span>
                    <input type="hidden" id="sdai-rating-input" name="sdai-rating" value="">
                  </div>
                </div>

                <div class="table-row">
                  <div class="cell das-label">
                    <span>CDAI <abbr rel="tooltip" class="info icon" title="SJC28 + TJC28 + PaGH+ PhGH"><span class="icon-help-circled"></span></abbr></span>
                  </div>
                  <div class="cell das-score">
                    <span id="cdai-score">-</span>
                    <input type="hidden" id="cdai-score-input" name="cdai-score" value="">
                  </div>
                  <div class="cell das-rating">
                    <span id="cdai-rating">-</span>
                    <input type="hidden" id="cdai-rating-input" name="cdai-rating" value="">
                  </div>
                </div>

              </div>

            </div>
          </div>
        </section>

        <section class="box additional-information">
          <header>
            <h3>Additional Information</h3>
          </header>
          <div class="contents">
            <div class="additional-information-fields" id="additional-information-fields">

              <div class="table">
                <div class="table-row">
                  <div class="cell">
                    <label for="pt-name">Patient Name:</label>
                  </div>
                  <div class="cell">
                    <input type="text" name="pt-name" id="pt-name">
                  </div>
                </div>
              </div>

              <div class="table">
                <div class="cell">
                  <label for="pt-id">Patient ID:</label>
                </div>
                <div class="cell">
                  <input type="text" name="pt-id" id="pt-id">
                </div>
              </div>

              <label for="current-medications">Current Medications:</label>
              <textarea name="current-medications" id="current-medications"></textarea>

            </div>
          </div>
        </section>
    </div>

    <div class="row">
      <section class="box large">
        <header>
          <h3>Export</h3>
        </header>
        <div class="contents export">
          <input name="export" type="button" class="button" onclick="submitForm('print');" value="Print">
          <input name="export" type="button" class="button" onclick="submitForm('save');" value="Save Image">
          <input name="export" type="button" class="button" onclick="submitForm('copy');" value="Copy Image"><br>

          <a href="#" class="button" id="email-trigger" class="button">Email</a>
          <div id="email-submission" style="display: none;">
            <input type="email" id="email-input" name="email-address" placeholder="Enter email address">
            <input name="export" type="button" class="button" onclick="submitForm('email');" value="Send">
          </div>

          <input type="hidden" id="export-type" name="export-type" value="none">
          <input type="hidden" name="submission" value="true">
        </div>
      </section>

      <section class="adsense">
        <div class="adsense-holder">
          <span class="ad-label">Advertisement</span>
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- RheumDas.com -->
          <ins class="adsbygoogle" style="display:inline-block;width:320px;height:100px" data-ad-client="ca-pub-9722778385524460" data-ad-slot="5892574384"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>
      </section>
    </div>

    </form>
  </div> <!-- .row -->
  </div> <!-- .main -->

  <footer>

    <div class="container">
      <hr class="divider">
      </hr>
      <div class="website-credits">
        <a href="https://www.albertarheumatology.com" target="_blank">
          <img class="abrheum-logo" src="images/abrheum-logo.svg">
        </a>
        <p>
          Brought to you by <br>
          <a href="https://www.albertarheumatology.com" target="_blank">www.albertarheumatology.com</a>
        </p>
      </div> <!-- .website-credits -->
    </div> <!-- .container -->

    <div class="subfooter">
      <div class="container">
        <p class="copyright">&copy; Alberta Rheumatology <?php echo date("Y"); ?></p>
        <nav class="footer-links">
          <a href="https://rheumdas.com/about.php">About the DAS Calculator</a>
        </nav>
      </div> <!-- .container -->
    </div>

  </footer>


  <!-- jQuery -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')
  </script>
  <!-- Bootstrap -->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <!-- Tooltipster -->
  <script src="js/tooltipsyv4/jquery.tooltipster.js"></script>
  <!-- Slider Pips -->
  <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script src="js/vendor/jquery.ui.slider-pips.js"></script>
  <!-- iFrame Sizer -->
  <script src="js/vendor/iframeSizer.min.js"></script>

  <!-- Custom Scripts -->

  <script type="text/javascript" src="js/rheumdas.js"></script>

  <script type="text/javascript">
    $(window).load(function() {

      //Appends true for IE11, false otherwise
      var isIE11 = !!window.MSInputMethodContext && !!document.documentMode;

      var isOldIE = (navigator.userAgent.indexOf("MSIE") !== -1); // Detect IE10 and below

      var desiredCalcMethod = 'bodyOffset';

      if (isOldIE) {
        // desiredCalcMethod = 'grow';
      } else if (isIE11) {
        // desiredCalcMethod = 'grow';
      }

      console.log(desiredCalcMethod);

      iFrameResize({
        heightCalculationMethod: desiredCalcMethod
      });

      //Track Downloads
      $('a').filter(function() {
        return this.href.match(/.*\.(zip|ra*|mp*|avi|flv|mpeg|pdf|doc*|ppt*|xls*|jp*|png|gif|tiff|bmp|txt)(\?.*)?$/);
      }).click(function(e) {
        ga('send', 'event', 'download', 'click', this.href, {
          'nonInteraction': 1
        });
      });

      //Track Mailto
      $('a[href^="mailto"]').click(function(e) {
        ga('send', 'event', 'email', 'send', this.href, {
          'nonInteraction': 1
        });
      });

      //Track Outbound Links
      $('a[href^="http"]').filter(function() {
        if (!this.href.match(/.*\.(zip|ra*|mp*|avi|flv|mpeg|pdf|doc*|ppt*|xls*|jp*|png|gif|tiff|bmp|txt)(\?.*)?$/)) {
          if (this.href.indexOf('rheumdas.com') == -1) return this.href;
        }
      }).click(function(e) {
        ga('send', 'event', 'outbound', 'click', this.href, {
          'nonInteraction': 1
        });
      });
    });
  </script>


</body>

</html>