<?php

namespace Daav\CarrierDetailsPerProduct\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Daav\CarrierDetailsPerProduct\Model\Carrier\Carrier;
use \Magento\Shipping\Model\Config\Source\Allmethods;


class CarrierBlock extends Template
{
    private Carrier $carrier;
    private Allmethods $shippingMethods;

    public function __construct(
        Context $context,
        Carrier $carrier,
        Allmethods $shippingMethods,
        array $data = []
    ) {
        $this->carrier = $carrier;
        $this->shippingMethods = $shippingMethods;
        parent::__construct($context, $data);
    }

    public function getShippingMethods(): array
    {
        $methods = [];
        $activeMethods = $this->getActiveShippingMethods();
        foreach ($activeMethods as $code => $shipping) {
            if(!empty($code))
            {
                $this->carrier->setCarrierCode($code);
                $methods[] = $this->carrier->getCarrierInfo();
            }
        }
        return $methods;
    }

    public function getActiveShippingMethods()
    {
        return $this->shippingMethods->toOptionArray(true);
    }
}
