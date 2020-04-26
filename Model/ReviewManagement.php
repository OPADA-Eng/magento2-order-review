<?php 
namespace OAG\OrderReview\Model;
 
use OAG\OrderReview\Model\OrderReview;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use OAG\OrderReview\Api\ReviewManagementInterface;
class ReviewManagement implements ReviewManagementInterface {
     /**
     * @var Context
     */
    protected $modelOrderReview;
    protected $modelOrder;

    /**
    * @var \Magento\Framework\Controller\Result\JsonFactory
    */
    protected $resultJsonFactory;

    public function __construct(
        OrderReview $modelOrderReview,
        \Magento\Sales\Model\Order $order
    ) {
        $this->modelOrderReview = $modelOrderReview;
        $this->modelOrder = $order;
    }

	/**
	 * {@inheritdoc}
	 */
	public function getReview($increment_id)
	{
		try{
            $this->modelOrder->loadByIncrementId($increment_id);
            $id = $this->modelOrder->getId();
            $review = $this->modelOrderReview->loadByOrderId($id);
            $response =['order_id' => $id,'shipping'=>$review->getShipping(),'product'=>$review->getProduct(),'customer_support'=>$review->getCustomerSupport(),'comment'=>$review->getComment()];
            
        }catch(\Exception $e) {
            $response=['error' => $e->getMessage()];
        }
 
        return json_encode($response);
    }
    
	/**
	 * {@inheritdoc}
	 */
	public function addReview($incrementId,$shipping,$product,$customer_support,$comment)
	{
        try {
            $message = '';
            $result = true;
            $this->modelOrder->loadByIncrementId($incrementId);
            // return json_encode(['id'=>$this->modelOrder->getId()]);
            if (!$this->modelOrder->getId()) {
                $message =__("Order does not exists");
                $result= false;
                $response = [
                    'result' => $result,
                    'review_id' =>$this->modelOrderReview->getId(),
                    'message'=>$message
                ];
               
                return json_encode($response);
            }
            $this->modelOrderReview->loadByOrderId($this->modelOrder->getId());
            if ($this->modelOrderReview->getId()) {
                $message = __('Sorry, you have already sent us a review for this order.');
                $result= false;
                $response = [
                    'result' => $result,
                    'review_id' =>$this->modelOrderReview->getId(),
                    'message'=>$message
                ];
               
                return json_encode($response);
            }
            $this->modelOrderReview->setOrderId($this->modelOrder->getId());
            $this->modelOrderReview->setShipping((int) $shipping);
            $this->modelOrderReview->setProduct((int) $product);
            $this->modelOrderReview->setCustomerSupport((int) $customer_support);
            if ($comment) {
                $comment = htmlentities($comment, ENT_QUOTES);
                $this->modelOrderReview->setComment($comment);
            }
            // return json_encode(['id'=>$this->modelOrder->getId()]);
            $this->modelOrderReview->save();
            $message =  __('Thanks for give us your opinion! :)');
        } catch (LocalizedException $e) {
            $message = $e->getMessage();
            $result= false;
        } catch (\Exception $e) {
            // $message = __('An unspecified error occurred. Please contact us for assistance.');
            $message = $e->getMessage();
            $result= false;
        }
        $response = [
            'result' => $result,
            'review_id' =>$this->modelOrderReview->getId(),
            'message'=>$message
        ];
       
        return json_encode($response);
	}
}