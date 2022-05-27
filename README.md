# bulletin-service
API сервис для хранения и подачи объявлений.

# Детали

**Метод получения списка объявлений**

- Пагинация: на одной странице должно присутствовать 10 объявлений;
- Cортировки: по цене (возрастание/убывание) и по дате создания (возрастание/убывание);
- Поля в ответе: название объявления, ссылка на главное фото (первое в списке), цена.

**Метод получения конкретного объявления**

- Обязательные поля в ответе: название объявления, цена, ссылка на главное фото;
- Опциональные поля (можно запросить, передав параметр fields): описание, ссылки на все фото.

**Метод создания объявления**

- Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена;
- Возвращает ID созданного объявления и код результата (ошибка или успех).