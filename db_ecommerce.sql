-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24-Fev-2023 às 21:22
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_ecommerce`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addresses_save` (`pidaddress` INT(11), `pidperson` INT(11), `pdesaddress` VARCHAR(128), `pdescomplement` VARCHAR(32), `pdescity` VARCHAR(32), `pdesstate` VARCHAR(32), `pdescountry` VARCHAR(32), `pdeszipcode` CHAR(8), `pdesdistrict` VARCHAR(32))   BEGIN

	IF pidaddress > 0 THEN
		
		UPDATE tb_addresses
        SET
			idperson = pidperson,
            desaddress = pdesaddress,
            descomplement = pdescomplement,
            descity = pdescity,
            desstate = pdesstate,
            descountry = pdescountry,
            deszipcode = pdeszipcode, 
            desdistrict = pdesdistrict
		WHERE idaddress = pidaddress;
        
    ELSE
		
		INSERT INTO tb_addresses (idperson, desaddress, descomplement, descity, desstate, descountry, deszipcode, desdistrict)
        VALUES(pidperson, pdesaddress, pdescomplement, pdescity, pdesstate, pdescountry, pdeszipcode, pdesdistrict);
        
        SET pidaddress = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_addresses WHERE idaddress = pidaddress;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_carts_save` (`pidcart` INT, `pdessessionid` VARCHAR(64), `piduser` INT, `pdeszipcode` CHAR(8), `pvlfreight` DECIMAL(10,2), `pnrdays` INT)   BEGIN

    IF pidcart > 0 THEN
        
        UPDATE tb_carts
        SET
            dessessionid = pdessessionid,
            iduser = piduser,
            deszipcode = pdeszipcode,
            vlfreight = pvlfreight,
            nrdays = pnrdays
        WHERE idcart = pidcart;
        
    ELSE
        
        INSERT INTO tb_carts (dessessionid, iduser, deszipcode, vlfreight, nrdays)
        VALUES(pdessessionid, piduser, pdeszipcode, pvlfreight, pnrdays);
        
        SET pidcart = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_carts WHERE idcart = pidcart;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categories_save` (`pidcategory` INT, `pdescategory` VARCHAR(64))   BEGIN
	
	IF pidcategory > 0 THEN
		
		UPDATE tb_categories
        SET descategory = pdescategory
        WHERE idcategory = pidcategory;
        
    ELSE
		
		INSERT INTO tb_categories (descategory) VALUES(pdescategory);
        
        SET pidcategory = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_categories WHERE idcategory = pidcategory;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_orders_save` (`pidorder` INT, `pidcart` INT(11), `piduser` INT(11), `pidstatus` INT(11), `pidaddress` INT(11), `pvltotal` DECIMAL(10,2))   BEGIN
	
	IF pidorder > 0 THEN
		
		UPDATE tb_orders
        SET
			idcart = pidcart,
            iduser = piduser,
            idstatus = pidstatus,
            idaddress = pidaddress,
            vltotal = pvltotal
		WHERE idorder = pidorder;
        
    ELSE
    
		INSERT INTO tb_orders (idcart, iduser, idstatus, idaddress, vltotal)
        VALUES(pidcart, piduser, pidstatus, pidaddress, pvltotal);
		
		SET pidorder = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * 
    FROM tb_orders a
    INNER JOIN tb_ordersstatus b USING(idstatus)
    INNER JOIN tb_carts c USING(idcart)
    INNER JOIN tb_users d ON d.iduser = a.iduser
    INNER JOIN tb_addresses e USING(idaddress)
    WHERE idorder = pidorder;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_products_save` (`pidproduct` INT(11), `pdesproduct` VARCHAR(64), `pvlprice` DECIMAL(10,2), `pvlwidth` DECIMAL(10,2), `pvlheight` DECIMAL(10,2), `pvllength` DECIMAL(10,2), `pvlweight` DECIMAL(10,2), `pdesurl` VARCHAR(128))   BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_products
        SET 
			desproduct = pdesproduct,
            vlprice = pvlprice,
            vlwidth = pvlwidth,
            vlheight = pvlheight,
            vllength = pvllength,
            vlweight = pvlweight,
            desurl = pdesurl
        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_products (desproduct, vlprice, vlwidth, vlheight, vllength, vlweight, desurl) 
        VALUES(pdesproduct, pvlprice, pvlwidth, pvlheight, pvllength, pvlweight, pdesurl);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_products WHERE idproduct = pidproduct;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_userspasswordsrecoveries_create` (`piduser` INT, `pdesip` VARCHAR(45))   BEGIN
  
  INSERT INTO tb_userspasswordsrecoveries (iduser, desip)
    VALUES(piduser, pdesip);
    
    SELECT * FROM tb_userspasswordsrecoveries
    WHERE idrecovery = LAST_INSERT_ID();
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usersupdate_save` (IN `piduser` INT, IN `pdesperson` VARCHAR(64), IN `pdeslogin` VARCHAR(64), IN `pdespassword` VARCHAR(256), IN `pdesemail` VARCHAR(128), IN `pnrphone` BIGINT, IN `pinadmin` TINYINT)   BEGIN
  
    DECLARE vidperson INT;
    
  SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    UPDATE tb_persons
    SET 
    desperson = pdesperson,
        desemail = pdesemail,
        nrphone = pnrphone
  WHERE idperson = vidperson;
    
    UPDATE tb_users
    SET
    deslogin = pdeslogin,
        despassword = pdespassword,
        inadmin = pinadmin
  WHERE iduser = piduser;
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = piduser;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_delete` (`piduser` INT)   BEGIN
  
    DECLARE vidperson INT;
    
  SELECT idperson INTO vidperson
    FROM tb_users
    WHERE iduser = piduser;
    
    DELETE FROM tb_users WHERE iduser = piduser;
    DELETE FROM tb_persons WHERE idperson = vidperson;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_save` (`pdesperson` VARCHAR(64), `pdeslogin` VARCHAR(64), `pdespassword` VARCHAR(256), `pdesemail` VARCHAR(128), `pnrphone` BIGINT, `pinadmin` TINYINT)   BEGIN
  
    DECLARE vidperson INT;
    
  INSERT INTO tb_persons (desperson, desemail, nrphone)
    VALUES(pdesperson, pdesemail, pnrphone);
    
    SET vidperson = LAST_INSERT_ID();
    
    INSERT INTO tb_users (idperson, deslogin, despassword, inadmin)
    VALUES(vidperson, pdeslogin, pdespassword, pinadmin);
    
    SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = LAST_INSERT_ID();
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_addresses`
--

CREATE TABLE `tb_addresses` (
  `idaddress` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `desaddress` varchar(128) NOT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `descity` varchar(32) NOT NULL,
  `desstate` varchar(32) NOT NULL,
  `descountry` varchar(32) NOT NULL,
  `deszipcode` char(8) NOT NULL,
  `desdistrict` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_addresses`
--

INSERT INTO `tb_addresses` (`idaddress`, `idperson`, `desaddress`, `descomplement`, `descity`, `desstate`, `descountry`, `deszipcode`, `desdistrict`, `dtregister`) VALUES
(1, 13, 'Rua Roque Polidoro', '', 'São Paulo', 'Rua Roque Polidoro', 'Brasil', '08240075', 'Jardim Liderança', '2023-02-10 00:16:10'),
(2, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 11:41:24'),
(3, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 11:42:51'),
(4, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:06:50'),
(5, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:11:14'),
(6, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:12:05'),
(7, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:36:07'),
(8, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:36:41'),
(9, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 12:38:24'),
(10, 8, 'Avenida Líder, 1004', '', 'São Paulo', 'Avenida Líder, 1004', 'Brasil', '03586000', 'Cidade Líder', '2023-02-14 15:47:05'),
(11, 8, 'Avenida L?der, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Cidade Líder', '2023-02-14 16:45:13'),
(12, 1, 'Avenida L?der, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Cidade Líder', '2023-02-14 16:51:16'),
(13, 1, 'Avenida L?der, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Cidade Líder', '2023-02-14 18:07:30'),
(14, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:01:57'),
(15, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:05:04'),
(16, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:16:11'),
(17, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:16:32'),
(18, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:16:49'),
(19, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:17:00'),
(20, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:17:17'),
(21, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:17:40'),
(22, 1, 'Rua Roque Polidoro, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim Liderança', '2023-02-14 19:18:08'),
(23, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:20:01'),
(24, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:20:25'),
(25, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:26:43'),
(26, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:27:49'),
(27, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:28:20'),
(28, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:36:10'),
(29, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:57:37'),
(30, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 19:59:50'),
(31, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:00:05'),
(32, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:00:19'),
(33, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:01:19'),
(34, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:01:32'),
(35, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:02:11'),
(36, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:02:15'),
(37, 1, 'Avenida Celso Garcia, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Brás', '2023-02-14 20:26:32'),
(38, 1, 'Rua Moacir de Souza, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Jardim das Camélias', '2023-02-16 21:43:32'),
(39, 8, 'Rua Doutor Manoel Guimar?es, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Vila Taquari', '2023-02-17 21:01:31'),
(40, 8, 'Rua Flor da Reden??o, 1004', NULL, '', 'S?o Paulo', 'SP', 'Brasil', 'Vila Jacuí', '2023-02-17 23:03:46'),
(41, 1, 'Rua Dalton Bird de Camargo Preto, 1820', NULL, '', 'Araras', 'SP', 'Brasil', 'Jardim José Ometto II', '2023-02-21 22:37:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_carts`
--

CREATE TABLE `tb_carts` (
  `idcart` int(11) NOT NULL,
  `dessessionid` varchar(64) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `deszipcode` char(8) DEFAULT NULL,
  `vlfreight` decimal(10,2) DEFAULT NULL,
  `nrdays` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_carts`
--

INSERT INTO `tb_carts` (`idcart`, `dessessionid`, `iduser`, `deszipcode`, `vlfreight`, `nrdays`, `dtregister`) VALUES
(1, 'e333be9a5alneo25ihqfn3qqoh', NULL, NULL, NULL, NULL, '2023-01-23 19:33:48'),
(3, 'vkfbmk120uotd1do8f4acqrdqu', NULL, NULL, NULL, NULL, '2023-01-24 13:27:57'),
(4, '0von3v0rjbo909sj082126lps4', NULL, NULL, NULL, NULL, '2023-01-24 17:57:09'),
(5, '7dr2ntsqhqs68d87o026hrcq7u', NULL, NULL, NULL, NULL, '2023-01-25 19:01:39'),
(6, 'nh8iafo6dge53a4nauq9jk4a29', NULL, NULL, NULL, NULL, '2023-01-27 19:17:03'),
(7, '2fp9ue6599h1m6ef3iioh82bf8', NULL, '01310200', 0.00, 0, '2023-01-30 18:21:54'),
(8, '9jft8vgp36a7st7bbvn6u67caa', NULL, '12960000', 62.80, 2, '2023-01-31 14:07:48'),
(9, 'a5vbigl9jopi36c82cfv9ljc06', NULL, '08690010', 51.30, 6, '2023-02-02 19:45:42'),
(10, '997g1k66qgak8ufehf3av84h2g', NULL, NULL, NULL, NULL, '2023-02-05 02:50:21'),
(11, 'p6g5k8bkhohga8m3e9kq7sesog', NULL, NULL, NULL, NULL, '2023-02-05 18:01:33'),
(12, 'r8ov953jed07qqtqciajrlodt0', NULL, NULL, NULL, NULL, '2023-02-06 23:00:10'),
(13, 'roj9bou6fn1qjdiv85rrf1sak7', NULL, NULL, NULL, NULL, '2023-02-07 17:33:23'),
(14, 'e2jhk6din5i601kjonveo1o5i9', NULL, '08531020', 51.30, 1, '2023-02-08 17:36:19'),
(15, 'ih79muj18rb03t7fc9aae9l4m6', NULL, '08240075', 165.30, 6, '2023-02-09 15:23:17'),
(16, 'shvpf9bvpt8f529e94350hba0o', NULL, NULL, NULL, NULL, '2023-02-13 18:04:11'),
(17, 'l07d6s6gq7mu9t19d7aniep2po', 8, '03586000', 193.80, 1, '2023-02-14 11:25:10'),
(18, '8psvkvjupi9n9da8s9ak80jh3a', NULL, '03014000', 51.30, 1, '2023-02-14 15:45:12'),
(19, 'bk3avp9uado6kjqmcrq60j1tnl', 8, '08050780', 114.00, 6, '2023-02-16 16:16:42'),
(20, 'giiabsbb309oiootvalcan3f31', 8, '08050060', 0.00, 0, '2023-02-17 20:59:47'),
(21, 'blerfhit2sve6edqo3ocqrn6gp', NULL, NULL, NULL, NULL, '2023-02-18 13:37:01'),
(22, 'mbld4l9nkkb90q7lcfbrh0o34p', NULL, '08230620', 51.30, 6, '2023-02-20 17:45:33'),
(23, '1mpl3nc0js1vb507turg5a6m87', 1, '13606350', 114.00, 1, '2023-02-21 22:36:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cartsproducts`
--

CREATE TABLE `tb_cartsproducts` (
  `idcartproduct` int(11) NOT NULL,
  `idcart` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL,
  `dtremoved` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cartsproducts`
--

INSERT INTO `tb_cartsproducts` (`idcartproduct`, `idcart`, `idproduct`, `dtremoved`, `dtregister`) VALUES
(1, 3, 48, '0000-00-00 00:00:00', '2023-01-24 17:31:37'),
(3, 4, 5, '2023-01-24 19:01:23', '2023-01-24 18:55:56'),
(4, 4, 5, '2023-01-24 19:01:26', '2023-01-24 21:25:05'),
(5, 4, 5, '2023-01-24 19:01:28', '2023-01-24 21:52:36'),
(6, 4, 5, '2023-01-24 19:01:30', '2023-01-24 21:55:24'),
(7, 4, 5, '2023-01-24 19:03:19', '2023-01-24 21:55:39'),
(8, 4, 5, '2023-01-24 19:03:22', '2023-01-24 21:56:05'),
(11, 4, 5, '2023-01-24 19:03:25', '2023-01-24 21:56:39'),
(12, 4, 5, '2023-01-24 19:03:26', '2023-01-24 21:56:46'),
(13, 4, 5, '2023-01-24 19:04:34', '2023-01-24 21:59:08'),
(21, 5, 5, '2023-01-25 16:01:43', '2023-01-25 19:01:40'),
(22, 5, 5, '2023-01-25 16:01:46', '2023-01-25 19:01:40'),
(23, 5, 5, '2023-01-25 16:01:47', '2023-01-25 19:01:40'),
(24, 5, 5, '2023-01-25 16:02:27', '2023-01-25 19:01:40'),
(25, 5, 5, '2023-01-25 16:02:54', '2023-01-25 19:02:33'),
(26, 5, 5, '2023-01-25 16:04:07', '2023-01-25 19:02:41'),
(27, 5, 7, '2023-01-25 16:04:09', '2023-01-25 19:02:47'),
(28, 5, 23, '2023-01-25 16:04:13', '2023-01-25 19:02:52'),
(29, 5, 7, '2023-01-25 16:04:11', '2023-01-25 19:03:04'),
(30, 5, 45, '2023-01-25 16:38:42', '2023-01-25 19:14:46'),
(31, 5, 45, '2023-01-25 16:41:21', '2023-01-25 19:14:50'),
(32, 5, 45, '2023-01-25 17:16:14', '2023-01-25 19:38:47'),
(33, 5, 45, '2023-01-25 17:16:15', '2023-01-25 19:42:29'),
(34, 5, 45, '2023-01-25 18:07:30', '2023-01-25 19:42:33'),
(35, 5, 23, '2023-01-25 18:07:37', '2023-01-25 19:42:45'),
(36, 5, 23, '2023-01-25 18:07:39', '2023-01-25 20:17:12'),
(37, 5, 45, '2023-01-25 18:07:32', '2023-01-25 20:17:21'),
(38, 5, 45, '2023-01-25 19:01:53', '2023-01-25 20:17:45'),
(39, 5, 23, '2023-01-25 19:01:51', '2023-01-25 20:17:52'),
(40, 5, 45, '2023-01-25 19:14:24', '2023-01-25 22:01:42'),
(41, 5, 23, '2023-01-25 19:01:55', '2023-01-25 22:01:44'),
(42, 5, 23, '2023-01-25 19:14:27', '2023-01-25 22:01:47'),
(44, 6, 5, '2023-02-01 18:01:47', '2023-01-27 20:50:13'),
(46, 6, 50, '2023-01-25 19:14:27', '2023-01-27 20:50:25'),
(47, 7, 7, '2023-01-25 19:14:27', '2023-01-30 18:21:54'),
(49, 7, 21, '2023-01-25 19:14:27', '2023-01-30 21:08:53'),
(51, 8, 5, '2023-01-31 14:21:18', '2023-01-31 14:07:48'),
(52, 8, 5, '2023-01-31 14:21:21', '2023-01-31 17:21:13'),
(53, 8, 5, '2023-01-31 14:26:51', '2023-01-31 17:21:16'),
(54, 8, 5, '2023-01-31 14:26:54', '2023-01-31 17:26:28'),
(55, 8, 5, '2023-01-31 14:40:11', '2023-01-31 17:26:31'),
(56, 8, 5, '2023-01-31 14:42:01', '2023-01-31 17:40:06'),
(57, 8, 5, '2023-01-31 14:42:05', '2023-01-31 17:40:39'),
(58, 8, 5, '2023-01-31 14:42:09', '2023-01-31 17:40:45'),
(59, 8, 5, '2023-01-31 14:57:57', '2023-01-31 17:40:48'),
(60, 8, 5, '2023-01-31 14:58:01', '2023-01-31 17:40:56'),
(61, 8, 5, '2023-01-31 14:58:05', '2023-01-31 17:41:04'),
(63, 8, 2, '2023-01-31 15:32:07', '2023-01-31 18:29:31'),
(64, 8, 5, '2023-01-31 15:38:51', '2023-01-31 18:32:13'),
(65, 8, 23, '2023-01-31 15:38:58', '2023-01-31 18:32:30'),
(66, 8, 5, '2023-01-31 15:44:48', '2023-01-31 18:38:48'),
(67, 8, 23, '2023-01-31 15:39:00', '2023-01-31 18:38:54'),
(68, 8, 23, '2023-01-31 15:44:44', '2023-01-31 18:38:55'),
(69, 8, 5, '2023-01-31 15:44:49', '2023-01-31 18:39:53'),
(70, 8, 5, '2023-01-31 15:44:49', '2023-01-31 18:41:09'),
(71, 8, 5, '2023-01-31 15:44:50', '2023-01-31 18:44:32'),
(72, 8, 5, '2023-01-31 15:44:51', '2023-01-31 18:44:35'),
(73, 8, 5, '2023-01-31 15:55:11', '2023-01-31 18:44:37'),
(74, 8, 23, '2023-01-31 15:44:45', '2023-01-31 18:44:39'),
(75, 8, 23, '2023-01-31 15:44:47', '2023-01-31 18:44:40'),
(76, 8, 23, '2023-01-31 16:06:29', '2023-01-31 18:44:42'),
(77, 8, 5, '2023-01-31 15:55:13', '2023-01-31 18:51:01'),
(78, 8, 5, '2023-01-31 16:04:38', '2023-01-31 18:55:07'),
(79, 8, 5, '2023-01-31 16:04:41', '2023-01-31 18:56:12'),
(80, 8, 23, '2023-01-31 16:07:22', '2023-01-31 18:56:14'),
(81, 8, 5, '2023-01-31 16:06:24', '2023-01-31 18:56:16'),
(82, 8, 5, '2023-01-31 16:07:19', '2023-01-31 18:56:52'),
(83, 8, 45, '2023-01-31 16:07:21', '2023-01-31 19:06:41'),
(84, 8, 5, '2023-02-01 19:19:43', '2023-02-01 20:50:18'),
(85, 8, 5, '2023-02-01 20:01:20', '2023-02-01 22:19:55'),
(86, 8, 5, '2023-02-01 20:04:34', '2023-02-01 23:01:13'),
(87, 8, 5, NULL, '2023-02-01 23:04:01'),
(88, 9, 5, NULL, '2023-02-02 19:50:22'),
(89, 14, 7, NULL, '2023-02-08 23:21:49'),
(90, 14, 23, NULL, '2023-02-08 23:22:09'),
(91, 15, 45, NULL, '2023-02-09 15:23:17'),
(92, 15, 48, NULL, '2023-02-09 15:23:31'),
(93, 17, 50, NULL, '2023-02-14 11:26:43'),
(94, 18, 21, '2023-02-14 16:01:17', '2023-02-14 15:45:58'),
(95, 18, 7, '2023-02-14 16:18:29', '2023-02-14 19:01:38'),
(96, 18, 5, '2023-02-14 16:18:32', '2023-02-14 19:18:27'),
(97, 18, 42, '2023-02-14 16:57:25', '2023-02-14 19:18:49'),
(98, 18, 23, NULL, '2023-02-14 19:19:15'),
(99, 18, 12, NULL, '2023-02-14 19:57:21'),
(100, 19, 45, NULL, '2023-02-16 21:38:40'),
(101, 19, 49, NULL, '2023-02-16 21:38:59'),
(102, 20, 48, '2023-02-17 20:01:50', '2023-02-17 20:59:47'),
(103, 20, 41, '2023-02-17 20:03:09', '2023-02-17 20:59:56'),
(104, 20, 21, '2023-02-17 20:01:47', '2023-02-17 21:00:22'),
(105, 20, 41, '2023-02-17 20:03:12', '2023-02-17 23:01:30'),
(106, 20, 5, '2023-02-17 21:11:44', '2023-02-17 23:03:18'),
(107, 20, 2, NULL, '2023-02-18 00:11:55'),
(108, 22, 50, '2023-02-20 19:05:33', '2023-02-20 22:02:25'),
(109, 22, 7, NULL, '2023-02-20 22:05:30'),
(110, 23, 5, NULL, '2023-02-21 22:36:11'),
(111, 23, 45, NULL, '2023-02-21 22:36:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categories`
--

CREATE TABLE `tb_categories` (
  `idcategory` int(11) NOT NULL,
  `descategory` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_categories`
--

INSERT INTO `tb_categories` (`idcategory`, `descategory`, `dtregister`) VALUES
(1, 'SMARTPHONES', '2022-11-02 22:19:32'),
(2, 'PROCESSADORES', '2022-11-03 00:54:17'),
(3, 'PLACAS DE VÍDEO', '2022-11-03 00:56:37'),
(4, 'PERIFÉRICOS', '2022-11-13 20:20:58'),
(5, 'APARELHOS', '2023-01-02 18:07:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_orders`
--

CREATE TABLE `tb_orders` (
  `idorder` int(11) NOT NULL,
  `idcart` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idstatus` int(11) NOT NULL,
  `idaddress` int(11) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_orders`
--

INSERT INTO `tb_orders` (`idorder`, `idcart`, `iduser`, `idstatus`, `idaddress`, `vltotal`, `dtregister`) VALUES
(10, 23, 1, 1, 41, 8960.67, '2023-02-21 22:37:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_ordersstatus`
--

CREATE TABLE `tb_ordersstatus` (
  `idstatus` int(11) NOT NULL,
  `desstatus` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_ordersstatus`
--

INSERT INTO `tb_ordersstatus` (`idstatus`, `desstatus`, `dtregister`) VALUES
(1, 'Em Aberto', '2017-03-13 06:00:00'),
(2, 'Aguardando Pagamento', '2017-03-13 06:00:00'),
(3, 'Pago', '2017-03-13 06:00:00'),
(4, 'Entregue', '2017-03-13 06:00:00'),
(5, 'Cancelado', '2023-02-16 20:29:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_persons`
--

CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL,
  `desperson` varchar(64) NOT NULL,
  `desemail` varchar(128) DEFAULT NULL,
  `nrphone` bigint(20) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_persons`
--

INSERT INTO `tb_persons` (`idperson`, `desperson`, `desemail`, `nrphone`, `dtregister`) VALUES
(1, 'Admin da Silva', 'admin@suporte.com', 11997628381, '2022-08-15 19:55:56'),
(7, 'Victor Daniel', 'victordn.araujo@gmail.com', 11997817789, '2022-08-26 00:03:40'),
(8, 'Eu creio', 'eucreio119@gmail.com', 11997273714, '2022-08-29 20:41:11'),
(10, 'suporte', 'suporte@suporte.com', 11998263788, '2023-01-30 19:22:21'),
(11, 'Kaique', 'kaique@suporte.com', 119972866628, '2023-02-03 00:44:18'),
(12, 'Zaquel da Silva', 'zaquel@gmail.com', 119972866382, '2023-02-03 18:09:46'),
(13, 'matheus silva ribeiro', 'matheus@gmail.com', 11992728822, '2023-02-03 18:13:34'),
(14, 'Yago Ribeiro', 'yago@gmail.com', 119928338829, '2023-02-03 18:16:25'),
(31, 'sara silva', 'sara@gmail.com', 119972826612, '2023-02-03 19:15:36'),
(32, 'gabriel da silva', 'gabriel@gmail.com', 11997839288, '2023-02-03 19:19:05'),
(33, 'matheus', 'matheus@gmail.com', 11992738827, '2023-02-03 19:51:51'),
(34, 'fatima', 'fatima@gmail.com', 0, '2023-02-03 19:55:32'),
(35, 'katia', 'katia@gmail.com', 11992837727, '2023-02-03 20:03:41'),
(36, 'João', 'joao@gmail.com', 11992738838, '2023-02-03 20:05:44'),
(37, 'Raquel', 'raquel@gmail.com', 11992877488, '2023-02-03 20:17:52'),
(41, 'raquel oliveira', 'raquel@gmail.com', 11997256388, '2023-02-05 00:50:08'),
(42, 'Fatima', 'fatima@gmail.com', 11998827627, '2023-02-05 02:19:28'),
(43, 'vitao', 'vitao@gmail.com', 119982734773, '2023-02-05 02:29:17'),
(44, 'hannah', 'hannah@gmail.com', 19982787883, '2023-02-05 02:30:46'),
(45, 'eduardo oliveira de lima', 'eduardo@gmail.com', 619982728828, '2023-02-05 02:31:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_products`
--

CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `vlwidth` decimal(10,2) NOT NULL,
  `vlheight` decimal(10,2) NOT NULL,
  `vllength` decimal(10,2) NOT NULL,
  `vlweight` decimal(10,2) NOT NULL,
  `desurl` varchar(128) NOT NULL,
  `imgproduct` varchar(100) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_products`
--

INSERT INTO `tb_products` (`idproduct`, `desproduct`, `vlprice`, `vlwidth`, `vlheight`, `vllength`, `vlweight`, `desurl`, `imgproduct`, `dtregister`) VALUES
(2, 'Smart TV LED LG 4K', 1475.30, 8.00, 90.00, 90.00, 90.00, 'smart-lg-tv-led-4k', '81lrAs5CQtL._AC_SL1500_.jpg', '2017-03-13 06:00:00'),
(5, 'Celular Samsung S12 64GB 4GB', 2500.87, 1.10, 8.90, 4.10, 0.80, 'celular-samsung-s7 ', 'celular-smartphone-galaxy-s22-5g-128gb-8gb-ram-samsung_706173.png', '2022-12-18 20:06:35'),
(7, 'Fone de Ouvido JBL Sorrounded ', 18.90, 0.10, 1.00, 5.00, 0.01, 'Fone-de-ouvido-sorrounded', 'JBL_TUNE_510BT_Product Image_Hero_Black.png', '2022-12-18 20:43:44'),
(12, 'Celular Samsung Galaxy A13', 4800.87, 2.00, 4.50, 3.00, 0.60, 'samsung-galaxy-a13', 'br-galaxy-a13-sm-a135-sm-a135mlbjzto-531826439.png', '2022-12-20 16:19:17'),
(21, 'Memória RAM 16GB HYPERX 3600HZ', 320.99, 1.00, 2.50, 8.50, 0.01, 'memoria-ram-hyperx-16gb', 'D_NQ_NP_821717-MLA48985939282_012022-O.png', '2022-12-25 18:35:10'),
(23, 'Processador Ryzen 5 1400 3.2Ghz 8 Núcleos', 450.90, 1.00, 4.00, 4.00, 0.90, 'processador-ryzen-5-1400-4.2ghz-turbo-3.5ghz-8-núcleos', 'ryzen-r5.png', '2022-12-25 18:48:13'),
(41, 'GTX 1660 6GB Windforce G1 Gaming Gigabyte', 1788.90, 3.00, 8.00, 15.00, 35.00, 'gtx-1660-6gb-windforce-g1-gaming-gigabyte', 'Png.png', '2023-01-06 19:40:59'),
(42, 'Pau de Selfie Com Apoio Bluetooth', 15.00, 4.00, 10.00, 4.00, 10.00, 'pau-de-selfie-com-apoio-bluetooth', '31kbrUQVWHL._AC_SS450_.jpg', '2023-01-07 18:20:18'),
(43, 'Smartphone Samsung  J7 Prime Plus', 900.99, 2.00, 7.00, 6.00, 20.00, 'smartphone-samsung-j7-prime-plus', 'smartphone-samsung-galaxy-j7-prime-preto-16gb-ram-3gb-octa-core-4g-13mp-tela-55-android-8.jpg', '2023-01-07 18:43:23'),
(44, 'Mini Ventilador Vermelho 12W Bateria AA', 12.00, 3.00, 5.00, 3.00, 30.00, 'mini-ventilador-vermelho-12w-bateria-aa', 'D_NQ_NP_630222-MLB47494495503_092021-V.jpg', '2023-01-07 18:45:53'),
(45, 'Placa de Vídeo RTX 3060 12GB 1-CLICK OC GDDR6X ASUS', 6345.80, 4.00, 6.00, 13.00, 20.00, 'placa-de-video-rtx-3060-12gb-1-click-oc-gddr6x', 'placa-de-video-asus-tuf-rtx3060-o12g-v2-gaming-90yv0gc0-m0na10_1624968047_gg.jpg', '2023-01-07 18:51:10'),
(46, 'Pendrive 4GB 3.0', 20.50, 1.00, 4.00, 2.00, 1.00, 'Pendrive-4GB-3.0', 'master_pen-drive-multilaser-4gb-preto-pd586bu-sem-logo-e-sem-caixa-afa4b33e..jpg', '2023-01-07 19:15:33'),
(47, 'Pendrive 8GB 3.0', 40.43, 1.00, 5.00, 2.00, 1.00, 'Pendrive-8gb-3.0', 'master_pen-drive-multilaser-4gb-preto-pd586bu-sem-logo-e-sem-caixa-afa4b33e..jpg', '2023-01-07 19:16:42'),
(48, 'Teclado Gamer Asrock 3.0 RGB Mecânico  10 Atalhos', 199.99, 2.00, 10.00, 30.00, 10.00, 'teclado-gamer-asrock-3.0-rgb-mecânico-10-atalhos', '180_teclado_gamer_gaming_master_k_mex_km_5228_rgb_8345_2_4af2385c49c3a972653916772a25f93e (1).png', '2023-01-09 15:22:07'),
(49, 'Processador Ryzen 5 3600 3.5Ghz 12 Núcleos 12 Threads', 800.21, 1.00, 4.00, 4.00, 0.10, 'processador-ryzen-5-3600-3.5ghz-12-nucleos-12-threads', 'processador-amd-ryzen-5-3600-36ghz-42ghz-turbo-6-core-12-thread-cooler-wraith-stealth-am4_143877.jpg', '2023-01-27 20:08:20'),
(50, 'Placa de Vídeo Radeon 5600X 8GB GDDR6', 2800.80, 30.00, 20.00, 40.00, 35.00, 'placa-de-vídeo-radeon-5600X-8GB-gddr6', 'avideo67007.jpg', '2023-01-27 20:10:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_productscategories`
--

CREATE TABLE `tb_productscategories` (
  `idcategory` int(11) NOT NULL,
  `idproduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_productscategories`
--

INSERT INTO `tb_productscategories` (`idcategory`, `idproduct`) VALUES
(1, 5),
(1, 12),
(1, 43),
(2, 23),
(3, 41),
(3, 45),
(4, 7),
(4, 46),
(4, 47),
(5, 2),
(5, 42),
(5, 44),
(5, 46),
(5, 47);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `deslogin` varchar(64) DEFAULT NULL,
  `despassword` varchar(256) NOT NULL,
  `inadmin` tinyint(4) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`iduser`, `idperson`, `deslogin`, `despassword`, `inadmin`, `dtregister`) VALUES
(1, 1, 'Admin Da Silva', '$2y$10$o02kfzjS0Sml0SRGdpnt4uLYQym9lTvHin8A3awh2tGJfgqM1riFi', 1, '2022-08-15 19:55:56'),
(7, 7, 'VICTOR DANIEL', '$2y$10$V27FZ88PScXEWG4jpL/Ate3z0r/9TRzOHUmQBEnh7grz055Cg.rhe', 1, '2022-08-26 00:03:40'),
(8, 8, 'Eu Creio', '$2y$10$A2N5A/WLjwtLXItds6pK8u9.YJGxXSgwKaVQ5BvA9oYM9rBfZe6ay', 0, '2022-08-29 20:41:11'),
(10, 10, 'SUPORTE', '$2y$10$TdopppLyP8rM9CBziSweXeHmU2Fj41yyZ7grCPBjRxlgyByVXvLEq', 1, '2023-01-30 19:22:21'),
(11, 11, 'KAIQUE', '$2y$10$gj0RxB1Duo1NS5g0qRG.Je5Up1NoIetwDhl9d466b6FTlBOjOsmPm', 0, '2023-02-03 00:44:18'),
(12, 12, 'ZAQUEL DA SILVA', '$2y$10$4.0vQenTBxF.B9Sm506iruCPT4DC.GCUTOJKIp3d548ZiGBV4mHSq', 0, '2023-02-03 18:09:46'),
(13, 13, 'Matheus Silva Ribeiro', '$2y$10$JH51q35VB3xvrjuCxcZsYuOug4TSNliJ7v1Uutag4sgv04yyMLvWW', 0, '2023-02-03 18:13:34'),
(14, 14, 'Yago Ribeiro', '$2y$10$CSZLyL7oseB1BlrGq.2RTuzRzAfzw2jsK5WkWEVgxJWrVEeU5fp0.', 0, '2023-02-03 18:16:25'),
(31, 31, 'Sara Silva', '$2y$10$m28TX4Swamg119HgK03onu3792aOxyQ4Q2BpzuVSznVWFWQ8ie8gS', 0, '2023-02-03 19:15:36'),
(32, 32, 'Gabriel Da Silva', '$2y$10$r2ZQkj9xMEmDcoEEW3UDCOqWWt.eUBjMx./1N8J6shrr/nXSPKxSG', 0, '2023-02-03 19:19:05'),
(33, 33, 'Matheus', '$2y$10$ZaLW93seaCS3NVSl6zEzbe3YQuZRYakVLH5CGtsze0qgF9YOwHhfS', 0, '2023-02-03 19:51:51'),
(34, 34, 'Fatima', '$2y$10$uRMXMDads6gnF8GBsX.z1Oki608ZPAGQEmUUOebn/1UGAzPa224z.', 0, '2023-02-03 19:55:32'),
(35, 35, 'Katia', '$2y$10$rA9raV3wy0Mnyz9t0eXmQOCh77q8eg8q0T8XyGLZVBe/H4ysvLGcq', 0, '2023-02-03 20:03:41'),
(36, 36, 'João', '$2y$10$j/CaZjhizI2Fgrpd9KQTQeBjJUR5LqdXMt..2hOKnT/Y6oNuUqiwu', 0, '2023-02-03 20:05:44'),
(37, 37, 'Raquel', '$2y$10$jRtsaKAACpO2J1.k/XS32eLrSqQykFeXcr4u2Lxqkd06tEIIA6q02', 0, '2023-02-03 20:17:52'),
(41, 41, 'Raquel Oliveira', '$2y$10$vnmOdGB3dv/jN6vW8G0.sOE/ICOfeIFigZmIUxiS3hxZ.dXLYAkn6', 0, '2023-02-05 00:50:08'),
(42, 42, 'Fatima', '$2y$10$v9vij695Pf7SgOeeXURbKepNP562yh8G.vjNn8X.OViPIJ0/WWTsO', 0, '2023-02-05 02:19:28'),
(43, 43, 'Vitao', '$2y$10$dcPs.uNRBjyvxVZA2Vi4Bubi6M5ngt0mNoF4Q.jedZzVy2qU31Yf6', 0, '2023-02-05 02:29:17'),
(44, 44, 'Hannah', '$2y$10$caizG7cqWHCTy/884RzUyeAN7eG.7OGfdOe2mNuOQ01JPuBYXk4wq', 0, '2023-02-05 02:30:46'),
(45, 45, 'Eduardo Oliveira De Lima', '$2y$10$7i5rGy999ey0ofQlGFHYpuqXO62n0t1K7czgInOofD9w4XYHMjGBW', 0, '2023-02-05 02:31:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userslogs`
--

CREATE TABLE `tb_userslogs` (
  `idlog` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `deslog` varchar(128) NOT NULL,
  `desip` varchar(45) NOT NULL,
  `desuseragent` varchar(128) NOT NULL,
  `dessessionid` varchar(64) NOT NULL,
  `desurl` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_userspasswordsrecoveries`
--

CREATE TABLE `tb_userspasswordsrecoveries` (
  `idrecovery` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `desip` varchar(45) NOT NULL,
  `dtrecovery` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_userspasswordsrecoveries`
--

INSERT INTO `tb_userspasswordsrecoveries` (`idrecovery`, `iduser`, `desip`, `dtrecovery`, `dtregister`) VALUES
(4, 7, '179.209.251.111', NULL, '2022-08-26 00:50:32'),
(5, 7, '179.209.251.111', NULL, '2022-08-26 00:55:46'),
(6, 7, '179.209.251.111', NULL, '2022-08-26 16:54:09'),
(7, 7, '179.209.251.111', NULL, '2022-08-26 17:33:29'),
(8, 7, '179.209.251.111', NULL, '2022-08-26 17:36:18'),
(9, 7, '179.209.251.111', NULL, '2022-08-26 17:37:25'),
(10, 7, '179.209.251.111', NULL, '2022-08-26 17:38:03'),
(11, 7, '179.209.251.111', NULL, '2022-08-26 17:43:36'),
(12, 7, '179.209.251.111', NULL, '2022-08-26 19:39:56'),
(13, 7, '179.209.251.111', NULL, '2022-08-26 19:57:32'),
(14, 7, '179.209.251.111', NULL, '2022-08-26 20:01:31'),
(15, 7, '179.209.251.111', NULL, '2022-08-26 20:24:02'),
(16, 7, '179.209.251.111', NULL, '2022-08-26 21:16:10'),
(17, 7, '179.209.251.111', NULL, '2022-08-29 17:57:12'),
(18, 7, '179.209.251.111', NULL, '2022-08-29 18:18:07'),
(19, 7, '179.209.251.111', NULL, '2022-08-29 18:20:59'),
(20, 7, '179.209.251.111', NULL, '2022-08-29 18:34:36'),
(21, 7, '179.209.251.111', NULL, '2022-08-29 18:47:51'),
(22, 7, '179.209.251.111', NULL, '2022-08-29 18:49:36'),
(23, 7, '179.209.251.111', NULL, '2022-08-29 19:37:10'),
(24, 7, '179.209.251.111', NULL, '2022-08-29 19:38:12'),
(25, 7, '179.209.251.111', NULL, '2022-08-29 19:38:37'),
(26, 7, '179.209.251.111', NULL, '2022-08-29 19:38:54'),
(27, 7, '179.209.251.111', NULL, '2022-08-29 19:50:27'),
(28, 7, '179.209.251.111', NULL, '2022-08-29 19:50:45'),
(29, 7, '179.209.251.111', NULL, '2022-08-29 19:51:11'),
(30, 7, '179.209.251.111', NULL, '2022-08-29 19:51:26'),
(31, 7, '179.209.251.111', NULL, '2022-08-29 19:51:31'),
(32, 7, '179.209.251.111', NULL, '2022-08-29 19:51:36'),
(33, 7, '179.209.251.111', NULL, '2022-08-29 19:52:00'),
(34, 7, '179.209.251.111', NULL, '2022-08-29 19:53:49'),
(35, 7, '179.209.251.111', NULL, '2022-08-29 19:54:58'),
(36, 7, '179.209.251.111', NULL, '2022-08-29 20:20:52'),
(37, 7, '179.209.251.111', NULL, '2022-08-29 20:21:11'),
(38, 7, '179.209.251.111', NULL, '2022-08-29 20:22:15'),
(39, 7, '179.209.251.111', NULL, '2022-08-29 20:22:49'),
(40, 8, '179.209.251.111', NULL, '2022-08-29 21:12:29'),
(41, 8, '179.209.251.111', NULL, '2022-09-09 21:12:00'),
(42, 8, '179.209.251.111', NULL, '2022-09-13 00:26:22'),
(43, 8, '179.209.251.111', NULL, '2022-10-16 17:40:17'),
(44, 8, '179.209.251.111', '2022-10-16 18:17:40', '2022-10-16 20:54:14'),
(45, 8, '179.209.251.111', '2022-10-16 18:20:46', '2022-10-16 21:19:14'),
(46, 8, '179.209.251.111', '2022-10-17 21:04:49', '2022-10-18 00:01:38'),
(47, 8, '179.209.251.111', '2022-11-05 16:34:10', '2022-11-05 19:30:08'),
(48, 8, '179.209.251.111', NULL, '2023-02-05 19:16:14'),
(49, 8, '179.209.251.111', '2023-02-05 16:26:01', '2023-02-05 19:16:50'),
(50, 8, '179.209.251.111', '2023-02-05 16:29:39', '2023-02-05 19:27:25'),
(51, 8, '179.209.251.111', '2023-02-05 16:33:38', '2023-02-05 19:33:12'),
(52, 8, '179.209.251.111', '2023-02-05 16:34:31', '2023-02-05 19:33:54');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_addresses`
--
ALTER TABLE `tb_addresses`
  ADD PRIMARY KEY (`idaddress`),
  ADD KEY `fk_addresses_persons_idx` (`idperson`);

--
-- Índices para tabela `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD PRIMARY KEY (`idcart`),
  ADD KEY `FK_carts_users_idx` (`iduser`);

--
-- Índices para tabela `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  ADD PRIMARY KEY (`idcartproduct`),
  ADD KEY `FK_cartsproducts_carts_idx` (`idcart`),
  ADD KEY `FK_cartsproducts_products_idx` (`idproduct`);

--
-- Índices para tabela `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`idcategory`);

--
-- Índices para tabela `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD PRIMARY KEY (`idorder`),
  ADD KEY `FK_orders_users_idx` (`iduser`),
  ADD KEY `fk_orders_ordersstatus_idx` (`idstatus`),
  ADD KEY `fk_orders_carts_idx` (`idcart`),
  ADD KEY `fk_orders_addresses_idx` (`idaddress`);

--
-- Índices para tabela `tb_ordersstatus`
--
ALTER TABLE `tb_ordersstatus`
  ADD PRIMARY KEY (`idstatus`);

--
-- Índices para tabela `tb_persons`
--
ALTER TABLE `tb_persons`
  ADD PRIMARY KEY (`idperson`);

--
-- Índices para tabela `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`idproduct`);

--
-- Índices para tabela `tb_productscategories`
--
ALTER TABLE `tb_productscategories`
  ADD PRIMARY KEY (`idcategory`,`idproduct`),
  ADD KEY `fk_productscategories_products_idx` (`idproduct`);

--
-- Índices para tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `FK_users_persons_idx` (`idperson`);

--
-- Índices para tabela `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  ADD PRIMARY KEY (`idlog`),
  ADD KEY `fk_userslogs_users_idx` (`iduser`);

--
-- Índices para tabela `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  ADD PRIMARY KEY (`idrecovery`),
  ADD KEY `fk_userspasswordsrecoveries_users_idx` (`iduser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_addresses`
--
ALTER TABLE `tb_addresses`
  MODIFY `idaddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `tb_carts`
--
ALTER TABLE `tb_carts`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  MODIFY `idcartproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de tabela `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_orders`
--
ALTER TABLE `tb_orders`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_ordersstatus`
--
ALTER TABLE `tb_ordersstatus`
  MODIFY `idstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_persons`
--
ALTER TABLE `tb_persons`
  MODIFY `idperson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `idproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  MODIFY `idlog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  MODIFY `idrecovery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_addresses`
--
ALTER TABLE `tb_addresses`
  ADD CONSTRAINT `fk_addresses_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD CONSTRAINT `fk_carts_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_cartsproducts`
--
ALTER TABLE `tb_cartsproducts`
  ADD CONSTRAINT `fk_cartsproducts_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_orders`
--
ALTER TABLE `tb_orders`
  ADD CONSTRAINT `fk_orders_addresses` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_carts` FOREIGN KEY (`idcart`) REFERENCES `tb_carts` (`idcart`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_ordersstatus` FOREIGN KEY (`idstatus`) REFERENCES `tb_ordersstatus` (`idstatus`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_productscategories`
--
ALTER TABLE `tb_productscategories`
  ADD CONSTRAINT `fk_productscategories_categories` FOREIGN KEY (`idcategory`) REFERENCES `tb_categories` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productscategories_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `fk_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_userslogs`
--
ALTER TABLE `tb_userslogs`
  ADD CONSTRAINT `fk_userslogs_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_userspasswordsrecoveries`
--
ALTER TABLE `tb_userspasswordsrecoveries`
  ADD CONSTRAINT `fk_userspasswordsrecoveries_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
