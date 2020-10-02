-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 02 oct. 2020 à 14:20
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `php_adverts`
--

-- --------------------------------------------------------

--
-- Structure de la table `adverts`
--

CREATE TABLE `adverts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` date DEFAULT NULL,
  `price` float DEFAULT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `description`, `date`, `end_date`, `price`, `user`) VALUES
(1, 'PS4 with 2 controllers and 3 games', 'Noscere his audirent habitu concordi destinarentur formido ut cuncta posticas est his conpluribus regiam inpendentium poterant ignoti cognita regiam vero.', '2020-10-01 15:02:51', NULL, 175, 2),
(2, 'iPhone', 'Noscere his audirent habitu concordi destinarentur formido ut cuncta posticas est his conpluribus regiam inpendentium poterant ignoti cognita regiam vero.', '2020-10-02 12:38:02', '2020-10-02', 125, 2),
(3, 'TV stand', 'Noscere his audirent habitu concordi destinarentur formido ut cuncta posticas est his conpluribus regiam inpendentium poterant ignoti cognita regiam vero.', '2020-10-01 10:12:35', NULL, 90, 1),
(4, 'Vacuum iRobot', 'Noscere his audirent habitu concordi destinarentur formido ut cuncta posticas est his conpluribus regiam inpendentium poterant ignoti cognita regiam vero.', '2020-09-30 20:49:59', NULL, 115, 1);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `advert_id`, `image`) VALUES
(1, 1, 'public/adverts/5f76f168763ac5f76f168763e1.jpg'),
(2, 1, 'public/adverts/ab9b23d5f63da7ff0455330dd957b7db2e956bc7.jpg'),
(3, 1, 'public/adverts/4a5a2ff4f36cae9ee35e0d25727112c74773f63f.jpg'),
(5, 3, 'public/adverts/e7912b3aa181d56dd40d0c27dfc215a0a358101c.jpg'),
(6, 3, 'public/adverts/c7581238d5770fba1223d293cbab0d13dd08e63e.jpg'),
(7, 4, 'public/adverts/a450170bec7623f7fd64a0f0f73302aad091ad22.jpg'),
(8, 4, 'public/adverts/5ff42f53e8db527aff615820a2e799c012f0cf3a.jpg'),
(9, 2, 'public/adverts/5f76fc80d506a5f76fc80d506d.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `register_date` date NOT NULL,
  `image` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `phone`, `register_date`, `image`) VALUES
(1, 'Adrien', 'a@a.fr', '$2y$10$vQgRZbthLeN4Z7.WtrTJKO6hJij6ADXqLFHtmal.D/zE7DW.Eo5kW', '00000', '2020-09-01', NULL),
(2, 'AdrienWEB', 'adrien-george@outlook.fr', '$2y$10$vQgRZbthLeN4Z7.WtrTJKO6hJij6ADXqLFHtmal.D/zE7DW.Eo5kW', '0614061830', '2020-09-30', 'public/users/5f75d97df2ac55f75d97df2ac8.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_user` (`user`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_image` (`advert_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adverts`
--
ALTER TABLE `adverts`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_post_image` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`);
