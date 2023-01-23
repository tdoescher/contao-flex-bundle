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

#[AsContentElement(category:'flex')]
class FlexDivOpenController extends AbstractContentElementController
{
  protected function getResponse(Template $template, ContentModel $model, Request $request): Response
  {
    if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
      $template = new BackendTemplate('be_wildcard');

      if(unserialize($model->cssID)[1]) $template->wildcard = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_main_class'].':</strong> '.unserialize($model->cssID)[1];

      return $template->getResponse();
    }

    $root = $model->ptable.'.'.$model->pid;

    if(!isset($GLOBALS['TL_FLEX'][$root])) {
      $GLOBALS['TL_FLEX'][$root] = [];
    }

    $key = count($GLOBALS['TL_FLEX'][$root]) + 1;

    $GLOBALS['TL_FLEX'][$root][$key] = ['type' => $model->type];

    return $template->getResponse();
  }
}