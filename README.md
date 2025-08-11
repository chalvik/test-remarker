# test-remarker
**Тестовое задание :**  Реализовать API для расчета итоговой стоимости заказа..

## Установка

- make vendor
- make up


## Пример запроса где 

```
 curl -X POST http://localhost:8888/order/calc \
  -H "Content-Type: application/json" \
  -d '{
    "buyer": { "birth_date": "1958-05-10", "gender": "female" },
    "delivery_date": "2025-08-20T12:00:00+00:00",
    "items": [
      { "name": "pizza", "price": 10.00, "quantity": 10 }, 
      { "name": "cola", "price": 2.50, "quantity": 2 } 
    ]
  }'
```

### - buyer - покупатель 
* - `birth_date` - день рождения 
* - `gender` - пол (m,f,male,female)
### `delivery_date` - дата заказа

### - items - массив товаров
* - `price` - базовая цена
* - `quantity` - кол-во


# tests
## vendor/bin/phpunit tests
