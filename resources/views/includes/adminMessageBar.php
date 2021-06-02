<?php

if(session()->get('error')) {

    echo '<div class="alert alert-danger"><ul class="ml-4 mb-0">';

    foreach (session()->get('error') as $err) {
        echo "<li>$err</li>";
    }
    echo '</ul></div>';
    session()->resetError();
}


if(session()->get('success')) {

    echo '<div class="alert alert-success"><ul class="ml-4 mb-0">';

    foreach (session()->get('success') as $success) {
        echo "<li>$success</li>";
    }
    echo '</ul></div>';
    session()->resetSuccess();
}


