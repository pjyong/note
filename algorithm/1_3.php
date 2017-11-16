<?php
// 如何用递归函数和栈操作逆序一个栈
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

function revert( $stack1, $stack2 )
{
    if( $stack1->isEmpty() ){
        return $stack2;
    }
    $endVal = $stack1->pop();
    $stack2->push( $endVal );
    return revert( $stack1, $stack2 );
}

$stack1 = new Stack();
$stack1->push( 3 );
$stack1->push( 2 );
$stack1->push( 5 );
$stack1->push( 6 );
$stack1->push( 1 );
$stack1->push( 8 );
$stack1->push( 10 );

$stack2 = revert( $stack1, new Stack() );
print_r( $stack2->dataArr );
