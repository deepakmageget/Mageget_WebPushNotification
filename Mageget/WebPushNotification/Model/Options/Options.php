<?php
/**
 * ELeones Components Model Options Active Options.
 *
 * The data options that can be used in forms ( should default to a "enabled, disabled" toggle.
 */

namespace Mageget\WebPushNotification\Model\Options;

use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    /**
     * Returns the available options
     * @return string[]
     */
    public function getOptionArray()
    {
        return [
            0 => __('Customer Email Basis'),
            1 => __('Customer Country Basis')
          
        ];
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: [['value' => '<value>', 'label' => '<label>'], ...]
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getOptionArray();

        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
