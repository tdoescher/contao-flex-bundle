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
use Contao\Widget;

#[AsHook('addCustomRegexp', priority: 100)]
class AddCustomRegexpListener
{
  public function __invoke(string $regexp, $input, Widget $widget): bool
  {
    if($regexp !== 'flex') {
      return false;
    }

    if(!preg_match('/^[,:\-0-9a-z]*$/', $input)) {
      $widget->addError($widget->label.' is not valid.');
    }

    return true;
  }
}
