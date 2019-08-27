<?php
namespace RedChamps\ZeroPriceText\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\Amount\AmountInterface;
use Magento\Framework\Pricing\Render\PriceBox;
use Magento\Store\Model\ScopeInterface;

class PricingRender
{
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundRenderAmount(
        PriceBox $subject,
        \Closure $proceed,
        AmountInterface $amount,
        array $arguments = []
    ) {
        if ($subject->getPrice()->getValue() <= 0) {
            return "<span class='free-price-text'>".$this->scopeConfig->getValue(
                'zero_price/general/text',
                ScopeInterface::SCOPE_STORE
            )."</span>";
        }

        return $proceed($amount, $arguments);
    }
}
