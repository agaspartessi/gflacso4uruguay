<?php
defined('MOODLE_INTERNAL') || die();

// First adaptation for Moodle 5.3; pending validation in the testing campus.
$plugin->version = 2026100600;
$plugin->requires = 2026100500;
$plugin->component = 'theme_gflacso4uruguay';

$plugin->dependencies = [
    'theme_boost' => 2026100500,
];

$plugin->maturity = MATURITY_BETA;
$plugin->release = '2.0.0-beta1';
