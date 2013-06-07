<?php
/**
 * Basic class for loaded files (html, css, js, images etc)
 * @author KronuS
 */
abstract class page {
    /**
     * @var url
     */
    protected $_url;
    /**
     * @var string
     */
    protected $_content_type;
    /**
     * @var string
     */
    protected $_charset;
    /**
     * @var array
     */
    protected $_headers;
    /**
     * @var string
     */
    protected $_content;

    public function set_url(url $url) {
        $this->_url = $url;
    }

    public function set_headers(array $headers) {
        $this->_headers = $headers;
    }

    public function set_content($content) {
        $this->_content = (string)$content;
    }

    public function set_charset($charset) {
        $this->_charset = (string)$charset;
    }

    public function set_content_type($content_type) {
        $this->_content_type = (string)$content_type;
    }

    public function get_charset() {
        return $this->_charset;
    }

    public function get_content_type() {
        return $this->_content_type;
    }

    public function get_headers() {
        return $this->_headers;
    }

    public function get_url() {
        return $this->_url;
    }

    /**
     * Modify "raw" link to "proxy" link (view.php?url=****)
     *
     * @param string $link
     * @param bool $encode
     * @return string
     */
    protected function _link_modify($link, $encode = true) {
        if (strpos($link, 'javascript:') !== false) {
            return $link;
        }
        if (strpos($link, 'http') !== false) {
            $add = '';
        }
        else {
            if (strpos($link, '//') === 0) {
                $add = 'http:';
            }
            else {
                if ($link and $link[0] != '/') {
                    $add = $this->_url->get('host').$this->_url->get('path');
                }
                else {
                    $add = $this->_url->get('host');
                }
            }
        }
        return 'view.php?url='.($encode?url::encode($add.$link):($add.$link));
    }

    /**
     * Processing page content
     *
     * @return string
     */
    abstract public function process();
}
