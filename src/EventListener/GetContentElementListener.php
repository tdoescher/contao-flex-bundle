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

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

#[AsHook('getContentElement', priority: 100)]
class GetContentElementListener
{
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        if (empty($GLOBALS['TL_FLEX'])) {
            return $buffer;
        }

        if ($contentModel->type === 'flex') {
            $root = 'tl_content.' . $contentModel->id;
        } else {
            $root = $contentModel->ptable . '.' . $contentModel->pid;
        }

        if (!isset($GLOBALS['TL_FLEX'][$root])) {
            return $buffer;
        }

        if ($contentModel->type !== 'flex') {
            $GLOBALS['TL_FLEX'][$root]['position']++;
            $buffer = '<div class="' . self::getClass($GLOBALS['TL_FLEX'][$root]) . '">' . $buffer . '</div>';
        }

        if ($contentModel->type === 'flex' && isset($GLOBALS['TL_FLEX'][$GLOBALS['TL_FLEX'][$root]['parent']])) {
            $parentKey = $GLOBALS['TL_FLEX'][$root]['parent'];

            $GLOBALS['TL_FLEX'][$parentKey]['position']++;
            $buffer = '<div class="' . self::getClass($GLOBALS['TL_FLEX'][$parentKey]) . '">' . $buffer . '</div>';
        }

        return $buffer;
    }

    protected static function getClass(array $box): string
    {
        $class = [];

        if ($box['framework'] === '0') {
            $class[] = 'cell';
            $class[] = 'cell-' . $box['position'];
        }

        if (count($box['segmentation']) && in_array($box['framework'], ['1', '2'])) {
            foreach ($box['segmentation'] as $column) {
                $position = ($box['repeat']) ? ($box['position'] - 1) % count($column['classes']) : $box['position'] - 1;

                if (isset($column['classes'][$position])) {
                    $class[] = $column['classes'][$position];
                }
            }
        }

        if (in_array($box['framework'], ['1', '2'])) {
            if (count($class) === 0) {
                $class[] = 'col';
            }
        }

        if (count($box['class']) && $box['class'][0] !== '') {
            $position = ($box['repeat']) ? ($box['position'] - 1) % count($box['class']) : $box['position'] - 1;

            if (isset($box['class'][$position])) {
                $class[] = $box['class'][$position];
            }
        }

        return trim(implode(' ', $class));
    }
}
