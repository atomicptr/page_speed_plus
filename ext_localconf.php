<?php

if(!defined("TYPO3_MODE")) {
    die("Access denied.");
}

if(TYPO3_COMPOSER_MODE !== true) {
    require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'vendor/autoload.php');
}

$GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["tslib/class.tslib_fe.php"]["contentPostProc-all"][] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).
        "/Classes/Hooks/ContentPostProcessor.php:Atomicptr\\PagespeedPlus\\Hooks\\ContentPostProcessor->renderCachedPage";
$GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["tslib/class.tslib_fe.php"]["contentPostProc-output"][] =
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).
        "/Classes/Hooks/ContentPostProcessor.php:Atomicptr\\PagespeedPlus\\Hooks\\ContentPostProcessor->renderUncachedPage";