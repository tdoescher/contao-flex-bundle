<?php

/**
 * This file is part of FlexBundle for Contao
 *
 * @package     tdoescher/flex-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

namespace tdoescher\FlexBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\ContentElement;
use Contao\ContentModel;

#[AsHook('getContentElement', priority: 100)]
class GetContentElementListener
{
  public static $displays = ['h', 'hidden', 's', 'show'];

  public static $sizes = ['a', 'auto', 'n', 'none', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

  public static $offsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
  
  public static $orders = ['f', 'first', 'l', 'last', '0', '1', '2', '3', '4', '5'];

  public function __invoke(ContentModel $contentModel, string $buffer, $element): string
  {
    if(!is_array($GLOBALS['TL_FLEX'])) {
      return $buffer;
    }

    if($contentModel->type === 'flex') {
      $root = 'tl_content.'.$contentModel->id;
    } else {
      $root = $contentModel->ptable.'.'.$contentModel->pid;
    }

    if(!isset($GLOBALS['TL_FLEX'][$root])) {
      $GLOBALS['TL_FLEX'][$root] = [];
    }

    $keys = array_keys($GLOBALS['TL_FLEX'][$root]);

    $currentKey = end($keys);
    $current = $currentKey ? $GLOBALS['TL_FLEX'][$root][$currentKey] : 0;

    $parentKey = prev($keys);
    $parent = $parentKey ? $GLOBALS['TL_FLEX'][$root][$parentKey] : 0;

    if(!in_array($contentModel->type, ['flex', 'flex_open', 'flex_close', 'flex_div_open', 'flex_div_close']) && $buffer != "") {
      if($currentKey && in_array($current['type'], ['flex', 'flex_open'])) {
        $GLOBALS['TL_FLEX'][$root][$currentKey]['position']++;

        return '<div class="'.self::getClass($GLOBALS['TL_FLEX'][$root][$currentKey]).'">'.$buffer.'</div>';
      }
    }

    if(in_array($contentModel->type, ['flex', 'flex_open', 'flex_div_open'])) {
      if($parentKey && in_array($parent['type'], ['flex', 'flex_open'])) {
        $GLOBALS['TL_FLEX'][$root][$parentKey]['position']++;

        return '<div class="'.self::getClass($GLOBALS['TL_FLEX'][$root][$parentKey]).'">'.$buffer;
      }
    }

    if(in_array($contentModel->type, ['flex_close', 'flex_div_close'])) {
      unset($GLOBALS['TL_FLEX'][$root][$currentKey]);

      if($parentKey && $parent['type'] === 'flex_open') {
        return $buffer.'</div>';
      }
    }

    return $buffer;
  }

  protected static function getClass($box)
  {
    $class = [];

    if(count($box['segmentation']) && $box['bootstrap']) {
      foreach($box['segmentation'] as $key => $column) {
        $position = ($box['repeat']) ? ($box['position'] - 1) % count($column) : $box['position'] - 1;

        if(isset($column[$position])) {
          $class[] = $column[$position];
        }
      }
    }

    if($box['bootstrap']) {
      if(count($class) === 0 || $class[0] === null) {
        $class[] = 'col';
      }
    }

    if(!$box['bootstrap']) {
      $class[] = 'cell';
      $class[] = 'cell-'.$box['position'];
    }

    if(count($box['class']) && $box['class'][0] !== '') {
      $position = ($box['repeat']) ? ($box['position'] - 1) % count($box['class']) : $box['position'] - 1;

      if(isset($box['class'][$position])) {
        $class[] = $box['class'][$position];
      }
    }

    return trim(implode(' ', $class));
  }
}
