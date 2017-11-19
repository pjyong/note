<?php
// 现有一个栈，全部为整型，要求从栈顶到栈底从大到小排序。（提供一个栈和一个变量，不准用其它数据结构）
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

    public function peek()
    {
        return $this->dataArr[ count($this->dataArr) - 1 ];
    }

    public function isEmpty()
    {
        return empty( $this->dataArr );
    }

    public function printAll()
    {
        print_r( $this->dataArr );
    }
}

function sortStack( $stack1 )
{
    $stack2 = new Stack();
    while( !$stack1->isEmpty() ){
        $tmp = isset( $tmp ) ? $tmp : $stack1->pop();
        if( $stack2->isEmpty() || $tmp >= $stack2->peek() ){
            $stack2->push( $tmp );
            unset( $tmp );
        } else {
            $stack1->push( $stack2->pop() );
        }
    }

    return $stack2;
}

// 改进下
function sortStack2( $stack1 )
{
    $stack2 = new Stack();
    while( !$stack1->isEmpty() ){
        $tmp = $stack1->pop();
        while( !$stack2->isEmpty() && $tmp < $stack2->peek() ){
            $stack1->push( $stack2->pop() );
        }
        $stack2->push( $tmp );
    }

    return $stack2;
}

// test
$stack = new Stack();
$stack->push( 5 );
$stack->push( 2 );
$stack->push( 3 );
$stack->push( 7 );
$stack->push( 1 );
$stack->push( 10 );
$stack->push( 8 );

$newStack = sortStack2( $stack );
$newStack->printAll();
