<?php
// 设计一个有getMin功能的栈
// 要求pop push getMin的时间复杂度都是O(1)

class Stack
{
    public $dataArr = array();
    public $minArr = array();

    public $lastMinVal = 0;

    public function pop()
    {
        $endVal = array_pop( $this->dataArr );
        $endMinVal = array_pop( $this->minArr );
        if( $endVal != $endMinVal ){
            array_push( $this->minArr, $endMinVal );
        }
        echo "pop:".$endVal."\n";
        return $endVal;
    }

    public function push( $val )
    {
        echo "push:".$val."\n";
        if( empty( $this->minArr ) || $val <= $this->lastMinVal ){
            array_push( $this->minArr, $val );
            $this->lastMinVal = $val;
        }
        array_push( $this->dataArr, $val );
        return $this;
    }

    public function getMin()
    {
        if( !empty( $this->minArr ) ){
            $endMinVal = array_pop( $this->minArr );
            array_push( $this->minArr, $endMinVal );
        } else {
            $endMinVal = 0;
        }
        echo "min:".$endMinVal."\n";
        return $endMinVal;
    }
}

// 测试
$stack = new Stack();
$stack->push( 5 );
$stack->getMin();
$stack->push( 6 );
$stack->getMin();
$stack->push( 4 );
$stack->getMin();
$stack->push( 1 );
$stack->getMin();
$stack->push( 2 );
$stack->getMin();
$stack->pop();
$stack->getMin();
$stack->pop();
$stack->getMin();
$stack->pop();
$stack->getMin();
$stack->pop();
$stack->getMin();
$stack->pop();
$stack->getMin();
