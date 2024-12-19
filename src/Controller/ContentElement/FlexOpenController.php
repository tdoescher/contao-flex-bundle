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
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'legacy')]
class FlexOpenController extends AbstractContentElementController
{
  protected static $displays = ['h', 'hidden', 's', 'show'];

  protected static $sizes = ['a', 'auto', 'n', 'none', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

  protected static $offsets = ['', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

  protected static $orders = ['f', 'first', 'l', 'last', '0', '1', '2', '3', '4', '5'];

  protected function getResponse(Template $template, ContentModel $model, Request $request): Response
  {
    if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
      $template = new BackendTemplate('be_wildcard');

      $wildcard = [];
      if($model->flex_xs) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xs'][0].':</strong> '.$model->flex_xs;
      }
      if($model->flex_sm) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_sm'][0].':</strong> '.$model->flex_sm;
      }
      if($model->flex_md) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_md'][0].':</strong> '.$model->flex_md;
      }
      if($model->flex_lg) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_lg'][0].':</strong> '.$model->flex_lg;
      }
      if($model->flex_xl) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xl'][0].':</strong> '.$model->flex_xl;
      }
      if($model->flex_xxl) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xxl'][0].':</strong> '.$model->flex_xxl;
      }
      if($model->flex_class) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_class'][0].':</strong> '.$model->flex_class;
      }
      if($model->flex_container_class) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_container_class'][0].':</strong> '.$model->flex_container_class;
      }
      if(unserialize($model->cssID)[1]) {
        $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_main_class'].':</strong> '.unserialize($model->cssID)[1];
      }
 
      $template->wildcard = implode(' - ', $wildcard);

      return $template->getResponse();
    }

    $root = $template->ptable.'.'.$template->pid;

    $segmentation = [];
    if($model->flex_sm) {
      $segmentation['sm'] = self::makeSegmantationClasses($model->flex_sm, 'sm', $model->flex_bootstrap);
    }
    if($model->flex_md) {
      $segmentation['md'] = self::makeSegmantationClasses($model->flex_md, 'md', $model->flex_bootstrap);
    }
    if($model->flex_xs) {
      $segmentation['xs'] = self::makeSegmantationClasses($model->flex_xs, 'xs', $model->flex_bootstrap);
    }
    if($model->flex_lg) {
       $segmentation['lg'] = self::makeSegmantationClasses($model->flex_lg, 'lg', $model->flex_bootstrap);
    }
    if($model->flex_xl) {
      $segmentation['xl'] = self::makeSegmantationClasses($model->flex_xl, 'xl', $model->flex_bootstrap);
    }
    if($model->flex_xxl) {
      $segmentation['xxl'] = self::makeSegmantationClasses($model->flex_xxl, 'xxl', $model->flex_bootstrap);
    }

    $cellClass = self::makeClasses($model->flex_class);

    if(!isset($GLOBALS['TL_FLEX_LEGACY'])) {
      $GLOBALS['TL_FLEX_LEGACY'] = [];
    }

    if(!isset($GLOBALS['TL_FLEX_LEGACY'][$root])) {
      $GLOBALS['TL_FLEX_LEGACY'][$root] = [];
    }

    $key = count($GLOBALS['TL_FLEX_LEGACY'][$root]) + 1;

    $GLOBALS['TL_FLEX_LEGACY'][$root][$key] = [
      'type' => $model->type,
      'position' => 0,
      'bootstrap' => $model->flex_bootstrap,
      'repeat' => $model->flex_repeat,
      'segmentation' => $segmentation,
      'class' => $cellClass
    ];

    $containerClass = [];
    $containerClass[] = $model->flex_bootstrap ? 'row' : 'flex';

    if(in_array($model->flex_justify, ['start', 'end', 'center', 'around', 'between', 'evenly'])) {
      $containerClass[] = 'justify-content-'.$model->flex_justify;
    }

    if(in_array($model->flex_align, ['start', 'end', 'center', 'baseline', 'stretch'])) {
      $containerClass[] = 'align-items-'.$model->flex_align;
    }

    if($model->flex_gutter === $model->flex_gutter_y && $model->flex_gutter != 'd') {
      if(in_array($model->flex_gutter, ['0', '1', '2', '3', '4', '5'])) {
        $containerClass[] = 'g-'.$model->flex_gutter;
      }
    }
    elseif($model->flex_gutter != 'd') {
      if(in_array($model->flex_gutter, ['0', '1', '2', '3', '4', '5'])) {
        $containerClass[] = 'gx-'.$model->flex_gutter;
      }
      
      if(in_array($model->flex_gutter_y, ['0', '1', '2', '3', '4', '5'])) {
        $containerClass[] = 'gy-'.$model->flex_gutter_y;
      }
    }

    if($model->flex_container_class) {
      $containerClass[] = $model->flex_container_class;
    }

    $template->containerClass = implode(' ', $containerClass);
    $template->cssID = $template->cssID ?: ' id="flex-'.$model->id.'"';

    return $template->getResponse();
  }

  protected static function makeSegmantationClasses($segmentation, $base, $bootstrap)
  {
    $cells = explode(':', $segmentation);
    $class = [];

    $prefix = $bootstrap ? 'col' : 'cell';
    $base = ($base !== 'xs') ? '-'.$base : null;

    foreach($cells as $cell) {
      $options = explode(',', $cell);
      $cellClass = [];

      if(count($options) === 0 || !$bootstrap) {
        continue;
      }

      if(in_array(current($options), self::$displays, true)) {
        $display = current($options);

        if($display === 'h' || $display === 'hidden') {
          $cellClass[] = 'd'.$base.'-none';
        }
        else if($display === 's' || $display === 'show') {
          $cellClass[] = 'd'.$base.'-block';
        }

        next($options);
      }

      if(in_array(current($options), self::$sizes, true)) {
        $size = current($options);

        if($size === 'n' || $size === 'none') {
          $cellClass[] = $prefix.$base;
        }
        else if($size === 'a') {
          $cellClass[] = $prefix.$base.'-auto';
        }
        else {
          $cellClass[] = $prefix.$base.'-'.$size;
        }

        next($options);
      }

      if(in_array(current($options), self::$offsets, true)) {
        $offset = current($options);

        if(current($options) !== '') {
          $cellClass[] = 'offset'.$base.'-'.$offset;
        }

        next($options);
      }

      if(in_array(current($options), self::$orders, true)) {
        $order = current($options);

        if($order === 'f') {
          $cellClass[] = 'order'.$base.'-last';
        }
        else if($order === 'l') {
          $cellClass[] = 'order'.$base.'-last';
        }
        else {
          $cellClass[] = 'order'.$base.'-'.$order;
        }

        next($options);
      }

      $class[] = (count($cellClass)) ? implode(' ', $cellClass) : null;
    }

    return $class;
  }

  protected static function makeClasses($class)
  {
    $cells = explode(':', $class);
    $class = [];

    foreach($cells as $cell) {
      $class[] = ($cell !== '') ? str_replace(',', ' ', $cell) : null;
    }

    return $class;
  }
}
