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

function reverse( $stack1, $stack2 )
{
    if( $stack1->isEmpty() ){
        return $stack2;
    }
    $stack2->push( $stack1->pop() );
    return reverse( $stack1, $stack2 );
}

$stack1 = new Stack();
$stack1->push( 3 );
$stack1->push( 2 );
$stack1->push( 5 );
$stack1->push( 6 );
$stack1->push( 1 );
$stack1->push( 8 );
$stack1->push( 10 );

$stack2 = reverse( $stack1, new Stack() );
print_r( $stack2->dataArr );


// 这种似乎更符合人的思维方式，但是不推荐
function reverseArray( $a1, $a2 )
{
    if( empty( $a1 ) ){
        return $a2;
    }
    array_push( $a2, array_pop( $a1 ) );
    return reverseArray( $a1, $a2 );
}

// 最后一起组装
function reverseArray2( $a1 )
{
    $a2 = array();
    if( empty( $a1 ) ){
        return $a2;
    }
    array_push( $a2, array_pop( $a1 ) );
    return array_merge( $a2, reverseArray2( $a1 ) );
}

$a1 = array( 1, 3, 5, 7 );
print_r( reverseArray2( $a1 ) );

// 如何写递归函数，我的经验是
// 1.明确每个函数职责
// 2.写下中止递归条件
