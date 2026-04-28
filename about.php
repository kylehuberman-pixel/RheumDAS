<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RheumDAS - About the DAS Calculator</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/cacc2a75-dfca-4d8a-809d-a6cf299fc224.css"/>
        <link rel="stylesheet" href="css/rheumdas-fontastic/styles.css">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/tooltipsterv4.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
        <link rel="stylesheet" href="style.css">

        <style type="text/css">
          .tooltipster-content{
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

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-51707950-31', 'auto');
          ga('send', 'pageview');
        </script>
        
    </head>
    <body>
        <!--[if lt IE 9]>
          <p class="browsehappy">You are using an outdated web browser. This website may not display or function properly. <br>Please <a style="text-decoration: underline" href="http://browsehappy.com/?locale=en">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


        <header id="site-header">
          <div class="container">
            <div class="logo-image">
              <a href="http://rheumdas.com">
                <img src="images/rheumdas-logo.svg" alt="RheumDAS Logo">
              </a>
            </div>
              
            <h1 style="visibility: hidden;">RheumDAS</h1>
            <h2 class="subtitle">
              Disease activity score calculator for Arthritis Care Providers
            </h2>
            
          </div>
        </header>

        <div id="main" class="container">
          <div class="row">

            <section class="text about">
              <h1>About the DAS Calculator</h1>

              <p>
                In rheumatology, study after study shows that a treat to target approach in the management of rheumatoid arthritis leads to best patient outcomes.  However, using validated tools to measure disease activity can sometimes be cumbersome.  Ideally, the clinician needs the most efficient method to record their results and in today's day and age, record those results practically.
              </p>
              <p>
                Hence the reason we launched RheumDAS.com.  The goal of this website, brought to you by the health care providers at <a href="http://albertarheumatology.com" target="_blank">AlbertaRheumatology.com</a>,  is to provide a tool for clinicians that will enhance the care they are able to provide to their patients with inflammatory arthritis.  To explore more about rheumatology and other tools we have to offer, visit us at <a href="http://albertarheumatology.com" target="_blank">AlbertaRheumatology.com</a>, or our <a href="https://www.youtube.com/user/EdmontonRheumatology" target="_blank">Youtube page</a>.
              </p>
              <p>
                This disease activity calculator can be used on our website alone, or you can email the results to your patient, print it off for your paper records, or import it directly into your electronic medical record.
              </p>
              <p>
                Disease Activity Score Calculations:
              </p>   
              <p>
                <strong>DAS28-ESR</strong> = 0.56*sqrt(t28) + 0.28*sqrt(sw28) + 0.70*Ln(ESR) + 0.014*GH <br>
                (Remission &lt;2.6, LDA 2.6 - 3.2, MDA 3.2 - 5.1, HDA &gt;5.1)
              </p>
              <p>
                <strong>DAS28-CRP</strong> = 0.56*sqrt(TJC28) + 0.28*sqrt(SJC28) + 0.36*ln(CRP+1) + 0.014*GH + 0.96 <br>
                (Remission &lt;2.6, LDA 2.6 - 3.2, MDA 3.2 - 5.1, HDA &gt;5.1)
              </p>
              <p>
                <strong>SDAI</strong> = TJC + SJC + PtGH + ProvGH + CRP/10 (mg/L) <br>
                (Remission 0-3.3, LDA 3.4 -11, MDA 11.1 - 26, HDA 26.1 - 86)
              </p>
              <p>
                <strong>CDAI</strong> = TJC + SJC + PtGH + ProvGH <br>
                (Remission &lt;2.8, LDA 2.8-9.9, MDA 10 - 21.9, HDA &gt;22)
              </p>
              <p>
                <small>
                  LDA = Low Disease Activity<br>
                  MDA = Moderate Disease Activity <br>
                  HDA = High Disease Activity<br>
                </small>
              </p>
            </section> <!-- .about -->

            <section id="privacy" class="text privacy">
              <h1>Terms of Use</h1>

              <p>
                Although we strive to ensure the information on our website is accurate and secure, we accept no legal responsibility for any errors or omissions. This website is intended for a Canadian audience.
              </p>
              <p>
                RheumDas.com does not collect any patient information used on this site.  All data is anonymous and is not stored for any use.  The tools presented here are for the exclusive use of the user only.
              </p>
            </section>


        </div> <!-- .row -->
      </div> <!-- .main -->

      <footer>

        <div class="container">
          <hr class="divider"></hr>
          <div class="website-credits">
            <a href="http://www.albertarheumatology.com" target="_blank">
              <img class="abrheum-logo" src="images/abrheum-logo.svg">
            </a>
            <p>
              Brought to you by <br>
              <a href="http://www.albertarheumatology.com" target="_blank">www.albertarheumatology.com</a>
            </p>
          </div> <!-- .website-credits -->
        </div> <!-- .container -->

        <div class="subfooter">
          <div class="container">
            <p class="copyright">&copy; Alberta Rheumatology <?php echo date("Y"); ?></p>
            <nav class="footer-links">
              <a href="http://rheumdas.com/about">About the DAS Calculator</a>
            </nav>
          </div> <!-- .container -->
        </div>

      </footer>


      <!-- jQuery -->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
      <!-- Bootstrap -->
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      <!-- Tooltipster -->
      <script src="js/tooltipsyv4/jquery.tooltipster.js"></script>
      <!-- Slider Pips -->
      <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
      <script src="js/vendor/jquery.ui.slider-pips.js"></script>

      <!-- Custom Scripts -->

      <script type="text/javascript">
        $(window).load(function() {
            
          //Track Downloads
          $('a').filter(function() {
            return this.href.match(/.*\.(zip|ra*|mp*|avi|flv|mpeg|pdf|doc*|ppt*|xls*|jp*|png|gif|tiff|bmp|txt)(\?.*)?$/);
          }).click(function(e) {
            ga('send','event', 'download', 'click', this.href, {'nonInteraction': 1});
          });

          //Track Mailto
          $('a[href^="mailto"]').click(function(e) {
            ga('send','event', 'email', 'send', this.href, {'nonInteraction': 1});
           });
          
          //Track Outbound Links
          $('a[href^="http"]').filter(function() {
            if (!this.href.match(/.*\.(zip|ra*|mp*|avi|flv|mpeg|pdf|doc*|ppt*|xls*|jp*|png|gif|tiff|bmp|txt)(\?.*)?$/)){
              if (this.href.indexOf('rheumdas.com') == -1) return this.href;
            }
          }).click(function(e) {
            ga('send','event', 'outbound', 'click', this.href, {'nonInteraction': 1});
          });
        });
      </script>



    </body>
</html>