create database if not exists erasiamanager character set utf8 collate utf8_unicode_ci;

use erasiamanager;

grant all privileges on erasiamanager.* to 'em_user'@'localhost' identified by '***';