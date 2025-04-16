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
    protected static array $displays = ['h', 'hide', 'hidden', 's', 'show'];

    protected static array $cols = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'a', 'auto', 'n', 'none'];

    protected static array $gridRows = ['', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

    protected static array $offsets = ['', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'a', 'auto'];

    protected static array $orders = ['', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'a', 'auto', 'f', 'first', 'l', 'last'];

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $wildcard = [];
            if ($model->flex_xs) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_xs'][0] . ':</strong> ' . $model->flex_xs;
            }
            if ($model->flex_sm) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_sm'][0] . ':</strong> ' . $model->flex_sm;
            }
            if ($model->flex_md) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_md'][0] . ':</strong> ' . $model->flex_md;
            }
            if ($model->flex_lg) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_lg'][0] . ':</strong> ' . $model->flex_lg;
            }
            if ($model->flex_xl) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_xl'][0] . ':</strong> ' . $model->flex_xl;
            }
            if ($model->flex_xxl) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_xxl'][0] . ':</strong> ' . $model->flex_xxl;
            }
            if ($model->flex_class) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_class'][0] . ':</strong> ' . $model->flex_class;
            }
            if ($model->flex_container_class) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_container_class'][0] . ':</strong> ' . $model->flex_container_class;
            }
            if (unserialize($model->cssID)[1]) {
                $wildcard[] = '<strong>' . $GLOBALS['TL_LANG']['tl_content']['flex_main_class'] . ':</strong> ' . unserialize($model->cssID)[1];
            }

            $template->wildcard = implode(' - ', $wildcard);
        }

        $root = 'tl_content.' . $model->id;

        $segmentation = [];
        if ($model->flex_sm) {
            $segmentation['sm'] = self::makeSegmantation($model->flex_sm, 'sm', $model->flex_bootstrap);
        }
        if ($model->flex_md) {
            $segmentation['md'] = self::makeSegmantation($model->flex_md, 'md', $model->flex_bootstrap);
        }
        if ($model->flex_xs) {
            $segmentation['xs'] = self::makeSegmantation($model->flex_xs, 'xs', $model->flex_bootstrap);
        }
        if ($model->flex_lg) {
            $segmentation['lg'] = self::makeSegmantation($model->flex_lg, 'lg', $model->flex_bootstrap);
        }
        if ($model->flex_xl) {
            $segmentation['xl'] = self::makeSegmantation($model->flex_xl, 'xl', $model->flex_bootstrap);
        }
        if ($model->flex_xxl) {
            $segmentation['xxl'] = self::makeSegmantation($model->flex_xxl, 'xxl', $model->flex_bootstrap);
        }

        $cellClass = self::makeClasses($model->flex_class);

        if (!isset($GLOBALS['TL_FLEX'])) {
            $GLOBALS['TL_FLEX'] = [];
        }

        $GLOBALS['TL_FLEX'][$root] = [
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
        $cells = explode(':', $segmentation);
        $attributes = [];

        $prefix = $framework ? 'col' : 'cell';
        $modifier = ($modifier !== 'xs') ? '-' . $modifier : null;

        foreach ($cells as $position => $cell) {
            $string = explode(',', $cell);
            $cellClass = [];

            if (count($string) === 0 || !$framework) {
                continue;
            }

            if (in_array(current($string), self::$displays, true)) {
                $display = current($string);

                if ($display === 'h' || $display === 'hide' || $display === 'hidden') {
                    $cellClass[] = 'd' . $modifier . '-none';
                    $attributes['visible'][$position] = 'hide';
                }
                else if ($display === 's' || $display === 'show') {
                    $cellClass[] = 'd' . $modifier . '-block';
                    $attributes['visible'][$position] = 'show';
                }

                next($string);
            }

            if ($framework === '1') {
                if (in_array(current($string), self::$cols, true)) {
                    $col = current($string);

                    if ($col === 'n' || $col === 'none') {
                        $cellClass[] = $prefix . $modifier;
                        $attributes['col'][$position] = 'narrow';
                    }
                    else if ($col === 'a') {
                        $cellClass[] = $prefix . $modifier . '-auto';
                        $attributes['col'][$position] = 'auto';
                    }
                    else {
                        $cellClass[] = $prefix . $modifier . '-' . $col;
                        $attributes['col'][$position] = $col;
                    }

                    next($string);
                }

                if (in_array(current($string), self::$offsets, true)) {
                    $offset = current($string);

                    if (!in_array($offset, ['', 'a', 'auto'])) {
                        $cellClass[] = 'offset' . $modifier . '-' . $offset;
                        $attributes['offset'][$position] = $offset;
                    }

                    next($string);
                }

                if (in_array(current($string), self::$orders, true)) {
                    $order = current($string);

                    if (!in_array($order, ['' , 'a', 'auto'])) {
                        if ($order === 'f' || $order === 'first') {
                            $cellClass[] = 'order' . $modifier . '-first';
                            $attributes['order'][$position] = 'f';
                        }
                        else if ($order === 'l' || $order === 'last') {
                            $cellClass[] = 'order' . $modifier . '-last';
                            $attributes['order'][$position] = 'l';
                        }
                        else if ($order <= '5') {
                            $cellClass[] = 'order' . $modifier . '-' . $order;
                            $attributes['order'][$position] = $order;
                        }
                    }

                    next($string);
                }
            }
            else {
                if (in_array(current($string), self::$cols, true)) {
                    $col = current($string);

                    if (!in_array($col, ['a', 'auto', 'n', 'none'])) {
                        $cellClass[] = $prefix . $modifier . '-' . $col;
                        $attributes['col'][$position] = $col;
                    }

                    next($string);
                }

                if (in_array(current($string), self::$offsets, true)) {
                    $offset = current($string);

                    if ($offset !== '') {
                        if ($offset === '0' || $offset === 'a') {
                            $offset = 'auto';
                        }

                        $cellClass[] = 'offset' . $modifier . '-' . $offset;
                        $attributes['offset'][$position] = $offset;
                    }

                    next($string);
                }

                if (in_array(current($string), self::$gridRows, true)) {
                    $row = current($string);

                    if ($row !== '') {
                        $cellClass[] = 'row' . $modifier . '-' . $row;
                        $attributes['row'][$position] = $row;
                    }

                    next($string);
                }

                if (in_array(current($string), self::$orders, true)) {
                    $order = current($string);

                    if (!in_array($order, ['', 'f', 'first', 'l', 'last'])) {
                        if ($order === '0' || $order === 'a') {
                            $order = 'auto';
                        }

                        $cellClass[] = 'order' . $modifier . '-' . $order;
                        $attributes['order'][$position] = $order;
                    }

                    next($string);
                }
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
