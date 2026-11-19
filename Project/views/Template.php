<?php
/**
 * Class Template - Template Engine Sederhana
 * Praktikum DPBO UPI
 */

class Template {
    var $filename = "";
    var $content = "";

    function __construct($filename = "") {
        $this->filename = $filename;
        if (!empty($filename)) {
            $this->load($filename);
        }
    }

    function load($filename = "") {
        $this->filename = $filename;
        $this->content = implode("", @file($filename));
    }

    function clear() {
        $this->content = preg_replace("/DATA_[A-Z0-9_]+/", "", $this->content);
    }

    function write() {
        $this->clear();
        print $this->content;
    }

    function getContent() {
        $this->clear();
        return $this->content;
    }

    function replace($old = "", $new = "") {
        $this->content = str_replace($old, $new, $this->content);
    }
}
?>
