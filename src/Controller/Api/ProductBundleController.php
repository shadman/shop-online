<?php
namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\ProductBundleService;

class ProductBundleController extends AbstractFOSRestController
{

	private $productBundleService;

	public function __construct(ProductBundleService $productBundleService){

		$this->productBundleService = $productBundleService;
	}

	/**
	 * Retrieves a collection of Product bundle resource
	 * @Rest\Get("/products/notbundles")
     * 
     * @return Response $response json
	 */

	public function getProductsIsNotBundles()
	{
	    $products = $this->productBundleService->getProductsIsNotBundles();

		$response = new Response();
		$response->setContent(json_encode($products));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
	}


	/**
	 * Get a list of all Product bundle
	 * @Rest\Get("/products/bundles")
	 * 
     * @return Response $response json
	 */

	public function getProductBundles()
	{
	    $products = $this->productBundleService->getProducts();

		$response = new Response();
		$response->setContent(json_encode($products));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
	}

	/**
	 * Get a Product bundle details
	 * @Rest\Get("/products/bundles/{id}")
	 * @param Request $request
     * @param integer $id
     * 
     * @return Response $response json
	 */

	public function getProduct(Request $request, $id)
	{
	    $product = $this->productBundleService->getProduct($id);

		$response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
	}

	/**
     * Creates a Product bundle
     * @Rest\Post("/products/bundles")
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
        $product = $this->productBundleService->addProduct($params);
		
		$response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
    }

    /**
     * Edit a Product bundle
     * @Rest\Put("/products/bundles/{id}")
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
        $product = $this->productBundleService->updateProduct($params, $id);
		
		$response = new Response();
		$response->setContent(json_encode($product));
		$response->setStatusCode(Response::HTTP_OK);
		return $response;
    }

    /**
	 * Delete the Product complete bundle
	 * @Rest\Delete("/products/bundles/{id}")
     * @param integer $id
     * 
     * @return Response $response json
	*/
	public function deleteProduct($id)
    {
    	$user = $this->getUser();
        if (!in_array('ROLE_ADMIN',$user->getRoles())) {
			$response = new Response();
			$response->setContent(json_encode([]));
			$response->setStatusCode(Response::HTTP_UNAUTHORIZED);
			return $response;
		}
		
        $this->productBundleService->deleteProduct($id);

		$response = new Response();
		$response->setContent(json_encode([]));
		$response->setStatusCode(Response::HTTP_NO_CONTENT);
		return $response;
    }
}