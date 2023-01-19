<?php

/**
 * This file is part of FlexBundle for Contao
 *
 * @package     tdoescher/flex-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

$GLOBALS['TL_WRAPPERS']['start'][] = 'flex_open';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'flex_close';
$GLOBALS['TL_WRAPPERS']['start'][] = 'flex_div_open';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'flex_div_close';

$GLOBALS['TL_FLEX'] = [];
