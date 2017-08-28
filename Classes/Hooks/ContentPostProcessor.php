<?php

namespace Atomicptr\PagespeedPlus\Hooks;

use \TYPO3\CMS\Extbase\Object\ObjectManager;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \TYPO3\CMS\Extbase\Service\TypoScriptService;

use \Atomicptr\PagespeedPlus\Utility\Http2ServerPush;
use \Atomicptr\PagespeedPlus\Utility\HtmlCompress;

class ContentPostProcessor {

    protected $configurationManager;
    protected $objectManager;
    protected $settings;

    protected $http2ServerPush;

    public function __construct() {
        $this->objectManager = new ObjectManager();
        $this->configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $configuration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        if(isset($configuration["plugin."]["tx_pagespeed_plus."])) {
            $tsService = $this->objectManager->get(TypoScriptService::class);
            $this->settings = $tsService->convertTypoScriptArrayToPlainArray(
                $configuration["plugin."]["tx_pagespeed_plus."]["settings."]);
        }

        $this->http2ServerPush = $this->objectManager->get(Http2ServerPush::class);
        $this->htmlCompress = $this->objectManager->get(HtmlCompress::class);
    }

    private function process($cached) {
        if($this->settings["http2"]["serverPushEnable"]) {
            $this->http2ServerPush->render((int)$this->settings["http2"]["maxHeaderLength"]);
        }

        // this should stay at the end
        if($this->settings["htmlCompress"]["enable"]) {
            $this->htmlCompress->render();
        }
    }

    public function renderCachedPage() {
        if(!$GLOBALS['TSFE']->isINTincScript()){
            $this->process(true);
        }
    }

    public function renderUncachedPage() {
        if($GLOBALS['TSFE']->isINTincScript()){
            $this->process(false);
        }
    }
}