CREATE DATABASE `apimood` CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `apimood`;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `users` VALUES (1,'Pedro Torres','pedro@gmail.com','$2y$10$wPGHsRebcvsOyz2hLViCq.BkbdBsa2nRmmsWCiGRcNMpImOHeaOS.');

--
-- Table structure for table `phrases`
--

CREATE TABLE IF NOT EXISTS `phrases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `phrases` VALUES (1,'sigue sonriendo, lo estas haciendo bien'),(2,'tómate un momento para respirar y recuperar la calma'),(3,'estás haciendo lo mejor que puedes, y eso está bien'),(4,'está bien parar. Descansa y vuelve con fuerzas'),(5,'respira profundo. Puedes controlar tu reacción'),(6,'hoy es un buen día para cuidar de ti'),(7,'a veces, no pasa nada... y eso está bien. Es el momento perfecto para respirar y reconectar'),(8,'levántate, muévete, cambia de espacio. El ánimo a veces está en el movimiento'),(9,'tal vez hoy no sea emocionante, pero aun puede ser significativo'),(10,'el mundo sigue siendo interesante, solo tienes que girar un poco el enfoque'),(11,'respira, no tienes que resolverlo todo hoy'),(12,'estás a salvo, este momento pasará, como todos los anteriores'),(13,'lo estás haciendo bien, incluso si no lo sientes así ahora'),(14,'poco a poco, paso a paso. No tienes que correr'),(15,'esta bien no saber qué hacer. Solo respira y da un paso a la vez'),(16,'confía en que poco a poco todo tomará forma'),(17,'la claridad llega cuando dejas de forzarla y simplemente escuchas'),(18,'incluso en la niebla el camino existe. Solo avanza con calma'),(19,'no todos los días son buenos, pero siempre hay algo bueno en cada día'),(20,'permítete descansar, pero no renuncies'),(21,'tu fuerza no está en no caer, sino en seguir levantándote'),(22,'está bien estar triste. A veces, sentir es el primer paso para sanar'),(23,'la nostalgia solo existe porque lo vivido valió la pena'),(24,'la nostalgia es una forma del corazón de decir que algo fue hermoso'),(25,'recordar no siempre es doloroso; a veces es la forma de honrar lo vivido'),(26,'deja que los recuerdos te abracen, pero que no te detengan'),(27,'no todas las preguntas necesitan una respuesta inmediata'),(28,'tu silencio también dice mucho. Escúchalo sin prisa'),(29,'tu mente esta buscando claridad. Confía en que llegará'),(30,'tu enojo tiene una razón. Escúchalo, pero no dejes que te controle'),(31,'a veces, estar en silencio es más fuerte que reaccionar'),(32,'no eres tu enojo, eres quien decide qué hacer con el'),(33,'el control no está en lo que te pasa, sino en cómo eliges responder'),(34,'antes de actuar, respira. No dejesque una emoción momentánea marque tu día'),(35,'disfruta este momento, te lo mereces más de lo que crees'),(36,'que tu alegría se quede tanto como lo necesites'),(37,'cuando sonries, todo al alrededor también lo nota'),(38,'aprovecha cada segundo de esta felicidad. Es tuya te la haz ganado'),(39,'sigue así, lo estás haciendo increíble'),(40,'estás haciendo la diferencia, sigue dejando huella'),(41,'estás en el camino correcto, confía en tu proceso'),(42,'el impulso que llevas es imparable, sigue avanzando'),(43,'a veces, pensar demasiado solo nos aleja de la respuesta más sencilla'),(44,'en el silencio de la mente, nacen las decisiones más sabias'),(45,'reflexionar no es dudar, es prepararse para elegir mejor'),(46,'cada pensamiento profundo es una semilla de claridad futura');

--
-- Table structure for table `moods`
--

CREATE TABLE IF NOT EXISTS `moods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emotion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emotion` (`emotion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `moods` VALUES (8,'aburrido, aburrida'),(5,'ansioso, ansiosa, estresado, estresada, nervioso, nerviosa, preocupado, preocupada'),(6,'cansado, cansada, agotado, agotada'),(7,'confundido, confundida'),(4,'enojado, enojada, molesto, molesta, frustrado, frustrada, furioso, furiosa, irritado, irritada'),(1,'feliz, contento, contenta, alegre, positivo, positiva'),(2,'motivado, motivada'),(9,'neutral, normal, ok'),(10,'pensativo, pensativa'),(3,'triste, mal, deprimido, deprimida, desanimado, desanimada, nostálgico, nostálgica');

--
-- Table structure for table `mood_phrases`
--

CREATE TABLE IF NOT EXISTS `mood_phrases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mood_id` int(11) DEFAULT NULL,
  `phrase_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `mood_phrases` VALUES (1,3,3),(2,3,13),(3,3,19),(4,3,22),(5,3,23),(6,3,24),(7,3,25),(8,3,26),(9,4,2),(10,4,5),(11,4,30),(12,4,31),(13,4,32),(14,4,33),(15,4,34),(16,5,3),(17,5,7),(18,5,11),(19,5,12),(20,5,13),(21,5,14),(22,5,15),(23,5,16),(24,6,1),(25,6,3),(26,6,4),(27,6,6),(28,6,11),(29,6,13),(30,6,14),(31,6,19),(32,6,21),(33,6,20),(34,7,15),(35,7,16),(36,7,17),(37,7,18),(38,7,27),(39,7,29),(40,8,8),(41,8,9),(42,8,10),(43,8,15),(44,8,19),(45,9,36),(46,9,37),(47,9,38),(48,10,7),(49,10,29),(50,10,27),(51,1,38),(52,1,37),(53,1,36),(54,1,35),(55,2,39),(56,2,40),(57,2,41),(58,2,42),(59,10,43),(60,10,44),(61,10,45),(62,10,46);

--
-- Table structure for table `daily_moods`
--

CREATE TABLE IF NOT EXISTS `daily_moods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `state` varchar(200) NOT NULL,
  `phrase_id` int(11) DEFAULT NULL,
  `daily_date` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_date` (`daily_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;