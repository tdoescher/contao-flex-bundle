<?php
    
namespace tdoescher\FlexBundle;

class FlexDivClose extends \ContentElement
{
    protected $strTemplate = 'ce_flex_div_close';
    
    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);
        }
    }
}
