<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 16/01/2017
 * Time: 18:09
 */
namespace Magenest\AdvancedProductOption\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\Locator\LocatorInterface;

class QuantityMapping extends AbstractModifier
{
    protected $_locator;

    protected $_request;

    protected $_mappingFactory;

    public function __construct(
        RequestInterface $request,
        LocatorInterface $locator,
        \Magenest\AdvancedProductOption\Model\QuantityMappingFactory $mappingFactory
    ) {
        $this->_mappingFactory = $mappingFactory;
        $this->_request = $request;
        $this->_locator = $locator;
    }

    public function modifyData(array $data)
    {
        $product = $this->_locator->getProduct();
        $productId = $product->getId();

        $mapping = $this->_mappingFactory->create();
        $existedMapping = $mapping->getCollection()->addFieldToFilter('product_id', $productId)->getFirstItem();
        if ($existedMapping) {
            $options = unserialize($existedMapping->getData('value'));

            $data[strval($productId)]['event']['mapping_value'] = $options;
        }

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
