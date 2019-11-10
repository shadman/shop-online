<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\ProductBundleItem;
use App\Entity\Order;
use App\Entity\OrderItem;

class AppFixtures extends Fixture
{
	private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

    	#Create user
    	$user = new User();
        $user->setEmail('admin@test.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFullName('Super Admin');
        $user->setCreatedAt(date("Y-m-d H:i:s"));
        
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             '123456'
         ));

		$manager->persist($user);
        
        $user2 = new User();
        $user2->setEmail('shadman@test.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setFullName('Shadman Jamil');
        $user2->setApiToken('2283434a7ex442dd54ec-4414591350');
        $user2->setCreatedAt(date("Y-m-d H:i:s"));

        $user2->setPassword($this->passwordEncoder->encodePassword(
             $user2,
             '123456'
         ));

        $manager->persist($user2);
        $manager->flush();



        # Create products
        # Product without discount
        $product1 = new Product();
        $title = 'My Product 1';
        $slug = str_replace(" ","-",strtolower($title));
        $product1->setTitle($title);
        $product1->setSlug($slug);
        $product1->setPrice(80);
        $product1->setDescription('Product description here');
        $product1->setCreatedAt(date("Y-m-d H:i:s"));
        $product1->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product1);

        # Product with concreate discount
        $product3 = new Product();
        $title = 'My Product 2';
        $slug = str_replace(" ","-",strtolower($title));
        $product3->setTitle($title);
        $product3->setSlug($slug);
        $product3->setPrice(150);
        $product3->setIsDiscount('Yes');
        $product3->setDiscountType('Concrete');
        $product3->setDiscount('1');
        $product3->setDescription('Product 2 description here');
        $product3->setCreatedAt(date("Y-m-d H:i:s"));
        $product3->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product3);
        $manager->flush();

        # Product with percentage discount
        $product4 = new Product();
        $title = 'My Product 3';
        $slug = str_replace(" ","-",strtolower($title));
        $product4->setTitle($title);
        $product4->setSlug($slug);
        $product4->setPrice(80);
        $product4->setIsDiscount('Yes');
        $product4->setDiscountType('Percentage');
        $product4->setDiscount('10');
        $product4->setDescription('Product 3 description here');
        $product4->setCreatedAt(date("Y-m-d H:i:s"));
        $product4->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($product4);
        $manager->flush();


        # Set Product bundle
        $productBundle = new Product();
        $title = 'Product 4 Bundle 1';
        $slug = str_replace(" ","-",strtolower($title));
        $productBundle->setTitle($title);
        $productBundle->setSlug($slug);
        $productBundle->setPrice(120);
        $productBundle->setIsProductBundle("Yes");
        $productBundle->setDescription('Product bundle description here');
        $productBundle->setCreatedAt(date("Y-m-d H:i:s"));
        $productBundle->setUpdatedAt(date("Y-m-d H:i:s"));
        $manager->persist($productBundle);
        $manager->flush();      

        # Set product bundle items
        # First product
        $productBundleItem = new ProductBundleItem();
        $productBundleItem->setProductBundleId($productBundle->getId());
        $productBundleItem->setProductId($product1->getId());
        $manager->persist($productBundleItem);

        # Second product
        $productBundleItem2 = new ProductBundleItem();
        $productBundleItem2->setProductBundleId($productBundle->getId());
        $productBundleItem2->setProductId($product3->getId());
        $manager->persist($productBundleItem2);
        
        $manager->flush();


        # Insert some more products for pagination in API
        for($i=5; $i<=20; $i++){
            $product = new Product();
            $title = 'My Product '.$i;
            $slug = str_replace(" ","-",strtolower($title));
            $product->setTitle($title);
            $product->setSlug($slug);
            $product->setPrice(200);
            $product->setDescription('My product description here '.$i);
            $product->setCreatedAt(date("Y-m-d H:i:s"));
            $product->setUpdatedAt(date("Y-m-d H:i:s"));
            $manager->persist($product);
        }

        $manager->flush();
        
    }
}