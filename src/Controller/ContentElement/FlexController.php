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

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous', nestedFragments: true)]
class FlexController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $wildcard = [];

            foreach (['xs', 'sm', 'md', 'lg', 'xl', 'xxl', 'class', 'container_class'] as $field) {
                if ($model->{'flex_' . $field}) {
                    $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_' . $field][0] . ':</strong> ' . $model->{'flex_' . $field};
                }
            }
            if (unserialize($model->cssID)[1]) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_main_class'] . ':</strong> ' . unserialize($model->cssID)[1];
            }

            $template->wildcard = implode(' - ', $wildcard);
        }

        $segmentation = [];
        foreach (['xs', 'sm', 'md', 'lg', 'xl', 'xxl'] as $field) {
            if ($model->{'flex_' . $field}) {
                $segmentation[$field] = self::makeSegmantation($model->{'flex_' . $field}, $field, $model->flex_bootstrap);
            }
        }

        $cellClass = self::makeClasses($model->flex_class);

        if (!isset($GLOBALS['TL_FLEX'])) {
            $GLOBALS['TL_FLEX'] = [];
        }

        $GLOBALS['TL_FLEX']['tl_content.' . $model->id] = [
            'type' => $model->type,
            'position' => 0,
            'parent' => $model->ptable . '.' . $model->pid,
            'framework' => $model->flex_bootstrap,
            'repeat' => $model->flex_repeat,
            'segmentation' => $segmentation,
            'class' => $cellClass
        ];

        $containerClass = [];

        switch ($model->flex_bootstrap) {
            case '0':
                $containerClass[] = 'flex';
                break;
            case '1':
                $containerClass[] = 'row';
                break;
            case '2':
                $containerClass[] = 'grid';
                break;
        }

        if (in_array($model->flex_justify, ['start', 'end', 'center', 'around', 'between', 'evenly'])) {
            $containerClass[] = 'justify-content-' . $model->flex_justify;
        }

        if (in_array($model->flex_align, ['start', 'end', 'center', 'baseline', 'stretch'])) {
            $containerClass[] = 'align-items-' . $model->flex_align;
        }

        if ($model->flex_gutter === $model->flex_gutter_y && in_array($model->flex_gutter, ['0', '1', '2', '3', '4', '5'])) {
            $containerClass[] = 'g-' . $model->flex_gutter;
        }
        else {
            if (in_array($model->flex_gutter, ['0', '1', '2', '3', '4', '5'])) {
                $containerClass[] = 'gx-' . $model->flex_gutter;
            }
            if (in_array($model->flex_gutter_y, ['0', '1', '2', '3', '4', '5'])) {
                $containerClass[] = 'gy-' . $model->flex_gutter_y;
            }
        }

        if ($model->flex_container_class) {
            $containerClass[] = $model->flex_container_class;
        }

        $template->containerClass = implode(' ', $containerClass);

        return $template->getResponse();
    }

    protected static function makeSegmantation($segmentation, $modifier, $framework): array
    {
        $cells = explode(':', trim(preg_replace('/\s+/', '', $segmentation)));
        $attributes = [];

        $modifier = ($modifier !== 'xs') ? '-' . $modifier : null;

        foreach ($cells as $position => $cell) {
            $string = explode(',', $cell);
            $cellClass = [];

            if (count($string) === 0 || !$framework) {
                continue;
            }

            // .d-*
            if (in_array(current($string), ['h', 'hide', 'hidden', 's', 'show'], true)) {
                $display = current($string);

                if ($display === 'h' || $display === 'hide' || $display === 'hidden') {
                    $cellClass[] = 'd' . $modifier . '-none';
                    $attributes['visible'][$position] = 'hide';
                }
                else {
                    $cellClass[] = 'd' . $modifier . '-block';
                    $attributes['visible'][$position] = 'show';
                }

                next($string);
            }

            // Flex
            if ($framework === '1') {
                // .col-*
                if (in_array(current($string), [...array_map('strval', range(1, 12)), 'a', 'auto', 'n', 'none'], true)) {
                    $col = current($string);

                    if ($col === 'n' || $col === 'none') {
                        $cellClass[] = 'col' . $modifier;
                        $attributes['col'][$position] = 'narrow';
                    }
                    else if ($col === 'a') {
                        $cellClass[] = 'col' . $modifier . '-auto';
                        $attributes['col'][$position] = 'auto';
                    }
                    else {
                        $cellClass[] = 'col' . $modifier . '-' . $col;
                        $attributes['col'][$position] = $col;
                    }

                    next($string);
                }

                // .offset-*
                if (in_array(current($string), ['', ...array_map('strval', range(0, 12))], true)) {
                    $offset = current($string);

                    if ($offset !== '') {
                        $cellClass[] = 'offset' . $modifier . '-' . $offset;
                        $attributes['offset'][$position] = $offset;
                    }

                    next($string);
                }
            }

            // Grid
            if ($framework === '2') {
                // .col-* & .offset-*
                if (current($string) === '' || preg_match('/^(([a1-9][0-2]{0,1})\/)?([1-9][0-2]{0,2})$/', current($string), $matches)) {
                    $col = current($string);

                    if ($col !== '') {
                        $cellClass[] = 'col' . $modifier . '-' . $matches[3];
                        $attributes['col-span'][$position] = $matches[3];

                        if ($matches[2] !== '') {
                            if ($matches[2] === 'a') $matches[2] = 'auto';

                            $cellClass[] = 'offset' . $modifier . '-' . $matches[2];
                            $attributes['col-start'][$position] = $matches[2];
                        }
                    }

                    next($string);
                }

                // .row-* & .row-offset-*
                if (current($string) === '' || preg_match('/^(([a1-9][0-2]{0,1})\/)?([1-9][0-2]{0,2})$/', current($string), $matches)) {
                    $row = current($string);

                    if ($row !== '') {
                        $cellClass[] = 'row' . $modifier . '-' . $matches[3];
                        $attributes['row-span'][$position] = $matches[3];

                        if ($matches[2] !== '') {
                            if ($matches[2] === 'a') $matches[2] = 'auto';

                            $cellClass[] = 'row-offset' . $modifier . '-' . $matches[2];
                            $attributes['row-start'][$position] = $matches[2];
                        }
                    }

                    next($string);
                }
            }

            // .order-*
            if (in_array(current($string), [...array_map('strval', range(1, 12)), 'f', 'first', 'l', 'last'], true)) {
                $order = current($string);

                if ($order === 'f') $order = 'first';
                if ($order === 'l') $order = 'last';

                $cellClass[] = 'order' . $modifier . '-' . $order;
                $attributes['order'][$position] = $order;

                next($string);
            }

            $attributes['classes'][$position] = count($cellClass) ? implode(' ', $cellClass) : null;
        }

        return $attributes;
    }

    protected static function makeClasses($class): array
    {
        $cells = explode(':', $class);
        $class = [];

        foreach ($cells as $cell) {
            $class[] = ($cell !== '') ? str_replace(',', ' ', $cell) : null;
        }

        return $class;
    }
}
