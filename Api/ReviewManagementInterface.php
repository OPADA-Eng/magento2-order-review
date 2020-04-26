<?php 
namespace OAG\OrderReview\Api;
 
 
interface ReviewManagementInterface {


	/**
	 * GET for review api
	 * @param string $increment_id
	 * @return json
	 */
	public function getReview($increment_id);
	/**
	 * Post for review api
	 * @param string $increment_id
	 * @param int $shipping
	 * @param int $product
	 * @param int $customer_support
	 * @param string $comment
	 * @return json
	 */
    public function addReview($increment_id,$shipping,$product,$customer_support,$comment);
    
}