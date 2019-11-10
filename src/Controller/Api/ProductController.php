<?php
namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\ProductService;

class ProductController extends AbstractFOSRestController
{

	private $productService;

	public function __construct(ProductService $productService){

		$this->productService = $productService;
	}

	/**
	 * Get a list of all products
	 * @Rest\Get("/products")
     * @param Request $request
     * 
     * @return Response $response json
	 */

	public function getProducts(Request $request)
	{

        $params['page'] = $request->query->getInt('page', 1);
        $params['limit'] = $request->query->getInt('limit', 10);

	    $products = $this->productService->getProducts($params);

        $response = new Response();
		$response->setContent(json_encode($products));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
	}

	/**
	 * Get a single Product 
	 * @Rest\Get("/products/{id}")
     * @param Request $request
     * @param integer $id
     * 
     * @return Response $response json
	 */

	public function getProduct(Request $request, $id)
	{
	    $product = $this->productService->getProduct($id);

        $response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
	}

	/**
     * Creates an Product
     * @Rest\Post("/products")
     * @param Request $request
     * 
     * @return Response $response json
    */
    public function addProduct(Request $request)
    {
        $user = $this->getUser();
        if (!in_array('ROLE_ADMIN',$user->getRoles())) {
            $response = new Response();
            $response->setContent(json_encode([]));
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            return $response;
        }

    	$params = json_decode($request->getContent(), true);
        $product = $this->productService->addProduct($params);

        $response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;   
    }

    /**
     * Creates a Product
     * @Rest\Put("/products/{id}")
     * @param Request $request
     * @param integer $id
     * 
     * @return Response $response json
    */
    public function updateProduct(Request $request, $id)
    {
        $user = $this->getUser();
        if (!in_array('ROLE_ADMIN',$user->getRoles())) {
            $response = new Response();
            $response->setContent(json_encode([]));
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            return $response;
        }
    	$params = json_decode($request->getContent(), true);
        $product = $this->productService->updateProduct($params, $id);

        $response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
    }

    /**
	 * Delete a selected Product
	 * @Rest\Delete("/products/{id}")
     * @param integer $id
     * 
     * @return Response $response json
	*/
	public function deleteProduct($id)
    {
        $user = $this->getUser();
        if(!in_array('ROLE_ADMIN',$user->getRoles())){
            $response = new Response();
            $response->setContent(json_encode([]));
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            return $response;
        }
        $this->productService->deleteProduct($id);

        $response = new Response();
		$response->setContent(json_encode([]));
		$response->setStatusCode(Response::HTTP_NO_CONTENT);
		return $response;
    }
}