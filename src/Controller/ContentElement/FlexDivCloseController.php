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

#[AsContentElement(category:'legacy')]
class FlexDivCloseController extends AbstractContentElementController
{
  protected function getResponse(Template $template, ContentModel $model, Request $request): Response
  {
    if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
      $template = new BackendTemplate('be_wildcard');
    }

    return $template->getResponse();
  }
}
