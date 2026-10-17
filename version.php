<?php
defined('MOODLE_INTERNAL') || die();

// Moodle 5.3 adaptation; validate with real campus courses and settings.
$plugin->version = 2026101703;
$plugin->requires = 2026100500;
$plugin->component = 'theme_gflacso4uruguay';

$plugin->dependencies = [
    'theme_boost' => 2026100500,
];

$plugin->maturity = MATURITY_BETA;
$plugin->release = '2.0.0-beta6';
