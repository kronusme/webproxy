<?php

class html_page extends page {
    public function process() {
        $dom = str_get_html($this->_content, true, true, $this->_charset, false);
        if ($dom) {
            $dom = $this->_remove_elements($dom);
            $dom = $this->_fix_attributes($dom);
            $dom = $this->_fix_forms($dom);
            $dom = $this->_fix_styles($dom);

            $dom->find('body', 0)->innertext = '<div style="box-shadow: 0px 0px 20px rgba(0,0,0,1);width: 90%;left: 5%; height: 40px; background-color: #ddd; border: 1px solid black; position: fixed; top: 20px;z-index: 10000000;"><input style="width: 90%; margin: 5px auto auto auto; display: block;" type="text" value="'.$this->get_url()->raw().'" /></div>'.$dom->find('body', 0)->innertext;
            ob_start();
            echo $dom;
            return ob_get_clean();
        }
        return '';
    }

    private function _remove_elements($dom) {
        $to_remove = $dom->find(' embed, applet, iframe');
        foreach($to_remove as $removable) {
            $removable->clear();
        }
        return $dom;
    }

    private function _fix_attributes($dom) {

        $fixes = array(
            array(
                'xpath' => '*[href]',
                'attr' => 'href'
            ),
            array(
                'xpath' => '*[src]',
                'attr' => 'src'
            ),
            array(
                'xpath' => '*[background]',
                'attr' => 'background'
            )
        );

        foreach($fixes as $fix) {
            $elements = $dom->find($fix['xpath']);
            foreach($elements as $element) {
                if ($element->$fix['attr']) {
                    $element->$fix['attr'] = $this->_link_modify($element->$fix['attr']);
                }
            }
        }
        return $dom;
    }

    private function _fix_forms($dom) {
        $forms = $dom->find('form');
        foreach($forms as $form) {
            if ($form->action) {
                $form->action = $this->_link_modify($form->action);
            }
            $real_form_method = $form->method;
            $form->method = 'post';
            $form->innertext = '<input type="hidden" name="convert_method" value="'.($real_form_method?$real_form_method:'get').'" />'.$form->innertext;
        }
        return $dom;
    }

    private function _fix_styles($dom) {
        $styles = array(
            array(
                'xpath' => '*[style]',
                'attr' => 'style'
            ),
            array(
                'xpath' => 'style',
                'attr' => 'innertext'
            )
        );

        foreach($styles as $s) {
            $elements = $dom->find($s['xpath']);
            foreach($elements as $element) {
                preg_match_all('/url\s*\((.*)\)/Ui', $element->$s['attr'], $matches);
                if (is_array($matches[1])) {
                    foreach($matches[1] as $key=>$match) {
                        $url = 'url("'.$this->_link_modify(trim($match,'"\'')).'")';
                        $element->$s['attr'] = str_replace($matches[0][$key], $url, $element->$s['attr']);
                    }
                }
            }
        }
        return $dom;
    }
}
