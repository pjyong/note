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
        $this->stack1 = new Stack();
        $this->stack2 = new Stack();
    }

    public function poll()
    {
        if( $this->stack2->isEmpty() ){
            while( !$this->stack1->isEmpty() ){
                $this->stack2->push( $this->stack1->pop() );
            }
        }
        return $this->stack2->pop();
    }

    public function add( $val )
    {
        // 这里必须要还原
        if( $this->stack1->isEmpty() && !$this->stack2->isEmpty() ){
            while( !$this->stack2->isEmpty() ){
                $this->stack1->push( $this->stack2->pop() );
            }
        }
        $this->stack1->push( $val );
        echo "$val \n";
        return $this;
    }
}

// test
$q = new Queue();
$q->add( 3 );
$q->add( 4 );
$q->add( 5 );
$q->add( 6 );
$res = $q->poll();
echo "$res \n";
$res = $q->poll();
echo "$res \n";
$q->add( 7 );
$q->add( 8 );
