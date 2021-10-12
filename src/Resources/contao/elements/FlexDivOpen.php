<?php
    
namespace tdoescher\FlexBundle;

class FlexDivOpen extends \ContentElement
{
    protected $strTemplate = 'ce_flex_div_open';
    
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);
            
            if($this->cssID[1]) $this->Template->wildcard = '<strong>Klasse:</strong> '.$this->cssID[1];
        }
        else
        {
            $root = $this->ptable.'.'.$this->pid;

            if(!isset($GLOBALS['TL_FLEX'][$root])) {
                $GLOBALS['TL_FLEX'][$root] = [];
            }

            $key = count($GLOBALS['TL_FLEX'][$root]) + 1;

            $GLOBALS['TL_FLEX'][$root][$key] = ['type' => $object->type];
        }
    }
}
