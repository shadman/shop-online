<?php
namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\OrderService;

class CustomerOrderController extends AbstractFOSRestController
{

	private $orderService;

	public function __construct(OrderService $orderService){
		$this->orderService = $orderService;
	}

    /**
     * Get a product list with total
     * @Rest\Post("/customers/orders")
     * @param Request $request
     * 
     * @return Response $response json
    */
    public function orderSummary(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        $orderSummary = $this->orderService->orderSummary($params);

        $response = new Response();
        $response->setContent(json_encode($orderSummary));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

    /**
     * Return a product after saving
     * @Rest\Post("/customers/orders")
     * @param Request $request
     * 
     * @return Response $response json
    */

	public function saveOrder(Request $request)
	{
        $params = json_decode($request->getContent(), true);
        $params['user'] = $this->getUser();
	    $order = $this->orderService->saveOrder($params);

        $response = new Response();
        $response->setContent(json_encode($order));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
	}

    /**
     * Fetch an order details
     * @Rest\Get("/customers/orders/{id}")
     * @param Request $request
     * @param Integer $id
     * 
     * @return Response $response json
     */

    public function getOrder(Request $request, $id)
    {
        $params['id'] = $id;
        $params['userId'] = $this->getUser()->getId();
        $order = $this->orderService->getOrder($params);

        $response = new Response();
        $response->setContent(json_encode($order));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

    /**
     * Retrieves a Orders resource
     * @Rest\Get("/customers/orders")
     * @param Request $request
     * 
     * @return Response $response json
     */

    public function getOrders(Request $request)
    {
        $params['userId'] = $this->getUser()->getId();
        $orders = $this->orderService->getOrders($params);

        $response = new Response();
        $response->setContent(json_encode($orders));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

}