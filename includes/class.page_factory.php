<?php

class page_factory {
    /**
     * Load file and make proper page object
     * @param url $url
     * @return basic_page|css_page|html_page
     */
    public function get_page(url $url) {
        $request = new request($url->raw());
        $data = $request->send();
        $headers = explode("\r\n", $data[0]);
        $content_type = '';
        $charset = '';
        foreach($headers as $k => $header) {
            if (strpos($header, 'Content-Type:') !== false) {
                $content_type = $header;
                if (strpos($header, 'charset=') !== false) {
                    $charset = substr($header, strpos($header, 'charset=') + strlen('charset='));
                }
            }
        }
        $is_html = strpos($content_type, 'text/html') !== false;
        $is_css = strpos($content_type, 'text/css') !== false;

        if ($is_html) {
            $page = new html_page();
        }
        else {
            if ($is_css) {
                $page = new css_page();
            }
            else {
                $page = new basic_page();
            }
        }
        $page->set_charset($charset);
        $page->set_content_type($content_type);
        $page->set_headers($headers);
        $page->set_content($data[1]);
        $page->set_url($url);
        return $page;
    }
}
