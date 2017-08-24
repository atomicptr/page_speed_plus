<?php

namespace Atomicptr\Pagespeed\Utility;

class HtmlCompress {

    public function render() {
        $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        $GLOBALS["TSFE"]->content = $parser->compress($GLOBALS["TSFE"]->content);
    }
}