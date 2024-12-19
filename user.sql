-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 01 déc. 2024 à 17:23
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dolicha`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `usermail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userRole` enum('admin','user','vendeur') NOT NULL,
  `adress` varchar(225) NOT NULL,
  `Nationalite` varchar(225) NOT NULL,
  `ddn` date NOT NULL,
  `num` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `usermail`, `password`, `userRole`, `adress`, `Nationalite`, `ddn`, `num`) VALUES
(42, '', '', 'aaa@aa.com', '$2y$10$5kfygKZbN0TponJ6o.i0De6oV1YxPWcz/uB4l3wEaEMycsDez40h2', 'user', 'aaa', 'aaa', '2024-11-25', 14125444),
(43, '', '', 'aaa@aa.com', '$2y$10$8t3WTkWElrUz4QnRJVlB0uu4kn6oh6F3nU7KV.BjfLQW3dDxClGTK', 'admin', 'aaaaaa', 'aaaaaa', '2024-11-22', 987447589),
(45, '', '', 'aaaa@aa.com', '$2y$10$LNpTqyKxJwpckWDOFDma8urRUXzPipU2IABKH1MzFrstMOoXrkueu', 'admin', 'mmmmmm', 'mmmmm', '2024-11-16', 2147483647),
(46, '', '', 'molkaomrani11@gmail.com', '$2y$10$s74B25jd.HszUNrc/JsSx.8f4GE364LsUjUpkvs4H45UQT5WfORVu', 'admin', 'zaezrea', 'sqzestrdjk', '2024-11-23', 2147483647),
(47, '', '', 'molkaomranieeeee@gmail.com', '$2y$10$VzDETz22/c6iIk87CPSRF.gVQ.38l8QENGDu66LuGaL8Q9eFCu71W', 'admin', 'aa14444', 'sfaxienne', '2024-11-05', 2147483647);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
