<?php


namespace Imbalance;


trait LoggerAttributesTrait
{
    public function getObjectWithAttributesForLogger()
    {
        $presenter_obj = new \stdClass();
        foreach ($this as $attribute_name => $attribute_value) {
            $presenter_obj->$attribute_name = $attribute_value;
        }
        return $presenter_obj;
    }

}