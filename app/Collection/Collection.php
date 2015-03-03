<?php

namespace Notes\Collection;

use Notes\Model\NoteTag as NoteTagModel;

class Collection implements \Iterator
{
    
    protected $mapper;
    protected $total = 0;
    protected $count;
    private $pointer = 0;
    private $objects = array();
    
    public function __construct($resultset = null)
    {
        $this->count = count($resultset);
    }
    
    public function add($object)
    {
        
        $this->objects[$this->total++] = $object;
        
    }
    
    public function getRow($num)
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }
        if (isset($this->objects[$num])) {
            return $this->objects[$num];
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
        $row = $this->getRow($this->pointer);
        if ($row) {
            $this->pointer++;
        }
        return $row;
    }
    
    public function valid()
    {
        return (!is_null($this->current()));
    }
}
