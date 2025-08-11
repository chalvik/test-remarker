# test-remarker
**Тестовое задание :**  Реализовать API для расчета итоговой стоимости заказа..

## Установка

- make up 
- composer install 

## Пример запроса где 

```
{
    "buyer": {
    "birth_date" : "2024-12-12",
    "gender":"m"
},
"delivery_date":"2024-12-12",
"items":[
    {
        "price": 5,
        "quantity": 5
    }
    ]
}
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
