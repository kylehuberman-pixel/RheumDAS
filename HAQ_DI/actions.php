<?php
require_once '../lib/csrf.php';
csrf_check();

$action = isset($_POST['action']) ? $_POST['action'] : 'send';

if ($action == 'print') {
    include 'print.php';
} else {
    include 'email.php';

    if ($action == 'send') {

        $validEmail = false;
        $emailTo = $_POST['email'];
        if (!filter_var($emailTo, FILTER_VALIDATE_EMAIL)) die('Invalid email');

        echo send($emailTo, 'Health Assessment Questionnaire for Rheumatoid Arthritis')['message'];
    } else if ($action == 'specialist') {
        $esc = function ($v) {
            return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
        };
        $html = "<ul>
        <li>Name - " . $esc($_POST['name'] ?? '') . "</li>
        <li>Last Name - " . $esc($_POST['lname'] ?? '') . "</li>
        <li>Birthday - " . $esc($_POST['birth'] ?? '') . "</li>
        <li>Healthcare - " . $esc($_POST['healthcare'] ?? '') . "</li>
    </ul>";
        $notification = "";
        foreach (explode(';', $_POST['practitionerEmail']) as $row) {
            $notification = send($row, $html)['message'];
        }
        echo $notification;
    }
}
