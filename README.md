# virtual-vm
Виртуальный аппарат по продаже кофе 
1. Сначала скачать и установить (макс 15 минут) очень легковесный фрэймворк phalcon [по ссыльке](https://phalconphp.com/en/download/ "Phalcon framework download") 
2. Склонировать проект git clone https://github.com/guediagael/virtual-vm/ 
3. Перейти в папку проекта cd virtual-vm 
4. Если у вас нет установленного Composer, сначала установите его [здесь](https://getcomposer.org/download/)
5. Запустить composer install (внутри папки проекта) 
6. Cоздавать у себя бд с [такой же](https://drive.google.com/open?id=0B53XQ45SPFEqeVZ2a1JSZEpIRDA) структуре. 
  > Соблюдайте названия поля и таблицы, если у вас отличаются, то могу возникнут проблемы. 
7. Настройть свой бд в файлах /app/config/config.php и /test/controllers/MainControllerPhalconTest.php
8. Запустить vendor/bin/phpunit 
