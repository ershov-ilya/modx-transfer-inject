MODX Revolution website merging php-script
======

Allows to inject a MODX subsite into existing mother MODX website.

1. First you need install same packages on acceptor website as on donor from package repositories

2. Then upload this script package to webserver which has access to both databases of donor and aceptor websites

3. Then need to fill the config files:

  1. Fill **core.config.sample.php** file and rename it to **core.config.php**

  2. Fill **donor.config.sample.php** file and rename it to **donor.config.php**

  3. Fill **acceptor.config.sample.php** file and rename it to **acceptor.config.php**

4. Import /dumps/import_map.sql into DB of acceptor site

5. Manually insert first entry to the table "import_map", where:

  * id = 1 (autoincrement)

  * donor_id = 0 (Root of old website)

  * aceptor_id = Here place ID of resource tree element where you want to inject donor website content (any resource of acceptor site)

  * entity = resource

  * name = ROOT

6. And then refer to /index.html for next steps

По-русски
======
Скрипт нужен, когда есть основной сайт и в подпаке лежит другой сайт MODX, а потом начальство решило, что админка должна быть общей...
все Шаблоны, Ресурсы, ТВшки, Чанки и т.д. из одного MODX перетащить в другой. Всё что написано ниже - сделать Обязательно.

Позволяет импортировать один сайт на MODx в доугой существующий сайт на MODX.

1. Прежде всего, необходимо установить те же пакеты на сайте Приёмнике, как у Донора из репозитория пакетов

2. Затем загрузить этот скрипт на веб-сервер, у которого есть доступ к обеим базам данных как Донора, так и Приёмника

3. Затем нужно заполнить конфигурационные файлы:

   1. Заполните **core.config.sample.php** файл и переименуйте его в **core.config.php**

   2. Заполните **donor.config.sample.php** файл и переименуйте его в **donor.config.php**

   3. Заполните **acceptor.config.sample.php** файл и переименуйте его в **acceptor.config.php**


4. Импортируйте /dumps/import_map.sql в БД сайта Приёмника

5. Вручную вставить первую запись в таблицу "import_map", где:

  * ID = 1 (автоинкремент)

  * donor_id = 0 (корень старого сайта)

  * aceptor_id = Здесь впишите идентификатор ресурса дерева документов, куда вы хотите прицепить содержание веб-сайта Донора (любой ресурс сайта Приёмника)

  * entity = resource

  * name = ROOT

6. И затем перейте к /index.html для последующих шагов