<?php

namespace tdoescher\FlexBundle;

class FlexOpen extends \ContentElement
{
    protected $strTemplate = 'ce_flex_open';

    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);

            $wildcard = array();

            if($this->cssID[1]) $wildcard[] = '<strong>Klasse:</strong> '.$this->cssID[1];
            if($this->arrData['flex_xs']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xs'][0].':</strong> '.$this->arrData['flex_xs'];
            if($this->arrData['flex_sm']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_sm'][0].':</strong> '.$this->arrData['flex_sm'];
            if($this->arrData['flex_md']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_md'][0].':</strong> '.$this->arrData['flex_md'];
            if($this->arrData['flex_lg']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_lg'][0].':</strong> '.$this->arrData['flex_lg'];
            if($this->arrData['flex_xl']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_xl'][0].':</strong> '.$this->arrData['flex_xl'];
            if($this->arrData['flex_class']) $wildcard[] = '<strong>'.$GLOBALS['TL_LANG']['tl_content']['flex_class'][0].':</strong> '.$this->arrData['flex_class'];

            $this->Template->wildcard = implode(' - ', $wildcard);
        }
        else
        {
            $segmentation = array();
            if($this->arrData['flex_sm']) $segmentation['sm'] = explode(':', $this->arrData['flex_sm']);
            if($this->arrData['flex_md']) $segmentation['md'] = explode(':', $this->arrData['flex_md']);
            if($this->arrData['flex_xs']) $segmentation['xs'] = explode(':', $this->arrData['flex_xs']);
            if($this->arrData['flex_lg']) $segmentation['lg'] = explode(':', $this->arrData['flex_lg']);
            if($this->arrData['flex_xl']) $segmentation['xl'] = explode(':', $this->arrData['flex_xl']);

            $class = array();
            if($this->arrData['flex_class']) $class = explode(':', $this->arrData['flex_class']);

            $root = $this->ptable.'.'.$this->pid;

            if(!isset($GLOBALS['TL_FLEX'][$root])) {
                $GLOBALS['TL_FLEX'][$root] = [];
            }

            $key = count($GLOBALS['TL_FLEX'][$root]) + 1;

            $GLOBALS['TL_FLEX'][$root][$key] = ['type' => $this->type, 'position' => 0, 'bootstrap' => $this->arrData['flex_bootstrap'], 'repeat' => $this->arrData['flex_repeat'], 'segmentation' => $segmentation, 'class' => $class];

            $classes = array();
            $classes[] = $this->arrData['flex_bootstrap'] ? 'row' : 'flex';

            if($this->arrData['flex_justify'] && $this->arrData['flex_justify'] !== 'normal') $classes[] = 'justify-content-'.$this->arrData['flex_justify'];
            if($this->arrData['flex_align'] && $this->arrData['flex_align'] !== 'normal') $classes[] = 'align-items-'.$this->arrData['flex_align'];

            $classes[] = $this->cssID[1];

            $cssID = $this->cssID[0] ? $this->cssID[0] : 'flex-'.$this->id;

            $this->cssID = [$cssID, implode(' ', $classes)];
        }
    }
}
