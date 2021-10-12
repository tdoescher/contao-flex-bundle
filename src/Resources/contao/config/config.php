<?php

$GLOBALS['TL_HOOKS']['getContentElement'][] = array('tdoescher\FlexBundle\Flex', 'getContentElementHook');
$GLOBALS['TL_HOOKS']['addCustomRegexp'][] = array('tdoescher\FlexBundle\Flex', 'addCustomRegexpHook');

$GLOBALS['TL_CTE']['flex']['flex_open'] = 'tdoescher\FlexBundle\FlexOpen';
$GLOBALS['TL_CTE']['flex']['flex_close'] = 'tdoescher\FlexBundle\FlexClose';
$GLOBALS['TL_CTE']['flex']['flex_div_open'] = 'tdoescher\FlexBundle\FlexDivOpen';
$GLOBALS['TL_CTE']['flex']['flex_div_close'] = 'tdoescher\FlexBundle\FlexDivClose';

$GLOBALS['TL_WRAPPERS']['start'][] = 'flex_open';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'flex_close';
$GLOBALS['TL_WRAPPERS']['start'][] = 'flex_div_open';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'flex_div_close';

$GLOBALS['TL_FLEX'] = [];
