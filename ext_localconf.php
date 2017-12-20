<?php

if(!defined("TYPO3_MODE")) {
    die("Access denied.");
}

if(!defined("TYPO3_COMPOSER_MODE")) {
    require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY)."vendor/autoload.php");
}

$conf = unserialize($_EXTCONF);

$confEnableCustomJSCompressor = $conf["enableCustomJavaScriptCompressor"];

// add JavaScript compress handler
if(!isset($confEnableCustomJSCompressor) || $confEnableCustomJSCompressor) {
    $GLOBALS["TYPO3_CONF_VARS"]["FE"]["jsCompressHandler"] =
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).
            "/Classes/Hooks/JavaScriptCompressionHandler.php:Atomicptr\\PageSpeedPlus\\Hooks\\JavaScriptCompressionHandler->process";
}

// register content post processors
$GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["tslib/class.tslib_fe.php"]["contentPostProc-all"][] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).
        "/Classes/Hooks/ContentPostProcessor.php:Atomicptr\\PageSpeedPlus\\Hooks\\ContentPostProcessor->renderCachedPage";
$GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["tslib/class.tslib_fe.php"]["contentPostProc-output"][] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).
        "/Classes/Hooks/ContentPostProcessor.php:Atomicptr\\PageSpeedPlus\\Hooks\\ContentPostProcessor->renderUncachedPage";