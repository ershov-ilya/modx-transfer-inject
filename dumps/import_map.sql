-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 10 2015 г., 15:51
-- Версия сервера: 5.1.63
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `arsenal_newsbs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `import_map`
--

CREATE TABLE `import_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `donor_id` int(11) unsigned NOT NULL,
  `aceptor_id` int(11) unsigned NOT NULL,
  `entity` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `donor_id` (`donor_id`,`aceptor_id`,`entity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;
