<?php

namespace Atomicptr\PageSpeedPlus\Hooks;

use \TYPO3\CMS\Extbase\Object\ObjectManager;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \TYPO3\CMS\Extbase\Service\TypoScriptService;

use Atomicptr\PageSpeedPlus\Resource\CustomResourceCompressor;

class JavaScriptCompressionHandler {

    protected $configurationManager;
    protected $objectManager;
    protected $settings;

    protected $resourceCompressor;

    public function __construct() {
        $this->objectManager = new ObjectManager();
        $this->configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $configuration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        if(isset($configuration["plugin."]["tx_page_speed_plus."])) {
            $tsService = $this->objectManager->get(TypoScriptService::class);
            $this->settings = $tsService->convertTypoScriptArrayToPlainArray(
                $configuration["plugin."]["tx_page_speed_plus."]["settings."]);
        }

        $this->resourceCompressor = $this->objectManager->get(CustomResourceCompressor::class);
    }

    public function process($args) {
        $params = ["jsLibs", "jsFiles", "jsFooterFiles"];

        foreach($params as $param) {
            $args[$param] = $this->resourceCompressor->compressJsFiles($args[$param]);
        }
    }
}