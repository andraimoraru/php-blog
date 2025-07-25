<?php
// Simple page redirect helper
function redirect($page) {
    header("Location: " . URLROOT . "/" . $page);
    exit();
}