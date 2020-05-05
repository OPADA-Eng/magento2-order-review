<?php 
namespace OAG\OrderReview\Api\Data;
interface OrderReview
{

    /**
    * @return int
    **/
    public function getShipping();

    /**
    * @return int
    **/
    public function getProduct();
    
    /**
    * @return int
    **/
    public function getCustomerSupport();

    /**
    * @return string
    **/
    public function getComment();
}