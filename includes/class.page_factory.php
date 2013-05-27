<?php

class page_factory {
    /**
     * Load file and make proper page object
     * @param url $url
     * @param array $post
     * @return basic_page|css_page|html_page
     */
    public function get_page(url $url, array $post = null) {
        $request = new request($url->raw(), $post);
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

    /**
     *
     * @param url $url
     * @return url
     */
    public function post_page(url $url) {
        $method = 'GET';
        $_POST['convert_method'] = strtoupper((string)$_POST['convert_method']);
        if (isset($_POST['convert_method']) && ($_POST['convert_method'] === 'GET' ||  $_POST['convert_method'] === 'POST')) {
            $method = $_POST['convert_method'];
            unset($_POST['convert_method']);
        }
        if ($method === 'POST') {
            return $this->_post($url);
        }
        if ($method === 'GET') {
            return $this->_get($url);
        }
    }

    private function _post(url $url) {
        return $url->assembly();
    }

    private function _get(url $url) {
        $post = http_build_query($_POST);
        ChromePhp::warn('!!!!!!!!!', $post);
        $_POST = null;
        $q = $url->get('query');
        if (is_null($q) || trim($q) === '') {
            $url->set('query', $post);
        }
        else {
            $url->set('query', $q.'&'.$post);
        }
        ChromePhp::warn('@@@@@@@@@@', $url->assembly());
        return $url;
    }
}
