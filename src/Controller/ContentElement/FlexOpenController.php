<?php

/**
 * This file is part of FlexBundle for Contao
 *
 * @package     tdoescher/flex-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */
 
namespace tdoescher\FlexBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\ContentModel;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tdoescher\FlexBundle;

#[AsContentElement(category: 'flex')]
class FlexOpenController extends AbstractContentElementController
{
  public static $displays = ['h', 'hidden', 's', 'show'];
  
  public static $sizes = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'a', 'auto', 'n', 'none'];
  
  public static $offsets = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
  
  public static $orders = ['0', '1', '2', '3', '4', '5', 'f', 'first', 'l', 'last'];

  protected function getResponse(Template $template, ContentModel $model, Request $request): Response
  {
    if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
      $template = new BackendTemplate('be_wildcard');

      $wildcard = [];

      if($model->flex_xs) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xs'][0].':</strong> '.$model->flex_xs;
      if($model->flex_sm) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_sm'][0].':</strong> '.$model->flex_sm;
      if($model->flex_md) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_md'][0].':</strong> '.$model->flex_md;
      if($model->flex_lg) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_lg'][0].':</strong> '.$model->flex_lg;
      if($model->flex_xl) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xl'][0].':</strong> '.$model->flex_xl;
      if($model->flex_xxl) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xxl'][0].':</strong> '.$model->flex_xxl;
      if($model->flex_class) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_class'][0].':</strong> '.$model->flex_class;
      if($model->flex_container_class) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_container_class'][0].':</strong> '.$model->flex_container_class;
      if(unserialize($model->cssID)[1]) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_main_class'].':</strong> '.unserialize($model->cssID)[1];
 
      $template->wildcard = implode(' - ', $wildcard);
        
      return $template->getResponse();
    }

    $root = $template->ptable.'.'.$template->pid;

    $segmentation = [];
    if($model->flex_sm) $segmentation['sm'] = self::getSegmantation($model->flex_sm, 'sm', $model->flex_bootstrap);
    if($model->flex_md) $segmentation['md'] = self::getSegmantation($model->flex_md, 'md', $model->flex_bootstrap);
    if($model->flex_xs) $segmentation['xs'] = self::getSegmantation($model->flex_xs, 'xs', $model->flex_bootstrap);
    if($model->flex_lg) $segmentation['lg'] = self::getSegmantation($model->flex_lg, 'lg', $model->flex_bootstrap);
    if($model->flex_xl) $segmentation['xl'] = self::getSegmantation($model->flex_xl, 'xl', $model->flex_bootstrap);
    if($model->flex_xxl) $segmentation['xxl'] = self::getSegmantation($model->flex_xxl, 'xxl', $model->flex_bootstrap);

    $class = self::getClasses($model->flex_class);

    if(!isset($GLOBALS['TL_FLEX'][$root])) {
      $GLOBALS['TL_FLEX'][$root] = [];
    }

    $key = count($GLOBALS['TL_FLEX'][$root]) + 1;

    $GLOBALS['TL_FLEX'][$root][$key] = [
      'type' => $model->type,
      'position' => 0,
      'bootstrap' => $model->flex_bootstrap,
      'repeat' => $model->flex_repeat,
      'segmentation' => $segmentation,
      'class' => $class
    ];

    $classes = [];
    $classes[] = $model->flex_bootstrap ? 'row' : 'flex';

    if(in_array($model->flex_justify, ['start', 'end', 'center', 'around', 'between', 'evenly'])) {
      $classes[] = 'justify-content-'.$model->flex_justify;
    }

    if(in_array($model->flex_align, ['start', 'end', 'center', 'baseline', 'stretch'])) {
      $classes[] = 'align-items-'.$model->flex_align;
    }

    if(in_array($model->flex_gutter, ['0', '1', '2', '3', '5'])) {
      $classes[] = 'gx-'.$model->flex_gutter;
    }

    if($model->flex_container_class) {
      $classes[] = $model->flex_container_class;
    }

    $template->containerClass = implode(' ', $classes);
    $template->cssID = $template->cssID ?: ' id="flex-'.$model->id.'"';

    return $template->getResponse();
  }

  protected static function getSegmantation($segmantation, $base, $bootstrap)
  {
    $columns = explode(':', $segmantation);
    $classes = [];
 
    foreach($columns as $key => $column) {
      $prefix = $bootstrap ? 'col' : 'cell';
      $base = ($base !== 'xs') ? $base : null;
      $options = explode(',', $column);

      if(!array_key_exists(0, $options) || !$bootstrap) {
        continue;
      }

      $optionKeySize = 0;
      $optionKeyOffset = 1;
      $optionKeyOrder = 2;

//       if(in_array($options[0], self::$displays)) {
//         $optionKeySize = 1;
//         $optionKeyOffset = 2;
//         $optionKeyOrder = 3;
// 
//         if($options[0] === 'h' || $options[0] === 'hidden') {
//           $classes[] = 'd-'.$base.'-none';
//         }
//         else if($options[0] === 's' || $options[0] === 'show') {
//           $classes[] = 'd-'.$base.'-block';
//         }
//       }

      if(array_key_exists($optionKeySize, $options) && in_array($options[$optionKeySize], self::$sizes)) {
        if($options[$optionKeySize] === 'n' || $options[$optionKeySize] === 'none') {
          $classes[] = $prefix.'-'.$base;
        }
        else if($options[$optionKeySize] === 'a') {
          $classes[] = $prefix.'-'.$base.'-auto';
        }
        else {
          $classes[] = $prefix.'-'.$base.'-'.$options[$optionKeySize];
        }
      }

      if(array_key_exists($optionKeyOffset, $options) && in_array($options[$optionKeyOffset], self::$offsets)) {
        $classes[] = 'offset-'.$base.'-'.$options[$optionKeyOffset];
      }

      if(array_key_exists($optionKeyOrder, $options) && in_array($options[$optionKeyOrder], self::$orders)) {
        if($options[$optionKeyOrder] === 'f') {
          $classes[] = 'order-'.$base.'-last';
        }
        else if($options[(1 + $position)] === 'l') {
          $classes[] = 'order-'.$base.'-last';
        }
        else {
          $classes[] = 'order-'.$base.'-'.$options[$optionKeyOrder];
        }
      }
    }

    return $classes;
  }

  protected static function getClasses($classes)
  {
    $columns = explode(':', $classes);
    $classes = [];

    foreach($columns as $key => $column) {
      $classes[] = str_replace(',', ' ', $column);
    }

    return $classes;
  }
}
