<?php

if(session()->get('error')) {

    echo '<div class="login__error d-block"><ul>';

    foreach (session()->get('error') as $err) {
        echo "<li>$err</li>";
    }
    echo '</ul></div>';
}
session()->resetError();

if(session()->get('success')) {

    echo '<div class="login__error d-block success"><ul>';

    foreach (session()->get('success') as $success) {
        echo "<li>$success</li>";
    }
    echo '</ul></div>';
}

session()->resetSuccess();
