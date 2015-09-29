-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 29 sep 2015 om 11:07
-- Serverversie: 5.6.17
-- PHP-versie: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `amateurlcs_solomid`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leagues_config`
--

CREATE TABLE IF NOT EXISTS `leagues_config` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`type` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Gegevens worden geëxporteerd voor tabel `leagues_config`
--

INSERT INTO `leagues_config` (`id`, `name`, `type`) VALUES
(13, 'Round Robin Test 1', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leagues_config_round_robin`
--

CREATE TABLE IF NOT EXISTS `leagues_config_round_robin` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`weeks` int(11) NOT NULL,
`current_week` int(11) NOT NULL,
`amount_of_teams` int(11) NOT NULL,
`match_results` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `leagues_config_round_robin`
--

INSERT INTO `leagues_config_round_robin` (`id`, `league_id`, `weeks`, `current_week`, `amount_of_teams`, `match_results`) VALUES
(2, 13, 3, 0, 4, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leagues_config_single_ele`
--

CREATE TABLE IF NOT EXISTS `leagues_config_single_ele` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`current_round` int(11) NOT NULL,
`round_progression` int(11) NOT NULL,
`match_results` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leagues_round_robin_teams`
--

CREATE TABLE IF NOT EXISTS `leagues_round_robin_teams` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`team_id` int(11) NOT NULL,
`points` int(11) NOT NULL,
`games_won` int(11) NOT NULL,
`games_lost` int(11) NOT NULL,
`games_played` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden geëxporteerd voor tabel `leagues_round_robin_teams`
--

INSERT INTO `leagues_round_robin_teams` (`id`, `league_id`, `team_id`, `points`, `games_won`, `games_lost`, `games_played`) VALUES
(7, 13, 21, 0, 0, 0, 0),
(8, 13, 22, 0, 0, 0, 0),
(9, 13, 23, 0, 0, 0, 0),
(10, 13, 24, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leagues_single_ele_teams`
--

CREATE TABLE IF NOT EXISTS `leagues_single_ele_teams` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`team_id` int(11) NOT NULL,
`defeated` int(11) NOT NULL,
`current_round` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Gegevens worden geëxporteerd voor tabel `leagues_single_ele_teams`
--

INSERT INTO `leagues_single_ele_teams` (`id`, `league_id`, `team_id`, `defeated`, `current_round`) VALUES
(126, 9, 54654654, 0, 5),
(127, 9, 7888, 0, 5),
(128, 9, 7777, 0, 5),
(129, 9, 55545, 0, 5),
(130, 9, 199898, 0, 5),
(131, 9, 78987987, 0, 5),
(132, 9, 31231231, 0, 5),
(133, 9, 6666699, 0, 5),
(134, 9, 787, 0, 5),
(135, 9, 39343, 0, 5),
(136, 9, 777, 0, 5),
(137, 9, 1234, 0, 5),
(138, 9, 4567, 0, 5),
(139, 9, 123, 0, 5),
(140, 9, 68586, 0, 5),
(141, 9, 1235, 0, 5),
(142, 9, 352524, 0, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `management`
--

CREATE TABLE IF NOT EXISTS `management` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`field` varchar(40) NOT NULL,
`value` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden geëxporteerd voor tabel `management`
--

INSERT INTO `management` (`id`, `field`, `value`) VALUES
(1, 'registration_open', '0'),
(2, 'enable_login', '1'),
(3, 'region_select', '1'),
(4, 'team_kicks', '3'),
(5, 'change_teamname', '1'),
(6, 'team_creation', '1'),
(7, 'pass_captainship', '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `matches_round_robin`
--

CREATE TABLE IF NOT EXISTS `matches_round_robin` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`week_id` int(11) NOT NULL,
`team_1` int(11) NOT NULL,
`team_2` int(11) NOT NULL,
`winning_team` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Gegevens worden geëxporteerd voor tabel `matches_round_robin`
--

INSERT INTO `matches_round_robin` (`id`, `league_id`, `week_id`, `team_1`, `team_2`, `winning_team`) VALUES
(16, 13, 1, 21, 23, 0),
(17, 13, 1, 22, 24, 0),
(18, 13, 2, 21, 22, 0),
(19, 13, 2, 24, 23, 0),
(20, 13, 3, 21, 24, 0),
(21, 13, 3, 23, 22, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `matches_single_ele`
--

CREATE TABLE IF NOT EXISTS `matches_single_ele` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`league_id` int(11) NOT NULL,
`round_id` int(11) NOT NULL,
`team_1` int(11) NOT NULL,
`team_2` int(11) NOT NULL,
`winning_team` int(11) NOT NULL,
`position` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=852 ;

--
-- Gegevens worden geëxporteerd voor tabel `matches_single_ele`
--

INSERT INTO `matches_single_ele` (`id`, `league_id`, `round_id`, `team_1`, `team_2`, `winning_team`, `position`) VALUES
(795, 9, 5, 0, 0, 0, 16),
(796, 9, 4, 0, 0, 0, 1),
(797, 9, 4, 0, 0, 0, 2),
(798, 9, 4, 0, 0, 0, 3),
(799, 9, 4, 0, 0, 0, 4),
(800, 9, 4, 0, 0, 0, 5),
(801, 9, 4, 0, 0, 0, 6),
(802, 9, 4, 0, 0, 0, 7),
(803, 9, 4, 0, 0, 0, 8),
(804, 9, 3, 0, 0, 0, 1),
(805, 9, 3, 0, 0, 0, 2),
(806, 9, 3, 0, 0, 0, 3),
(807, 9, 3, 0, 0, 0, 4),
(808, 9, 2, 0, 0, 0, 1),
(809, 9, 2, 0, 0, 0, 2),
(810, 9, 1, 0, 0, 0, 1),
(811, 9, 6, 19, 20, 0, 1),
(812, 9, 6, 21, 122, 0, 2),
(813, 9, 6, 222, 2222, 0, 3),
(814, 9, 6, 22222, 333, 0, 4),
(815, 9, 6, 3333, 19333, 0, 5),
(816, 9, 6, 2066, 19787, 0, 6),
(817, 9, 6, 989, 7897897, 0, 7),
(818, 9, 6, 56465, 99999, 0, 8),
(819, 9, 6, 98989, 98798798, 0, 9),
(820, 9, 6, 666, 7878, 0, 10),
(821, 9, 5, 1965646, 778787, 0, 1),
(822, 9, 5, 44545, 888, 0, 2),
(823, 9, 5, 197777, 54654654, 0, 3),
(824, 9, 5, 7888, 7777, 0, 4),
(825, 9, 5, 55545, 199898, 0, 5),
(826, 9, 5, 78987987, 31231231, 0, 6),
(827, 9, 5, 6666699, 787, 0, 7),
(828, 9, 5, 39343, 777, 0, 8),
(829, 9, 5, 1234, 4567, 0, 9),
(830, 9, 5, 123, 68586, 0, 10),
(831, 9, 5, 1235, 352524, 0, 11),
(832, 9, 5, 0, 0, 0, 12),
(833, 9, 5, 0, 0, 0, 13),
(834, 9, 5, 0, 0, 0, 14),
(835, 9, 5, 0, 0, 0, 15),
(836, 9, 5, 0, 0, 0, 16),
(837, 9, 4, 0, 0, 0, 1),
(838, 9, 4, 0, 0, 0, 2),
(839, 9, 4, 0, 0, 0, 3),
(840, 9, 4, 0, 0, 0, 4),
(841, 9, 4, 0, 0, 0, 5),
(842, 9, 4, 0, 0, 0, 6),
(843, 9, 4, 0, 0, 0, 7),
(844, 9, 4, 0, 0, 0, 8),
(845, 9, 3, 0, 0, 0, 1),
(846, 9, 3, 0, 0, 0, 2),
(847, 9, 3, 0, 0, 0, 3),
(848, 9, 3, 0, 0, 0, 4),
(849, 9, 2, 0, 0, 0, 1),
(850, 9, 2, 0, 0, 0, 2),
(851, 9, 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` int(11) NOT NULL,
`sender` int(11) NOT NULL,
`receiver` int(11) NOT NULL,
`m_title` text NOT NULL,
`m_body` text NOT NULL,
`send_at` datetime NOT NULL,
`read_at` datetime NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`tag` varchar(10) NOT NULL,
`captain_id` int(11) NOT NULL,
`kicks_left` tinyint(4) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`,`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `tag`, `captain_id`, `kicks_left`) VALUES
(21, 'Team 1', 'T1', 1, 2),
(22, 'Team 2 ', 'T2', 9, 2),
(23, 'Team 3', 'T3', 10, 2),
(24, 'Team 4', 'T4', 11, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams_roles`
--

CREATE TABLE IF NOT EXISTS `teams_roles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`team_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`role_id` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Gegevens worden geëxporteerd voor tabel `teams_roles`
--

INSERT INTO `teams_roles` (`id`, `team_id`, `user_id`, `role_id`) VALUES
(23, 21, 1, 1),
(26, 22, 9, 1),
(27, 23, 10, 1),
(28, 24, 11, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(30) NOT NULL,
`email` varchar(50) NOT NULL,
`password` varchar(100) NOT NULL,
`type` int(11) NOT NULL DEFAULT '2',
`last_login` datetime NOT NULL,
`data_reloaded` datetime NOT NULL,
`role_pref` varchar(30) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `type`, `last_login`, `data_reloaded`, `role_pref`) VALUES
(1, 'Kaiprioska', 'kaiprioska@gmail.com', '$2y$10$VvumsLTfDIrhXpluaUtS/.aXVpAL4w5CDfJ9KoWQvTTYgqAJW2X9W', 3, '2015-09-29 11:06:03', '0000-00-00 00:00:00', ''),
(9, 'metazoans98', 'vanmulders1992@gmail.com', '$2y$10$78F.IEigpv40GB4yBiGoY.sE0nMcQcGA8TQQ9z2DAZ04ICDkmZ5uy', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(10, 'Captain 3', 'ggg', '$2y$10$eINOBzWMczvDbIiFAmSpeuBgGVshYOj3nqlY1712VIY5GDn.VUDXy', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(11, 'Captain 4', 'gbdgf', '$2y$10$lPYZF9BBrvJ0uRVGDLWSzu3/PEGLZkDlvPZKjTG39qpH7RWwkcfOS', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(12, 'Solo player 1', 'vbvcbxbcvbxcv', '$2y$10$i83WrLMhCifO9kQiCHEUd.nGJz0TrWRaHypMn3/I//U1CdzKcjYOi', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(13, 'Solo player 2', 'vbcvbxcv', '$2y$10$74Fc72If4q665cgx7L8uDOTir1MCEewdoOqeDfkgyrNuqQl/cqpb.', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(14, 'Solo player', 'fgfgdfgdfgd', '$2y$10$rIO.C9SIwRuC9EjOM3HHq.e.aT9n87D2fmuwclkrqZcnapJRfpZou', 2, '2015-09-29 11:05:01', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_champions`
--

CREATE TABLE IF NOT EXISTS `users_champions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`champion_id` tinyint(4) NOT NULL,
`games_played` smallint(6) NOT NULL,
`games_won` smallint(6) NOT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Gegevens worden geëxporteerd voor tabel `users_champions`
--

INSERT INTO `users_champions` (`id`, `user_id`, `champion_id`, `games_played`, `games_won`) VALUES
(6, 9, 25, 69, 41),
(7, 9, 127, 46, 32),
(8, 9, 18, 43, 20),
(9, 9, 127, 37, 15),
(10, 9, 22, 36, 21),
(11, 1, 40, 95, 53),
(12, 1, 12, 35, 20),
(13, 1, 127, 29, 17),
(14, 1, 117, 28, 17),
(15, 1, 127, 24, 16);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_shoutcasters`
--

CREATE TABLE IF NOT EXISTS `users_shoutcasters` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`type` int(11) NOT NULL,
`vod` varchar(100) NOT NULL,
`days` varchar(30) NOT NULL,
`details` text NOT NULL,
PRIMARY KEY (`id`),
KEY `users_shoutcasters_ibfk_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `users_shoutcasters`
--

INSERT INTO `users_shoutcasters` (`id`, `user_id`, `type`, `vod`, `days`, `details`) VALUES
(2, 1, 1, 'dsfdsfds', '2;4;', 'dsfdsfds');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_statistics`
--

CREATE TABLE IF NOT EXISTS `users_statistics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`summoner_id` int(11) NOT NULL,
`games_played` smallint(6) NOT NULL,
`games_won` smallint(6) NOT NULL,
`rank_solo` tinyint(4) NOT NULL,
`rank_v5` tinyint(4) NOT NULL,
`rank_v3` tinyint(4) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden geëxporteerd voor tabel `users_statistics`
--

INSERT INTO `users_statistics` (`id`, `user_id`, `summoner_id`, `games_played`, `games_won`, `rank_solo`, `rank_v5`, `rank_v3`) VALUES
(1, 1, 44338650, 392, 208, 18, 7, 13),
(4, 9, 61712877, 298, 156, 21, 0, 0),
(5, 10, 0, 0, 0, 0, 0, 0),
(6, 11, 0, 0, 0, 0, 0, 0),
(7, 12, 0, 0, 0, 0, 0, 0),
(8, 13, 0, 0, 0, 0, 0, 0),
(9, 14, 0, 0, 0, 0, 0, 0);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `teams_roles`
--
ALTER TABLE `teams_roles`
ADD CONSTRAINT `teams_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `teams_roles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `users_champions`
--
ALTER TABLE `users_champions`
ADD CONSTRAINT `users_champions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `users_champions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `users_shoutcasters`
--
ALTER TABLE `users_shoutcasters`
ADD CONSTRAINT `users_shoutcasters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `users_statistics`
--
ALTER TABLE `users_statistics`
ADD CONSTRAINT `users_statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `users_statistics_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
