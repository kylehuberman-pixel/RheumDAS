<?php

$standatrAnswers = [
    'Without ANY Difficulty',
    'With SOME Difficulty',
    'With MUCH Difficulty',
    'UNABLE to do'
];

$questions = [
    (object)[
        "title" => "Dressing & Grooming",
        "required" => true,
        "type" => "radio",
        "block" => [
            'Dress yourself, including tying shoelaces and doing buttons?',
            'Shampoo your hair?'
        ]
    ],
    (object)[
        "title" => "Arising",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Stand up from an armless chair?",
            "Get in and out of bed?"
        ]
    ],
    (object)[
        "title" => "Eating",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Cut up your own meat or vegetables?",
            "Lift a full cup or glass to your mouth?",
            "Open a new carton of milk (or soap powder)?"
        ]
    ],
    (object)[
        "title" => "Walking",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Walk outdoors on flat ground?",
            "Climb up five steps?"
        ]
    ],
    (object)[
        "title" => "Aids & Devices",
        "required" => false,
        "type" => "checkbox",
        "block" => [
            "Please check any AIDS OR DEVICES that you use more than 50% of the time for any of the above activities:" => [
                "Devices used for Dressing (button hook, zipper pull, etc.)" => "Dressing & Grooming",
                "Built up or special utensils" =>  "Eating",
                "Special or built up chair" => "Arising",
                "Cane or Walker" => "Walking",
                "Crutches" => "Walking",
                "Wheelchair" => "Walking"
            ],
            "Please check any categories for which you need HELP FROM ANOTHER PERSON more than 50% of the time:" => [
                "Dressing & Grooming" => "Dressing & Grooming",
                "Arising" => "Arising",
                "Eating" => "Eating",
                "Walking" => "Walking"
            ]
        ]
    ],
    (object)[
        "title" => "Hygiene",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Wash and dry your entire body?",
            "Get up off the floor?",
            "Get on and off the toilet?"
        ]
    ],
    (object)[
        "title" => "Reach",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Reach and get down a 5 lb object (e.g. a bag of potatoes) from just above your head?",
            "Bend down to pick up clothing off the floor?"
        ]
    ],
    (object)[
        "title" => "Grip",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Open car doors?",
            "Open jars which have been previously opened?",
            "Turn taps on and off?"
        ]
    ],
    (object)[
        "title" => "Activities",
        "required" => true,
        "type" => "radio",
        "block" => [
            "Run errands and shop?",
            "Get in and out of a car?",
            "Do chores such as vacuuming, housework or light gardening?"
        ]
    ],
    (object)[
        "title" => "Aids & Devices",
        "required" => false,
        "type" => "checkbox",
        "block" => [
            "Please check any AIDS OR DEVICES that you use more than 50% of the time for any of the above activities:" => [
                "Raised toilet seat (H)" => "Hygiene",
                "Bath rail (H)" => "Hygiene",
                "Bath seat (H)" => "Hygiene",
                "Long-handled appliances for reach (R)" => "Reach",
                "Jar opener (for jars previously opened) (G)" => "Grip"
            ],
            "Please check any categories for which you need HELP FROM ANOTHER PERSON more than 50% of the time:" => [
                "Hygiene" => "Hygiene",
                "Gripping and opening things" => "Grip",
                "Reach" => "Reach",
                "Errands and housework" => "Activities"
            ],
        ]
    ],
    (object)[
        "title" => "Your Pain & Overall Wellness",
        "required" => false,
        "type" => "slider",
        "block" => [
            (object)[
                'title' => "Your Pain",
                'description' => "How much pain have you had IN THE PAST WEEK?",
                'rangeDecs' => "On a scale of 0 to 100, please record the number",
                'range' => (object)["min" => 0, "max" => 100],
            ],
            (object)[
                'title' => "Global Assessment",
                'description' => "How has your health been IN THE PAST WEEK specifically related to your arthritis?",
                'rangeDecs' => "On a scale of 0 to 100, please record the number",
                'range' => (object)["min" => 0, "max" => 100],
            ],
            (object)[
                'title' => "",
                'description' => "How long do your joints feel stiff when you wake up in the morning?",
                'rangeDecs' => "",
                'range' => (object)["min" => 0, "max" => 10],
            ],
        ]
    ],
];
