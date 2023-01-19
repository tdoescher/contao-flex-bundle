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
  public static $sizes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'a', 'auto', 'h', 'hidden', 'n', 'none'];

  public static $offsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

  public function __invoke(ContentModel $contentModel, string $buffer, $element): string
  {
    if(!is_array($GLOBALS['TL_FLEX'])) {
      return $buffer;
    }

    $root = $contentModel->ptable.'.'.$contentModel->pid;

    if(!isset($GLOBALS['TL_FLEX'][$root])) {
      $GLOBALS['TL_FLEX'][$root] = [];
    }

    $keys = array_keys($GLOBALS['TL_FLEX'][$root]);

    $currentKey = end($keys);
    $current = $currentKey ? $GLOBALS['TL_FLEX'][$root][$currentKey] : 0;

    $parentKey = prev($keys);
    $parent = $parentKey ? $GLOBALS['TL_FLEX'][$root][$parentKey] : 0;

    if(!in_array($contentModel->type, ['flex_open', 'flex_close', 'flex_div_open', 'flex_div_close']) && $buffer != "") {
      if($currentKey && $current['type'] === 'flex_open') {
        $GLOBALS['TL_FLEX'][$root][$currentKey]['position']++;

        return '<div class="'.self::getClasses($root, $currentKey).'">'.$buffer.'</div>';
      }
    }

    if(in_array($contentModel->type, ['flex_open', 'flex_div_open'])) {
      if($parentKey && $parent['type'] === 'flex_open') {
        $GLOBALS['TL_FLEX'][$root][$parentKey]['position']++;

        return '<div class="'.self::getClasses($root, $parentKey).'">'.$buffer;
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

  public static function getClasses($parent, $id)
  {
    $box = $GLOBALS['TL_FLEX'][$parent][$id];

    if(!$box['bootstrap']) {
      $prefix = 'cell';
      $classes = array('cell', 'cell-'.$box['position']);
    } else {
      $prefix = 'col';
      $classes = array();
    }

    if(is_array($box['segmentation']) && count($box['segmentation'])) {
      
      foreach($box['segmentation'] as $key => $column) {
        $base = ($key != 'xs') ? $key.'-' : null;
        $position = array_key_exists($box['position'] - 1, $column) ? $box['position'] - 1 : null;

        $segmantation = ($box['repeat']) ? $column[$position % count($column)] : $column[$position];

        if($key === 'class') {
          foreach(explode(',', $segmantation) as $key => $segmant) {
            $classes[] = $segmant;
          }

          continue;
        }

        foreach(explode(',', $segmantation) as $key => $segmant) {
          if($key === 0 && in_array($segmant, self::$sizes)) {
            if($segmant === 'h' || $segmant === 'hidden') {
              $classes[] = 'd-'.$base.'none';

              continue;
            }

            if($segmant === 'n' || $segmant === 'none') {
              $classes[] = $prefix.'-'.substr($base, 0, -1);

              continue;
            }

            if($segmant === 'a') {
              $segmant = 'auto';
            }

            $classes[] = $prefix.'-'.$base.$segmant;

            continue;
          }

          if($key === 1 && in_array($segmant, self::$offsets)) {
            $classes[] = 'offset-'.$base.$segmant;

            continue;
          }
        }
      }
    }

    if(count($classes) === 0) {
      $classes[] = $prefix;
    }

    if(is_array($box['class']) && count($box['class'])) {
      if($box['repeat']) {
        $class = $box['class'][($box['position'] - 1) % count($box['class'])];
      } else {
        $class = isset($box['class'][($box['position'] - 1)]) ? $box['class'][($box['position'] - 1)] : null;
      }

      if(!empty($class)) {
        foreach(explode(',', $class) as $key => $segmant) {
          $classes[] = $segmant;
        }
      }
    }

    return implode(' ', $classes);
  }
}
