<?php

namespace Notes\Collection;

use Notes\Model\NoteTag as NoteTagModel;

class Collection implements \Iterator
{
    private $total = 0;
    private $count=0;
    private $pointer = 0;
    private $objects = array();
    
    public function __construct($resultset = null)
    {
        $this->count = count($resultset);
    }
    
    public function add($object)
    {
        if (is_object($object)) {
            $this->objects[$this->total++] = $object;
        } else {
            throw new \InvalidArgumentException("Input should be Object");
        }
        
    }

    public function getResult($index)
    {
        if ($index >= $this->total || $index < 0) {
            return null;
        }
        if (isset($this->objects[$index])) {
            return $this->objects[$index];
        }
        
    }
    
    public function rewind()
    {
        $this->pointer = 0;
    }
    
    public function current()
    {
        return $this->getResult($this->pointer);
    }
    
    public function key()
    {
        return $this->pointer;
    }
    
    public function next()
    {
        $result = $this->getResult($this->pointer);
        if ($result) {
            $this->pointer++;
            return $result;
        }
    }
    public function hasNext()
    {
        $result = $this->getResult($this->pointer);
        if ($result) {
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
}
