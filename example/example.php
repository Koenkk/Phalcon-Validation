<?php

include "../src/Validator/Json.php";

$validation = new Phalcon\Validation();

$validation->add(
    "hello",
    new BasilFX\Validation\Validator\Json([
        "schema" => "file://" . dirname(__file__) . "schema.json"
    ])
);

// Validation without errors.
$messages = $validation->validate([
    "hello" => "world"
]);

if (count($messages)) {
    foreach ($messages as $message) {
        echo $message, "\n";
    }
}

// Validation with errors.
$messages = $validation->validate([
    "hello" => 1337
]);

if (count($messages)) {
    foreach ($messages as $message) {
        echo $message, "\n";
    }
}
