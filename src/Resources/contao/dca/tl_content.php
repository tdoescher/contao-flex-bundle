<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['flex_open'] = '{type_legend},type;{flex_legend},flex_xs,flex_sm,flex_md,flex_lg,flex_xl,flex_xxl;{flex_extended_legend},flex_class,flex_repeat,flex_bootstrap,flex_multiline,flex_justify,flex_align,flex_container_class;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['flex_close'] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['flex_div_open'] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['flex_div_close'] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xs'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_xs'],
    'exclude'    => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_sm'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_sm'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_md'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_md'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'clr w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_lg'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_lg'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xl'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_xl'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'clr w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_xxl'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_xxl'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'tl_class' => 'w50', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_class'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_class'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'flex', 'maxlength' => '255'),
    'sql'       => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_repeat'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_repeat'],
    'exclude'   => true,
    'default'   => 1,
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'clr w50'),
    'sql'       => "char(1) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_bootstrap'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_bootstrap'],
    'exclude'   => true,
    'default'   => 1,
    'inputType' => 'checkbox',
    'eval'      => array('tl_class' => 'w50'),
    'sql'       => "char(1) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_justify'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_justify'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('normal', 'start', 'end', 'center', 'around', 'between'),
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_justify_options'],
    'eval'      => array('helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'),
    'sql'       => array('name' => 'flex_justify', 'type' => 'string', 'length' => 13, 'default' => 'normal')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_align'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_align'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('normal', 'start', 'end', 'center', 'baseline', 'stretch'),
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['flex_align_options'],
    'eval'      => array('helpwizard' => false, 'chosen' => false, 'tl_class' => 'w50'),
    'sql'       => array('name' => 'flex_align', 'type' => 'string', 'length' => 13, 'default' => 'normal')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['flex_container_class'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['flex_container_class'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('maxlength' => '255', 'tl_class' => 'clr'),
    'sql'       => "varchar(255) NOT NULL default ''"
);
