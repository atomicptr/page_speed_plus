<?php

namespace Atomicptr\Pagespeed\Utility;

class Http2ServerPush {
    const MatchCss = "/<link.+?href=[\"'](.+?\.css.*?)[\"'].*?>/";
    const MatchJs = "/<script.+?src=[\"'](.+?)[\"'].+?>/";
    const MatchImageTags = "/<img.+?src=[\"'](.+?)[\"'].+?>/";

    const MatchLocalFile = "/^(?!http|\/\/).*/";

    private function extractFilePaths($content, $localOnly=true) {
        $css = [];
        $js = [];
        $imageTags = [];

        preg_match_all(Http2ServerPush::MatchCss, $content, $css);
        preg_match_all(Http2ServerPush::MatchJs, $content, $js);
        preg_match_all(Http2ServerPush::MatchImageTags, $content, $imageTags);

        $files = array_merge([], $css[1], $js[1], $imageTags[1]);

        if(!$localOnly) {
            return $files;
        }

        $res = [];

        foreach($files as $file) {
            if(preg_match(Http2ServerPush::MatchLocalFile, $file)) {
                $res[] = $file;
            }
        }

        return $res;
    }

    private function formatArgument($link) {
        $extra = "";

        if(preg_match("/.+?\.css/", $link)) {
            $extra = "as=stylesheet";
        }

        if(preg_match("/.+?\.js/", $link)) {
            $extra = "as=script";
        }

        if(preg_match("/.+?\.(?:jpg|jpeg|gif|svg|png|webp|tiff)/", $link)) {
            $extra = "as=image";
        }

        return "<$link> rel=preload;$extra";
    }

    // 8190 is the max header length of apache2 by default
    public function render($maxHeaderLength=8190) {
        $files = $this->extractFilePaths($GLOBALS["TSFE"]->content);

        $headers = [];
        $result = "";

        foreach($files as $file) {
            $headers[] = $this->formatArgument($file);
            $header = "Link: ".join(",", $headers);

            if(strlen($header) < $maxHeaderLength) {
                $result = substr($header, 0, strlen($header));
            } else {
                break; // break if max header length is exceeded
            }
        }

        if(empty($result)) return;
        header($result);
    }
}