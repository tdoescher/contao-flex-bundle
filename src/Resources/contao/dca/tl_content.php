<?php

/**
 * This file is part of FlexBundle for Contao
 *
 * @package     tdoescher/flex-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['flex'] = '{type_legend},type;{flex_legend},flex_xs,flex_sm,flex_md,flex_lg,flex_xl,flex_xxl;{flex_extended_legend},flex_class,flex_repeat,flex_bootstrap,flex_multiline,flex_justify,flex_align,flex_gutter,flex_gutter_y,flex_container_class;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xs'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_sm'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_md'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'clr w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_lg'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xl'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'clr w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xxl'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_class'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'flex', 'maxlength' => '255'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_repeat'] = [
    'exclude' => true,
    'default' => 1,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_bootstrap'] = [
    'exclude' => true,
    'default' => 1,
    'inputType' => 'select',
    'options' => ['0', '1', '2'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_bootstrap_options'],
    'eval' => ['helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_justify'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['normal', 'start', 'end', 'center', 'around', 'between', 'evenly'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_justify_options'],
    'eval' => ['helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'],
    'sql' => "varchar(7) NOT NULL default 'normal'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_align'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['normal', 'start', 'end', 'center', 'baseline', 'stretch'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_align_options'],
    'eval' => ['helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default 'normal'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_gutter'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['d', '0', '1', '2', '3', '4', '5'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_gutter_options'],
    'eval' => ['helpwizard' => false, 'chosen' => false, 'tl_class' => 'clr w50'],
    'sql' => "varchar(1) NOT NULL default 'd'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_gutter_y'] = [
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['d', '0', '1', '2', '3', '4', '5'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_gutter_options'],
    'eval' => ['helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'],
    'sql' => "varchar(1) NOT NULL default 'd'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_container_class'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => '255', 'tl_class' => 'clr'],
    'sql' => "varchar(255) NOT NULL default ''"
];
