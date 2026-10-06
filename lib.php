<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Returns the selected Boost preset.
 *
 * Order handled by Moodle:
 * 1. prescsscallback  -> pre.scss + Raw initial SCSS
 * 2. scss             -> Boost preset
 * 3. extrascsscallback -> post.scss + Raw SCSS
 *
 * @param theme_config $theme
 * @return string
 */
function theme_gflacso4uruguay_get_main_scss_content($theme): string {
    global $CFG;

    $preset = get_config('theme_gflacso4uruguay', 'preset') ?: 'default.scss';

    if ($preset === 'plain.scss') {
        $presetpath = $CFG->dirroot . '/theme/boost/scss/preset/plain.scss';
        return is_readable($presetpath) ? file_get_contents($presetpath) : '';
    }

    if ($preset === 'default.scss') {
        $presetpath = $CFG->dirroot . '/theme/boost/scss/preset/default.scss';
        return is_readable($presetpath) ? file_get_contents($presetpath) : '';
    }

    $fs = get_file_storage();
    $context = context_system::instance();

    $presetfile = $fs->get_file(
        $context->id,
        'theme_gflacso4uruguay',
        'preset',
        0,
        '/',
        $preset
    );

    if ($presetfile) {
        return $presetfile->get_content();
    }

    $fallback = $CFG->dirroot . '/theme/boost/scss/preset/default.scss';
    return is_readable($fallback) ? file_get_contents($fallback) : '';
}

/**
 * Prepends SCSS before the Boost preset.
 * This is where variables should go.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_gflacso4uruguay_get_pre_scss($theme): string {
    global $CFG;

    $scss = '';

    $prepath = $CFG->dirroot . '/theme/gflacso4uruguay/scss/pre.scss';

    if (is_readable($prepath)) {
        $scss .= file_get_contents($prepath) . "\n";
    }

    $brandcolor = get_config('theme_gflacso4uruguay', 'brandcolor');
    if (!empty($brandcolor)) {
        $scss .= '$primary: ' . $brandcolor . ";\n";
    }

    $rawpre = get_config('theme_gflacso4uruguay', 'scsspre');
    if (!empty($rawpre)) {
        $scss .= $rawpre . "\n";
    }

    return $scss;
}

/**
 * Appends SCSS after the Boost preset.
 * This is where final theme rules and admin Raw SCSS should go.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_gflacso4uruguay_get_extra_scss($theme): string {
    global $CFG;

    $scss = '';

    $postpath = $CFG->dirroot . '/theme/gflacso4uruguay/scss/post.scss';

    if (is_readable($postpath)) {
        $scss .= file_get_contents($postpath) . "\n";
    }

    $rawpost = get_config('theme_gflacso4uruguay', 'scss');
    if (!empty($rawpost)) {
        $scss .= $rawpost . "\n";
    }

    return $scss;
}
