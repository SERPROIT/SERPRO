-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2020 at 12:57 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdsistema`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cliente` (IN `p_DisplayLength` INT, IN `p_DisplayStart` INT, IN `p_SortCol` INT, IN `p_SortDir` VARCHAR(10), IN `p_Search` VARCHAR(255))  BEGIN

 DECLARE FirstRec int DEFAULT 0;
 DECLARE LastRec int DEFAULT 0;
 SET FirstRec = p_DisplayStart;
 SET LastRec = p_DisplayStart + p_DisplayLength;
 
 
  With CTE_cliente as
 (
  Select ROW_NUMBER() over (order by 
  
	  case when (p_SortCol = 0 and p_SortDir='asc')
	   then id
	  end asc,
	  case when (p_SortCol = 0 and p_SortDir='desc')
	   then id
	  end desc,
		case when (p_SortCol = 1 and p_SortDir='asc')
			then nombre
		end asc,
		case when (p_SortCol = 1 and p_SortDir='desc')
			then nombre
		end desc
  )
  as RowNum,
  COUNT(*) over() as TotalCount,
  c.id,
  c.nombre,
  c.iddepartamento,
  (select nombre from departamento where id = c.iddepartamento) as departamento,
  idprovincia,
  (select nombre from provincia where id = c.idprovincia) as provincia,
  iddistrito,
  (select nombre from distrito where id = c.iddistrito) as distrito,
  c.direccion,
  c.telefono
  from cliente c
  where (p_Search IS NULL 
    Or nombre like concat('%' , p_Search , '%'))
	AND estado = 1
 )
 
 Select * 
 from CTE_cliente
 where RowNum BETWEEN FirstRec AND LastRec;
 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_I_UsuarioMarcacion` (IN `cDniUsu` VARCHAR(9), IN `cTipMar` VARCHAR(11))  BEGIN
DECLARE cFecAct VARCHAR(10);
DECLARE hIngMar VARCHAR(8);
DECLARE hSalRef VARCHAR(8);
DECLARE hEntRef VARCHAR(8);
DECLARE hSalMar VARCHAR(8);
DECLARE cMenEstTar VARCHAR(10);  
DECLARE cMenEstTem VARCHAR(10); 
DECLARE cCodMarGen INT;

DECLARE cLogUsu VARCHAR(15);
DECLARE cIdUsu INT;
DECLARE cNomUsu VARCHAR(50);
DECLARE lhIngMarUsu CHAR(9);
DECLARE lhSalRefUsu CHAR(9);
DECLARE lhEntRefUsu CHAR(9);
DECLARE lhSalMarUsu CHAR(9);

 SET cMenEstTar ='TARDANZA';
 SET cMenEstTem ='TEMPRANO';
 /*
 SET cFecAct = '2020-03-14';
 SET hIngMar = '09:00:00';
 SET hSalRef = '13:00:00';
 SET hEntRef = '14:00:00';
 SET hSalMar = '18:00:00';
 */
 SET cFecAct = (SELECT CURDATE());
 SET hIngMar = (SELECT CURTIME());
 SET hSalRef = (SELECT CURTIME());
 SET hEntRef = (SELECT CURTIME());
 SET hSalMar = (SELECT CURTIME());

SET cIdUsu = (SELECT id FROM usuario WHERE dni = cDniUsu);
SET cLogUsu =(SELECT usuario FROM usuario WHERE dni = cDniUsu);
SET cNomUsu = (SELECT nombre FROM usuario WHERE usuario = cLogUsu);
SET lhIngMarUsu = (SELECT h_ingreso FROM marcaciones_generales WHERE usuario = cLogUsu);
SET lhSalRefUsu = (SELECT h_salida_refrigerio FROM marcaciones_generales WHERE usuario = cLogUsu);
SET lhEntRefUsu = (SELECT h_ingreso_refrigerio FROM marcaciones_generales WHERE usuario = cLogUsu);
SET lhSalMarUsu = (SELECT h_salida FROM marcaciones_generales WHERE usuario = cLogUsu);
SET cCodMarGen = (SELECT idmarcacion_general FROM marcaciones_generales WHERE usuario = cLogUsu); 


 IF cTipMar = 'INGRESO' THEN
   IF hIngMar > lhIngMarUsu THEN
     INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
     VALUES ( 1, cFecAct, hIngMar, 'INGRESO', cMenEstTar, cIdUsu, NOW());
 ELSE 
    INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hIngMar, 'INGRESO', cMenEstTem, cIdUsu, NOW());
   END IF;
 END IF;
 
 
 IF cTipMar = 'SREFRIGERIO' THEN
   IF hSalRef > lhSalRefUsu THEN
    INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalRef, 'S. REFRIGERIO', cMenEstTar, cIdUsu, NOW());
 ELSE 
   INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalRef, 'S. REFRIGERIO', cMenEstTem, cIdUsu, NOW());
    END IF;
   END IF;
   
 IF cTipMar = 'EREFRIGERIO' THEN
   IF hEntRef > lhEntRefUsu THEN
    INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hEntRef, 'E. REFRIGERIO', cMenEstTar, cIdUsu, NOW());
 ELSE 
   INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hEntRef, 'E. REFRIGERIO', cMenEstTem, cIdUsu, NOW());
    END IF;
   END IF;   
 
  IF cTipMar = 'SMARCACION' THEN
   IF hSalMar > lhSalMarUsu THEN
    INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalMar, 'SALIDA', cMenEstTar, cIdUsu, NOW());
 ELSE 
   INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalMar, 'SALIDA', cMenEstTem, cIdUsu, NOW());
     END IF;
   END IF;  
   
 IF cTipMar = 'SEXCEPCIONAL' THEN
   IF hSalMar > lhSalMarUsu THEN
    INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalMar, 'SALIDA EXCEPCIONAL', cMenEstTar, cIdUsu, NOW());
 ELSE 
   INSERT INTO detallemarcaciones (idmarcacion_general, df_ingreso, hr_ingreso, estado_marcacion, estado, usuario, fecha_sistema)
    VALUES ( 1, cFecAct, hSalMar, 'SALIDA EXCEPCIONAL', cMenEstTem, cIdUsu, NOW());
     END IF;
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_proveedor` (IN `p_DisplayLength` INT, IN `p_DisplayStart` INT, IN `p_SortCol` INT, IN `p_SortDir` VARCHAR(10), IN `p_Search` VARCHAR(255))  BEGIN


 DECLARE FirstRec int DEFAULT 0;
 DECLARE LastRec int DEFAULT 0;
 SET FirstRec = p_DisplayStart;
 SET LastRec = p_DisplayStart + p_DisplayLength;
 
 
  With CTEPROVEEDOR as
 (
  Select ROW_NUMBER() over (order by 
  
	  case when (p_SortCol = 0 and p_SortDir='asc')
	   then id
	  end asc,
	  case when (p_SortCol = 0 and p_SortDir='desc')
	   then id
	  end desc,
		case when (p_SortCol = 1 and p_SortDir='asc')
			then nombre
		end asc,
		case when (p_SortCol = 1 and p_SortDir='desc')
			then nombre
		end desc
  )
  as RowNum,
  COUNT(*) over() as TotalCount,
  c.id,
  c.nombre,
  c.iddepartamento,
  (select nombre from departamento where id = c.iddepartamento) as departamento,
  idprovincia,
  (select nombre from provincia where id = c.idprovincia) as provincia,
  iddistrito,
  (select nombre from distrito where id = c.iddistrito) as distrito,
  c.direccion,
  c.telefono
  from proveedor c
  where (p_Search IS NULL 
    Or nombre like concat('%' , p_Search , '%'))
	AND estado = 1
 )
 
 Select * 
 from CTEPROVEEDOR
 where RowNum BETWEEN FirstRec AND LastRec;
 


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_S_ListarDetalleMarcacion` (IN `p_DisplayLength` INT, IN `p_DisplayStart` INT, IN `p_SortCol` INT, IN `p_SortDir` VARCHAR(10), IN `p_Search` VARCHAR(255))  NO SQL
BEGIN

 DECLARE FirstRec int DEFAULT 0;
 DECLARE LastRec int DEFAULT 0;
 SET FirstRec = p_DisplayStart;
 SET LastRec = p_DisplayStart + p_DisplayLength;
 
 
  With CTE_DetMarcacion as
 (
  Select ROW_NUMBER() over (order by 
  
                            case when (p_SortCol = 0 and p_SortDir='asc')
                            then id
                            end asc,
                            case when (p_SortCol = 0 and p_SortDir='desc')
                            then id
                            end desc,
                            case when (p_SortCol = 1 and p_SortDir='asc')
                            then nombre
                            end asc,
                            case when (p_SortCol = 1 and p_SortDir='desc')
                            then nombre
                            end desc
  )
     as RowNum,
     COUNT(*) over() as TotalCount,
   T1.nombre,
   T2.df_ingreso,
   T2.hr_ingreso,
   T2.estado_marcacion,
   T2.estado,
   T2.usuario
     FROM usuario T1 
      INNER JOIN detallemarcaciones T2 ON T1.id = T2.usuario
     WHERE (p_Search IS NULL 
            Or T1.nombre LIKE concat('%' , p_Search , '%'))
 )
 
 Select * 
 from CTE_DetMarcacion
 where RowNum BETWEEN FirstRec AND LastRec;
 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_S_TraerUsuarioMarcacion` (IN `cNumDoc` VARCHAR(9))  BEGIN
DECLARE cNomUsu VARCHAR(50);
 IF EXISTS(SELECT dni FROM usuario WHERE dni = cNumDoc) THEN
     SET cNomUsu = (
 		  SELECT nombre AS Nombres 
     		  FROM usuario WHERE dni = cNumDoc
 		   );  
ELSE
  SET cNomUsu = '-1';
END IF;
   SELECT cNomUsu As NomUsu;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_S_ValidarContrasenaUsuario` (IN `cNumDoc` VARCHAR(9), IN `cConUsu` VARCHAR(300))  BEGIN
DECLARE c_input VARCHAR(50);
	IF EXISTS(SELECT password FROM usuario WHERE dni = cNumDoc AND password = cConUsu) THEN
     SET c_input = '1';
	ELSE 
     SET c_input = '-1';
    END IF;
  SELECT c_input As Mssage;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_worker` (IN `p_DisplayLength` INT, IN `p_DisplayStart` INT, IN `p_SortCol` INT, IN `p_SortDir` VARCHAR(10), IN `p_Search` VARCHAR(255))  BEGIN

 DECLARE FirstRec int DEFAULT 0;
 DECLARE LastRec int DEFAULT 0;
 SET FirstRec = p_DisplayStart;
 SET LastRec = p_DisplayStart + p_DisplayLength;
 
 
  With CTE_usuario as
 (
  Select ROW_NUMBER() over (order by 
  
	  case when (p_SortCol = 0 and p_SortDir='asc')
	   then id
	  end asc,
	  case when (p_SortCol = 0 and p_SortDir='desc')
	   then id
	  end desc,
		case when (p_SortCol = 1 and p_SortDir='asc')
			then usuario
		end asc,
		case when (p_SortCol = 1 and p_SortDir='desc')
			then usuario
		end desc,
      case when (p_SortCol = 1 and p_SortDir='asc')
			then nombre
		end asc,
		case when (p_SortCol = 1 and p_SortDir='desc')
			then nombre
		end desc
  )
  as RowNum,
  COUNT(*) over() as TotalCount,
  c.id,
  c.usuario,
  c.nombre
  from usuario c
  where (p_Search IS NULL 
    Or usuario like concat('%' , p_Search , '%'))
	AND estado = 1
 )
 
 Select * 
 from CTE_usuario
 where RowNum BETWEEN FirstRec AND LastRec;
 

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idprovincia` int(11) DEFAULT NULL,
  `iddistrito` int(11) DEFAULT NULL,
  `direccion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `iddepartamento`, `idprovincia`, `iddistrito`, `direccion`, `telefono`, `estado`) VALUES
(3, 'sdfdsf', 1, 101, 10101, 'sdfsfsdf', '5155151', b'0'),
(4, 'sdfsf', 2, 201, 20103, 'fsdfs', '6232', b'0'),
(5, 'werwer pasjerp', 2, 201, 20101, 'aaaaaa', '4646546', b'1'),
(6, 'pierina grimaldo', 14, 1401, 140101, 'qqqq dddd ccvvv lasdlsadGJGJGJGJGJKGJGGMHFFFGIFNDGNDGNDNGD', '987654321', b'1'),
(7, 'pierina', 1, 101, 10101, 'zzzzzz', '987654321', b'1'),
(8, 'www', 1, 101, 10101, 'www', '1222', b'1'),
(9, 'qweqweqwe', 1, 101, 10101, 'qweqweqweqweqwewq', '99516161', b'1'),
(10, 'adasdasd', 1, 101, 10101, 'cvcvcvcvv', '6565654564', b'1'),
(11, 'asdasdasd', NULL, NULL, NULL, 'asdasdasdasda', '65651651', b'0'),
(12, 'dsaddsadad', NULL, NULL, NULL, 's', '646515', b'0'),
(13, 'asdasdas', NULL, NULL, NULL, 'asdasdas', '651651651', b'0'),
(14, 'adfsdf', 1, 101, 10101, 'fdf', '5151', b'0'),
(15, 'dasdasd', NULL, NULL, NULL, 'asdasdads', '5151', b'0'),
(16, 'qqqq', 1, 101, 10101, 'qqqq', '99999', b'1'),
(17, 'chiclayo', 1, 101, 10101, 'yyyyyyyyyyyyyyyyy', '654654654', b'0'),
(18, 'rrrrrrrrrrrr', 1, 101, 10101, 'bbbbbbbbbbbb', '21321321', b'0'),
(19, 'pier mi perrita', 15, 1501, 150115, 'mi bbita golosa', '987654321', b'0'),
(20, 'grimaldo', 15, 1501, 150110, 'xxx', '654654654599999', b'1'),
(21, NULL, 1, 101, 10101, NULL, NULL, b'0'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, b'0'),
(24, NULL, NULL, NULL, NULL, NULL, NULL, b'0'),
(25, 'cliente serproc', 15, 1501, 150101, 'huandoy 456', '987654321', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`) VALUES
(1, 'Amazonas'),
(2, 'Áncash'),
(3, 'Apurímac'),
(4, 'Arequipa'),
(5, 'Ayacucho'),
(6, 'Cajamarca'),
(7, 'Callao'),
(8, 'Cusco'),
(9, 'Huancavelica'),
(10, 'Huánuco'),
(11, 'Ica'),
(12, 'Junín'),
(13, 'La Libertad'),
(14, 'Lambayeque'),
(15, 'Lima'),
(16, 'Loreto'),
(17, 'Madre de Dios'),
(18, 'Moquegua'),
(19, 'Pasco'),
(20, 'Piura'),
(21, 'Puno'),
(22, 'San Martín'),
(23, 'Tacna'),
(24, 'Tumbes'),
(25, 'Ucayali');

-- --------------------------------------------------------

--
-- Table structure for table `detallemarcaciones`
--

CREATE TABLE `detallemarcaciones` (
  `idmarcacion` int(11) NOT NULL,
  `idmarcacion_general` int(11) NOT NULL,
  `df_ingreso` char(10) DEFAULT NULL,
  `hr_ingreso` char(8) DEFAULT NULL,
  `estado_marcacion` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `fecha_sistema` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `distrito`
--

CREATE TABLE `distrito` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `idprovincia` int(11) DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distrito`
--

INSERT INTO `distrito` (`id`, `nombre`, `idprovincia`, `iddepartamento`) VALUES
(10101, 'Chachapoyas', 101, 1),
(10102, 'Asunción', 101, 1),
(10103, 'Balsas', 101, 1),
(10104, 'Cheto', 101, 1),
(10105, 'Chiliquin', 101, 1),
(10106, 'Chuquibamba', 101, 1),
(10107, 'Granada', 101, 1),
(10108, 'Huancas', 101, 1),
(10109, 'La Jalca', 101, 1),
(10110, 'Leimebamba', 101, 1),
(10111, 'Levanto', 101, 1),
(10112, 'Magdalena', 101, 1),
(10113, 'Mariscal Castilla', 101, 1),
(10114, 'Molinopampa', 101, 1),
(10115, 'Montevideo', 101, 1),
(10116, 'Olleros', 101, 1),
(10117, 'Quinjalca', 101, 1),
(10118, 'San Francisco de Daguas', 101, 1),
(10119, 'San Isidro de Maino', 101, 1),
(10120, 'Soloco', 101, 1),
(10121, 'Sonche', 101, 1),
(10201, 'Bagua', 102, 1),
(10202, 'Aramango', 102, 1),
(10203, 'Copallin', 102, 1),
(10204, 'El Parco', 102, 1),
(10205, 'Imaza', 102, 1),
(10206, 'La Peca', 102, 1),
(10301, 'Jumbilla', 103, 1),
(10302, 'Chisquilla', 103, 1),
(10303, 'Churuja', 103, 1),
(10304, 'Corosha', 103, 1),
(10305, 'Cuispes', 103, 1),
(10306, 'Florida', 103, 1),
(10307, 'Jazan', 103, 1),
(10308, 'Recta', 103, 1),
(10309, 'San Carlos', 103, 1),
(10310, 'Shipasbamba', 103, 1),
(10311, 'Valera', 103, 1),
(10312, 'Yambrasbamba', 103, 1),
(10401, 'Nieva', 104, 1),
(10402, 'El Cenepa', 104, 1),
(10403, 'Río Santiago', 104, 1),
(10501, 'Lamud', 105, 1),
(10502, 'Camporredondo', 105, 1),
(10503, 'Cocabamba', 105, 1),
(10504, 'Colcamar', 105, 1),
(10505, 'Conila', 105, 1),
(10506, 'Inguilpata', 105, 1),
(10507, 'Longuita', 105, 1),
(10508, 'Lonya Chico', 105, 1),
(10509, 'Luya', 105, 1),
(10510, 'Luya Viejo', 105, 1),
(10511, 'María', 105, 1),
(10512, 'Ocalli', 105, 1),
(10513, 'Ocumal', 105, 1),
(10514, 'Pisuquia', 105, 1),
(10515, 'Providencia', 105, 1),
(10516, 'San Cristóbal', 105, 1),
(10517, 'San Francisco de Yeso', 105, 1),
(10518, 'San Jerónimo', 105, 1),
(10519, 'San Juan de Lopecancha', 105, 1),
(10520, 'Santa Catalina', 105, 1),
(10521, 'Santo Tomas', 105, 1),
(10522, 'Tingo', 105, 1),
(10523, 'Trita', 105, 1),
(10601, 'San Nicolás', 106, 1),
(10602, 'Chirimoto', 106, 1),
(10603, 'Cochamal', 106, 1),
(10604, 'Huambo', 106, 1),
(10605, 'Limabamba', 106, 1),
(10606, 'Longar', 106, 1),
(10607, 'Mariscal Benavides', 106, 1),
(10608, 'Milpuc', 106, 1),
(10609, 'Omia', 106, 1),
(10610, 'Santa Rosa', 106, 1),
(10611, 'Totora', 106, 1),
(10612, 'Vista Alegre', 106, 1),
(10701, 'Bagua Grande', 107, 1),
(10702, 'Cajaruro', 107, 1),
(10703, 'Cumba', 107, 1),
(10704, 'El Milagro', 107, 1),
(10705, 'Jamalca', 107, 1),
(10706, 'Lonya Grande', 107, 1),
(10707, 'Yamon', 107, 1),
(20101, 'Huaraz', 201, 2),
(20102, 'Cochabamba', 201, 2),
(20103, 'Colcabamba', 201, 2),
(20104, 'Huanchay', 201, 2),
(20105, 'Independencia', 201, 2),
(20106, 'Jangas', 201, 2),
(20107, 'La Libertad', 201, 2),
(20108, 'Olleros', 201, 2),
(20109, 'Pampas Grande', 201, 2),
(20110, 'Pariacoto', 201, 2),
(20111, 'Pira', 201, 2),
(20112, 'Tarica', 201, 2),
(20201, 'Aija', 202, 2),
(20202, 'Coris', 202, 2),
(20203, 'Huacllan', 202, 2),
(20204, 'La Merced', 202, 2),
(20205, 'Succha', 202, 2),
(20301, 'Llamellin', 203, 2),
(20302, 'Aczo', 203, 2),
(20303, 'Chaccho', 203, 2),
(20304, 'Chingas', 203, 2),
(20305, 'Mirgas', 203, 2),
(20306, 'San Juan de Rontoy', 203, 2),
(20401, 'Chacas', 204, 2),
(20402, 'Acochaca', 204, 2),
(20501, 'Chiquian', 205, 2),
(20502, 'Abelardo Pardo Lezameta', 205, 2),
(20503, 'Antonio Raymondi', 205, 2),
(20504, 'Aquia', 205, 2),
(20505, 'Cajacay', 205, 2),
(20506, 'Canis', 205, 2),
(20507, 'Colquioc', 205, 2),
(20508, 'Huallanca', 205, 2),
(20509, 'Huasta', 205, 2),
(20510, 'Huayllacayan', 205, 2),
(20511, 'La Primavera', 205, 2),
(20512, 'Mangas', 205, 2),
(20513, 'Pacllon', 205, 2),
(20514, 'San Miguel de Corpanqui', 205, 2),
(20515, 'Ticllos', 205, 2),
(20601, 'Carhuaz', 206, 2),
(20602, 'Acopampa', 206, 2),
(20603, 'Amashca', 206, 2),
(20604, 'Anta', 206, 2),
(20605, 'Ataquero', 206, 2),
(20606, 'Marcara', 206, 2),
(20607, 'Pariahuanca', 206, 2),
(20608, 'San Miguel de Aco', 206, 2),
(20609, 'Shilla', 206, 2),
(20610, 'Tinco', 206, 2),
(20611, 'Yungar', 206, 2),
(20701, 'San Luis', 207, 2),
(20702, 'San Nicolás', 207, 2),
(20703, 'Yauya', 207, 2),
(20801, 'Casma', 208, 2),
(20802, 'Buena Vista Alta', 208, 2),
(20803, 'Comandante Noel', 208, 2),
(20804, 'Yautan', 208, 2),
(20901, 'Corongo', 209, 2),
(20902, 'Aco', 209, 2),
(20903, 'Bambas', 209, 2),
(20904, 'Cusca', 209, 2),
(20905, 'La Pampa', 209, 2),
(20906, 'Yanac', 209, 2),
(20907, 'Yupan', 209, 2),
(21001, 'Huari', 210, 2),
(21002, 'Anra', 210, 2),
(21003, 'Cajay', 210, 2),
(21004, 'Chavin de Huantar', 210, 2),
(21005, 'Huacachi', 210, 2),
(21006, 'Huacchis', 210, 2),
(21007, 'Huachis', 210, 2),
(21008, 'Huantar', 210, 2),
(21009, 'Masin', 210, 2),
(21010, 'Paucas', 210, 2),
(21011, 'Ponto', 210, 2),
(21012, 'Rahuapampa', 210, 2),
(21013, 'Rapayan', 210, 2),
(21014, 'San Marcos', 210, 2),
(21015, 'San Pedro de Chana', 210, 2),
(21016, 'Uco', 210, 2),
(21101, 'Huarmey', 211, 2),
(21102, 'Cochapeti', 211, 2),
(21103, 'Culebras', 211, 2),
(21104, 'Huayan', 211, 2),
(21105, 'Malvas', 211, 2),
(21201, 'Caraz', 212, 2),
(21202, 'Huallanca', 212, 2),
(21203, 'Huata', 212, 2),
(21204, 'Huaylas', 212, 2),
(21205, 'Mato', 212, 2),
(21206, 'Pamparomas', 212, 2),
(21207, 'Pueblo Libre', 212, 2),
(21208, 'Santa Cruz', 212, 2),
(21209, 'Santo Toribio', 212, 2),
(21210, 'Yuracmarca', 212, 2),
(21301, 'Piscobamba', 213, 2),
(21302, 'Casca', 213, 2),
(21303, 'Eleazar Guzmán Barron', 213, 2),
(21304, 'Fidel Olivas Escudero', 213, 2),
(21305, 'Llama', 213, 2),
(21306, 'Llumpa', 213, 2),
(21307, 'Lucma', 213, 2),
(21308, 'Musga', 213, 2),
(21401, 'Ocros', 214, 2),
(21402, 'Acas', 214, 2),
(21403, 'Cajamarquilla', 214, 2),
(21404, 'Carhuapampa', 214, 2),
(21405, 'Cochas', 214, 2),
(21406, 'Congas', 214, 2),
(21407, 'Llipa', 214, 2),
(21408, 'San Cristóbal de Rajan', 214, 2),
(21409, 'San Pedro', 214, 2),
(21410, 'Santiago de Chilcas', 214, 2),
(21501, 'Cabana', 215, 2),
(21502, 'Bolognesi', 215, 2),
(21503, 'Conchucos', 215, 2),
(21504, 'Huacaschuque', 215, 2),
(21505, 'Huandoval', 215, 2),
(21506, 'Lacabamba', 215, 2),
(21507, 'Llapo', 215, 2),
(21508, 'Pallasca', 215, 2),
(21509, 'Pampas', 215, 2),
(21510, 'Santa Rosa', 215, 2),
(21511, 'Tauca', 215, 2),
(21601, 'Pomabamba', 216, 2),
(21602, 'Huayllan', 216, 2),
(21603, 'Parobamba', 216, 2),
(21604, 'Quinuabamba', 216, 2),
(21701, 'Recuay', 217, 2),
(21702, 'Catac', 217, 2),
(21703, 'Cotaparaco', 217, 2),
(21704, 'Huayllapampa', 217, 2),
(21705, 'Llacllin', 217, 2),
(21706, 'Marca', 217, 2),
(21707, 'Pampas Chico', 217, 2),
(21708, 'Pararin', 217, 2),
(21709, 'Tapacocha', 217, 2),
(21710, 'Ticapampa', 217, 2),
(21801, 'Chimbote', 218, 2),
(21802, 'Cáceres del Perú', 218, 2),
(21803, 'Coishco', 218, 2),
(21804, 'Macate', 218, 2),
(21805, 'Moro', 218, 2),
(21806, 'Nepeña', 218, 2),
(21807, 'Samanco', 218, 2),
(21808, 'Santa', 218, 2),
(21809, 'Nuevo Chimbote', 218, 2),
(21901, 'Sihuas', 219, 2),
(21902, 'Acobamba', 219, 2),
(21903, 'Alfonso Ugarte', 219, 2),
(21904, 'Cashapampa', 219, 2),
(21905, 'Chingalpo', 219, 2),
(21906, 'Huayllabamba', 219, 2),
(21907, 'Quiches', 219, 2),
(21908, 'Ragash', 219, 2),
(21909, 'San Juan', 219, 2),
(21910, 'Sicsibamba', 219, 2),
(22001, 'Yungay', 220, 2),
(22002, 'Cascapara', 220, 2),
(22003, 'Mancos', 220, 2),
(22004, 'Matacoto', 220, 2),
(22005, 'Quillo', 220, 2),
(22006, 'Ranrahirca', 220, 2),
(22007, 'Shupluy', 220, 2),
(22008, 'Yanama', 220, 2),
(30101, 'Abancay', 301, 3),
(30102, 'Chacoche', 301, 3),
(30103, 'Circa', 301, 3),
(30104, 'Curahuasi', 301, 3),
(30105, 'Huanipaca', 301, 3),
(30106, 'Lambrama', 301, 3),
(30107, 'Pichirhua', 301, 3),
(30108, 'San Pedro de Cachora', 301, 3),
(30109, 'Tamburco', 301, 3),
(30201, 'Andahuaylas', 302, 3),
(30202, 'Andarapa', 302, 3),
(30203, 'Chiara', 302, 3),
(30204, 'Huancarama', 302, 3),
(30205, 'Huancaray', 302, 3),
(30206, 'Huayana', 302, 3),
(30207, 'Kishuara', 302, 3),
(30208, 'Pacobamba', 302, 3),
(30209, 'Pacucha', 302, 3),
(30210, 'Pampachiri', 302, 3),
(30211, 'Pomacocha', 302, 3),
(30212, 'San Antonio de Cachi', 302, 3),
(30213, 'San Jerónimo', 302, 3),
(30214, 'San Miguel de Chaccrampa', 302, 3),
(30215, 'Santa María de Chicmo', 302, 3),
(30216, 'Talavera', 302, 3),
(30217, 'Tumay Huaraca', 302, 3),
(30218, 'Turpo', 302, 3),
(30219, 'Kaquiabamba', 302, 3),
(30220, 'José María Arguedas', 302, 3),
(30301, 'Antabamba', 303, 3),
(30302, 'El Oro', 303, 3),
(30303, 'Huaquirca', 303, 3),
(30304, 'Juan Espinoza Medrano', 303, 3),
(30305, 'Oropesa', 303, 3),
(30306, 'Pachaconas', 303, 3),
(30307, 'Sabaino', 303, 3),
(30401, 'Chalhuanca', 304, 3),
(30402, 'Capaya', 304, 3),
(30403, 'Caraybamba', 304, 3),
(30404, 'Chapimarca', 304, 3),
(30405, 'Colcabamba', 304, 3),
(30406, 'Cotaruse', 304, 3),
(30407, 'Ihuayllo', 304, 3),
(30408, 'Justo Apu Sahuaraura', 304, 3),
(30409, 'Lucre', 304, 3),
(30410, 'Pocohuanca', 304, 3),
(30411, 'San Juan de Chacña', 304, 3),
(30412, 'Sañayca', 304, 3),
(30413, 'Soraya', 304, 3),
(30414, 'Tapairihua', 304, 3),
(30415, 'Tintay', 304, 3),
(30416, 'Toraya', 304, 3),
(30417, 'Yanaca', 304, 3),
(30501, 'Tambobamba', 305, 3),
(30502, 'Cotabambas', 305, 3),
(30503, 'Coyllurqui', 305, 3),
(30504, 'Haquira', 305, 3),
(30505, 'Mara', 305, 3),
(30506, 'Challhuahuacho', 305, 3),
(30601, 'Chincheros', 306, 3),
(30602, 'Anco_Huallo', 306, 3),
(30603, 'Cocharcas', 306, 3),
(30604, 'Huaccana', 306, 3),
(30605, 'Ocobamba', 306, 3),
(30606, 'Ongoy', 306, 3),
(30607, 'Uranmarca', 306, 3),
(30608, 'Ranracancha', 306, 3),
(30609, 'Rocchacc', 306, 3),
(30610, 'El Porvenir', 306, 3),
(30611, 'Los Chankas', 306, 3),
(30701, 'Chuquibambilla', 307, 3),
(30702, 'Curpahuasi', 307, 3),
(30703, 'Gamarra', 307, 3),
(30704, 'Huayllati', 307, 3),
(30705, 'Mamara', 307, 3),
(30706, 'Micaela Bastidas', 307, 3),
(30707, 'Pataypampa', 307, 3),
(30708, 'Progreso', 307, 3),
(30709, 'San Antonio', 307, 3),
(30710, 'Santa Rosa', 307, 3),
(30711, 'Turpay', 307, 3),
(30712, 'Vilcabamba', 307, 3),
(30713, 'Virundo', 307, 3),
(30714, 'Curasco', 307, 3),
(40101, 'Arequipa', 401, 4),
(40102, 'Alto Selva Alegre', 401, 4),
(40103, 'Cayma', 401, 4),
(40104, 'Cerro Colorado', 401, 4),
(40105, 'Characato', 401, 4),
(40106, 'Chiguata', 401, 4),
(40107, 'Jacobo Hunter', 401, 4),
(40108, 'La Joya', 401, 4),
(40109, 'Mariano Melgar', 401, 4),
(40110, 'Miraflores', 401, 4),
(40111, 'Mollebaya', 401, 4),
(40112, 'Paucarpata', 401, 4),
(40113, 'Pocsi', 401, 4),
(40114, 'Polobaya', 401, 4),
(40115, 'Quequeña', 401, 4),
(40116, 'Sabandia', 401, 4),
(40117, 'Sachaca', 401, 4),
(40118, 'San Juan de Siguas', 401, 4),
(40119, 'San Juan de Tarucani', 401, 4),
(40120, 'Santa Isabel de Siguas', 401, 4),
(40121, 'Santa Rita de Siguas', 401, 4),
(40122, 'Socabaya', 401, 4),
(40123, 'Tiabaya', 401, 4),
(40124, 'Uchumayo', 401, 4),
(40125, 'Vitor', 401, 4),
(40126, 'Yanahuara', 401, 4),
(40127, 'Yarabamba', 401, 4),
(40128, 'Yura', 401, 4),
(40129, 'José Luis Bustamante Y Rivero', 401, 4),
(40201, 'Camaná', 402, 4),
(40202, 'José María Quimper', 402, 4),
(40203, 'Mariano Nicolás Valcárcel', 402, 4),
(40204, 'Mariscal Cáceres', 402, 4),
(40205, 'Nicolás de Pierola', 402, 4),
(40206, 'Ocoña', 402, 4),
(40207, 'Quilca', 402, 4),
(40208, 'Samuel Pastor', 402, 4),
(40301, 'Caravelí', 403, 4),
(40302, 'Acarí', 403, 4),
(40303, 'Atico', 403, 4),
(40304, 'Atiquipa', 403, 4),
(40305, 'Bella Unión', 403, 4),
(40306, 'Cahuacho', 403, 4),
(40307, 'Chala', 403, 4),
(40308, 'Chaparra', 403, 4),
(40309, 'Huanuhuanu', 403, 4),
(40310, 'Jaqui', 403, 4),
(40311, 'Lomas', 403, 4),
(40312, 'Quicacha', 403, 4),
(40313, 'Yauca', 403, 4),
(40401, 'Aplao', 404, 4),
(40402, 'Andagua', 404, 4),
(40403, 'Ayo', 404, 4),
(40404, 'Chachas', 404, 4),
(40405, 'Chilcaymarca', 404, 4),
(40406, 'Choco', 404, 4),
(40407, 'Huancarqui', 404, 4),
(40408, 'Machaguay', 404, 4),
(40409, 'Orcopampa', 404, 4),
(40410, 'Pampacolca', 404, 4),
(40411, 'Tipan', 404, 4),
(40412, 'Uñon', 404, 4),
(40413, 'Uraca', 404, 4),
(40414, 'Viraco', 404, 4),
(40501, 'Chivay', 405, 4),
(40502, 'Achoma', 405, 4),
(40503, 'Cabanaconde', 405, 4),
(40504, 'Callalli', 405, 4),
(40505, 'Caylloma', 405, 4),
(40506, 'Coporaque', 405, 4),
(40507, 'Huambo', 405, 4),
(40508, 'Huanca', 405, 4),
(40509, 'Ichupampa', 405, 4),
(40510, 'Lari', 405, 4),
(40511, 'Lluta', 405, 4),
(40512, 'Maca', 405, 4),
(40513, 'Madrigal', 405, 4),
(40514, 'San Antonio de Chuca', 405, 4),
(40515, 'Sibayo', 405, 4),
(40516, 'Tapay', 405, 4),
(40517, 'Tisco', 405, 4),
(40518, 'Tuti', 405, 4),
(40519, 'Yanque', 405, 4),
(40520, 'Majes', 405, 4),
(40601, 'Chuquibamba', 406, 4),
(40602, 'Andaray', 406, 4),
(40603, 'Cayarani', 406, 4),
(40604, 'Chichas', 406, 4),
(40605, 'Iray', 406, 4),
(40606, 'Río Grande', 406, 4),
(40607, 'Salamanca', 406, 4),
(40608, 'Yanaquihua', 406, 4),
(40701, 'Mollendo', 407, 4),
(40702, 'Cocachacra', 407, 4),
(40703, 'Dean Valdivia', 407, 4),
(40704, 'Islay', 407, 4),
(40705, 'Mejia', 407, 4),
(40706, 'Punta de Bombón', 407, 4),
(40801, 'Cotahuasi', 408, 4),
(40802, 'Alca', 408, 4),
(40803, 'Charcana', 408, 4),
(40804, 'Huaynacotas', 408, 4),
(40805, 'Pampamarca', 408, 4),
(40806, 'Puyca', 408, 4),
(40807, 'Quechualla', 408, 4),
(40808, 'Sayla', 408, 4),
(40809, 'Tauria', 408, 4),
(40810, 'Tomepampa', 408, 4),
(40811, 'Toro', 408, 4),
(50101, 'Ayacucho', 501, 5),
(50102, 'Acocro', 501, 5),
(50103, 'Acos Vinchos', 501, 5),
(50104, 'Carmen Alto', 501, 5),
(50105, 'Chiara', 501, 5),
(50106, 'Ocros', 501, 5),
(50107, 'Pacaycasa', 501, 5),
(50108, 'Quinua', 501, 5),
(50109, 'San José de Ticllas', 501, 5),
(50110, 'San Juan Bautista', 501, 5),
(50111, 'Santiago de Pischa', 501, 5),
(50112, 'Socos', 501, 5),
(50113, 'Tambillo', 501, 5),
(50114, 'Vinchos', 501, 5),
(50115, 'Jesús Nazareno', 501, 5),
(50116, 'Andrés Avelino Cáceres Dorregaray', 501, 5),
(50201, 'Cangallo', 502, 5),
(50202, 'Chuschi', 502, 5),
(50203, 'Los Morochucos', 502, 5),
(50204, 'María Parado de Bellido', 502, 5),
(50205, 'Paras', 502, 5),
(50206, 'Totos', 502, 5),
(50301, 'Sancos', 503, 5),
(50302, 'Carapo', 503, 5),
(50303, 'Sacsamarca', 503, 5),
(50304, 'Santiago de Lucanamarca', 503, 5),
(50401, 'Huanta', 504, 5),
(50402, 'Ayahuanco', 504, 5),
(50403, 'Huamanguilla', 504, 5),
(50404, 'Iguain', 504, 5),
(50405, 'Luricocha', 504, 5),
(50406, 'Santillana', 504, 5),
(50407, 'Sivia', 504, 5),
(50408, 'Llochegua', 504, 5),
(50409, 'Canayre', 504, 5),
(50410, 'Uchuraccay', 504, 5),
(50411, 'Pucacolpa', 504, 5),
(50412, 'Chaca', 504, 5),
(50501, 'San Miguel', 505, 5),
(50502, 'Anco', 505, 5),
(50503, 'Ayna', 505, 5),
(50504, 'Chilcas', 505, 5),
(50505, 'Chungui', 505, 5),
(50506, 'Luis Carranza', 505, 5),
(50507, 'Santa Rosa', 505, 5),
(50508, 'Tambo', 505, 5),
(50509, 'Samugari', 505, 5),
(50510, 'Anchihuay', 505, 5),
(50511, 'Oronccoy', 505, 5),
(50601, 'Puquio', 506, 5),
(50602, 'Aucara', 506, 5),
(50603, 'Cabana', 506, 5),
(50604, 'Carmen Salcedo', 506, 5),
(50605, 'Chaviña', 506, 5),
(50606, 'Chipao', 506, 5),
(50607, 'Huac-Huas', 506, 5),
(50608, 'Laramate', 506, 5),
(50609, 'Leoncio Prado', 506, 5),
(50610, 'Llauta', 506, 5),
(50611, 'Lucanas', 506, 5),
(50612, 'Ocaña', 506, 5),
(50613, 'Otoca', 506, 5),
(50614, 'Saisa', 506, 5),
(50615, 'San Cristóbal', 506, 5),
(50616, 'San Juan', 506, 5),
(50617, 'San Pedro', 506, 5),
(50618, 'San Pedro de Palco', 506, 5),
(50619, 'Sancos', 506, 5),
(50620, 'Santa Ana de Huaycahuacho', 506, 5),
(50621, 'Santa Lucia', 506, 5),
(50701, 'Coracora', 507, 5),
(50702, 'Chumpi', 507, 5),
(50703, 'Coronel Castañeda', 507, 5),
(50704, 'Pacapausa', 507, 5),
(50705, 'Pullo', 507, 5),
(50706, 'Puyusca', 507, 5),
(50707, 'San Francisco de Ravacayco', 507, 5),
(50708, 'Upahuacho', 507, 5),
(50801, 'Pausa', 508, 5),
(50802, 'Colta', 508, 5),
(50803, 'Corculla', 508, 5),
(50804, 'Lampa', 508, 5),
(50805, 'Marcabamba', 508, 5),
(50806, 'Oyolo', 508, 5),
(50807, 'Pararca', 508, 5),
(50808, 'San Javier de Alpabamba', 508, 5),
(50809, 'San José de Ushua', 508, 5),
(50810, 'Sara Sara', 508, 5),
(50901, 'Querobamba', 509, 5),
(50902, 'Belén', 509, 5),
(50903, 'Chalcos', 509, 5),
(50904, 'Chilcayoc', 509, 5),
(50905, 'Huacaña', 509, 5),
(50906, 'Morcolla', 509, 5),
(50907, 'Paico', 509, 5),
(50908, 'San Pedro de Larcay', 509, 5),
(50909, 'San Salvador de Quije', 509, 5),
(50910, 'Santiago de Paucaray', 509, 5),
(50911, 'Soras', 509, 5),
(51001, 'Huancapi', 510, 5),
(51002, 'Alcamenca', 510, 5),
(51003, 'Apongo', 510, 5),
(51004, 'Asquipata', 510, 5),
(51005, 'Canaria', 510, 5),
(51006, 'Cayara', 510, 5),
(51007, 'Colca', 510, 5),
(51008, 'Huamanquiquia', 510, 5),
(51009, 'Huancaraylla', 510, 5),
(51010, 'Hualla', 510, 5),
(51011, 'Sarhua', 510, 5),
(51012, 'Vilcanchos', 510, 5),
(51101, 'Vilcas Huaman', 511, 5),
(51102, 'Accomarca', 511, 5),
(51103, 'Carhuanca', 511, 5),
(51104, 'Concepción', 511, 5),
(51105, 'Huambalpa', 511, 5),
(51106, 'Independencia', 511, 5),
(51107, 'Saurama', 511, 5),
(51108, 'Vischongo', 511, 5),
(60101, 'Cajamarca', 601, 6),
(60102, 'Asunción', 601, 6),
(60103, 'Chetilla', 601, 6),
(60104, 'Cospan', 601, 6),
(60105, 'Encañada', 601, 6),
(60106, 'Jesús', 601, 6),
(60107, 'Llacanora', 601, 6),
(60108, 'Los Baños del Inca', 601, 6),
(60109, 'Magdalena', 601, 6),
(60110, 'Matara', 601, 6),
(60111, 'Namora', 601, 6),
(60112, 'San Juan', 601, 6),
(60201, 'Cajabamba', 602, 6),
(60202, 'Cachachi', 602, 6),
(60203, 'Condebamba', 602, 6),
(60204, 'Sitacocha', 602, 6),
(60301, 'Celendín', 603, 6),
(60302, 'Chumuch', 603, 6),
(60303, 'Cortegana', 603, 6),
(60304, 'Huasmin', 603, 6),
(60305, 'Jorge Chávez', 603, 6),
(60306, 'José Gálvez', 603, 6),
(60307, 'Miguel Iglesias', 603, 6),
(60308, 'Oxamarca', 603, 6),
(60309, 'Sorochuco', 603, 6),
(60310, 'Sucre', 603, 6),
(60311, 'Utco', 603, 6),
(60312, 'La Libertad de Pallan', 603, 6),
(60401, 'Chota', 604, 6),
(60402, 'Anguia', 604, 6),
(60403, 'Chadin', 604, 6),
(60404, 'Chiguirip', 604, 6),
(60405, 'Chimban', 604, 6),
(60406, 'Choropampa', 604, 6),
(60407, 'Cochabamba', 604, 6),
(60408, 'Conchan', 604, 6),
(60409, 'Huambos', 604, 6),
(60410, 'Lajas', 604, 6),
(60411, 'Llama', 604, 6),
(60412, 'Miracosta', 604, 6),
(60413, 'Paccha', 604, 6),
(60414, 'Pion', 604, 6),
(60415, 'Querocoto', 604, 6),
(60416, 'San Juan de Licupis', 604, 6),
(60417, 'Tacabamba', 604, 6),
(60418, 'Tocmoche', 604, 6),
(60419, 'Chalamarca', 604, 6),
(60501, 'Contumaza', 605, 6),
(60502, 'Chilete', 605, 6),
(60503, 'Cupisnique', 605, 6),
(60504, 'Guzmango', 605, 6),
(60505, 'San Benito', 605, 6),
(60506, 'Santa Cruz de Toledo', 605, 6),
(60507, 'Tantarica', 605, 6),
(60508, 'Yonan', 605, 6),
(60601, 'Cutervo', 606, 6),
(60602, 'Callayuc', 606, 6),
(60603, 'Choros', 606, 6),
(60604, 'Cujillo', 606, 6),
(60605, 'La Ramada', 606, 6),
(60606, 'Pimpingos', 606, 6),
(60607, 'Querocotillo', 606, 6),
(60608, 'San Andrés de Cutervo', 606, 6),
(60609, 'San Juan de Cutervo', 606, 6),
(60610, 'San Luis de Lucma', 606, 6),
(60611, 'Santa Cruz', 606, 6),
(60612, 'Santo Domingo de la Capilla', 606, 6),
(60613, 'Santo Tomas', 606, 6),
(60614, 'Socota', 606, 6),
(60615, 'Toribio Casanova', 606, 6),
(60701, 'Bambamarca', 607, 6),
(60702, 'Chugur', 607, 6),
(60703, 'Hualgayoc', 607, 6),
(60801, 'Jaén', 608, 6),
(60802, 'Bellavista', 608, 6),
(60803, 'Chontali', 608, 6),
(60804, 'Colasay', 608, 6),
(60805, 'Huabal', 608, 6),
(60806, 'Las Pirias', 608, 6),
(60807, 'Pomahuaca', 608, 6),
(60808, 'Pucara', 608, 6),
(60809, 'Sallique', 608, 6),
(60810, 'San Felipe', 608, 6),
(60811, 'San José del Alto', 608, 6),
(60812, 'Santa Rosa', 608, 6),
(60901, 'San Ignacio', 609, 6),
(60902, 'Chirinos', 609, 6),
(60903, 'Huarango', 609, 6),
(60904, 'La Coipa', 609, 6),
(60905, 'Namballe', 609, 6),
(60906, 'San José de Lourdes', 609, 6),
(60907, 'Tabaconas', 609, 6),
(61001, 'Pedro Gálvez', 610, 6),
(61002, 'Chancay', 610, 6),
(61003, 'Eduardo Villanueva', 610, 6),
(61004, 'Gregorio Pita', 610, 6),
(61005, 'Ichocan', 610, 6),
(61006, 'José Manuel Quiroz', 610, 6),
(61007, 'José Sabogal', 610, 6),
(61101, 'San Miguel', 611, 6),
(61102, 'Bolívar', 611, 6),
(61103, 'Calquis', 611, 6),
(61104, 'Catilluc', 611, 6),
(61105, 'El Prado', 611, 6),
(61106, 'La Florida', 611, 6),
(61107, 'Llapa', 611, 6),
(61108, 'Nanchoc', 611, 6),
(61109, 'Niepos', 611, 6),
(61110, 'San Gregorio', 611, 6),
(61111, 'San Silvestre de Cochan', 611, 6),
(61112, 'Tongod', 611, 6),
(61113, 'Unión Agua Blanca', 611, 6),
(61201, 'San Pablo', 612, 6),
(61202, 'San Bernardino', 612, 6),
(61203, 'San Luis', 612, 6),
(61204, 'Tumbaden', 612, 6),
(61301, 'Santa Cruz', 613, 6),
(61302, 'Andabamba', 613, 6),
(61303, 'Catache', 613, 6),
(61304, 'Chancaybaños', 613, 6),
(61305, 'La Esperanza', 613, 6),
(61306, 'Ninabamba', 613, 6),
(61307, 'Pulan', 613, 6),
(61308, 'Saucepampa', 613, 6),
(61309, 'Sexi', 613, 6),
(61310, 'Uticyacu', 613, 6),
(61311, 'Yauyucan', 613, 6),
(70101, 'Callao', 701, 7),
(70102, 'Bellavista', 701, 7),
(70103, 'Carmen de la Legua Reynoso', 701, 7),
(70104, 'La Perla', 701, 7),
(70105, 'La Punta', 701, 7),
(70106, 'Ventanilla', 701, 7),
(70107, 'Mi Perú', 701, 7),
(80101, 'Cusco', 801, 8),
(80102, 'Ccorca', 801, 8),
(80103, 'Poroy', 801, 8),
(80104, 'San Jerónimo', 801, 8),
(80105, 'San Sebastian', 801, 8),
(80106, 'Santiago', 801, 8),
(80107, 'Saylla', 801, 8),
(80108, 'Wanchaq', 801, 8),
(80201, 'Acomayo', 802, 8),
(80202, 'Acopia', 802, 8),
(80203, 'Acos', 802, 8),
(80204, 'Mosoc Llacta', 802, 8),
(80205, 'Pomacanchi', 802, 8),
(80206, 'Rondocan', 802, 8),
(80207, 'Sangarara', 802, 8),
(80301, 'Anta', 803, 8),
(80302, 'Ancahuasi', 803, 8),
(80303, 'Cachimayo', 803, 8),
(80304, 'Chinchaypujio', 803, 8),
(80305, 'Huarocondo', 803, 8),
(80306, 'Limatambo', 803, 8),
(80307, 'Mollepata', 803, 8),
(80308, 'Pucyura', 803, 8),
(80309, 'Zurite', 803, 8),
(80401, 'Calca', 804, 8),
(80402, 'Coya', 804, 8),
(80403, 'Lamay', 804, 8),
(80404, 'Lares', 804, 8),
(80405, 'Pisac', 804, 8),
(80406, 'San Salvador', 804, 8),
(80407, 'Taray', 804, 8),
(80408, 'Yanatile', 804, 8),
(80501, 'Yanaoca', 805, 8),
(80502, 'Checca', 805, 8),
(80503, 'Kunturkanki', 805, 8),
(80504, 'Langui', 805, 8),
(80505, 'Layo', 805, 8),
(80506, 'Pampamarca', 805, 8),
(80507, 'Quehue', 805, 8),
(80508, 'Tupac Amaru', 805, 8),
(80601, 'Sicuani', 806, 8),
(80602, 'Checacupe', 806, 8),
(80603, 'Combapata', 806, 8),
(80604, 'Marangani', 806, 8),
(80605, 'Pitumarca', 806, 8),
(80606, 'San Pablo', 806, 8),
(80607, 'San Pedro', 806, 8),
(80608, 'Tinta', 806, 8),
(80701, 'Santo Tomas', 807, 8),
(80702, 'Capacmarca', 807, 8),
(80703, 'Chamaca', 807, 8),
(80704, 'Colquemarca', 807, 8),
(80705, 'Livitaca', 807, 8),
(80706, 'Llusco', 807, 8),
(80707, 'Quiñota', 807, 8),
(80708, 'Velille', 807, 8),
(80801, 'Espinar', 808, 8),
(80802, 'Condoroma', 808, 8),
(80803, 'Coporaque', 808, 8),
(80804, 'Ocoruro', 808, 8),
(80805, 'Pallpata', 808, 8),
(80806, 'Pichigua', 808, 8),
(80807, 'Suyckutambo', 808, 8),
(80808, 'Alto Pichigua', 808, 8),
(80901, 'Santa Ana', 809, 8),
(80902, 'Echarate', 809, 8),
(80903, 'Huayopata', 809, 8),
(80904, 'Maranura', 809, 8),
(80905, 'Ocobamba', 809, 8),
(80906, 'Quellouno', 809, 8),
(80907, 'Kimbiri', 809, 8),
(80908, 'Santa Teresa', 809, 8),
(80909, 'Vilcabamba', 809, 8),
(80910, 'Pichari', 809, 8),
(80911, 'Inkawasi', 809, 8),
(80912, 'Villa Virgen', 809, 8),
(80913, 'Villa Kintiarina', 809, 8),
(80914, 'Megantoni', 809, 8),
(81001, 'Paruro', 810, 8),
(81002, 'Accha', 810, 8),
(81003, 'Ccapi', 810, 8),
(81004, 'Colcha', 810, 8),
(81005, 'Huanoquite', 810, 8),
(81006, 'Omachaç', 810, 8),
(81007, 'Paccaritambo', 810, 8),
(81008, 'Pillpinto', 810, 8),
(81009, 'Yaurisque', 810, 8),
(81101, 'Paucartambo', 811, 8),
(81102, 'Caicay', 811, 8),
(81103, 'Challabamba', 811, 8),
(81104, 'Colquepata', 811, 8),
(81105, 'Huancarani', 811, 8),
(81106, 'Kosñipata', 811, 8),
(81201, 'Urcos', 812, 8),
(81202, 'Andahuaylillas', 812, 8),
(81203, 'Camanti', 812, 8),
(81204, 'Ccarhuayo', 812, 8),
(81205, 'Ccatca', 812, 8),
(81206, 'Cusipata', 812, 8),
(81207, 'Huaro', 812, 8),
(81208, 'Lucre', 812, 8),
(81209, 'Marcapata', 812, 8),
(81210, 'Ocongate', 812, 8),
(81211, 'Oropesa', 812, 8),
(81212, 'Quiquijana', 812, 8),
(81301, 'Urubamba', 813, 8),
(81302, 'Chinchero', 813, 8),
(81303, 'Huayllabamba', 813, 8),
(81304, 'Machupicchu', 813, 8),
(81305, 'Maras', 813, 8),
(81306, 'Ollantaytambo', 813, 8),
(81307, 'Yucay', 813, 8),
(90101, 'Huancavelica', 901, 9),
(90102, 'Acobambilla', 901, 9),
(90103, 'Acoria', 901, 9),
(90104, 'Conayca', 901, 9),
(90105, 'Cuenca', 901, 9),
(90106, 'Huachocolpa', 901, 9),
(90107, 'Huayllahuara', 901, 9),
(90108, 'Izcuchaca', 901, 9),
(90109, 'Laria', 901, 9),
(90110, 'Manta', 901, 9),
(90111, 'Mariscal Cáceres', 901, 9),
(90112, 'Moya', 901, 9),
(90113, 'Nuevo Occoro', 901, 9),
(90114, 'Palca', 901, 9),
(90115, 'Pilchaca', 901, 9),
(90116, 'Vilca', 901, 9),
(90117, 'Yauli', 901, 9),
(90118, 'Ascensión', 901, 9),
(90119, 'Huando', 901, 9),
(90201, 'Acobamba', 902, 9),
(90202, 'Andabamba', 902, 9),
(90203, 'Anta', 902, 9),
(90204, 'Caja', 902, 9),
(90205, 'Marcas', 902, 9),
(90206, 'Paucara', 902, 9),
(90207, 'Pomacocha', 902, 9),
(90208, 'Rosario', 902, 9),
(90301, 'Lircay', 903, 9),
(90302, 'Anchonga', 903, 9),
(90303, 'Callanmarca', 903, 9),
(90304, 'Ccochaccasa', 903, 9),
(90305, 'Chincho', 903, 9),
(90306, 'Congalla', 903, 9),
(90307, 'Huanca-Huanca', 903, 9),
(90308, 'Huayllay Grande', 903, 9),
(90309, 'Julcamarca', 903, 9),
(90310, 'San Antonio de Antaparco', 903, 9),
(90311, 'Santo Tomas de Pata', 903, 9),
(90312, 'Secclla', 903, 9),
(90401, 'Castrovirreyna', 904, 9),
(90402, 'Arma', 904, 9),
(90403, 'Aurahua', 904, 9),
(90404, 'Capillas', 904, 9),
(90405, 'Chupamarca', 904, 9),
(90406, 'Cocas', 904, 9),
(90407, 'Huachos', 904, 9),
(90408, 'Huamatambo', 904, 9),
(90409, 'Mollepampa', 904, 9),
(90410, 'San Juan', 904, 9),
(90411, 'Santa Ana', 904, 9),
(90412, 'Tantara', 904, 9),
(90413, 'Ticrapo', 904, 9),
(90501, 'Churcampa', 905, 9),
(90502, 'Anco', 905, 9),
(90503, 'Chinchihuasi', 905, 9),
(90504, 'El Carmen', 905, 9),
(90505, 'La Merced', 905, 9),
(90506, 'Locroja', 905, 9),
(90507, 'Paucarbamba', 905, 9),
(90508, 'San Miguel de Mayocc', 905, 9),
(90509, 'San Pedro de Coris', 905, 9),
(90510, 'Pachamarca', 905, 9),
(90511, 'Cosme', 905, 9),
(90601, 'Huaytara', 906, 9),
(90602, 'Ayavi', 906, 9),
(90603, 'Córdova', 906, 9),
(90604, 'Huayacundo Arma', 906, 9),
(90605, 'Laramarca', 906, 9),
(90606, 'Ocoyo', 906, 9),
(90607, 'Pilpichaca', 906, 9),
(90608, 'Querco', 906, 9),
(90609, 'Quito-Arma', 906, 9),
(90610, 'San Antonio de Cusicancha', 906, 9),
(90611, 'San Francisco de Sangayaico', 906, 9),
(90612, 'San Isidro', 906, 9),
(90613, 'Santiago de Chocorvos', 906, 9),
(90614, 'Santiago de Quirahuara', 906, 9),
(90615, 'Santo Domingo de Capillas', 906, 9),
(90616, 'Tambo', 906, 9),
(90701, 'Pampas', 907, 9),
(90702, 'Acostambo', 907, 9),
(90703, 'Acraquia', 907, 9),
(90704, 'Ahuaycha', 907, 9),
(90705, 'Colcabamba', 907, 9),
(90706, 'Daniel Hernández', 907, 9),
(90707, 'Huachocolpa', 907, 9),
(90709, 'Huaribamba', 907, 9),
(90710, 'Ñahuimpuquio', 907, 9),
(90711, 'Pazos', 907, 9),
(90713, 'Quishuar', 907, 9),
(90714, 'Salcabamba', 907, 9),
(90715, 'Salcahuasi', 907, 9),
(90716, 'San Marcos de Rocchac', 907, 9),
(90717, 'Surcubamba', 907, 9),
(90718, 'Tintay Puncu', 907, 9),
(90719, 'Quichuas', 907, 9),
(90720, 'Andaymarca', 907, 9),
(90721, 'Roble', 907, 9),
(90722, 'Pichos', 907, 9),
(90723, 'Santiago de Tucuma', 907, 9),
(100101, 'Huanuco', 1001, 10),
(100102, 'Amarilis', 1001, 10),
(100103, 'Chinchao', 1001, 10),
(100104, 'Churubamba', 1001, 10),
(100105, 'Margos', 1001, 10),
(100106, 'Quisqui (Kichki)', 1001, 10),
(100107, 'San Francisco de Cayran', 1001, 10),
(100108, 'San Pedro de Chaulan', 1001, 10),
(100109, 'Santa María del Valle', 1001, 10),
(100110, 'Yarumayo', 1001, 10),
(100111, 'Pillco Marca', 1001, 10),
(100112, 'Yacus', 1001, 10),
(100113, 'San Pablo de Pillao', 1001, 10),
(100201, 'Ambo', 1002, 10),
(100202, 'Cayna', 1002, 10),
(100203, 'Colpas', 1002, 10),
(100204, 'Conchamarca', 1002, 10),
(100205, 'Huacar', 1002, 10),
(100206, 'San Francisco', 1002, 10),
(100207, 'San Rafael', 1002, 10),
(100208, 'Tomay Kichwa', 1002, 10),
(100301, 'La Unión', 1003, 10),
(100307, 'Chuquis', 1003, 10),
(100311, 'Marías', 1003, 10),
(100313, 'Pachas', 1003, 10),
(100316, 'Quivilla', 1003, 10),
(100317, 'Ripan', 1003, 10),
(100321, 'Shunqui', 1003, 10),
(100322, 'Sillapata', 1003, 10),
(100323, 'Yanas', 1003, 10),
(100401, 'Huacaybamba', 1004, 10),
(100402, 'Canchabamba', 1004, 10),
(100403, 'Cochabamba', 1004, 10),
(100404, 'Pinra', 1004, 10),
(100501, 'Llata', 1005, 10),
(100502, 'Arancay', 1005, 10),
(100503, 'Chavín de Pariarca', 1005, 10),
(100504, 'Jacas Grande', 1005, 10),
(100505, 'Jircan', 1005, 10),
(100506, 'Miraflores', 1005, 10),
(100507, 'Monzón', 1005, 10),
(100508, 'Punchao', 1005, 10),
(100509, 'Puños', 1005, 10),
(100510, 'Singa', 1005, 10),
(100511, 'Tantamayo', 1005, 10),
(100601, 'Rupa-Rupa', 1006, 10),
(100602, 'Daniel Alomía Robles', 1006, 10),
(100603, 'Hermílio Valdizan', 1006, 10),
(100604, 'José Crespo y Castillo', 1006, 10),
(100605, 'Luyando', 1006, 10),
(100606, 'Mariano Damaso Beraun', 1006, 10),
(100607, 'Pucayacu', 1006, 10),
(100608, 'Castillo Grande', 1006, 10),
(100609, 'Pueblo Nuevo', 1006, 10),
(100610, 'Santo Domingo de Anda', 1006, 10),
(100701, 'Huacrachuco', 1007, 10),
(100702, 'Cholon', 1007, 10),
(100703, 'San Buenaventura', 1007, 10),
(100704, 'La Morada', 1007, 10),
(100705, 'Santa Rosa de Alto Yanajanca', 1007, 10),
(100801, 'Panao', 1008, 10),
(100802, 'Chaglla', 1008, 10),
(100803, 'Molino', 1008, 10),
(100804, 'Umari', 1008, 10),
(100901, 'Puerto Inca', 1009, 10),
(100902, 'Codo del Pozuzo', 1009, 10),
(100903, 'Honoria', 1009, 10),
(100904, 'Tournavista', 1009, 10),
(100905, 'Yuyapichis', 1009, 10),
(101001, 'Jesús', 1010, 10),
(101002, 'Baños', 1010, 10),
(101003, 'Jivia', 1010, 10),
(101004, 'Queropalca', 1010, 10),
(101005, 'Rondos', 1010, 10),
(101006, 'San Francisco de Asís', 1010, 10),
(101007, 'San Miguel de Cauri', 1010, 10),
(101101, 'Chavinillo', 1011, 10),
(101102, 'Cahuac', 1011, 10),
(101103, 'Chacabamba', 1011, 10),
(101104, 'Aparicio Pomares', 1011, 10),
(101105, 'Jacas Chico', 1011, 10),
(101106, 'Obas', 1011, 10),
(101107, 'Pampamarca', 1011, 10),
(101108, 'Choras', 1011, 10),
(110101, 'Ica', 1101, 11),
(110102, 'La Tinguiña', 1101, 11),
(110103, 'Los Aquijes', 1101, 11),
(110104, 'Ocucaje', 1101, 11),
(110105, 'Pachacutec', 1101, 11),
(110106, 'Parcona', 1101, 11),
(110107, 'Pueblo Nuevo', 1101, 11),
(110108, 'Salas', 1101, 11),
(110109, 'San José de Los Molinos', 1101, 11),
(110110, 'San Juan Bautista', 1101, 11),
(110111, 'Santiago', 1101, 11),
(110112, 'Subtanjalla', 1101, 11),
(110113, 'Tate', 1101, 11),
(110114, 'Yauca del Rosario', 1101, 11),
(110201, 'Chincha Alta', 1102, 11),
(110202, 'Alto Laran', 1102, 11),
(110203, 'Chavin', 1102, 11),
(110204, 'Chincha Baja', 1102, 11),
(110205, 'El Carmen', 1102, 11),
(110206, 'Grocio Prado', 1102, 11),
(110207, 'Pueblo Nuevo', 1102, 11),
(110208, 'San Juan de Yanac', 1102, 11),
(110209, 'San Pedro de Huacarpana', 1102, 11),
(110210, 'Sunampe', 1102, 11),
(110211, 'Tambo de Mora', 1102, 11),
(110301, 'Nasca', 1103, 11),
(110302, 'Changuillo', 1103, 11),
(110303, 'El Ingenio', 1103, 11),
(110304, 'Marcona', 1103, 11),
(110305, 'Vista Alegre', 1103, 11),
(110401, 'Palpa', 1104, 11),
(110402, 'Llipata', 1104, 11),
(110403, 'Río Grande', 1104, 11),
(110404, 'Santa Cruz', 1104, 11),
(110405, 'Tibillo', 1104, 11),
(110501, 'Pisco', 1105, 11),
(110502, 'Huancano', 1105, 11),
(110503, 'Humay', 1105, 11),
(110504, 'Independencia', 1105, 11),
(110505, 'Paracas', 1105, 11),
(110506, 'San Andrés', 1105, 11),
(110507, 'San Clemente', 1105, 11),
(110508, 'Tupac Amaru Inca', 1105, 11),
(120101, 'Huancayo', 1201, 12),
(120104, 'Carhuacallanga', 1201, 12),
(120105, 'Chacapampa', 1201, 12),
(120106, 'Chicche', 1201, 12),
(120107, 'Chilca', 1201, 12),
(120108, 'Chongos Alto', 1201, 12),
(120111, 'Chupuro', 1201, 12),
(120112, 'Colca', 1201, 12),
(120113, 'Cullhuas', 1201, 12),
(120114, 'El Tambo', 1201, 12),
(120116, 'Huacrapuquio', 1201, 12),
(120117, 'Hualhuas', 1201, 12),
(120119, 'Huancan', 1201, 12),
(120120, 'Huasicancha', 1201, 12),
(120121, 'Huayucachi', 1201, 12),
(120122, 'Ingenio', 1201, 12),
(120124, 'Pariahuanca', 1201, 12),
(120125, 'Pilcomayo', 1201, 12),
(120126, 'Pucara', 1201, 12),
(120127, 'Quichuay', 1201, 12),
(120128, 'Quilcas', 1201, 12),
(120129, 'San Agustín', 1201, 12),
(120130, 'San Jerónimo de Tunan', 1201, 12),
(120132, 'Saño', 1201, 12),
(120133, 'Sapallanga', 1201, 12),
(120134, 'Sicaya', 1201, 12),
(120135, 'Santo Domingo de Acobamba', 1201, 12),
(120136, 'Viques', 1201, 12),
(120201, 'Concepción', 1202, 12),
(120202, 'Aco', 1202, 12),
(120203, 'Andamarca', 1202, 12),
(120204, 'Chambara', 1202, 12),
(120205, 'Cochas', 1202, 12),
(120206, 'Comas', 1202, 12),
(120207, 'Heroínas Toledo', 1202, 12),
(120208, 'Manzanares', 1202, 12),
(120209, 'Mariscal Castilla', 1202, 12),
(120210, 'Matahuasi', 1202, 12),
(120211, 'Mito', 1202, 12),
(120212, 'Nueve de Julio', 1202, 12),
(120213, 'Orcotuna', 1202, 12),
(120214, 'San José de Quero', 1202, 12),
(120215, 'Santa Rosa de Ocopa', 1202, 12),
(120301, 'Chanchamayo', 1203, 12),
(120302, 'Perene', 1203, 12),
(120303, 'Pichanaqui', 1203, 12),
(120304, 'San Luis de Shuaro', 1203, 12),
(120305, 'San Ramón', 1203, 12),
(120306, 'Vitoc', 1203, 12),
(120401, 'Jauja', 1204, 12),
(120402, 'Acolla', 1204, 12),
(120403, 'Apata', 1204, 12),
(120404, 'Ataura', 1204, 12),
(120405, 'Canchayllo', 1204, 12),
(120406, 'Curicaca', 1204, 12),
(120407, 'El Mantaro', 1204, 12),
(120408, 'Huamali', 1204, 12),
(120409, 'Huaripampa', 1204, 12),
(120410, 'Huertas', 1204, 12),
(120411, 'Janjaillo', 1204, 12),
(120412, 'Julcán', 1204, 12),
(120413, 'Leonor Ordóñez', 1204, 12),
(120414, 'Llocllapampa', 1204, 12),
(120415, 'Marco', 1204, 12),
(120416, 'Masma', 1204, 12),
(120417, 'Masma Chicche', 1204, 12),
(120418, 'Molinos', 1204, 12),
(120419, 'Monobamba', 1204, 12),
(120420, 'Muqui', 1204, 12),
(120421, 'Muquiyauyo', 1204, 12),
(120422, 'Paca', 1204, 12),
(120423, 'Paccha', 1204, 12),
(120424, 'Pancan', 1204, 12),
(120425, 'Parco', 1204, 12),
(120426, 'Pomacancha', 1204, 12),
(120427, 'Ricran', 1204, 12),
(120428, 'San Lorenzo', 1204, 12),
(120429, 'San Pedro de Chunan', 1204, 12),
(120430, 'Sausa', 1204, 12),
(120431, 'Sincos', 1204, 12),
(120432, 'Tunan Marca', 1204, 12),
(120433, 'Yauli', 1204, 12),
(120434, 'Yauyos', 1204, 12),
(120501, 'Junin', 1205, 12),
(120502, 'Carhuamayo', 1205, 12),
(120503, 'Ondores', 1205, 12),
(120504, 'Ulcumayo', 1205, 12),
(120601, 'Satipo', 1206, 12),
(120602, 'Coviriali', 1206, 12),
(120603, 'Llaylla', 1206, 12),
(120604, 'Mazamari', 1206, 12),
(120605, 'Pampa Hermosa', 1206, 12),
(120606, 'Pangoa', 1206, 12),
(120607, 'Río Negro', 1206, 12),
(120608, 'Río Tambo', 1206, 12),
(120609, 'Vizcatan del Ene', 1206, 12),
(120701, 'Tarma', 1207, 12),
(120702, 'Acobamba', 1207, 12),
(120703, 'Huaricolca', 1207, 12),
(120704, 'Huasahuasi', 1207, 12),
(120705, 'La Unión', 1207, 12),
(120706, 'Palca', 1207, 12),
(120707, 'Palcamayo', 1207, 12),
(120708, 'San Pedro de Cajas', 1207, 12),
(120709, 'Tapo', 1207, 12),
(120801, 'La Oroya', 1208, 12),
(120802, 'Chacapalpa', 1208, 12),
(120803, 'Huay-Huay', 1208, 12),
(120804, 'Marcapomacocha', 1208, 12),
(120805, 'Morococha', 1208, 12),
(120806, 'Paccha', 1208, 12),
(120807, 'Santa Bárbara de Carhuacayan', 1208, 12),
(120808, 'Santa Rosa de Sacco', 1208, 12),
(120809, 'Suitucancha', 1208, 12),
(120810, 'Yauli', 1208, 12),
(120901, 'Chupaca', 1209, 12),
(120902, 'Ahuac', 1209, 12),
(120903, 'Chongos Bajo', 1209, 12),
(120904, 'Huachac', 1209, 12),
(120905, 'Huamancaca Chico', 1209, 12),
(120906, 'San Juan de Iscos', 1209, 12),
(120907, 'San Juan de Jarpa', 1209, 12),
(120908, 'Tres de Diciembre', 1209, 12),
(120909, 'Yanacancha', 1209, 12),
(130101, 'Trujillo', 1301, 13),
(130102, 'El Porvenir', 1301, 13),
(130103, 'Florencia de Mora', 1301, 13),
(130104, 'Huanchaco', 1301, 13),
(130105, 'La Esperanza', 1301, 13),
(130106, 'Laredo', 1301, 13),
(130107, 'Moche', 1301, 13),
(130108, 'Poroto', 1301, 13),
(130109, 'Salaverry', 1301, 13),
(130110, 'Simbal', 1301, 13),
(130111, 'Victor Larco Herrera', 1301, 13),
(130201, 'Ascope', 1302, 13),
(130202, 'Chicama', 1302, 13),
(130203, 'Chocope', 1302, 13),
(130204, 'Magdalena de Cao', 1302, 13),
(130205, 'Paijan', 1302, 13),
(130206, 'Rázuri', 1302, 13),
(130207, 'Santiago de Cao', 1302, 13),
(130208, 'Casa Grande', 1302, 13),
(130301, 'Bolívar', 1303, 13),
(130302, 'Bambamarca', 1303, 13),
(130303, 'Condormarca', 1303, 13),
(130304, 'Longotea', 1303, 13),
(130305, 'Uchumarca', 1303, 13),
(130306, 'Ucuncha', 1303, 13),
(130401, 'Chepen', 1304, 13),
(130402, 'Pacanga', 1304, 13),
(130403, 'Pueblo Nuevo', 1304, 13),
(130501, 'Julcan', 1305, 13),
(130502, 'Calamarca', 1305, 13),
(130503, 'Carabamba', 1305, 13),
(130504, 'Huaso', 1305, 13),
(130601, 'Otuzco', 1306, 13),
(130602, 'Agallpampa', 1306, 13),
(130604, 'Charat', 1306, 13),
(130605, 'Huaranchal', 1306, 13),
(130606, 'La Cuesta', 1306, 13),
(130608, 'Mache', 1306, 13),
(130610, 'Paranday', 1306, 13),
(130611, 'Salpo', 1306, 13),
(130613, 'Sinsicap', 1306, 13),
(130614, 'Usquil', 1306, 13),
(130701, 'San Pedro de Lloc', 1307, 13),
(130702, 'Guadalupe', 1307, 13),
(130703, 'Jequetepeque', 1307, 13),
(130704, 'Pacasmayo', 1307, 13),
(130705, 'San José', 1307, 13),
(130801, 'Tayabamba', 1308, 13),
(130802, 'Buldibuyo', 1308, 13),
(130803, 'Chillia', 1308, 13),
(130804, 'Huancaspata', 1308, 13),
(130805, 'Huaylillas', 1308, 13),
(130806, 'Huayo', 1308, 13),
(130807, 'Ongon', 1308, 13),
(130808, 'Parcoy', 1308, 13),
(130809, 'Pataz', 1308, 13),
(130810, 'Pias', 1308, 13),
(130811, 'Santiago de Challas', 1308, 13),
(130812, 'Taurija', 1308, 13),
(130813, 'Urpay', 1308, 13),
(130901, 'Huamachuco', 1309, 13),
(130902, 'Chugay', 1309, 13),
(130903, 'Cochorco', 1309, 13),
(130904, 'Curgos', 1309, 13),
(130905, 'Marcabal', 1309, 13),
(130906, 'Sanagoran', 1309, 13),
(130907, 'Sarin', 1309, 13),
(130908, 'Sartimbamba', 1309, 13),
(131001, 'Santiago de Chuco', 1310, 13),
(131002, 'Angasmarca', 1310, 13),
(131003, 'Cachicadan', 1310, 13),
(131004, 'Mollebamba', 1310, 13),
(131005, 'Mollepata', 1310, 13),
(131006, 'Quiruvilca', 1310, 13),
(131007, 'Santa Cruz de Chuca', 1310, 13),
(131008, 'Sitabamba', 1310, 13),
(131101, 'Cascas', 1311, 13),
(131102, 'Lucma', 1311, 13),
(131103, 'Marmot', 1311, 13),
(131104, 'Sayapullo', 1311, 13),
(131201, 'Viru', 1312, 13),
(131202, 'Chao', 1312, 13),
(131203, 'Guadalupito', 1312, 13),
(140101, 'Chiclayo', 1401, 14),
(140102, 'Chongoyape', 1401, 14),
(140103, 'Eten', 1401, 14),
(140104, 'Eten Puerto', 1401, 14),
(140105, 'José Leonardo Ortiz', 1401, 14),
(140106, 'La Victoria', 1401, 14),
(140107, 'Lagunas', 1401, 14),
(140108, 'Monsefu', 1401, 14),
(140109, 'Nueva Arica', 1401, 14),
(140110, 'Oyotun', 1401, 14),
(140111, 'Picsi', 1401, 14),
(140112, 'Pimentel', 1401, 14),
(140113, 'Reque', 1401, 14),
(140114, 'Santa Rosa', 1401, 14),
(140115, 'Saña', 1401, 14),
(140116, 'Cayalti', 1401, 14),
(140117, 'Patapo', 1401, 14),
(140118, 'Pomalca', 1401, 14),
(140119, 'Pucala', 1401, 14),
(140120, 'Tuman', 1401, 14),
(140201, 'Ferreñafe', 1402, 14),
(140202, 'Cañaris', 1402, 14),
(140203, 'Incahuasi', 1402, 14),
(140204, 'Manuel Antonio Mesones Muro', 1402, 14),
(140205, 'Pitipo', 1402, 14),
(140206, 'Pueblo Nuevo', 1402, 14),
(140301, 'Lambayeque', 1403, 14),
(140302, 'Chochope', 1403, 14),
(140303, 'Illimo', 1403, 14),
(140304, 'Jayanca', 1403, 14),
(140305, 'Mochumi', 1403, 14),
(140306, 'Morrope', 1403, 14),
(140307, 'Motupe', 1403, 14),
(140308, 'Olmos', 1403, 14),
(140309, 'Pacora', 1403, 14),
(140310, 'Salas', 1403, 14),
(140311, 'San José', 1403, 14),
(140312, 'Tucume', 1403, 14),
(150101, 'Lima', 1501, 15),
(150102, 'Ancón', 1501, 15),
(150103, 'Ate', 1501, 15),
(150104, 'Barranco', 1501, 15),
(150105, 'Breña', 1501, 15),
(150106, 'Carabayllo', 1501, 15),
(150107, 'Chaclacayo', 1501, 15),
(150108, 'Chorrillos', 1501, 15),
(150109, 'Cieneguilla', 1501, 15),
(150110, 'Comas', 1501, 15),
(150111, 'El Agustino', 1501, 15),
(150112, 'Independencia', 1501, 15),
(150113, 'Jesús María', 1501, 15),
(150114, 'La Molina', 1501, 15),
(150115, 'La Victoria', 1501, 15),
(150116, 'Lince', 1501, 15),
(150117, 'Los Olivos', 1501, 15),
(150118, 'Lurigancho', 1501, 15),
(150119, 'Lurin', 1501, 15),
(150120, 'Magdalena del Mar', 1501, 15),
(150121, 'Pueblo Libre', 1501, 15),
(150122, 'Miraflores', 1501, 15),
(150123, 'Pachacamac', 1501, 15),
(150124, 'Pucusana', 1501, 15),
(150125, 'Puente Piedra', 1501, 15),
(150126, 'Punta Hermosa', 1501, 15),
(150127, 'Punta Negra', 1501, 15),
(150128, 'Rímac', 1501, 15),
(150129, 'San Bartolo', 1501, 15),
(150130, 'San Borja', 1501, 15),
(150131, 'San Isidro', 1501, 15),
(150132, 'San Juan de Lurigancho', 1501, 15),
(150133, 'San Juan de Miraflores', 1501, 15),
(150134, 'San Luis', 1501, 15),
(150135, 'San Martín de Porres', 1501, 15),
(150136, 'San Miguel', 1501, 15),
(150137, 'Santa Anita', 1501, 15),
(150138, 'Santa María del Mar', 1501, 15),
(150139, 'Santa Rosa', 1501, 15),
(150140, 'Santiago de Surco', 1501, 15),
(150141, 'Surquillo', 1501, 15),
(150142, 'Villa El Salvador', 1501, 15),
(150143, 'Villa María del Triunfo', 1501, 15),
(150201, 'Barranca', 1502, 15),
(150202, 'Paramonga', 1502, 15),
(150203, 'Pativilca', 1502, 15),
(150204, 'Supe', 1502, 15),
(150205, 'Supe Puerto', 1502, 15),
(150301, 'Cajatambo', 1503, 15),
(150302, 'Copa', 1503, 15),
(150303, 'Gorgor', 1503, 15),
(150304, 'Huancapon', 1503, 15),
(150305, 'Manas', 1503, 15),
(150401, 'Canta', 1504, 15),
(150402, 'Arahuay', 1504, 15),
(150403, 'Huamantanga', 1504, 15),
(150404, 'Huaros', 1504, 15),
(150405, 'Lachaqui', 1504, 15),
(150406, 'San Buenaventura', 1504, 15),
(150407, 'Santa Rosa de Quives', 1504, 15),
(150501, 'San Vicente de Cañete', 1505, 15),
(150502, 'Asia', 1505, 15),
(150503, 'Calango', 1505, 15),
(150504, 'Cerro Azul', 1505, 15),
(150505, 'Chilca', 1505, 15),
(150506, 'Coayllo', 1505, 15),
(150507, 'Imperial', 1505, 15),
(150508, 'Lunahuana', 1505, 15),
(150509, 'Mala', 1505, 15),
(150510, 'Nuevo Imperial', 1505, 15),
(150511, 'Pacaran', 1505, 15),
(150512, 'Quilmana', 1505, 15),
(150513, 'San Antonio', 1505, 15),
(150514, 'San Luis', 1505, 15),
(150515, 'Santa Cruz de Flores', 1505, 15),
(150516, 'Zúñiga', 1505, 15),
(150601, 'Huaral', 1506, 15),
(150602, 'Atavillos Alto', 1506, 15),
(150603, 'Atavillos Bajo', 1506, 15),
(150604, 'Aucallama', 1506, 15),
(150605, 'Chancay', 1506, 15),
(150606, 'Ihuari', 1506, 15),
(150607, 'Lampian', 1506, 15),
(150608, 'Pacaraos', 1506, 15),
(150609, 'San Miguel de Acos', 1506, 15),
(150610, 'Santa Cruz de Andamarca', 1506, 15),
(150611, 'Sumbilca', 1506, 15),
(150612, 'Veintisiete de Noviembre', 1506, 15),
(150701, 'Matucana', 1507, 15),
(150702, 'Antioquia', 1507, 15),
(150703, 'Callahuanca', 1507, 15),
(150704, 'Carampoma', 1507, 15),
(150705, 'Chicla', 1507, 15),
(150706, 'Cuenca', 1507, 15),
(150707, 'Huachupampa', 1507, 15),
(150708, 'Huanza', 1507, 15),
(150709, 'Huarochiri', 1507, 15),
(150710, 'Lahuaytambo', 1507, 15),
(150711, 'Langa', 1507, 15),
(150712, 'Laraos', 1507, 15),
(150713, 'Mariatana', 1507, 15),
(150714, 'Ricardo Palma', 1507, 15),
(150715, 'San Andrés de Tupicocha', 1507, 15),
(150716, 'San Antonio', 1507, 15),
(150717, 'San Bartolomé', 1507, 15),
(150718, 'San Damian', 1507, 15),
(150719, 'San Juan de Iris', 1507, 15),
(150720, 'San Juan de Tantaranche', 1507, 15),
(150721, 'San Lorenzo de Quinti', 1507, 15),
(150722, 'San Mateo', 1507, 15),
(150723, 'San Mateo de Otao', 1507, 15),
(150724, 'San Pedro de Casta', 1507, 15),
(150725, 'San Pedro de Huancayre', 1507, 15),
(150726, 'Sangallaya', 1507, 15),
(150727, 'Santa Cruz de Cocachacra', 1507, 15),
(150728, 'Santa Eulalia', 1507, 15),
(150729, 'Santiago de Anchucaya', 1507, 15),
(150730, 'Santiago de Tuna', 1507, 15),
(150731, 'Santo Domingo de Los Olleros', 1507, 15),
(150732, 'Surco', 1507, 15),
(150801, 'Huacho', 1508, 15),
(150802, 'Ambar', 1508, 15),
(150803, 'Caleta de Carquin', 1508, 15),
(150804, 'Checras', 1508, 15),
(150805, 'Hualmay', 1508, 15),
(150806, 'Huaura', 1508, 15),
(150807, 'Leoncio Prado', 1508, 15),
(150808, 'Paccho', 1508, 15),
(150809, 'Santa Leonor', 1508, 15),
(150810, 'Santa María', 1508, 15),
(150811, 'Sayan', 1508, 15),
(150812, 'Vegueta', 1508, 15),
(150901, 'Oyon', 1509, 15),
(150902, 'Andajes', 1509, 15),
(150903, 'Caujul', 1509, 15),
(150904, 'Cochamarca', 1509, 15),
(150905, 'Navan', 1509, 15),
(150906, 'Pachangara', 1509, 15),
(151001, 'Yauyos', 1510, 15),
(151002, 'Alis', 1510, 15),
(151003, 'Allauca', 1510, 15),
(151004, 'Ayaviri', 1510, 15),
(151005, 'Azángaro', 1510, 15),
(151006, 'Cacra', 1510, 15),
(151007, 'Carania', 1510, 15),
(151008, 'Catahuasi', 1510, 15),
(151009, 'Chocos', 1510, 15),
(151010, 'Cochas', 1510, 15),
(151011, 'Colonia', 1510, 15),
(151012, 'Hongos', 1510, 15),
(151013, 'Huampara', 1510, 15),
(151014, 'Huancaya', 1510, 15),
(151015, 'Huangascar', 1510, 15),
(151016, 'Huantan', 1510, 15),
(151017, 'Huañec', 1510, 15),
(151018, 'Laraos', 1510, 15),
(151019, 'Lincha', 1510, 15),
(151020, 'Madean', 1510, 15),
(151021, 'Miraflores', 1510, 15),
(151022, 'Omas', 1510, 15),
(151023, 'Putinza', 1510, 15),
(151024, 'Quinches', 1510, 15),
(151025, 'Quinocay', 1510, 15),
(151026, 'San Joaquín', 1510, 15),
(151027, 'San Pedro de Pilas', 1510, 15),
(151028, 'Tanta', 1510, 15),
(151029, 'Tauripampa', 1510, 15),
(151030, 'Tomas', 1510, 15),
(151031, 'Tupe', 1510, 15),
(151032, 'Viñac', 1510, 15),
(151033, 'Vitis', 1510, 15),
(160101, 'Iquitos', 1601, 16),
(160102, 'Alto Nanay', 1601, 16),
(160103, 'Fernando Lores', 1601, 16),
(160104, 'Indiana', 1601, 16),
(160105, 'Las Amazonas', 1601, 16),
(160106, 'Mazan', 1601, 16),
(160107, 'Napo', 1601, 16),
(160108, 'Punchana', 1601, 16),
(160110, 'Torres Causana', 1601, 16),
(160112, 'Belén', 1601, 16),
(160113, 'San Juan Bautista', 1601, 16),
(160201, 'Yurimaguas', 1602, 16),
(160202, 'Balsapuerto', 1602, 16),
(160205, 'Jeberos', 1602, 16),
(160206, 'Lagunas', 1602, 16),
(160210, 'Santa Cruz', 1602, 16),
(160211, 'Teniente Cesar López Rojas', 1602, 16),
(160301, 'Nauta', 1603, 16),
(160302, 'Parinari', 1603, 16),
(160303, 'Tigre', 1603, 16),
(160304, 'Trompeteros', 1603, 16),
(160305, 'Urarinas', 1603, 16),
(160401, 'Ramón Castilla', 1604, 16),
(160402, 'Pebas', 1604, 16),
(160403, 'Yavari', 1604, 16),
(160404, 'San Pablo', 1604, 16),
(160501, 'Requena', 1605, 16),
(160502, 'Alto Tapiche', 1605, 16),
(160503, 'Capelo', 1605, 16),
(160504, 'Emilio San Martín', 1605, 16),
(160505, 'Maquia', 1605, 16),
(160506, 'Puinahua', 1605, 16),
(160507, 'Saquena', 1605, 16),
(160508, 'Soplin', 1605, 16),
(160509, 'Tapiche', 1605, 16),
(160510, 'Jenaro Herrera', 1605, 16),
(160511, 'Yaquerana', 1605, 16),
(160601, 'Contamana', 1606, 16),
(160602, 'Inahuaya', 1606, 16),
(160603, 'Padre Márquez', 1606, 16),
(160604, 'Pampa Hermosa', 1606, 16),
(160605, 'Sarayacu', 1606, 16),
(160606, 'Vargas Guerra', 1606, 16),
(160701, 'Barranca', 1607, 16),
(160702, 'Cahuapanas', 1607, 16),
(160703, 'Manseriche', 1607, 16),
(160704, 'Morona', 1607, 16),
(160705, 'Pastaza', 1607, 16),
(160706, 'Andoas', 1607, 16),
(160801, 'Putumayo', 1608, 16),
(160802, 'Rosa Panduro', 1608, 16),
(160803, 'Teniente Manuel Clavero', 1608, 16),
(160804, 'Yaguas', 1608, 16),
(170101, 'Tambopata', 1701, 17),
(170102, 'Inambari', 1701, 17),
(170103, 'Las Piedras', 1701, 17),
(170104, 'Laberinto', 1701, 17),
(170201, 'Manu', 1702, 17),
(170202, 'Fitzcarrald', 1702, 17),
(170203, 'Madre de Dios', 1702, 17),
(170204, 'Huepetuhe', 1702, 17),
(170301, 'Iñapari', 1703, 17),
(170302, 'Iberia', 1703, 17),
(170303, 'Tahuamanu', 1703, 17),
(180101, 'Moquegua', 1801, 18),
(180102, 'Carumas', 1801, 18),
(180103, 'Cuchumbaya', 1801, 18),
(180104, 'Samegua', 1801, 18),
(180105, 'San Cristóbal', 1801, 18),
(180106, 'Torata', 1801, 18),
(180201, 'Omate', 1802, 18),
(180202, 'Chojata', 1802, 18),
(180203, 'Coalaque', 1802, 18),
(180204, 'Ichuña', 1802, 18),
(180205, 'La Capilla', 1802, 18),
(180206, 'Lloque', 1802, 18),
(180207, 'Matalaque', 1802, 18),
(180208, 'Puquina', 1802, 18),
(180209, 'Quinistaquillas', 1802, 18),
(180210, 'Ubinas', 1802, 18),
(180211, 'Yunga', 1802, 18),
(180301, 'Ilo', 1803, 18),
(180302, 'El Algarrobal', 1803, 18),
(180303, 'Pacocha', 1803, 18),
(190101, 'Chaupimarca', 1901, 19),
(190102, 'Huachon', 1901, 19),
(190103, 'Huariaca', 1901, 19),
(190104, 'Huayllay', 1901, 19),
(190105, 'Ninacaca', 1901, 19),
(190106, 'Pallanchacra', 1901, 19),
(190107, 'Paucartambo', 1901, 19),
(190108, 'San Francisco de Asís de Yarusyacan', 1901, 19),
(190109, 'Simon Bolívar', 1901, 19),
(190110, 'Ticlacayan', 1901, 19),
(190111, 'Tinyahuarco', 1901, 19),
(190112, 'Vicco', 1901, 19),
(190113, 'Yanacancha', 1901, 19),
(190201, 'Yanahuanca', 1902, 19),
(190202, 'Chacayan', 1902, 19),
(190203, 'Goyllarisquizga', 1902, 19),
(190204, 'Paucar', 1902, 19),
(190205, 'San Pedro de Pillao', 1902, 19),
(190206, 'Santa Ana de Tusi', 1902, 19),
(190207, 'Tapuc', 1902, 19),
(190208, 'Vilcabamba', 1902, 19),
(190301, 'Oxapampa', 1903, 19),
(190302, 'Chontabamba', 1903, 19),
(190303, 'Huancabamba', 1903, 19),
(190304, 'Palcazu', 1903, 19),
(190305, 'Pozuzo', 1903, 19),
(190306, 'Puerto Bermúdez', 1903, 19),
(190307, 'Villa Rica', 1903, 19),
(190308, 'Constitución', 1903, 19),
(200101, 'Piura', 2001, 20),
(200104, 'Castilla', 2001, 20),
(200105, 'Catacaos', 2001, 20),
(200107, 'Cura Mori', 2001, 20),
(200108, 'El Tallan', 2001, 20),
(200109, 'La Arena', 2001, 20),
(200110, 'La Unión', 2001, 20),
(200111, 'Las Lomas', 2001, 20),
(200114, 'Tambo Grande', 2001, 20),
(200115, 'Veintiseis de Octubre', 2001, 20),
(200201, 'Ayabaca', 2002, 20),
(200202, 'Frias', 2002, 20),
(200203, 'Jilili', 2002, 20),
(200204, 'Lagunas', 2002, 20),
(200205, 'Montero', 2002, 20),
(200206, 'Pacaipampa', 2002, 20),
(200207, 'Paimas', 2002, 20),
(200208, 'Sapillica', 2002, 20),
(200209, 'Sicchez', 2002, 20),
(200210, 'Suyo', 2002, 20),
(200301, 'Huancabamba', 2003, 20),
(200302, 'Canchaque', 2003, 20),
(200303, 'El Carmen de la Frontera', 2003, 20),
(200304, 'Huarmaca', 2003, 20),
(200305, 'Lalaquiz', 2003, 20),
(200306, 'San Miguel de El Faique', 2003, 20),
(200307, 'Sondor', 2003, 20),
(200308, 'Sondorillo', 2003, 20),
(200401, 'Chulucanas', 2004, 20),
(200402, 'Buenos Aires', 2004, 20),
(200403, 'Chalaco', 2004, 20),
(200404, 'La Matanza', 2004, 20),
(200405, 'Morropon', 2004, 20),
(200406, 'Salitral', 2004, 20),
(200407, 'San Juan de Bigote', 2004, 20),
(200408, 'Santa Catalina de Mossa', 2004, 20),
(200409, 'Santo Domingo', 2004, 20),
(200410, 'Yamango', 2004, 20),
(200501, 'Paita', 2005, 20),
(200502, 'Amotape', 2005, 20),
(200503, 'Arenal', 2005, 20),
(200504, 'Colan', 2005, 20),
(200505, 'La Huaca', 2005, 20),
(200506, 'Tamarindo', 2005, 20),
(200507, 'Vichayal', 2005, 20),
(200601, 'Sullana', 2006, 20),
(200602, 'Bellavista', 2006, 20),
(200603, 'Ignacio Escudero', 2006, 20),
(200604, 'Lancones', 2006, 20),
(200605, 'Marcavelica', 2006, 20),
(200606, 'Miguel Checa', 2006, 20),
(200607, 'Querecotillo', 2006, 20),
(200608, 'Salitral', 2006, 20),
(200701, 'Pariñas', 2007, 20),
(200702, 'El Alto', 2007, 20),
(200703, 'La Brea', 2007, 20),
(200704, 'Lobitos', 2007, 20),
(200705, 'Los Organos', 2007, 20),
(200706, 'Mancora', 2007, 20),
(200801, 'Sechura', 2008, 20),
(200802, 'Bellavista de la Unión', 2008, 20),
(200803, 'Bernal', 2008, 20),
(200804, 'Cristo Nos Valga', 2008, 20),
(200805, 'Vice', 2008, 20),
(200806, 'Rinconada Llicuar', 2008, 20),
(210101, 'Puno', 2101, 21),
(210102, 'Acora', 2101, 21),
(210103, 'Amantani', 2101, 21),
(210104, 'Atuncolla', 2101, 21),
(210105, 'Capachica', 2101, 21),
(210106, 'Chucuito', 2101, 21),
(210107, 'Coata', 2101, 21),
(210108, 'Huata', 2101, 21),
(210109, 'Mañazo', 2101, 21),
(210110, 'Paucarcolla', 2101, 21),
(210111, 'Pichacani', 2101, 21),
(210112, 'Plateria', 2101, 21),
(210113, 'San Antonio', 2101, 21),
(210114, 'Tiquillaca', 2101, 21),
(210115, 'Vilque', 2101, 21),
(210201, 'Azángaro', 2102, 21),
(210202, 'Achaya', 2102, 21),
(210203, 'Arapa', 2102, 21),
(210204, 'Asillo', 2102, 21),
(210205, 'Caminaca', 2102, 21),
(210206, 'Chupa', 2102, 21),
(210207, 'José Domingo Choquehuanca', 2102, 21),
(210208, 'Muñani', 2102, 21),
(210209, 'Potoni', 2102, 21),
(210210, 'Saman', 2102, 21),
(210211, 'San Anton', 2102, 21),
(210212, 'San José', 2102, 21),
(210213, 'San Juan de Salinas', 2102, 21),
(210214, 'Santiago de Pupuja', 2102, 21),
(210215, 'Tirapata', 2102, 21),
(210301, 'Macusani', 2103, 21),
(210302, 'Ajoyani', 2103, 21),
(210303, 'Ayapata', 2103, 21),
(210304, 'Coasa', 2103, 21),
(210305, 'Corani', 2103, 21),
(210306, 'Crucero', 2103, 21),
(210307, 'Ituata', 2103, 21),
(210308, 'Ollachea', 2103, 21),
(210309, 'San Gaban', 2103, 21),
(210310, 'Usicayos', 2103, 21),
(210401, 'Juli', 2104, 21),
(210402, 'Desaguadero', 2104, 21),
(210403, 'Huacullani', 2104, 21),
(210404, 'Kelluyo', 2104, 21),
(210405, 'Pisacoma', 2104, 21),
(210406, 'Pomata', 2104, 21),
(210407, 'Zepita', 2104, 21),
(210501, 'Ilave', 2105, 21),
(210502, 'Capazo', 2105, 21),
(210503, 'Pilcuyo', 2105, 21),
(210504, 'Santa Rosa', 2105, 21),
(210505, 'Conduriri', 2105, 21),
(210601, 'Huancane', 2106, 21),
(210602, 'Cojata', 2106, 21);
INSERT INTO `distrito` (`id`, `nombre`, `idprovincia`, `iddepartamento`) VALUES
(210603, 'Huatasani', 2106, 21),
(210604, 'Inchupalla', 2106, 21),
(210605, 'Pusi', 2106, 21),
(210606, 'Rosaspata', 2106, 21),
(210607, 'Taraco', 2106, 21),
(210608, 'Vilque Chico', 2106, 21),
(210701, 'Lampa', 2107, 21),
(210702, 'Cabanilla', 2107, 21),
(210703, 'Calapuja', 2107, 21),
(210704, 'Nicasio', 2107, 21),
(210705, 'Ocuviri', 2107, 21),
(210706, 'Palca', 2107, 21),
(210707, 'Paratia', 2107, 21),
(210708, 'Pucara', 2107, 21),
(210709, 'Santa Lucia', 2107, 21),
(210710, 'Vilavila', 2107, 21),
(210801, 'Ayaviri', 2108, 21),
(210802, 'Antauta', 2108, 21),
(210803, 'Cupi', 2108, 21),
(210804, 'Llalli', 2108, 21),
(210805, 'Macari', 2108, 21),
(210806, 'Nuñoa', 2108, 21),
(210807, 'Orurillo', 2108, 21),
(210808, 'Santa Rosa', 2108, 21),
(210809, 'Umachiri', 2108, 21),
(210901, 'Moho', 2109, 21),
(210902, 'Conima', 2109, 21),
(210903, 'Huayrapata', 2109, 21),
(210904, 'Tilali', 2109, 21),
(211001, 'Putina', 2110, 21),
(211002, 'Ananea', 2110, 21),
(211003, 'Pedro Vilca Apaza', 2110, 21),
(211004, 'Quilcapuncu', 2110, 21),
(211005, 'Sina', 2110, 21),
(211101, 'Juliaca', 2111, 21),
(211102, 'Cabana', 2111, 21),
(211103, 'Cabanillas', 2111, 21),
(211104, 'Caracoto', 2111, 21),
(211105, 'San Miguel', 2111, 21),
(211201, 'Sandia', 2112, 21),
(211202, 'Cuyocuyo', 2112, 21),
(211203, 'Limbani', 2112, 21),
(211204, 'Patambuco', 2112, 21),
(211205, 'Phara', 2112, 21),
(211206, 'Quiaca', 2112, 21),
(211207, 'San Juan del Oro', 2112, 21),
(211208, 'Yanahuaya', 2112, 21),
(211209, 'Alto Inambari', 2112, 21),
(211210, 'San Pedro de Putina Punco', 2112, 21),
(211301, 'Yunguyo', 2113, 21),
(211302, 'Anapia', 2113, 21),
(211303, 'Copani', 2113, 21),
(211304, 'Cuturapi', 2113, 21),
(211305, 'Ollaraya', 2113, 21),
(211306, 'Tinicachi', 2113, 21),
(211307, 'Unicachi', 2113, 21),
(220101, 'Moyobamba', 2201, 22),
(220102, 'Calzada', 2201, 22),
(220103, 'Habana', 2201, 22),
(220104, 'Jepelacio', 2201, 22),
(220105, 'Soritor', 2201, 22),
(220106, 'Yantalo', 2201, 22),
(220201, 'Bellavista', 2202, 22),
(220202, 'Alto Biavo', 2202, 22),
(220203, 'Bajo Biavo', 2202, 22),
(220204, 'Huallaga', 2202, 22),
(220205, 'San Pablo', 2202, 22),
(220206, 'San Rafael', 2202, 22),
(220301, 'San José de Sisa', 2203, 22),
(220302, 'Agua Blanca', 2203, 22),
(220303, 'San Martín', 2203, 22),
(220304, 'Santa Rosa', 2203, 22),
(220305, 'Shatoja', 2203, 22),
(220401, 'Saposoa', 2204, 22),
(220402, 'Alto Saposoa', 2204, 22),
(220403, 'El Eslabón', 2204, 22),
(220404, 'Piscoyacu', 2204, 22),
(220405, 'Sacanche', 2204, 22),
(220406, 'Tingo de Saposoa', 2204, 22),
(220501, 'Lamas', 2205, 22),
(220502, 'Alonso de Alvarado', 2205, 22),
(220503, 'Barranquita', 2205, 22),
(220504, 'Caynarachi', 2205, 22),
(220505, 'Cuñumbuqui', 2205, 22),
(220506, 'Pinto Recodo', 2205, 22),
(220507, 'Rumisapa', 2205, 22),
(220508, 'San Roque de Cumbaza', 2205, 22),
(220509, 'Shanao', 2205, 22),
(220510, 'Tabalosos', 2205, 22),
(220511, 'Zapatero', 2205, 22),
(220601, 'Juanjuí', 2206, 22),
(220602, 'Campanilla', 2206, 22),
(220603, 'Huicungo', 2206, 22),
(220604, 'Pachiza', 2206, 22),
(220605, 'Pajarillo', 2206, 22),
(220701, 'Picota', 2207, 22),
(220702, 'Buenos Aires', 2207, 22),
(220703, 'Caspisapa', 2207, 22),
(220704, 'Pilluana', 2207, 22),
(220705, 'Pucacaca', 2207, 22),
(220706, 'San Cristóbal', 2207, 22),
(220707, 'San Hilarión', 2207, 22),
(220708, 'Shamboyacu', 2207, 22),
(220709, 'Tingo de Ponasa', 2207, 22),
(220710, 'Tres Unidos', 2207, 22),
(220801, 'Rioja', 2208, 22),
(220802, 'Awajun', 2208, 22),
(220803, 'Elías Soplin Vargas', 2208, 22),
(220804, 'Nueva Cajamarca', 2208, 22),
(220805, 'Pardo Miguel', 2208, 22),
(220806, 'Posic', 2208, 22),
(220807, 'San Fernando', 2208, 22),
(220808, 'Yorongos', 2208, 22),
(220809, 'Yuracyacu', 2208, 22),
(220901, 'Tarapoto', 2209, 22),
(220902, 'Alberto Leveau', 2209, 22),
(220903, 'Cacatachi', 2209, 22),
(220904, 'Chazuta', 2209, 22),
(220905, 'Chipurana', 2209, 22),
(220906, 'El Porvenir', 2209, 22),
(220907, 'Huimbayoc', 2209, 22),
(220908, 'Juan Guerra', 2209, 22),
(220909, 'La Banda de Shilcayo', 2209, 22),
(220910, 'Morales', 2209, 22),
(220911, 'Papaplaya', 2209, 22),
(220912, 'San Antonio', 2209, 22),
(220913, 'Sauce', 2209, 22),
(220914, 'Shapaja', 2209, 22),
(221001, 'Tocache', 2210, 22),
(221002, 'Nuevo Progreso', 2210, 22),
(221003, 'Polvora', 2210, 22),
(221004, 'Shunte', 2210, 22),
(221005, 'Uchiza', 2210, 22),
(230101, 'Tacna', 2301, 23),
(230102, 'Alto de la Alianza', 2301, 23),
(230103, 'Calana', 2301, 23),
(230104, 'Ciudad Nueva', 2301, 23),
(230105, 'Inclan', 2301, 23),
(230106, 'Pachia', 2301, 23),
(230107, 'Palca', 2301, 23),
(230108, 'Pocollay', 2301, 23),
(230109, 'Sama', 2301, 23),
(230110, 'Coronel Gregorio Albarracín Lanchipa', 2301, 23),
(230111, 'La Yarada los Palos', 2301, 23),
(230201, 'Candarave', 2302, 23),
(230202, 'Cairani', 2302, 23),
(230203, 'Camilaca', 2302, 23),
(230204, 'Curibaya', 2302, 23),
(230205, 'Huanuara', 2302, 23),
(230206, 'Quilahuani', 2302, 23),
(230301, 'Locumba', 2303, 23),
(230302, 'Ilabaya', 2303, 23),
(230303, 'Ite', 2303, 23),
(230401, 'Tarata', 2304, 23),
(230402, 'Héroes Albarracín', 2304, 23),
(230403, 'Estique', 2304, 23),
(230404, 'Estique-Pampa', 2304, 23),
(230405, 'Sitajara', 2304, 23),
(230406, 'Susapaya', 2304, 23),
(230407, 'Tarucachi', 2304, 23),
(230408, 'Ticaco', 2304, 23),
(240101, 'Tumbes', 2401, 24),
(240102, 'Corrales', 2401, 24),
(240103, 'La Cruz', 2401, 24),
(240104, 'Pampas de Hospital', 2401, 24),
(240105, 'San Jacinto', 2401, 24),
(240106, 'San Juan de la Virgen', 2401, 24),
(240201, 'Zorritos', 2402, 24),
(240202, 'Casitas', 2402, 24),
(240203, 'Canoas de Punta Sal', 2402, 24),
(240301, 'Zarumilla', 2403, 24),
(240302, 'Aguas Verdes', 2403, 24),
(240303, 'Matapalo', 2403, 24),
(240304, 'Papayal', 2403, 24),
(250101, 'Calleria', 2501, 25),
(250102, 'Campoverde', 2501, 25),
(250103, 'Iparia', 2501, 25),
(250104, 'Masisea', 2501, 25),
(250105, 'Yarinacocha', 2501, 25),
(250106, 'Nueva Requena', 2501, 25),
(250107, 'Manantay', 2501, 25),
(250201, 'Raymondi', 2502, 25),
(250202, 'Sepahua', 2502, 25),
(250203, 'Tahuania', 2502, 25),
(250204, 'Yurua', 2502, 25),
(250301, 'Padre Abad', 2503, 25),
(250302, 'Irazola', 2503, 25),
(250303, 'Curimana', 2503, 25),
(250304, 'Neshuya', 2503, 25),
(250305, 'Alexander Von Humboldt', 2503, 25),
(250401, 'Purus', 2504, 25);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `estado`) VALUES
(1, 'GESTION', b'1'),
(2, 'ASISTENCIA', b'1'),
(3, 'ADMIN', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idsubmenu` int(11) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`id`, `idusuario`, `idsubmenu`, `estado`) VALUES
(1, 1, 1, b'1'),
(2, 1, 2, b'1'),
(3, 1, 3, b'1'),
(4, 1, 4, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `idtipoproveedor` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `idprovincia` int(11) NOT NULL,
  `iddistrito` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `estado` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`id`, `idtipoproveedor`, `iddepartamento`, `idprovincia`, `iddistrito`, `nombre`, `direccion`, `telefono`, `estado`) VALUES
(4, 1, 1, 101, 10101, 'eeee', 'ddasd 656 adads', '987987', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `provincia`
--

CREATE TABLE `provincia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `iddepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provincia`
--

INSERT INTO `provincia` (`id`, `nombre`, `iddepartamento`) VALUES
(101, 'Chachapoyas', 1),
(102, 'Bagua', 1),
(103, 'Bongará', 1),
(104, 'Condorcanqui', 1),
(105, 'Luya', 1),
(106, 'Rodríguez de Mendoza', 1),
(107, 'Utcubamba', 1),
(201, 'Huaraz', 2),
(202, 'Aija', 2),
(203, 'Antonio Raymondi', 2),
(204, 'Asunción', 2),
(205, 'Bolognesi', 2),
(206, 'Carhuaz', 2),
(207, 'Carlos Fermín Fitzcarrald', 2),
(208, 'Casma', 2),
(209, 'Corongo', 2),
(210, 'Huari', 2),
(211, 'Huarmey', 2),
(212, 'Huaylas', 2),
(213, 'Mariscal Luzuriaga', 2),
(214, 'Ocros', 2),
(215, 'Pallasca', 2),
(216, 'Pomabamba', 2),
(217, 'Recuay', 2),
(218, 'Santa', 2),
(219, 'Sihuas', 2),
(220, 'Yungay', 2),
(301, 'Abancay', 3),
(302, 'Andahuaylas', 3),
(303, 'Antabamba', 3),
(304, 'Aymaraes', 3),
(305, 'Cotabambas', 3),
(306, 'Chincheros', 3),
(307, 'Grau', 3),
(401, 'Arequipa', 4),
(402, 'Camaná', 4),
(403, 'Caravelí', 4),
(404, 'Castilla', 4),
(405, 'Caylloma', 4),
(406, 'Condesuyos', 4),
(407, 'Islay', 4),
(408, 'La Uniòn', 4),
(501, 'Huamanga', 5),
(502, 'Cangallo', 5),
(503, 'Huanca Sancos', 5),
(504, 'Huanta', 5),
(505, 'La Mar', 5),
(506, 'Lucanas', 5),
(507, 'Parinacochas', 5),
(508, 'Pàucar del Sara Sara', 5),
(509, 'Sucre', 5),
(510, 'Víctor Fajardo', 5),
(511, 'Vilcas Huamán', 5),
(601, 'Cajamarca', 6),
(602, 'Cajabamba', 6),
(603, 'Celendín', 6),
(604, 'Chota', 6),
(605, 'Contumazá', 6),
(606, 'Cutervo', 6),
(607, 'Hualgayoc', 6),
(608, 'Jaén', 6),
(609, 'San Ignacio', 6),
(610, 'San Marcos', 6),
(611, 'San Miguel', 6),
(612, 'San Pablo', 6),
(613, 'Santa Cruz', 6),
(701, 'Prov. Const. del Callao', 7),
(801, 'Cusco', 8),
(802, 'Acomayo', 8),
(803, 'Anta', 8),
(804, 'Calca', 8),
(805, 'Canas', 8),
(806, 'Canchis', 8),
(807, 'Chumbivilcas', 8),
(808, 'Espinar', 8),
(809, 'La Convención', 8),
(810, 'Paruro', 8),
(811, 'Paucartambo', 8),
(812, 'Quispicanchi', 8),
(813, 'Urubamba', 8),
(901, 'Huancavelica', 9),
(902, 'Acobamba', 9),
(903, 'Angaraes', 9),
(904, 'Castrovirreyna', 9),
(905, 'Churcampa', 9),
(906, 'Huaytará', 9),
(907, 'Tayacaja', 9),
(1001, 'Huánuco', 10),
(1002, 'Ambo', 10),
(1003, 'Dos de Mayo', 10),
(1004, 'Huacaybamba', 10),
(1005, 'Huamalíes', 10),
(1006, 'Leoncio Prado', 10),
(1007, 'Marañón', 10),
(1008, 'Pachitea', 10),
(1009, 'Puerto Inca', 10),
(1010, 'Lauricocha ', 10),
(1011, 'Yarowilca ', 10),
(1101, 'Ica ', 11),
(1102, 'Chincha ', 11),
(1103, 'Nasca ', 11),
(1104, 'Palpa ', 11),
(1105, 'Pisco ', 11),
(1201, 'Huancayo ', 12),
(1202, 'Concepción ', 12),
(1203, 'Chanchamayo ', 12),
(1204, 'Jauja ', 12),
(1205, 'Junín ', 12),
(1206, 'Satipo ', 12),
(1207, 'Tarma ', 12),
(1208, 'Yauli ', 12),
(1209, 'Chupaca ', 12),
(1301, 'Trujillo ', 13),
(1302, 'Ascope ', 13),
(1303, 'Bolívar ', 13),
(1304, 'Chepén ', 13),
(1305, 'Julcán ', 13),
(1306, 'Otuzco ', 13),
(1307, 'Pacasmayo ', 13),
(1308, 'Pataz ', 13),
(1309, 'Sánchez Carrión ', 13),
(1310, 'Santiago de Chuco ', 13),
(1311, 'Gran Chimú ', 13),
(1312, 'Virú ', 13),
(1401, 'Chiclayo ', 14),
(1402, 'Ferreñafe ', 14),
(1403, 'Lambayeque ', 14),
(1501, 'Lima ', 15),
(1502, 'Barranca ', 15),
(1503, 'Cajatambo ', 15),
(1504, 'Canta ', 15),
(1505, 'Cañete ', 15),
(1506, 'Huaral ', 15),
(1507, 'Huarochirí ', 15),
(1508, 'Huaura ', 15),
(1509, 'Oyón ', 15),
(1510, 'Yauyos ', 15),
(1601, 'Maynas ', 16),
(1602, 'Alto Amazonas ', 16),
(1603, 'Loreto ', 16),
(1604, 'Mariscal Ramón Castilla ', 16),
(1605, 'Requena ', 16),
(1606, 'Ucayali ', 16),
(1607, 'Datem del Marañón ', 16),
(1608, 'Putumayo', 16),
(1701, 'Tambopata ', 17),
(1702, 'Manu ', 17),
(1703, 'Tahuamanu ', 17),
(1801, 'Mariscal Nieto ', 18),
(1802, 'General Sánchez Cerro ', 18),
(1803, 'Ilo ', 18),
(1901, 'Pasco ', 19),
(1902, 'Daniel Alcides Carrión ', 19),
(1903, 'Oxapampa ', 19),
(2001, 'Piura ', 20),
(2002, 'Ayabaca ', 20),
(2003, 'Huancabamba ', 20),
(2004, 'Morropón ', 20),
(2005, 'Paita ', 20),
(2006, 'Sullana ', 20),
(2007, 'Talara ', 20),
(2008, 'Sechura ', 20),
(2101, 'Puno ', 21),
(2102, 'Azángaro ', 21),
(2103, 'Carabaya ', 21),
(2104, 'Chucuito ', 21),
(2105, 'El Collao ', 21),
(2106, 'Huancané ', 21),
(2107, 'Lampa ', 21),
(2108, 'Melgar ', 21),
(2109, 'Moho ', 21),
(2110, 'San Antonio de Putina ', 21),
(2111, 'San Román ', 21),
(2112, 'Sandia ', 21),
(2113, 'Yunguyo ', 21),
(2201, 'Moyobamba ', 22),
(2202, 'Bellavista ', 22),
(2203, 'El Dorado ', 22),
(2204, 'Huallaga ', 22),
(2205, 'Lamas ', 22),
(2206, 'Mariscal Cáceres ', 22),
(2207, 'Picota ', 22),
(2208, 'Rioja ', 22),
(2209, 'San Martín ', 22),
(2210, 'Tocache ', 22),
(2301, 'Tacna ', 23),
(2302, 'Candarave ', 23),
(2303, 'Jorge Basadre ', 23),
(2304, 'Tarata ', 23),
(2401, 'Tumbes ', 24),
(2402, 'Contralmirante Villar ', 24),
(2403, 'Zarumilla ', 24),
(2501, 'Coronel Portillo ', 25),
(2502, 'Atalaya ', 25),
(2503, 'Padre Abad ', 25),
(2504, 'Purús', 25);

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE `submenu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruta` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idmenu` int(11) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `submenu`
--

INSERT INTO `submenu` (`id`, `nombre`, `ruta`, `idmenu`, `estado`) VALUES
(1, 'CLIENTE', 'ClientController@index', 1, b'1'),
(2, 'PROVEEDOR', 'ProveedorController@index', 1, b'1'),
(3, 'ADMINISTRADOR', 'WorkerController@index', 3, b'1'),
(4, 'INICIO', 'InicioController@index', 1, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tipoproveedor`
--

CREATE TABLE `tipoproveedor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipoproveedor`
--

INSERT INTO `tipoproveedor` (`id`, `nombre`, `estado`) VALUES
(1, 'Excelente', b'1'),
(2, 'Bajo', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  `vigencia` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `nombre`, `dni`, `correo`, `telefono`, `direccion`, `estado`, `vigencia`) VALUES
(1, 'admin', '123', 'nombres y apellidos', '46153010', 'ing.cizuniga@gmail.com', '987654321', 'los olivos 123', b'1', b'1'),
(2, 'qwe1', 'qwe', 'xxxx', NULL, NULL, NULL, NULL, b'1', b'1'),
(3, 'sss', '123', 'eeee', NULL, NULL, NULL, 'ddasd 656 adads', b'1', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtipoproveedor` (`idtipoproveedor`),
  ADD KEY `iddepartamento` (`iddepartamento`),
  ADD KEY `iddistrito` (`iddistrito`),
  ADD KEY `idprovincia` (`idprovincia`);

--
-- Indexes for table `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submenu`
--
ALTER TABLE `submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
