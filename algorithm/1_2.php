<?php
// 由两个栈组成的队列
// 支持队列的基本操作add poll peek

class Stack
{
    public $dataArr = array();

    public function pop()
    {
        return array_pop( $this->dataArr );
    }

    public function push( $val )
    {
        array_push( $this->dataArr, $val );
        return $this;
    }

    public function isEmpty()
    {
        return empty( $this->dataArr );
    }
}

class Queue
{
    private $stack1;
    private $stack2;

    public function __construct()
    {
        $this->stack1 = = new Stack();
        $this->stack2 = = new Stack();
    }

    public function poll()
    {
        $popVal = $this->stack1->pop();
        while( $popVal !== null ){
            $this->stack2->push( $popVal );
            $popVal = $this->stack1->pop();
        }
        return $this->stack2->pop();
    }

    public function add( $val )
    {
        $this->stack1->push( $val );
        return $this;
    }

    public function peek()
    {
    }
}
