<?php

namespace Atomicptr\PageSpeedPlus\Resource;

use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use JShrink\Minifier;

class CustomResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor {

    // customized version of \TYPO3\CMS\Core\Resource\ResourceCompressor->compressJsFile
    public function compressJsFile($path) {
        $filename = GeneralUtility::resolveBackPath($this->rootPath.$this->getFilenameFromMainDir($path));

        $ident = null;

        if (@file_exists($filename)) {
            $status = stat($filename);
            $ident = $filename."_pagespeed+_".$status["mtime"].$status["size"];
        } else {
            $ident = $filename;
        }

        $pathinfo = PathUtility::pathinfo($path);
        $targetFile = $this->targetDirectory.$pathinfo["filename"]."-".md5($ident).".min.js";

        if (!file_exists(PATH_site.$targetFile) || $this->createGzipped && !file_exists(PATH_site.$targetFile.".gzip")) {
            $contents = $this->compressJsString(file_get_contents($filename));
            $this->writeFileAndCompressed($targetFile, $contents);
        }

        return $this->returnFileReference($targetFile);
    }

     public function compressJsString($str) {
        return Minifier::minify($str);
     }
}