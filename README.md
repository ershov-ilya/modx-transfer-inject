MODX Revolution website merging php-script
======

Allows to inject a MODX subsite into existing mother MODX website.

1. First you need to upload the package to webserver which has access to both databases of donor and aceptor websites

2. Then need to fill the config files:
  1. Fill **core.config.sample.php** file and rename it to **core.config.php**
  2. Fill **donor.config.sample.php** file and rename it to **donor.config.php**
  3. Fill **aceptor.config.sample.php** file and rename it to **aceptor.config.php**

3. And then refer to /index.html to next steps

По-русски
======
Скрипт нужен, когда есть основной сайт и в подпаке лежит другой сайт MODX, а потом начальство решило, что админка должна быть общей...
все Шаблоны, Ресурсы, ТВшки, Чанки и т.д. из одного MODX перетащить в другой.