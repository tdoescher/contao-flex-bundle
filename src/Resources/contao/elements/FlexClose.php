<?php
    
namespace tdoescher\FlexBundle;

class FlexClose extends \ContentElement
{
    protected $strTemplate = 'ce_flex_close';
    
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);
        }
    }
}
