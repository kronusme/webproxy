<?php

/**
 * Parsing url for components like scheme, host, port, user, pass, path, file, query, fragment
 *
 * @author KronuS
 */
class url {
    /**
     * @var array
     */
    private $_components;
    /**
     * @var string
     */
    private $_raw_url;

    /**
     * Return raw url
     * @return string
     */
    public function raw() {
        return $this->_raw_url;
    }

    /**
     * Return parsed url components
     * @return array
     */
    public function get_all_components() {
        return $this->_components;
    }

    /**
     * Get url component by its name (like schema, host, port etc)
     * @param string $component
     * @return string|null
     */
    public function get($component) {
        $component = (string)$component;
        return isset($this->_components[$component]) ? $this->_components[$component] : null;
    }

    /**
     * Set url component by its name
     * @param string $component component name
     * @param string $value component value
     */
    public function set($component, $value) {
        $this->_components[(string)$component] = (string)$value;
    }

    public function __construct($url) {
        $url = (string)$url;
        $this->_raw_url = $url;
        $url_parsed = parse_url($url);
        if (!isset($url_parsed['host'])) {
            $url_parsed = parse_url('http://'.$url);
        }
        if (!isset($url_parsed['path'])) {
            $url_parsed['path'] = '/';
        }
        $this->_components = $url_parsed;
        $path_info = pathinfo($this->_components['path']);
        if (isset($path_info['extension'])) {
            $file = $path_info['filename'].'.'.$path_info['extension'];
            $this->_components['path'] = str_replace($file, '', $this->_components['path']);
            $this->_components['file'] = $file;
        }
    }

    public static function encode($url) {
        return str_rot13(base64_encode($url));
    }

    public static function decode($string) {
        return base64_decode(str_rot13($string));
    }
}