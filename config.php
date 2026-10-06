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

/**
 * Main SCSS: only the selected Boost preset.
 * Pre and post SCSS are injected through Moodle's native callbacks.
 */
$THEME->scss = function($theme) {
    return theme_gflacso4uruguay_get_main_scss_content($theme);
};

/**
 * Native Moodle callbacks.
 */
$THEME->prescsscallback = 'theme_gflacso4uruguay_get_pre_scss';
$THEME->extrascsscallback = 'theme_gflacso4uruguay_get_extra_scss';
