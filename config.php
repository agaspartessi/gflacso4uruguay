<?php
defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/lib.php');

$THEME->name = 'gflacso4uruguay';
$THEME->parents = ['boost'];
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->yuicssmodules = [];
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->enable_dock = false;
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
$THEME->hidefromselector = false;
$THEME->haseditswitch = true;
$THEME->removedprimarynavitems = ['home'];

// Boost already supplies brandcolor and Raw initial SCSS before this callback.
$THEME->prescsscallback = 'theme_gflacso4uruguay_get_pre_scss';

// Keep post.scss here so Boost's inherited extra callback adds Raw SCSS last,
// exactly once. Registering a second raw-SCSS callback would duplicate it.
$THEME->scss = function($theme) {
    return theme_gflacso4uruguay_get_main_scss_content($theme);
};
