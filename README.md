# shop-online

Symfony 4, PHP 7 used to develop a online shop RESTfull API

## Pre-requsite
- Symfony 4
- PHP 7.2
- Appache/Nginx 
- Mysql 5.6

## Install Application

```
git clone https://github.com/shadman/shop-online.git

cd shop-online

composer install
```

## Create Database

Create a database with credentials like `shop_online` and user <username> and password <password>

Update .env file parameter `DATABASE_URL` for created database connection string:

> DATABASE_URL=mysql://<username>:<password>@127.0.0.1:3306/shop_online

## Create Migrations

> php bin/console make:migration

## Run Migrations

> php bin/console doctrine:migrations:migrate

## Add pre-defined products

> php bin/console doctrine:fixtures:load --purge-with-truncate


## API Endpoints

### Register User

METHOD: POST 

URL: http://localhost/shop-online/public/api/register

REQUEST:
```
{
  "email":"demo@app.com",
  "plainPassword":"123456",
  "fullName":"Demo User"
}
```

### Login User

Login to get access token and to access other API endpoints

METHOD: POST

URL: http://localhost/shop-online/public/api/login

REQUEST:
```
{
  "email":"demo@app.com",
  "assword":"123456"
}
```

RESPONSE:
```
{
"apikey": "6e847cd99e8a1e915001-1558878749"
}
```

#### Note: 
This token will be required for every API call in headers

### Products List

Fetch Products list, set 'X-AUTH-TOKEN' in request headers

METHOD: GET 

URL: http://localhost/shop-online/public/api/products

```
Header Name: X-AUTH-TOKEN
Header Value: dbe7a82479ae4aea7f44-1558876797
```

### Product List with Pagination
METHOD: GET

URL: http://localhost/shop-online/public/api/products?page=2&limit=3


### Customer Orders
METHHOD: GET

URL: http://localhost/shop-online/public/api/customers/orders/summary

RESPONSE:
```
{
  "productsIdsArr" : {
    "0" : {"productId" : 1,"quantity" : 2},
    "1" : {"productId" : 2,"quantity" : 2},
    "2" : {"productId" : 4,"quantity" : 2}
  }
}
```

### Save Customer Orders

Save customer order details

METHOD: POST

URL: http://localhost/shop-online/public/api/customers/orders

RESPONSE: 
```
{
  "fullName":"John Smith",
  "email":"john@app.com",
  "contactNumber":"+92787887878",
  "postalCode":"46000",
  "shippingAddress":"House#xyz, Street abc",
  "city":"City name",
  "country":"Pakistan",
  "customerNotes":"I need urgent service...",
  "productsIdsArr":{
            "0": {"productId":1,"quantity":1},
            "1": {"productId":2,"quantity":1},
            "2": {"productId":4,"quantity":1}
  }
}
```

### Get Specific Order

METHOD: GET

URL: http://localhost/shop-online/public/api/customers/orders/1


### Get Customer Order List

METHOD: GET

URL: http://localhost/shop-online/public/api/customers/orders


NOTE: apitoken will be mandatory to access endpoints.

### Create Product

METHOD: POST

URL: http://localhost/shop-online/public/api/products

RESPONSE:
```
{
"title": "My final product 1",
"slug": "my-final-product-1",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "No",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://image.shutterstock.com/image-vector/grunge-red-sample-word-round-260nw-1242668641.jpg",
"description": null
}
```

###  Update Product Detaols

METHOD: PUT

URL: http://localhost/shop-online/public/api/products/19

RESPONSE: 
```
{
"title": "My final product 11",
"slug": "my-final-product-1",
"price": 222,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "No",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://image.shutterstock.com/image-vector/grunge-red-sample-word-round-260nw-1242668641.jpg",
"description": null
}
```

### Specific Product

METHOD: GET

http://localhost/shop-online/public/api/products/19

### Delete Specific Product

METHOD: DELETE

URL: http://localhost/shop-online/public/api/products/19


### Get Products having no bundles

List all products which dont have bundles so by that we can display to select when creating new bundle

METHOD: GET

URL: http://localhost/shop-online/public/api/products/notbundles


### Add Product Bundle

METHOD: POST

URL: http://localhost/shop-online/public/api/products/bundles

RESPONSE:
```
{
"title": "My final product bundle",
"slug": "my-final-product-bundle",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "Yes",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://image.shutterstock.com/image-vector/grunge-red-sample-word-round-260nw-1242668641.jpg",
"description": null,
"productsArr":{"0":23,"1":12}
}
```

###  Update Product Bundle

METHOD: PUT

URL: http://localhost/shop-online/public/api/products/bundles/25

RESPONSE:
```
{
"title": "My final product bundle",
"slug": "my-final-product-bundle",
"price": 220,
"isDiscount": "No",
"discountType": null,
"discount": 0,
"isProductBundle": "Yes",
"sku": null,
"status": "Active",
"imageType": "Link",
"image": "https://image.shutterstock.com/image-vector/grunge-red-sample-word-round-260nw-1242668641.jpg",
"description": "Awesome description",
"productsArr":{"0":3,"1":4}
}
```

### Get Product Bundle

METHOD: GET

URL: http://localhost/shop-online/public/api/products/bundles/25

### Delete Product Bundle

METHOD: DELETE

URL: http://localhost/shop-online/public/api/products/bundles/25


## Unit Tests

Run following command on project root:

>  ./bin/phpunit

#### Note
- If you get error `Failed asserting that 403 matches expected 200.` update `HTTP_X-AUTH-TOKEN` with apikey in all `tests/Controllers`, you may get that apikey from `user` table ```api_token```


Cheers !
