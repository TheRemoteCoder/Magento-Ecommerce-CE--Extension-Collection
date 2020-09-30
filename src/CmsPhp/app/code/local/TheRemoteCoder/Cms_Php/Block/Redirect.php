<?php
/**
 * Class TheRemoteCoder_CmsPhp_Block_Redirect
 *
 * @package  TheRemoteCoder_CmsPhp
 */
class TheRemoteCoder_CmsPhp_Block_Redirect extends Mage_Core_Block_Template
{
    /**
     * Override parent method for block HTML rendering.
     * Redirect or return empty string.
     *
     * @return  string
     */
    protected function _toHtml()
    {
        $this->redirect($this->getTarget());
        return '';
    }

    /**
     * XML action method for this block.
     *
     * @param  string  $url  URL to do a 301 redirect to.
     */
    public function redirectXml($url = '')
    {
        $this->redirect($url);
    }

    /**
     * Redirect to a given URL or simply return.
     *
     * @param  string  $url  URL to do a 301 redirect to.
     */
    private function redirect($url = '')
    {
        if (    strlen($url)
            && !headers_sent()) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $url);
            die;
        }
    }
}

