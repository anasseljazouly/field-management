-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 05 juin 2022 à 21:30
-- Version du serveur :  8.0.23
-- Version de PHP : 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test2`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `ID_A` int NOT NULL,
  `id_u` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID_A`, `id_u`) VALUES
(1, 26);

-- --------------------------------------------------------

--
-- Structure de la table `class`
--

CREATE TABLE `class` (
  `ID_class` int NOT NULL,
  `Type_class` varchar(30) NOT NULL,
  `Capacity_class` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `class`
--

INSERT INTO `class` (`ID_class`, `Type_class`, `Capacity_class`) VALUES
(17, 'AMPHI 1', 20),
(18, 'AMPHI 2', 50),
(19, 'AMPHI 3', 40);

-- --------------------------------------------------------

--
-- Structure de la table `elem_module`
--

CREATE TABLE `elem_module` (
  `id_prof` int NOT NULL,
  `NAME_elem_M` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `year_s` varchar(2) NOT NULL,
  `semester` varchar(2) NOT NULL,
  `periode` varchar(2) NOT NULL,
  `id_matiere` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `elem_module`
--

INSERT INTO `elem_module` (`id_prof`, `NAME_elem_M`, `year_s`, `semester`, `periode`, `id_matiere`) VALUES
(22, 'module 3:element 3:Chef Num1', '3A', 'S1', 'P1', 23);

-- --------------------------------------------------------

--
-- Structure de la table `field`
--

CREATE TABLE `field` (
  `ID_F` int NOT NULL,
  `NAME_F` varchar(30) NOT NULL,
  `CHEF_F` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `field`
--

INSERT INTO `field` (`ID_F`, `NAME_F`, `CHEF_F`) VALUES
(9, 'GL', 24),
(10, 'IWIM', 23);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `ID_M` int NOT NULL,
  `NAME_M` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`ID_M`, `NAME_M`) VALUES
(5, 'module 1'),
(6, 'module 2'),
(7, 'module 3');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id_n` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Pas de titre',
  `content` text NOT NULL,
  `name_field` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id_n`, `content`, `name_field`) VALUES
('ANNULATION module 1 element 1 S1 P1', '<p>La seance module 1 element 1 qui a ete programmé pour le Lundi dans la semaine 1 à 14:00 -> 15:40 est annulee .</p>', 'GL'),
('Nouveaute 1', '<p>Text Nouveaute 1 Modifie</p>', 'GL'),
('REPROGRAMMATION module 1 element 1 S1 P1', '<p>La seance module 1 element 1 qui a ete programmé pour le Lundi dans la semaine 1 à 10:50 -> 12:30 est reportée \r\n      pour leMardi dans la semaine 1 à 09:00 -> 10:40</p>', 'GL');

-- --------------------------------------------------------

--
-- Structure de la table `request`
--

CREATE TABLE `request` (
  `ID_req` int NOT NULL,
  `id_s` int NOT NULL,
  `week_r` int DEFAULT NULL,
  `day_r` int DEFAULT NULL,
  `seance_n_r` int DEFAULT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `request`
--

INSERT INTO `request` (`ID_req`, `id_s`, `week_r`, `day_r`, `seance_n_r`, `type`) VALUES
(21, 176, 1, 2, 1, 'R');

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

CREATE TABLE `seance` (
  `ID_S` int NOT NULL,
  `NAME_S` varchar(30) DEFAULT NULL,
  `id_prof` int NOT NULL,
  `week` int NOT NULL,
  `day_` int DEFAULT NULL,
  `CLASS_S` int NOT NULL,
  `seance_n` int NOT NULL,
  `name_field` varchar(11) NOT NULL,
  `year_s` varchar(2) NOT NULL,
  `semestre` varchar(2) NOT NULL,
  `periode` varchar(2) NOT NULL,
  `id_matiere` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `ID_ST` int NOT NULL,
  `CNE_ST` varchar(20) DEFAULT NULL,
  `Year_ST` varchar(2) DEFAULT NULL,
  `Feild_ST` varchar(10) DEFAULT NULL,
  `id_u` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

CREATE TABLE `teacher` (
  `ID_T` int NOT NULL,
  `id_u` int NOT NULL,
  `Bibliographie_T` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `IS_chef_T` tinyint(1) NOT NULL DEFAULT '0',
  `FIELD_T` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`ID_T`, `id_u`, `Bibliographie_T`, `IS_chef_T`, `FIELD_T`) VALUES
(23, 38, NULL, 1, 'IWIM'),
(24, 44, NULL, 1, 'GL');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID_U` int NOT NULL,
  `token` varchar(100) NOT NULL,
  `Email_U` varchar(60) NOT NULL,
  `Password_U` varchar(60) NOT NULL,
  `CIN_u` varchar(8) NOT NULL,
  `FIRST_NAME_u` varchar(30) NOT NULL,
  `SECOND_NAME_u` varchar(30) NOT NULL,
  `SEXE_u` tinyint(1) NOT NULL,
  `ADRESSE_u` text NOT NULL,
  `city_u` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COUNTRY_u` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `BIRTHDAY_u` date NOT NULL,
  `BIRTH_PLACE_u` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `PHONE_NUMBER_u` varchar(20) NOT NULL,
  `type_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID_U`, `token`, `Email_U`, `Password_U`, `CIN_u`, `FIRST_NAME_u`, `SECOND_NAME_u`, `SEXE_u`, `ADRESSE_u`, `city_u`, `COUNTRY_u`, `BIRTHDAY_u`, `BIRTH_PLACE_u`, `PHONE_NUMBER_u`, `type_user`) VALUES
(26, '9fdc9e1633481fdf714a9cb9560de34c1e832e52aa7b3a89daedab651bc37c6401b7dd26a645a9dc64512faf345ccdb1e994', 'anass.eljazouly@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'BW10946', 'Anass', 'EL JAZOULY', 0, 'RES EL FATH 2 IMM 3', 'CASABLANCA', 'Maroc', '2000-04-04', 'Temara', '689047182', 'A'),
(38, '1bc5abbd4983b7e716a3cc7ec72bdcd2a10ca277a1ee79beb7a441a4077d2287ac04c6eb0c1681c4bf4f8eff726f29c1068c', 'cf2@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'BXSXfggg', 'Chef', 'Num2', 0, 'XXXXXXX XXXXXXXXX', 'XXXXXXXXXXX', 'XXXX', '1997-05-05', 'XXXXXXX', '0666666653', 'T'),
(44, '18e58a7a0bfcd012518afcc8a24a6120cabb8cc09408bf90e48d65e7cf3f2fd60d3134e7d07c6156c33d57cea3092f8405da', 'cf3@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'BXSXfGHH', 'Chef', 'Num3', 1, 'XXXXXXX XXXXXXXXX', 'XXXXXXXXXXX', 'XXXX', '1998-11-01', 'Rabat', '0666666653', 'T');

-- --------------------------------------------------------

--
-- Structure de la table `user_image`
--

CREATE TABLE `user_image` (
  `id_im` int NOT NULL,
  `id_u` int NOT NULL,
  `image_u` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_A`),
  ADD KEY `id_u` (`id_u`);

--
-- Index pour la table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ID_class`),
  ADD UNIQUE KEY `Type_class` (`Type_class`);

--
-- Index pour la table `elem_module`
--
ALTER TABLE `elem_module`
  ADD PRIMARY KEY (`id_matiere`),
  ADD UNIQUE KEY `id_matiere` (`id_matiere`);

--
-- Index pour la table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`ID_F`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`ID_M`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_n`,`name_field`);

--
-- Index pour la table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`ID_req`);

--
-- Index pour la table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`ID_S`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID_ST`),
  ADD UNIQUE KEY `CNE_ST` (`CNE_ST`),
  ADD KEY `id_u` (`id_u`);

--
-- Index pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`ID_T`),
  ADD KEY `id_u` (`id_u`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_U`),
  ADD UNIQUE KEY `Email_U` (`Email_U`),
  ADD UNIQUE KEY `CIN_u` (`CIN_u`),
  ADD UNIQUE KEY `id_us` (`ID_U`);

--
-- Index pour la table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`id_im`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_A` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `class`
--
ALTER TABLE `class`
  MODIFY `ID_class` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `elem_module`
--
ALTER TABLE `elem_module`
  MODIFY `id_matiere` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `field`
--
ALTER TABLE `field`
  MODIFY `ID_F` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `ID_M` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `request`
--
ALTER TABLE `request`
  MODIFY `ID_req` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `seance`
--
ALTER TABLE `seance`
  MODIFY `ID_S` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `ID_ST` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `ID_T` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID_U` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `id_im` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`ID_U`);

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`ID_U`);

--
-- Contraintes pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`ID_U`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
