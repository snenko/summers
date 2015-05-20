-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.41-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных u391597384_summ
CREATE DATABASE IF NOT EXISTS `u391597384_summ` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `u391597384_summ`;


-- Дамп структуры для таблица u391597384_summ.blog
DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `blogid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `blogupdate` datetime DEFAULT NULL,
  `blogstatus` varchar(1) DEFAULT NULL,
  `mask` varchar(500) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`blogid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.blog: 1 rows
DELETE FROM `blog`;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` (`blogid`, `title`, `body`, `blogupdate`, `blogstatus`, `mask`, `userid`) VALUES
	(8, 'ЕСТЬ ЛЮДИ И ЕСТЬ МЕСТА  ч.1', '<span style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);"><b>ЕСТЬ ЛЮДИ И ЕСТЬ МЕСТА </b></span><div><b style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; line-height: 19.2000007629395px;">Часть 1</b><div><b><br style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);" /></b><span style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);">(2003г.)</span></div><div><span style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);"><br /></span></div><div><span style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);"><br /></span></div><div><span style="color: rgb(0, 0, 0); font-family: \'Lucida Grande\', Arial, tahoma, verdana, sans-serif; font-size: 12px; line-height: 19.2000007629395px; background-color: rgb(255, 255, 255);">Кто-то может не понять того, о чем я сейчас расскажу. Я уже могу не помнить деталей, но суть, саму суть, надеюсь, смогу передать. С тех пор прошло немало лет, но, как и все в этом мире, история эта началась в один день...<br /><br />Я, как всегда, в тот день проснулась в вагоне метро. Честно говоря, в последнее время ничего, кроме метро, и не помнила. Я просыпалась всегда в одном и том же вагоне, на одной и той же станции… всегда в 18.32… Просыпалась, хотя совершенно не помнила, ложилась ли я здесь спать. Я, как будто, включалась и все. Я не помнила, ела ли я что-то, но чувства голода не испытывала. Перед глазами всегда были толпы людей. Люди меня иногда раздражали. Иногда просто надоедали. Я выходила из вагона на ближайшей станции… Садилась на лавочку и пыталась собраться с мыслями. Так было каждый день… Я наблюдала за пассажирами. Вслушивалась в разговоры, но не понимала ни какой сейчас год, ни какой месяц…Я не могла ответить, ни на какой хронологический вопрос, кроме разве, что того, что мне 19 лет. Почему то в этом я была уверенна на 100%. Не помнила где живу сейчас, хотя о том, где проживала раньше, вполне, могла рассказать. Я всего боялась. Страх жил внутри меня. Причины ему небыло. Но я боялась всего. Заговорить с людьми, своей амнезии, но больше всего боялась выйти из метро… От одной мысли об этом у меня замирало сердце. Прошибало в холодный пот, и подкашивались ноги… <br />Если честно, я думала, что серьезно больна. Возможно у меня какая-то фобия или шизофрения - рассуждала я. Никогда не была сильна в такой науке как психология, но ведь ясно, же как божий день, что со мной что - то очень не в порядке. Люди тоже не обращали на меня внимания. Но это было гораздо лучше, чем если бы они тыкали в меня пальцами и кричали - « Психопатка!»<br />Собаки, редкие гости подземки, шарахались от меня. Говорят, собаки чуют, когда человек болен. Вот и мой случай доказывал это. А еще я отлично понимала, что всё это началось после моей попытки самоубийства. Это тоже произошло в метро. Я тогда тоже была в ужасном состоянии. Я стояла на краю платформы и думала о том, что смерть лучший вариант, но я боялась и поэтому не прыгнула сразу. Я стояла и смотрела вниз, пока не услышала звук приближающегося поезда. Звук нарастал, и я вдруг поняла, что этот способ не лучший. И что мне, пожалуй, нужно еще пожить на этом свете. И в момент, когда все это пришло мне в голову, кто-то толкнул меня в спину. Не сильно. И, я думаю, не специально. Я не удержала равновесия и упала. Дальше сплошная полоса беспамятства, вплоть до того как несколько дней назад (сколько я точно не помню), я снова оказалась в метро. Хотя память начинала возвращаться… Хотя бы потому, что я помнила то, что произошло вчера… Настораживало отсутствие чувства голода, но мама говорила, что при нервном перенапряжении человек довольно долго может обходиться без еды.<br />Мама…<br />Вечность назад я приехала от подруги домой и увидела пожарные машины… толпы соседей и машину скорой помощи. Дома как такового уже почти не осталось. Взрыв газа… насколько я поняла… да я мало что поняла тогда…Я смотрела как выносят тела…одно за другим… Мама, папа, Корри…мой младший брат…Как же я терпеть его не могла! Доставучая такая мелюзга и вредная! А вот теперь я смотрела на то, как лежит его маленькое тело… в саже, копоти…. И я бы, не раздумывая, отдала бы свою жизнь взамен его…Я не верила во взрыв газа. Соседи шептались о том, что час назад около дома остановился фургон, а через секунду дом уже пылал от взрыва…Я знала, что у отца были какие-то проблемы. Но меня никогда не волновало это. Я думала о подругах, походах в магазин, о парнях… Мой папа был мэром нашего городка, и я жила вполне отличной жизнью. Разговоры родителей на кухне о звонках и угрозах я слышала, но пропускала «мимо ушей». Джон Харпер был чертовски спокойным человеком. Он не давал мне почувствовать ни тени тревоги. Мой отец никогда небыл трусом. И только потом я поняла, что именно в моменты, когда ситуация с угрозами накалялась - он отправлял меня к Шерон…Я была у нее и в тот день. Мама же, обычно, забирала Корри к бабушке…В наше отсутствие отец все улаживал. И вскоре жизнь входила в обычное русло.<br />Но все люди ошибаются. И он просчитался. Где-то недосмотрел, чего-то не предусмотрел. И моя семья погибла, в один день. Я осталась одна. Из родных была только бабушка, но она жила в соседнем городе и я сразу как-то о ней не подумала. Да о чем я могла подумать? Моя жизнь рухнула. Я хлопнулась с ванильных небес в реальный мир. В весь ужас того, что произошло .Меня забрала семья Шерон. Три дня я лежала в кровати и не могла ни есть, ни спать… Три дня слились в сплошной бред и ступор. Шерон позвонила в какой-то реабилитационный центр. Меня определили в больницу - похожую на санаторий. Там мне стало еще хуже. Я насмотрелась чужого горя и окончательно зациклилась на своём. От таблеток я стала спокойной. Все что во мне накопилось - просто затаилось внутри, и когда подруга забрала меня к себе я сбежала от нее. Написав на прощание, что мне не нужна подруга, готовая запереть меня в психушку. Тогда я и спустилась в метро…<br />И вот результат: неудачная попытка суицида подарила мне амнезию и уродливый отпечаток на шее, толи шрам то ли ожег. Мерзкая красная полоса, я увидела его в отражении на окнах вагона. В который раз я оценила преимущество толпы, где никому до тебя нет дела. Никто не обращает внимания на еще одну ненормальную. Хватит с меня и собак.<br /><br />Но в тот день ,когда началась эта история все было иначе...</span></div></div>', '2015-04-20 20:15:18', '1', NULL, 1);
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;


-- Дамп структуры для таблица u391597384_summ.carousel
DROP TABLE IF EXISTS `carousel`;
CREATE TABLE IF NOT EXISTS `carousel` (
  `carousel_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `description` text,
  `picture` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  PRIMARY KEY (`carousel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.carousel: 2 rows
DELETE FROM `carousel`;
/*!40000 ALTER TABLE `carousel` DISABLE KEYS */;
INSERT INTO `carousel` (`carousel_id`, `title`, `productid`, `description`, `picture`, `url`, `sort_order`) VALUES
	(2, 'Кольє "Бриз" підкреслює твою красу', 6, '', 'image_5536570809fd1.jpg', '', 0),
	(3, 'Ти гарненька та цікава', 8, '', 'image_5536574fb9182.jpg', '', 0);
/*!40000 ALTER TABLE `carousel` ENABLE KEYS */;


-- Дамп структуры для таблица u391597384_summ.gallery
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `galleryid` int(11) NOT NULL AUTO_INCREMENT,
  `galleryname` varchar(255) NOT NULL,
  `description` text,
  `picture` varchar(255) DEFAULT NULL,
  `meta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`galleryid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.gallery: 3 rows
DELETE FROM `gallery`;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` (`galleryid`, `galleryname`, `description`, `picture`, `meta`) VALUES
	(6, 'Кольє', '', 'image_55343775ac032.jpg', 'Кольє'),
	(7, 'Сережки', '', 'image_553438ca9a7a2.jpg', 'Сережки'),
	(8, 'Клатч', '', 'image_553438e6e1ed0.jpg', 'Клатч, сумочка');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;


-- Дамп структуры для таблица u391597384_summ.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `pictures` text,
  `url` text,
  `meta` varchar(255) DEFAULT NULL,
  `gallerys` text,
  PRIMARY KEY (`productid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.product: 6 rows
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`productid`, `name`, `description`, `pictures`, `url`, `meta`, `gallerys`) VALUES
	(5, 'Сережки "Взгляд сокола."', 'Бусины натуральный камень - соколиный глаз.\r\nЦена 35 грн.', 'image_553439881f026.jpg', NULL, 'Бусины, натуральный камень', NULL),
	(6, 'Колье "Омут"', 'Колье "Омут" Лабрадоры, сваровски, речной жемчуг, японский бисер ТОХО и Делика', 'image_553439de87ada.jpg,image_553439de8f372.jpg,image_553439de96c71.jpg,image_553439de9d573.jpg', NULL, 'Лабрадоры, сваровски, речной жемчуг, японский бисер ТОХО', NULL),
	(7, 'Колье "Бриз".', 'Летнее колье для отпуска, пляжа и хорошего настроения.Чешский бисер, японский бисер, говлит, пауа( гелиотис) аммониты, жемчуг речной натуральный. Изнанка натуральная кожа.', 'image_55343a3bd4b26.jpg,image_55343a3bdd745.jpg', NULL, 'натуральная кожа, жемчуг речной натуральный, аммониты, чешский бисер, японский бисер, говлит', NULL),
	(8, 'Колье "Апрельское утро"', 'Колье "Апрельское утро". Агаты, авантюрин, чешский и японский бисер. Сделано на заказ.', 'image_55343b05f30b8.jpg,image_55343b0607179.jpg,image_55343b060ddba.jpg', NULL, '', NULL),
	(9, 'Колье-трансформер', 'Колье-трансформер .Сделано на заказ.', 'image_55343b47298ed.jpg,image_55343b4730725.jpg,image_55343b473683e.jpg,image_55343b473cf61.jpg', NULL, '', NULL),
	(10, 'кольє1', 'Кольє патріотичне, синьожовте.', 'image_55352ef35edde.jpg', NULL, '', NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Дамп структуры для таблица u391597384_summ.sub_product_gallery
DROP TABLE IF EXISTS `sub_product_gallery`;
CREATE TABLE IF NOT EXISTS `sub_product_gallery` (
  `productid` int(11) NOT NULL,
  `galleryid` int(11) NOT NULL,
  PRIMARY KEY (`productid`,`galleryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.sub_product_gallery: 6 rows
DELETE FROM `sub_product_gallery`;
/*!40000 ALTER TABLE `sub_product_gallery` DISABLE KEYS */;
INSERT INTO `sub_product_gallery` (`productid`, `galleryid`) VALUES
	(5, 7),
	(6, 6),
	(7, 6),
	(8, 6),
	(9, 6),
	(10, 6);
/*!40000 ALTER TABLE `sub_product_gallery` ENABLE KEYS */;


-- Дамп структуры для таблица u391597384_summ.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `recordid` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`recordid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы u391597384_summ.user: 1 rows
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`recordid`, `username`, `password`, `role`) VALUES
	(1, 'snenko', '*1C583FE4270FDE8D6C31E1837060426D24C2DACF', 'admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
