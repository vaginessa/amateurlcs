-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 29 sep 2015 om 11:06
-- Serverversie: 5.6.17
-- PHP-versie: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `amateurlcs_central`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`domain` varchar(30) NOT NULL,
`database_user` varchar(30) NOT NULL,
`database_password` varchar(30) NOT NULL,
`database_db` varchar(30) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden geëxporteerd voor tabel `domains`
--

INSERT INTO `domains` (`id`, `domain`, `database_user`, `database_password`, `database_db`) VALUES
(1, 'solomid', 'alcs_solomid', 'pV7si5kAnYXQk6P', 'amateurlcs_solomid');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `domains_packages`
--

CREATE TABLE IF NOT EXISTS `domains_packages` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`domain` int(11) NOT NULL,
`package` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden geëxporteerd voor tabel `domains_packages`
--

INSERT INTO `domains_packages` (`id`, `domain`, `package`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_account_types`
--

CREATE TABLE IF NOT EXISTS `global_account_types` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`value` varchar(30) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_account_types`
--

INSERT INTO `global_account_types` (`id`, `value`) VALUES
(1, 'Admin'),
(2, 'Free agent'),
(3, 'Teammember'),
(4, 'Analyst'),
(5, 'Coach'),
(6, 'Shoutcaster'),
(7, 'Team owner');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_champions`
--

CREATE TABLE IF NOT EXISTS `global_champions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`champion_id` int(11) NOT NULL,
`name` varchar(20) NOT NULL,
`title` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_champions`
--

INSERT INTO `global_champions` (`id`, `champion_id`, `name`, `title`) VALUES
(1, 412, 'Thresh', 'the Chain Warden'),
(2, 266, 'Aatrox', 'the Darkin Blade'),
(3, 23, 'Tryndamere', 'the Barbarian King'),
(4, 79, 'Gragas', 'the Rabble Rouser'),
(5, 69, 'Cassiopeia', 'the Serpent''s Embrace'),
(6, 78, 'Poppy', 'the Iron Ambassador'),
(7, 13, 'Ryze', 'the Rogue Mage'),
(8, 14, 'Sion', 'The Undead Juggernaut'),
(9, 1, 'Annie', 'the Dark Child'),
(10, 43, 'Karma', 'the Enlightened One'),
(11, 111, 'Nautilus', 'the Titan of the Depths'),
(12, 99, 'Lux', 'the Lady of Luminosity'),
(13, 103, 'Ahri', 'the Nine-Tailed Fox'),
(14, 2, 'Olaf', 'the Berserker'),
(15, 112, 'Viktor', 'the Machine Herald'),
(16, 34, 'Anivia', 'the Cryophoenix'),
(17, 86, 'Garen', 'The Might of Demacia'),
(18, 27, 'Singed', 'the Mad Chemist'),
(19, 127, 'Lissandra', 'the Ice Witch'),
(20, 57, 'Maokai', 'the Twisted Treant'),
(21, 25, 'Morgana', 'Fallen Angel'),
(22, 28, 'Evelynn', 'the Widowmaker'),
(23, 105, 'Fizz', 'the Tidal Trickster'),
(24, 238, 'Zed', 'the Master of Shadows'),
(25, 74, 'Heimerdinger', 'the Revered Inventor'),
(26, 68, 'Rumble', 'the Mechanized Menace'),
(27, 82, 'Mordekaiser', 'the Master of Metal'),
(28, 37, 'Sona', 'Maven of the Strings'),
(29, 55, 'Katarina', 'the Sinister Blade'),
(30, 96, 'Kog''Maw', 'the Mouth of the Abyss'),
(31, 22, 'Ashe', 'the Frost Archer'),
(32, 117, 'Lulu', 'the Fae Sorceress'),
(33, 30, 'Karthus', 'the Deathsinger'),
(34, 12, 'Alistar', 'the Minotaur'),
(35, 122, 'Darius', 'the Hand of Noxus'),
(36, 67, 'Vayne', 'the Night Hunter'),
(37, 110, 'Varus', 'the Arrow of Retribution'),
(38, 77, 'Udyr', 'the Spirit Walker'),
(39, 126, 'Jayce', 'the Defender of Tomorrow'),
(40, 89, 'Leona', 'the Radiant Dawn'),
(41, 134, 'Syndra', 'the Dark Sovereign'),
(42, 80, 'Pantheon', 'the Artisan of War'),
(43, 121, 'Kha''Zix', 'the Voidreaver'),
(44, 92, 'Riven', 'the Exile'),
(45, 42, 'Corki', 'the Daring Bombardier'),
(46, 268, 'Azir', 'the Emperor of the Sands'),
(47, 51, 'Caitlyn', 'the Sheriff of Piltover'),
(48, 76, 'Nidalee', 'the Bestial Huntress'),
(49, 3, 'Galio', 'the Sentinel''s Sorrow'),
(50, 85, 'Kennen', 'the Heart of the Tempest'),
(51, 45, 'Veigar', 'the Tiny Master of Evil'),
(52, 432, 'Bard', 'the Wandering Caretaker'),
(53, 150, 'Gnar', 'the Missing Link'),
(54, 104, 'Graves', 'the Outlaw'),
(55, 90, 'Malzahar', 'the Prophet of the Void'),
(56, 254, 'Vi', 'the Piltover Enforcer'),
(57, 10, 'Kayle', 'The Judicator'),
(58, 39, 'Irelia', 'the Will of the Blades'),
(59, 64, 'Lee Sin', 'the Blind Monk'),
(60, 60, 'Elise', 'The Spider Queen'),
(61, 106, 'Volibear', 'the Thunder''s Roar'),
(62, 20, 'Nunu', 'the Yeti Rider'),
(63, 4, 'Twisted Fate', 'the Card Master'),
(64, 24, 'Jax', 'Grandmaster at Arms'),
(65, 102, 'Shyvana', 'the Half-Dragon'),
(66, 429, 'Kalista', 'the Spear of Vengeance'),
(67, 36, 'Dr. Mundo', 'the Madman of Zaun'),
(68, 223, 'Tahm Kench', 'the River King'),
(69, 63, 'Brand', 'the Burning Vengeance'),
(70, 131, 'Diana', 'Scorn of the Moon'),
(71, 113, 'Sejuani', 'the Winter''s Wrath'),
(72, 8, 'Vladimir', 'the Crimson Reaper'),
(73, 154, 'Zac', 'the Secret Weapon'),
(74, 421, 'RekSai', 'the Void Burrower'),
(75, 133, 'Quinn', 'Demacia''s Wings'),
(76, 84, 'Akali', 'the Fist of Shadow'),
(77, 18, 'Tristana', 'the Yordle Gunner'),
(78, 120, 'Hecarim', 'the Shadow of War'),
(79, 15, 'Sivir', 'the Battle Mistress'),
(80, 236, 'Lucian', 'the Purifier'),
(81, 107, 'Rengar', 'the Pridestalker'),
(82, 19, 'Warwick', 'the Blood Hunter'),
(83, 72, 'Skarner', 'the Crystal Vanguard'),
(84, 54, 'Malphite', 'Shard of the Monolith'),
(85, 157, 'Yasuo', 'the Unforgiven'),
(86, 101, 'Xerath', 'the Magus Ascendant'),
(87, 17, 'Teemo', 'the Swift Scout'),
(88, 75, 'Nasus', 'the Curator of the Sands'),
(89, 58, 'Renekton', 'the Butcher of the Sands'),
(90, 119, 'Draven', 'the Glorious Executioner'),
(91, 35, 'Shaco', 'the Demon Jester'),
(92, 50, 'Swain', 'the Master Tactician'),
(93, 115, 'Ziggs', 'the Hexplosives Expert'),
(94, 91, 'Talon', 'the Blade''s Shadow'),
(95, 40, 'Janna', 'the Storm''s Fury'),
(96, 245, 'Ekko', 'the Boy Who Shattered Time'),
(97, 61, 'Orianna', 'the Lady of Clockwork'),
(98, 9, 'Fiddlesticks', 'the Harbinger of Doom'),
(99, 114, 'Fiora', 'the Grand Duelist'),
(100, 31, 'Cho''Gath', 'the Terror of the Void'),
(101, 33, 'Rammus', 'the Armordillo'),
(102, 7, 'LeBlanc', 'the Deceiver'),
(103, 26, 'Zilean', 'the Chronokeeper'),
(104, 16, 'Soraka', 'the Starchild'),
(105, 56, 'Nocturne', 'the Eternal Nightmare'),
(106, 222, 'Jinx', 'the Loose Cannon'),
(107, 83, 'Yorick', 'the Gravedigger'),
(108, 6, 'Urgot', 'the Headsman''s Pride'),
(109, 21, 'Miss Fortune', 'the Bounty Hunter'),
(110, 62, 'Wukong', 'the Monkey King'),
(111, 53, 'Blitzcrank', 'the Great Steam Golem'),
(112, 98, 'Shen', 'Eye of Twilight'),
(113, 201, 'Braum', 'the Heart of the Freljord'),
(114, 5, 'Xin Zhao', 'the Seneschal of Demacia'),
(115, 29, 'Twitch', 'the Plague Rat'),
(116, 11, 'Master Yi', 'the Wuju Bladesman'),
(117, 44, 'Taric', 'the Gem Knight'),
(118, 32, 'Amumu', 'the Sad Mummy'),
(119, 41, 'Gangplank', 'the Saltwater Scourge'),
(120, 48, 'Trundle', 'the Troll King'),
(121, 38, 'Kassadin', 'the Void Walker'),
(122, 161, 'VelKoz', 'the Eye of the Void'),
(123, 143, 'Zyra', 'Rise of the Thorns'),
(124, 267, 'Nami', 'the Tidecaller'),
(125, 59, 'Jarvan IV', 'the Exemplar of Demacia'),
(126, 81, 'Ezreal', 'the Prodigal Explorer');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_lolranks`
--

CREATE TABLE IF NOT EXISTS `global_lolranks` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`value` varchar(40) NOT NULL,
`short_value` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_lolranks`
--

INSERT INTO `global_lolranks` (`id`, `value`, `short_value`) VALUES
(1, 'Unranked', 'U'),
(2, 'BRONZE V', 'B5'),
(3, 'BRONZE IV', 'B4'),
(4, 'BRONZE III', 'B3'),
(5, 'BRONZE II', 'B2'),
(6, 'BRONZE I', 'B1'),
(7, 'SILVER V', 'S5'),
(8, 'SILVER IV', 'S4'),
(9, 'SILVER III', 'S3'),
(10, 'SILVER II', 'S2'),
(11, 'SILVER I', 'S1'),
(12, 'GOLD V', 'G5'),
(13, 'GOLD IV', 'G4'),
(14, 'GOLD III', 'G3'),
(15, 'GOLD II', 'G2'),
(16, 'GOLD I', 'G1'),
(17, 'PLATINUM V', 'P5'),
(18, 'PLATINUM IV', 'P4'),
(19, 'PLATINUM III', 'P3'),
(20, 'PLATINUM II', 'P2'),
(21, 'PLATINUM I', 'P1'),
(22, 'DIAMOND V', 'D5'),
(23, 'DIAMOND IV', 'D4'),
(24, 'DIAMOND III', 'D3'),
(25, 'DIAMOND II', 'D2'),
(26, 'DIAMOND I', 'D1'),
(27, 'MASTER I', 'MAS'),
(28, 'CHALLENGER I', 'CHA');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_regions`
--

CREATE TABLE IF NOT EXISTS `global_regions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`region` varchar(40) NOT NULL,
`short` varchar(15) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_regions`
--

INSERT INTO `global_regions` (`id`, `region`, `short`) VALUES
(1, 'Europe West', 'euw'),
(2, 'North America', 'na');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_single_ele_rounds`
--

CREATE TABLE IF NOT EXISTS `global_single_ele_rounds` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`team_amount` int(11) NOT NULL,
`name` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_single_ele_rounds`
--

INSERT INTO `global_single_ele_rounds` (`id`, `team_amount`, `name`) VALUES
(1, 2, 'Final'),
(2, 4, 'Semi Final'),
(3, 8, 'Quarter Final'),
(4, 16, 'Round Of 16'),
(5, 32, 'Round of 32'),
(6, 64, 'Round of 64'),
(7, 128, 'Round of 128');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_teamroles`
--

CREATE TABLE IF NOT EXISTS `global_teamroles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`value` varchar(30) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_teamroles`
--

INSERT INTO `global_teamroles` (`id`, `value`) VALUES
(1, 'Top'),
(2, 'Jungler'),
(3, 'Midlane'),
(4, 'Adc'),
(5, 'Support'),
(6, 'Coach'),
(7, 'Analyst'),
(8, 'Owner'),
(9, 'Sub 1'),
(10, 'Sub 2'),
(11, 'Sub 3'),
(12, 'Sub 4'),
(13, 'Sub 5');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `global_tournament_types`
--

CREATE TABLE IF NOT EXISTS `global_tournament_types` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden geëxporteerd voor tabel `global_tournament_types`
--

INSERT INTO `global_tournament_types` (`id`, `name`) VALUES
(1, 'Single Elemination'),
(2, 'Double Elimination'),
(3, 'Round Robin'),
(4, 'Swiss');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
