# montessori-php

The purpose of this repository is for development from PHP mysql_* statements to mysqli_*.

THE KEY PROBLEM/GOAL: to have all mysqli_* work properly and thus add, update, and 
delete records in the project database. Currently, the exising mysql_* statements are
sometimes resulting in failed queries. For example, on executing a mysql_update query,
an error is thrown and no update to the record takes place.

This repository contains all files -- including mostly PHP files -- that make up
the website of a Montessori school. The PHP code, most of it created in 2003, makes queries 
to a MySQL database by using mysql_* statements. In 2003 the commercial host for the site
was running PHP 4 and MySQL 4 database server; the hosting company has migrated to PHP 5.6
and MySQL 5.5.54 database server. 
