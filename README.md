MODX Revolution website merging php-script
======

Allows to inject a MODX subsite into existing mother MODX website.

1. First you need install same packages on acceptor website as on donor from package repositories

2. Then upload this package to webserver which has access to both databases of donor and aceptor websites

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
все Шаблоны, Ресурсы, ТВшки, Чанки и т.д. из одного MODX перетащить в другой.