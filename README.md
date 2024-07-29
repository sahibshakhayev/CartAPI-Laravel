# Cart Management API

This is a simple Cart Management API built with Laravel. The API provides endpoints to manage cart items, including adding, updating, removing items, and calculating totals.

## Author

Developed by: Sahib Shakhayev as ADAS Exam Task

## Endpoints

### Get All Cart Items

**Request:**

GET /cart



**Response:**

```json
{
    "cartItems": [
        {
            "id": 1,
            "product_name": "Product 1",
            "quantity": 2,
            "price": 34.5
        },
        {
            "id": 2,
            "product_name": "Product 2",
            "quantity": 1,
            "price": 50.0
        }
    ],
    "X-CSRF-TOKEN": "tWuj5rptM4ups8lMv55fdDxt5KpUyrG1oKn5fH0f"
}
```

### Get One Cart Item

Request:

GET /cart/item/{id}

Response (success):

```json
{
    "cartItem": {
        "id": 1,
        "product_name": "Product 1",
        "quantity": 2,
        "price": 34.5
    }
}
```
Response (error):

```json
{
    "error": "Cart item not found"
}
```

### Add a Cart Item
Request:

POST /cart/add<br>
Content-Type: application/json

```json
{
    "id": 3,
    "product_name": "Product 3",
    "quantity": 3,
    "price": 25.0
}
```

Response:

```json
{
    "cartItem": {
        "id": 3,
        "product_name": "Product 3",
        "quantity": 3,
        "price": 25.0,
        "created_at": "2024-07-29T12:48:54.000000Z",
        "updated_at": "2024-07-29T12:48:54.000000Z"
    }
}
```

### Add Multiple Cart Items
Request:


POST /cart/multiple-add<br>
Content-Type: application/json

```json
{
    "items": [
        {
            "id": 4,
            "product_name": "Product 4",
            "quantity": 2,
            "price": 40.0
        },
        {
            "id": 5,
            "product_name": "Product 5",
            "quantity": 1,
            "price": 60.0
        }
    ]
}
```

Response:

```json
{
    "addedItems": [
        {
            "id": 4,
            "product_name": "Product 4",
            "quantity": 2,
            "price": 40.0,
            "created_at": "2024-07-29T12:48:54.000000Z",
            "updated_at": "2024-07-29T12:48:54.000000Z"
        },
        {
            "id": 5,
            "product_name": "Product 5",
            "quantity": 1,
            "price": 60.0,
            "created_at": "2024-07-29T12:48:54.000000Z",
            "updated_at": "2024-07-29T12:48:54.000000Z"
        }
    ]
}
```

### Update a Cart Item
Request:

PUT /cart/update/{id}<br>
Content-Type: application/json

```json
{
    "product_name": "Updated Product",
    "quantity": 5,
    "price": 35.0
}
```

Response:

```json
{
    "cartItem": {
        "id": 1,
        "product_name": "Updated Product",
        "quantity": 5,
        "price": 35.0,
        "created_at": "2024-07-29T12:48:54.000000Z",
        "updated_at": "2024-07-29T12:48:54.000000Z"
    }
}
```

Response (error):

```json
{
    "error": "Cart item not found"
}
```


### Remove a Cart Item
Request:

DELETE /cart/remove-item/{productId}<br>
Response (success):

```json
{
    "message": "Item removed"
}
```

Response (error):

```json
{
    "error": "Cart item not found"
}
```

### Remove All Cart Items
Request:

DELETE /cart/remove-all


Response:

```json
{
    "message": "All items removed"
}
```


### Get Cart Subtotal
Request:

GET /cart/subtotal <br>

Response:

```json

{
    "subtotal": 100.0
}

```

### Get Cart Total
Request:

GET /cart/total
Response:

```json

{
    "total": 120.0
}
```

### Get Cart Tax
Request:

GET /cart/tax

Response:

```json
{
    "tax": 20.0
}
```


### Set Tax Rate

Request:
PUT /cart/setTax

Content-Type: application/json
```json
{
    "taxRate": 0.25
}
```

Response:

```json
{
    "message": "Tax is set"
}
```

### Get Cart Item Count
Request:


GET /cart/count

Response:

```json
{
    "count": 10
}
```

## CSRF Protection
For all POST, PUT, and DELETE requests, make sure to include the CSRF token in your requests. In Laravel, this token can be retrieved from the meta tag in your Blade templates:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

#### Example for AJAX Requests

``` javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

Include this setup in your JavaScript to ensure that the CSRF token is sent with all AJAX requests.

## Installation
* Clone the repository.
* Run composer install to install the dependencies.
* Copy .env.example to .env and configure your database settings.
* Run php artisan migrate to create the database tables.
* Run php artisan serve to start the development server.

## License
This project is open-source and available under the MIT License.
