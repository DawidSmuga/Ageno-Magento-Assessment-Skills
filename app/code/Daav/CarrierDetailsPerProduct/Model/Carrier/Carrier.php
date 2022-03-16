<?php

namespace Daav\CarrierDetailsPerProduct\Model\Carrier;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use \Magento\Framework\Pricing\Helper\Data;
use \Magento\Quote\Model\Quote\Address\RateRequest;
use \Psr\Log\LoggerInterface;

class Carrier extends \Magento\Shipping\Model\Carrier\AbstractCarrier
{

    protected $_code;
    protected Data $dataHelper;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        Data $dataHelper,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->dataHelper = $dataHelper;
    }

    public function setCarrierCode(string $carrierCode): void
    {
        $this->_code = $carrierCode;
    }

    public function getCarrierInfo()
    {
        if(empty($this->_code))
            return false;

        return [
            'code' => $this->_code,
            'title' => $this->getConfigData('title'),
            'methodName' => $this->getConfigData('name'),
            'price' => $this->dataHelper->currency($this->getConfigData('price'))
        ];
    }

    public function collectRates(RateRequest $request)
    {
    }
}
