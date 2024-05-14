# Тестовое задание
Ожидемый результат: прототип API интернет магазина с тремя функцианальными блоками (личный кабинет пользователя, каталог товаров, административный модуль ("админка")). 

## Реализация API
### Почуму Laravel?
- API пишется для крупного интернет-магазина с большим функционалом ---> в api потребуется грамотно реализовать большое кол-во *эндпоинтов*.
  Архитектура Laravel (MVC) обеспечиват модульность кода и упрощает разработку API.
- Laravel позволяет асинхронно обрабатывать запросы, что полезно в случе обработки большого кол-ва запросов.
- Имеет готовые модули для безопасной авторизации (мы будем использовать sanctum).
- Laravel позволяет легко масштабировать приложение.

____
### Работа с базами данных
Были использованя **MySQL** и **Redis** для кэширования значиний.
#### Сиситема использования:
- MySQL:
  - Хранить все основные данные, такие как:
    - Информация о товарах (название, описание, цена, характеристики...)
    - Информация о пользователях (имя, email, адрес, телефон...)
    - Информация о заказах (товары, цены, статус, адрес доставки...)
- Redis:
  - Кэширование запрашиваемых данных:
    - При первичном запросе, данные, получаеые из SQL бд, кэшируются
    - При измении данных, запись удаляется из Redis и будет добалена при следующем запросе
    

#### MySQL
- Хорошо подходит для хранения структурированных данных, таких как информация о товарах, пользователях, заказах и т.д
- Интеграция с Laravel
#### Redis
- Обеспечивает высокую производительность и низкую задержку
- Легко масштабируется

  ![db](https://github.com/ddos-pmv/portfolio/blob/main/Untitled%20Workspace.png?raw=true)
  
### Схема обработки заказа
![](https://github.com/ddos-pmv/portfolio/blob/main/Sheme.png?raw=true)

### How to start
#### *Step 1. Создание пользователя.*
![](https://github.com/ddos-pmv/portfolio/blob/main/Reg.png?raw=true)

#### *Step 2.Получение bearer токена.*
![](https://github.com/ddos-pmv/portfolio/blob/main/Bearer.png?raw=true)

#### *Step 3. Пробуем эндпоинты.*
Все не закоментированные routes должны работать!

____
## Пример реализации кэширования (Route::get - 'goods/{good_id}/{regin_id}')
```php
public function get($good_id, $region_id){
        $cacheKey = "product_price_{$good_id}_{$region_id}";
        $data = Cache::remember($cacheKey, 60*60*60, function() use ($good_id, $region_id){
            $product = Good::find($good_id);
            if (! $product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $productName = $product->name;

            $price = Price::where(['good_id' => $good_id, 'region_id'=>$region_id])->first();
            if (! $price) {
                return response()->json(['error' => 'Price not found for this region'], 404);
            }

            $regionPrice = $price->value;

            $regionName = Region::find($region_id);

            return [
                'product_name' => $productName,
                'region_price' => $regionPrice,
                'region_name' =>$regionName->name,
                'product_quantity' => $product->quantity,

            ];

        });

        return response()->json($data);

    }
```




## Рекомендации по доработке
- *JWT авторизация*. Сейчас используется Bearer Token, выбор обусловлен тем, что я просто не успевал доделать нормальную авторизацию. Авторизация с помощью JWT токена безопаснне Bearer!
- *pgSQL*. Постгре работает немного быстрее mySQL
