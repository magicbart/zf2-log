<?php
namespace Log\Model;

class Token
{
    public $key;

    /**
     * Set class values from data
     * @param array $data
     */
    public function exchangeArray($data)
    {
        $this->trash = $this;
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            if (array_key_exists($prop->name, $data)) {
                $this->{$prop->name} = $data[$prop->name];
            }
        }
    }
}
