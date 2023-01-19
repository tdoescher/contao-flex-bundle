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

#[AsContentElement(category: 'flex')]
class FlexOpenController extends AbstractContentElementController
{
  public static $gutters = ['0', '1', '2', '3', '4', '5'];

  protected function getResponse(Template $template, ContentModel $model, Request $request): Response
  {
    if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
      $template = new BackendTemplate('be_wildcard');

      $wildcard = array();

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

    $segmentation = array();

    if($model->flex_sm) $segmentation['sm'] = explode(':', $model->flex_sm);
    if($model->flex_md) $segmentation['md'] = explode(':', $model->flex_md);
    if($model->flex_xs) $segmentation['xs'] = explode(':', $model->flex_xs);
    if($model->flex_lg) $segmentation['lg'] = explode(':', $model->flex_lg);
    if($model->flex_xl) $segmentation['xl'] = explode(':', $model->flex_xl);
    if($model->flex_xxl) $segmentation['xxl'] = explode(':', $model->flex_xxl);

    $class = array();
    if($model->flex_class) $class = explode(':', $model->flex_class);

    $root = $template->ptable.'.'.$template->pid;

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

    $classes = array();
    $classes[] = $model->flex_bootstrap ? 'row' : 'flex';

    if(in_array($model->flex_justify, ['normal', 'start', 'end', 'center', 'around', 'between', 'evenly'])) {
      $classes[] = 'justify-content-'.$model->flex_justify;
    }

    if(in_array($model->flex_align, ['normal', 'start', 'end', 'center', 'baseline', 'stretch'])) {
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
}