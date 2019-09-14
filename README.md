# Zend Expressive com MongoDB

API utilizando Zend Expressive 3 com MongoDB.

### GET `/v1/populate`

```json
{
    "product": "5d7d3a3b48873b609d6523c2",
    "customer": "5d7d3a3b48873b609d6523c3",
    "order": "5d7d3a3b48873b609d6523c4"
}
```

### POST `/v1/products`

```json
{
   "sku": 8552515751438641,
   "name": "Produto",
   "price": 109
}
```

### GET `/v1/products`

```json
[
    {
        "_id": "5d7d1f61e9b32648906edaa2",
        "sku": 8552515751438641,
        "name": "Produto",
        "price": 109,
        "created_at": "2019-09-14 17:12:01",
        "updated_at": null
    }
]
```

### POST `/v1/customers`

```json
{
   "name": "Maria Aparecida de Souza",
   "cpf": "81258705044",
   "email": "mariasouza@gmail.com"
}
```

### POST `/v1/orders`

```json
{
  "status": "CONCLUDED",
  "total": 189.80,
  "buyer": {
    "_id": "5d7d1f7ce9b32648906edaa3"
  },
  "items": [
    {
      "amount": 1,
      "price_unit": 109.90,
      "total": 109.90,
      "product": {
        "_id": "5d7d1f61e9b32648906edaa2"
      }
    }
  ]
}
```

### GET `/v1/orders`

```json
[
    {
        "_id": "5d7d1fa4beb5e247d05c7032",
        "created_at": "2019-09-14 17:13:08",
        "cancelDate": "2019-09-14 17:48:53",
        "status": "CANCELLED",
        "total": 189.8,
        "buyer": {
            "_id": "5d7d1f7ce9b32648906edaa3",
            "name": "Maria Aparecida de Souza",
            "cpf": "81258705044",
            "email": "mariasouza@gmail.com",
            "created_at": "2019-09-14 17:12:28",
            "updated_at": null
        },
        "items": [
            {
                "amount": 1,
                "price_unit": 109.9,
                "total": 109.9,
                "product": {
                    "_id": "5d7d1f61e9b32648906edaa2",
                    "sku": 8552515751438643,
                    "name": "Produto",
                    "price": 109,
                    "created_at": "2019-09-14 17:12:01",
                    "updated_at": null
                }
            }
        ]
    }
]
```

### PUT `/v1/orders/{idorder}`

```json
{
	"status": "CANCELLED"
}
```
