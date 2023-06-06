<?php
declare(strict_types=1);

namespace Grasch\AdminUi\Block\Widget;

use Grasch\AdminUi\Model\DecodeComponentValue;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

abstract class AbstractWidget extends Template
{
    /**
     * @var DecodeComponentValue
     */
    private DecodeComponentValue $decodeComponentValue;

    /**
     * @param Context $context
     * @param DecodeComponentValue $decodeComponentValue
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DecodeComponentValue $decodeComponentValue,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->decodeComponentValue = $decodeComponentValue;
    }

    /**
     * Get data
     *
     * @param string $key
     * @param string|int $index
     * @return array|mixed|string|null
     */
    public function getData($key = '', $index = null)
    {
        $data = $this->_getData($key);
        if (is_string($data) && $this->decodeComponentValue->isEncoded($data)) {
            $decoded = $this->decodeComponentValue->execute($data);
            return isset($index)? $decoded[$index] : $decoded;
        }

        return parent::getData($key, $index);
    }
}
