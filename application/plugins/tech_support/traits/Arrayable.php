<?php 
namespace TechSupport\Traits;
trait Arrayable{
    public function offsetSet($offset, $value) {
		$data = $this->getData();
        if (!is_null($offset)) {
            $data[$offset] = $value;
        }
        $this->setData($data,true);
    }

    public function offsetExists($offset) {
    	$data = $this->getData();
        return isset($data[$offset]);
    }

    public function offsetUnset($offset) {
    	$data = $this->getData();
        unset($data[$offset]);
        $this->setData($data,true);
    }

    public function offsetGet($offset) {
    	$data = $this->getData();
        return isset($data[$offset]) ? $data[$offset] : null;
    }
}