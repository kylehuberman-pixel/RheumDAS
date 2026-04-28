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
        include 'practitioners.php';
        $allowed = [];
        foreach ($practitioners as $p) {
            $allowed[strtolower($p->email)] = true;
        }

        $requested = explode(';', (string)($_POST['practitionerEmail'] ?? ''));
        $recipients = [];
        foreach ($requested as $candidate) {
            $candidate = trim($candidate);
            if ($candidate === '' || !filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            if (isset($allowed[strtolower($candidate)])) {
                $recipients[] = $candidate;
            }
        }

        if (empty($recipients)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failure', 'message' => 'No valid practitioner selected.']);
            exit;
        }

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
        foreach ($recipients as $row) {
            $notification = send($row, $html)['message'];
        }
        echo $notification;
    }
}
