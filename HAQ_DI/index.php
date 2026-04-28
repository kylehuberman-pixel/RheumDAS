<?php include_once('./question.php'); ?>
<?php include_once('./practitioners.php'); ?>

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

    <!-- **** Favicons **** -->
    <!-- Windows 8 Tile -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../images/favicons/alberta-rheumatology-favicon-144x144.png">
    <!-- For iPad with high-resolution Retina display running iOS ≥ 7: -->
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="../images/favicons/alberta-rheumatology-favicon-152x152.png">
    <!-- For iPad with high-resolution Retina display running iOS ≤ 6: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/favicons/alberta-rheumatology-favicon-144x144.png">
    <!-- For iPhone with high-resolution Retina display running iOS ≥ 7: -->
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="../images/favicons/alberta-rheumatology-favicon-120x120.png">
    <!-- For iPhone with high-resolution Retina display running iOS ≤ 6: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/favicons/alberta-rheumatology-favicon-114x114.png">
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/favicons/alberta-rheumatology-favicon-72x72.png">
    <!-- Everyone else -->
    <link rel="icon" href="../images/favicons/alberta-rheumatology-favicon-32x32.png" sizes="32x32">

    <!-- Fonts -->
    <link type="text/css" rel="stylesheet" href="https://fast.fonts.net/cssapi/cacc2a75-dfca-4d8a-809d-a6cf299fc224.css" />
    <link rel="stylesheet" href="../css/rheumdas-fontastic/styles.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/tooltipsterv4.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
    <link rel="stylesheet" href="../style.css?v=1.3">
    <link rel="stylesheet" type="text/css" href="../css/HAQ-DI.css" />

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
    <script src="../js/vendor/modernizr-2.6.2.min.js"></script>

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

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-51707950-31', 'auto');
        ga('send', 'pageview');
    </script>
    <script async src=“https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9722778385524460” crossorigin=“anonymous”></script>
</head>

<body>

    <header id="site-header">
        <div class="container">
            <div class="logo-image">
                <a href="https://rheumdas.com">
                    <img src="../images/RheumHAQ-logo.svg" alt="RheumDAS Logo">
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
                <a href="/">RheumDAS Calculator</a>
                <p class="active">RheumHAQ Calculator</p>
            </div>
        </div>
    </nav>
    <div id="main" class="container">
        <div class="row">
            <form id="HAQ-DI" method="POST" action="actions.php" target="_blank">
                <div id="HAQ-DI-fixed-title">
                    <h1>Health Assessment Questionnaire (HAQ-DI)©</h1>
                    <p class="HAQ-DI-subtitle">Assessment</p>
                    <p class="HAQ-DI-desctiption">Please review the questions below and select which best describes your abilities OVER THE PAST WEEK:</p>
                </div>
                <div id="HAQ-DI-wrapper">

                    <? foreach ($questions as $qIndex => $question) : ?>
                        <div class="HAQ-DI-block" data-required="<?= $question->required ?>">
                            <div class="HAQ-DI-title"><?= $question->title ?></div>
                            <input value="<?= $question->title ?>" type="hidden" name="questions[<?= $qIndex ?>][title]" />
                            <input value="<?= $question->type ?>" type="hidden" name="questions[<?= $qIndex ?>][type]" />
                            <div class="HAQ-DI-questions">
                                <div class="HAQ-DI-questions-<?= $question->type ?>">
                                    <div class="HAQ-DI-head">
                                        <?php
                                        if ($question->type == 'radio') {
                                            foreach ($standatrAnswers as $answer)
                                                echo "<p>" . $answer . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <? if (!isset($question->block[0])) : ?>
                                        <? foreach ($question->block as $title => $qBlock) : ?>
                                            <div>
                                                <p class='HAQ-DI-questions-description'><?= $title ?></p>
                                                <div class="HAQ-DI-body">
                                                    <? foreach ($qBlock as $qText => $titleBlock) : ?>
                                                        <div>
                                                            <input type='checkbox' value="<?= $titleBlock ?>" name='questions[<?= $qIndex ?>][block][<?= $title ?>][<?= $qText ?>]' />
                                                            <p><?= $qText ?></p>
                                                        </div>
                                                    <? endforeach; ?>
                                                </div>
                                            </div>
                                        <? endforeach; ?>

                                    <? else : ?>

                                        <div class="HAQ-DI-questions-description">
                                            <? if ($question->type == 'radio') echo "Are you able to:"; ?>
                                        </div>

                                        <div class="HAQ-DI-body">
                                            <? foreach ($question->block as $i => $row) : ?>
                                                <lable>
                                                    <?
                                                    $html = '';
                                                    switch ($question->type) {
                                                        case 'slider':
                                                            if ($row->title == '') {
                                                                $html =  "<p>
                                                                    <span class='HAQ-DI-slider-title'>$row->title</span>
                                                                    <br>
                                                                    $row->description<br>$row->rangeDecs</p>
                                                                    <div>
                                                                        <span>Hours: </span>
                                                                        <input name='questions[$qIndex][block][$row->description][hours]' min='0' max='12' type='number' />
                                                                    </div>
                                                                    <div>
                                                                        <span>Minutes: </span>
                                                                        <input name='questions[$qIndex][block][$row->description][minutes]' min='0' max='59' type='number' />
                                                                    </div>
                                                                    ";
                                                            } else {
                                                                $html =  "<p>
                                                                    <span class='HAQ-DI-slider-title'>$row->title</span>
                                                                    <br>
                                                                    $row->description<br>$row->rangeDecs</p>
                                                                    
                                                                    <div>
                                                                        <input name='questions[$qIndex][block][$row->description]' min='0' max='100' type='number' type='text' />
                                                                        <span class='big-text'>/100</span>
                                                                    </div>";
                                                            }

                                                            break;
                                                        default:
                                                            $html =  "<p>" . $row . "</p><div style='display: flex;'>";

                                                            foreach ($standatrAnswers as $index => $answer)
                                                                $html .=  "<input type='radio' name='questions[$qIndex][block][$row]' value='$index' >";
                                                            $html .=  "</div>";
                                                    }

                                                    echo $html;
                                                    ?>
                                                </lable>
                                            <? endforeach ?>
                                        </div>
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    <? endforeach ?>

                    <div class="HAQ-DI-block">
                        <div class="HAQ-DI-title">Scoring</div>
                        <div class="HAQ-DI-questions">
                            <p class=" HAQ-DI-score">HAQ Score
                                <input readonly name="scores" id="score-input-value" value="0" />
                                <input type="button" id="score-calculate-button" onclick="calculateScores();" class="submit" value="Calculate">
                            </p>
                        </div>
                    </div>

                    <div class="HAQ-DI-block">
                        <div class="HAQ-DI-title">Export</div>
                        <div class="HAQ-DI-questions" id="forms">
                            <div style="text-align:center;">
                                <input type="hidden" name="action" id="HAQ-DI-action">
                                <input name="action" type="button" onclick="submitForm('print');" class="submit" value="Print">
                                <input name="action" type="button" onclick="openTab(this, 'email');" class="submit" value="Email">
                                <input name="action" type="button" onclick="openTab(this,'specialist');" class="submit" value="Send to Practitioner">
                            </div>
                            <div class="HAQ-form-tabs">
                                <div class="row HAQ-DI-personal-details" data-tab="email">
                                    <input type="email" class="col-3" name="email" placeholder="Enter email address" />
                                    <input name="action" type="button" onclick="submitForm('send');" class="submit" value="Send">
                                </div>
                                <div class="row HAQ-DI-personal-details" data-tab="specialist">
                                    <p class="HAQ-DI-subtitle">Select your Practitioner</p>
                                    <select name="practitionerEmail">
                                        <option value="0">- Select your practitioner from the list -</option>
                                        <? foreach ($practitioners as $row) : ?>
                                            <option value="<?= $row->email ?>"><?= $row->name ?></option>
                                        <? endforeach; ?>
                                    </select>
                                    <p class="HAQ-DI-subtitle">Personal Details</p>
                                    <input type="text" class="col-12" name="name" placeholder="First Name">
                                    <input type="text" class="col-3" name="lname" placeholder="Last Name">
                                    <input type="text" class="col-3" name="birth" placeholder="Birth Date">
                                    <span style="font-weight:900;">OR</span>
                                    <input type="text" class="col-3" name="healthcare" placeholder="Healthcare #"><br>
                                    <input name="action" type="button" onclick="submitForm('specialist');" class="submit" value="Send">
                                </div>
                            </div>

                        </div>
                    </div>
            </form>
        </div>
    </div>
    </div>

    <footer>

        <div class="container">
            <hr class="divider">
            </hr>
            <div class="website-credits">
                <a href="https://www.albertarheumatology.com" target="_blank">
                    <img class="abrheum-logo" src="../images/abrheum-logo.svg">
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
    <script src="../js/tooltipsyv4/jquery.tooltipster.js"></script>
    <!-- Slider Pips -->
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="../js/vendor/jquery.ui.slider-pips.js"></script>
    <!-- iFrame Sizer -->
    <script src="../js/vendor/iframeSizer.min.js"></script>

    <!-- Custom Scripts -->

    <script type="text/javascript" src="../js/rheumdas.js"></script>


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

    <script src="../js/HAQ_DI.js"></script>


</body>

</html>
