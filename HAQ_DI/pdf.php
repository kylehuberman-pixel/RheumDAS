<?php

include('./question.php');

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
    <style>
        .HAQ-DI {
            text-align: center;
        }

        .HAQ-DI-questions {
            background-color: #ffffff;
            margin-bottom: 10px;
            padding: 10px;
        }

        .HAQ-DI-title {
            padding: 10px;
            background-color: black;
            font-size: 17px;
            color: white;
            text-align: left;
            letter-spacing: 0px;
            color: #FFFFFF;
        }

        .HAQ-DI-head>div>input {
            font-weight: 400;
        }

        .HAQ-DI-head>div {
            margin: 10px;
            width: 100px;
            display: inline-block;
            font-size: 13px;
            font-weight: 900;
            text-align: center;
            text-transform: uppercase;
        }

        .HAQ-DI-slider-title {
            font-size: 20px;
            display: block;
        }

        .HAQ-DI-questions-radio lable p {
            width: 100%;
        }

        .HAQ-DI-questions-description {
            font-weight: 900;
        }


        .HAQ-DI-subtitle {
            font-size: 25px;
            padding-top: 10px;
            padding: 0px 0px 0px 7px;
            margin-top: 20px;
        }

        .HAQ-DI-desctiption {
            font-size: 16px;
            padding: 7px;
        }


        .HAQ-DI-score {
            font-size: 17px;
            font-weight: 900;
        }

        .HAQ-DI-questions-slider .score-input-value {
            margin-top: -20px;
        }

        .HAQ-DI-questions-slider .HAQ-DI-score {
            font-weight: 400;
            font-size: 15px;
        }

        .score-input-value {
            width: 50px;
            text-align: center;
            margin-left: 28px;
            padding: 0;
            margin-top: -7px;
            font-size: 20px;
            float: right;
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
                                    <? if (isset($question['block'])) : ?>
                                        <? if ($question['type'] === 'checkbox') : ?>
                                            <? foreach ($question['block'] as $title => $qBlock) : ?>
                                                <div>
                                                    <p class='HAQ-DI-questions-description'><?= $title ?></p>
                                                    <div class="HAQ-DI-body">
                                                        <? foreach ($qBlock as $title => $row) : ?>
                                                            <div>
                                                                <p><?= $title ?></p>
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>
                                                </div>
                                            <? endforeach; ?>

                                        <? else : ?>
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
                                                                $html = '';
                                                                if ($sliderData->title == '') {
                                                                    if ($row['hours'] == 0 && $row['minutes']) break;
                                                                    $html =  "
                                                                    <p class='HAQ-DI-score'>
                                                                        <span class='HAQ-DI-slider-title'>$sliderData->title</span> 
                                                                        <br> 
                                                                        $sliderData->description
                                                                        <br>
                                                                        $sliderData->rangeDecs
                                                                        </p>
                                                                        <div>
                                                                            <span>Hours: </span>
                                                                            <input class='score-input-value' type='text' value=" . $row['hours'] . " />
                                                                        </div>
                                                                        <br>
                                                                        <div>
                                                                            <span>Minutes: </span>
                                                                            <input class='score-input-value' type='text' value=" . $row['minutes'] . " />
                                                                        </div>
                                                                    ";
                                                                } else {
                                                                    $html =  "<p class='HAQ-DI-score'>
                                                                    <span class='HAQ-DI-slider-title'>$sliderData->title</span> <br> 
                                                                    $sliderData->description
                                                                    <br>
                                                                    $sliderData->rangeDecs
                                                                    <input class='score-input-value' type='text' value=" . $row . " /></p>";
                                                                }
                                                                echo $html;
                                                                break;
                                                            default:
                                                                echo
                                                                "<p>" . $i . " - <b>" . $standatrAnswers[$row] . "</b> </p>";
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
                            <p class="HAQ-DI-score">HAQ Score <input class="score-input-value" type="text" value="<?= $_POST["scores"] ?>" /></p>
                        </div>
                    </div>
            </form>
        </div>
    </div>

</body>

</html>
