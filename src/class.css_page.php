<?php

class css_page extends page {
    public function process() {
        preg_match_all('/url\s*\((.*)\)/Ui', $this->_content, $matches);
        if (is_array($matches[1])) {
            foreach($matches[1] as $key=>$match) {
                $url = 'url("'.$this->_link_modify(trim($match,'"\'')).'")';
                $this->_content = str_replace($matches[0][$key], $url, $this->_content);
            }
        }
        return $this->_content;
    }
}
