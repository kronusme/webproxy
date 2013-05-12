<?php

class html_page extends page {
    public function process() {
        $dom = str_get_html($this->_content, true, true, $this->_charset, false);
        if ($dom) {
            $to_remove = $dom->find(' embed, applet, iframe');
            foreach($to_remove as $removable) {
                $removable->clear();
            }
            $elements_with_href = $dom->find('*[href]');
            foreach($elements_with_href as $element) {
                if ($element->href) {
                    $element->href = $this->_link_modify($element->href);
                }
            }
            $elements_with_src = $dom->find('*[src]');
            foreach($elements_with_src as $element) {
                if ($element->src) {
                    $element->src = $this->_link_modify($element->src);
                }
            }
            $forms = $dom->find('form');
            foreach($forms as $form) {
                if ($form->action) {
                    $form->action = $this->_link_modify($form->action);
                }
                $form->method = 'post';
                $form->innertext = '<input type="hidden" name="convert_method" value="'.($form->method?$form->method:'get').'" />'.$form->innertext;
            }

            $elements_with_background = $dom->find('*[background]');
            foreach ($elements_with_background as $element) {
                $element->background = $this->_link_modify($element->background);
            }

            $elements_with_style_attr = $dom->find('*[style]');
            foreach($elements_with_style_attr as $element) {
                preg_match_all('/url\s*\((.*)\)/Ui', $element->style, $matches);
                if (is_array($matches[1])) {
                    foreach($matches[1] as $key=>$match) {
                        $url = 'url("'.$this->_link_modify(trim($match,'"\'')).'")';
                        $element->style = str_replace($matches[0][$key], $url, $element->style);
                    }
                }
            }

            $dom->find('body', 0)->innertext = '<div style="box-shadow: 0px 0px 20px rgba(0,0,0,1);width: 90%;left: 5%; height: 40px; background-color: #ddd; border: 1px solid black; position: fixed; top: 20px;z-index: 10000000;"><input style="width: 90%; margin: 5px auto auto auto; display: block;" type="text" value="'.$_GET['url'].'" /></div>'.$dom->find('body', 0)->innertext;
            ob_start();
            echo $dom;
            return ob_get_clean();
        }
        return '';
    }
}
