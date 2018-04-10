Yii 2 REST Testing
==================

Проект был создан для тестового задания "Написать REST API для генерации рандомного числа. Каждой генерации присваивать уникальный id по которому можно получить результат генерации. Должны быть доступны 2 публичных API метода generate() и retrieve(id)." Срок - примерно за 4 вечера.

Можно протестить текущее API в **heroku** по адресу:
http://pudich-random.herokuapp.com
 
Адреса методов соответственно:
* http://pudich-random.herokuapp.com/generate
* http://pudich-random.herokuapp.com/retrieve/102

Использовать след. образом:
 
- http://pudich-random.herokuapp.com - информация о методах в HTML
 
- GET http://pudich-random.herokuapp.com/generate - при запросе получаем ID сгенерированого числа в диапазоне 0-1000.
- POST http://pudich-random.herokuapp.com/generate - при запросе можно указать в теле запроса (можно в виде JSON) границы min, max.
 
- GET http://pudich-random.herokuapp.com/retrieve/102 - получаем ответ по идентификатору (число, ссылка на текущий ресурс).
- GET http://pudich-random.herokuapp.com/retrieve/102?expand=id,created_at - при желании можно получить в ответе
- POST http://pudich-random.herokuapp.com/retrieve - ID числа можно также передавать в теле запроса (application/x-www-form-urlencoded или JSON формат)
 
При передачи заголовка Accept с *application/json* или *application/xml* ответ будет возвращен в форматах JSON или XML соответственно. Для браузера (text/html) также вернется JSON.
В случае отсутствия записи будет ответ с кодом ошибки 404.
 
При разворачивании необходимо создать БД: random, random_test (для тестирования codeception) - настройки не закомичены (локальные конфиги в .gitignore)
 
Для установки приложения надо выполнить в корне:  
``php composer.phar install`` (скачать композер если отсутствует)  
// если с git'а, то инициализировать (подключение для heroku настроено к postgresql): ``php init --env=Development``  
и запустить миграции  
```
php yii migrate  
php yii_test migrate  
```
