<?php

include_once('./question.php');

$sliders = array_pop(array_filter($questions, function ($item) {
    return $item->type == 'slider';
}));

$answers = $_POST['questions'];

$scorse = [];
foreach ($answers as $q) {
    if ($q['type'] != 'radio' || !isset($q['block'])) continue;
    $scorse[] = max($q['block']);
}
$haq_di = count($scorse) ? array_sum($scorse) / count($scorse) : 0;

?>

<!DOCTYPE html>
<html class="no-js">

<head>
    <title>HAQ_DI</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/tooltipsterv4.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
    <link rel="stylesheet" href="../style.css?v=1.3">
    <link rel="stylesheet" type="text/css" href="../css/HAQ-DI.css" />
    <style>
        input {
            pointer-events: none;
        }
    </style>
</head>

<body>

    <div id="main" class="container">
        <div class="row">
            <form id="HAQ-DI" method="POST" action="actions.php" target="_blank">
                <div>
                    <h1>Health Assessment Questionnaire (HAQ-DI)©</h1>
                    <p class="HAQ-DI-subtitle">Assessment</p>
                    <p class="HAQ-DI-desctiption">Please review the questions below and select which best describes your abilities OVER THE PAST WEEK:</p>
                </div>
                <div>

                    <? foreach ($answers as $qIndex => $question) : ?>
                        <?
                        if (
                            $question['title'] == 'Your Pain & Overall Wellness' &&
                            !$question['block']["How long do your joints feel stiff when you wake up in the morning?"]['hours'] &&
                            !$question['block']["How long do your joints feel stiff when you wake up in the morning?"]['minutes'] &&
                            !$question['block']["How has your health been IN THE PAST WEEK specifically related to your arthritis?"] &&
                            !$question['block']["How much pain have you had IN THE PAST WEEK?"]
                        ) continue;
                        ?>
                        <div class="HAQ-DI-block">
                            <div class="HAQ-DI-title"><?= $question['title'] ?></div>
                            <div class="HAQ-DI-questions">
                                <div class="HAQ-DI-questions-<?= $question['type'] ?>">
                                    <div class="HAQ-DI-head">
                                        <?php
                                        if ($question['type'] == 'radio') {
                                            foreach ($standatrAnswers as $answer)
                                                echo "<p>" . $answer . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <? if (isset($question['block'])) : ?>
                                        <? if ($question['type'] === 'checkbox') : ?>
                                            <? foreach ($question['block'] as $title => $qBlock) : ?>
                                                <div>
                                                    <p class='HAQ-DI-questions-description'><?= $title ?></p>
                                                    <div class="HAQ-DI-body">
                                                        <? foreach ($qBlock as $title => $row) : ?>
                                                            <div>
                                                                <input type='checkbox' checked />
                                                                <p><?= $title ?></p>
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>
                                                </div>
                                            <? endforeach; ?>

                                        <? else : ?>
                                            <div class="HAQ-DI-questions-description">
                                                <? if ($question['type'] == 'radio') echo "Are you able to:"; ?>
                                            </div>

                                            <div class="HAQ-DI-body">
                                                <? foreach ($question['block'] as $i => $row) : ?>
                                                    <lable>
                                                        <?
                                                        switch ($question['type']) {
                                                            case 'slider':

                                                                if ($row == 0) break;

                                                                $sliderData = array_pop(array_filter($sliders->block, function ($item) use ($i) {
                                                                    return $item->description == $i;
                                                                }));

                                                                if ($sliderData->title == '') {

                                                                    if ($row['hours'] == 0 && $row['minutes'] == 0) break;

                                                                    $html =  "<p>
                                                                    <span class='HAQ-DI-slider-title'>$sliderData->title</span>
                                                                    <br>
                                                                    $sliderData->description<br>$sliderData->rangeDecs</p>
                                                                    <div>
                                                                        <span>Hours: </span>
                                                                        <input name='questions[$qIndex][block][$sliderData->description][hours]' min='0' max='2' type='number' value='" . $row['hours'] . "' />
                                                                    </div>
                                                                    <div>
                                                                        <span>Minutes: </span>
                                                                        <input name='questions[$qIndex][block][$sliderData->description][minutes]' min='0' max='59' type='number' value='" . $row['minutes'] . "' />
                                                                    </div>
                                                                    ";
                                                                } else {
                                                                    $html =  "<p>
                                                                    <span class='HAQ-DI-slider-title'>$sliderData->title</span>
                                                                    <br>
                                                                    $sliderData->description<br>$sliderData->rangeDecs</p>
                                                                    <div>
                                                                        <input name='questions[$qIndex][block][$sliderData->description]' min='0' max='100' type='number' type='text' value='" . $row . "' />
                                                                        <span class='big-text'>/100</span>
                                                                    </div>";
                                                                }

                                                                echo $html;
                                                                break;
                                                            default:
                                                                echo "<p>" . $i . "</p><div style='display: flex;'>";

                                                                foreach ($standatrAnswers as $index => $answer)
                                                                    echo "<input type='radio' " . (($index == $row) ? "checked" : "") . " value='$index' >";
                                                                echo "</div>";
                                                        }
                                                        ?>
                                                    </lable>
                                                <? endforeach ?>
                                            </div>
                                        <? endif; ?>
                                    <? endif; ?>
                                </div>
                            </div>
                        </div>
                    <? endforeach ?>

                    <div class="HAQ-DI-block">
                        <div class="HAQ-DI-title">Scoring</div>
                        <div class="HAQ-DI-questions">
                            <p class="HAQ-DI-score">HAQ Score <input readonly name="scores" id="score-input-value" value="<?= $_POST["scores"] ?>" /></p>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')
    </script>
    <!-- Slider Pips -->
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="../js/vendor/jquery.ui.slider-pips.js"></script>

    <script src="../js/HAQ_DI.js"></script>
    <script>
        $(".HAQ-DI-questions-slider input[type=text]").each((index, row) => {
            let value = row.value;
            const lable = row.closest('lable');
            const range = $(lable.querySelector('.slider')).data();

            if (value > range.max) value = range.max;
            if (value < range.min) value = range.min;

            row.value = value;

            $(lable.querySelector('.slider')).slider("value", value);
        });

        window.print();
    </script>
</body>

</html>
