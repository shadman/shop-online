<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductsListingApi()
    {
        $client = static::createClient();
		$client->request(
	        'GET',
	        '/api/products',
	        [],
	        [],
	        [
	        	'HTTP_X-AUTH-TOKEN'=>'0587365e7ec362d52ffb-1558893137',
	        ]
	    );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}