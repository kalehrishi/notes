<?php

namespace Notes\Collection;

class Collection implements \Iterator
{
    private $total = -1;
    private $count = 0;
    private $pointer = 0;
    private $objects = array();
    
    public function __construct($resultset = null)
    {
        $this->count = count($resultset);
        
    }
    
    public function add($object)
    {
        if (is_object($object)) {
            $this->objects[++$this->total] = $object;
        } else {
            throw new \InvalidArgumentException("Input should be Object");
        }
        
    }
    
    public function getRow($index)
    {
        if ($index > $this->total || $index < 0) {
            throw new \OutOfBoundsException("Array index is out of bounds");
        } elseif (isset($this->objects[$index])) {
            return $this->objects[$index];
        }
        
    }
    
    public function rewind()
    {
        $this->pointer = 0;
    }
    
    public function current()
    {
        return $this->getRow($this->pointer);
    }
    
    public function key()
    {
        return $this->pointer;
    }
    
    public function next()
    {
        if ($this->hasNext()) {
            $result = $this->getRow($this->pointer++);
            return $result;
        } else {
            return null;
        }
    }
    public function hasNext()
    {
        if ($this->pointer <= $this->total) {
            return true;
        } else {
            return false;
        }
    }
    public function valid()
    {
        if (!is_null($this->current())) {
            return true;
        } else {
            return false;
        }
    }
    public function getCount()
    {
        return $this->count;
    }

    public function getTotal()
    {
        return $this->total;
    }
    public function isEmpty($object)
    {
        if (!empty($object)) {
            return true;
        }
    }
    public function toArray()
    {
        $object_array = get_object_vars($this);
        foreach ($object_array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $index => $object) {
                    $value[$index]      = $object->toArray();
                    $object_array[$key] = $value;
                }
            } elseif (is_object($value)) {
                $value              = $value->toArray();
                $object_array[$key] = $value;
            }
        }
        return ($object_array['objects']);
    }
}
