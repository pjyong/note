<?php
class Pet
{
    private $type;

    public function __construct( $type )
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}

class Dog extends Pet
{
    public function __construct()
    {
        parent::__construct( 'dog' );
    }
}

class Cat extends Pet
{
    public function __construct()
    {
        parent::__construct( 'cat' );
    }
}

// answer
