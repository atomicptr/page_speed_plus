<?php

namespace Atomicptr\PageSpeedPlus\Utility;

use WyriHaximus\HtmlCompress\Parser;
use WyriHaximus\HtmlCompress\Patterns;
use WyriHaximus\HtmlCompress\Compressor\Compressor;
use WyriHaximus\HtmlCompress\Compressor\CssMinCompressor;
use WyriHaximus\HtmlCompress\Compressor\CssMinifierCompressor;
use WyriHaximus\HtmlCompress\Compressor\ReturnCompressor;

use JShrink\Minifier;

class JavaScriptMinifierCompressor extends Compressor {
    protected function execute($string) {
        return Minifier::minify($string);
    }
}

class HtmlCompress {

    public function render() {
        $parser = new Parser([
            "compressors" => [
                [
                    "patterns" => [
                        Patterns::MATCH_NOCOMPRESS,
                    ],
                    "compressor" => new ReturnCompressor(),
                ],
                [
                    "patterns" => [
                        Patterns::MATCH_JSCRIPT,
                    ],
                    "compressor" => new JavaScriptMinifierCompressor(),
                ],
                [
                    "patterns" => [
                        Patterns::MATCH_SCRIPT,
                        Patterns::MATCH_PRE,
                        Patterns::MATCH_TEXTAREA,
                    ],
                    "compressor" => new ReturnCompressor(),
                ],
                [
                    "patterns" => [
                        Patterns::MATCH_STYLE,
                        Patterns::MATCH_STYLE_INLINE,
                    ],
                    "compressor" => new CssMinCompressor(),
                ],
            ],
        ]);

        $GLOBALS["TSFE"]->content = $parser->compress($GLOBALS["TSFE"]->content);
    }
}