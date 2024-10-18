<?php
require_once './config.php';

class Model
{
  protected $db;

  public function __construct()
  {
    require_once './config.php';
    $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    $this->deploy();
  }

  function deploy()
  {
    // Chequear si hay tablas
    $query = $this->db->query('SHOW TABLES');
    $tables = $query->fetchAll();

    if (count($tables) == 0) {
      // Si no hay tablas, crearlas
        $sql = <<<SQL
      
            SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
            START TRANSACTION;
            SET time_zone = "+00:00";


            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
            /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
            /*!40101 SET NAMES utf8mb4 */;

            --
            -- Base de datos: `via_tandil`
            --

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `destinos`
            --

            CREATE TABLE `destinos` (
              `destino` varchar(40) NOT NULL,
              `id` int(11) NOT NULL,
              `imagen_destino` text NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `destinos`
            --

            INSERT INTO `destinos` (`destino`, `id`, `imagen_destino`) VALUES
            ('roma', 1, 'https://wayfarer.travel/wp-content/uploads/2018/06/Colloseum-Rome-iStock-622806180-EDITED.jpg');

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `usuarios`
            --

            CREATE TABLE `usuarios` (
              `nombre_usuario` varchar(30) DEFAULT NULL,
              `clave_usuario` varchar(255) DEFAULT NULL,
              `id` int(11) NOT NULL,
              `rol` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `usuarios`
            --

            INSERT INTO `usuarios` (`nombre_usuario`, `clave_usuario`, `id`, `rol`) VALUES
            ('webadmin', 'admin', 1, 1),
            ('juan', '1234', 2, 0),
            ('pablo', '3030', 3, 0),
            ('pepe', '2345', 4, 0),
            ('pepe', '2345', 5, 0);

            -- --------------------------------------------------------

            --
            -- Estructura de tabla para la tabla `viajes`
            --

            CREATE TABLE `viajes` (
              `id` int(11) NOT NULL,
              `fecha` date NOT NULL,
              `hora` time(4) NOT NULL,
              `id_destinos` int(11) NOT NULL,
              `id_usuarios` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            --
            -- Volcado de datos para la tabla `viajes`
            --

            INSERT INTO `viajes` (`id`, `fecha`, `hora`, `id_destinos`, `id_usuarios`) VALUES
            (18, '2024-09-16', '12:55:00.0000', 1, 2),
            (19, '2025-12-21', '23:30:00.0000', 1, 3);

            --
            -- Índices para tablas volcadas
            --

            --
            -- Indices de la tabla `destinos`
            --
            ALTER TABLE `destinos`
              ADD PRIMARY KEY (`id`);

            --
            -- Indices de la tabla `usuarios`
            --
            ALTER TABLE `usuarios`
              ADD PRIMARY KEY (`id`);

            --
            -- Indices de la tabla `viajes`
            --
            ALTER TABLE `viajes`
              ADD PRIMARY KEY (`id`),
              ADD KEY `id_destinos` (`id_destinos`),
              ADD KEY `id_usuarios` (`id_usuarios`);

            --
            -- AUTO_INCREMENT de las tablas volcadas
            --

            --
            -- AUTO_INCREMENT de la tabla `destinos`
            --
            ALTER TABLE `destinos`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

            --
            -- AUTO_INCREMENT de la tabla `usuarios`
            --
            ALTER TABLE `usuarios`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

            --
            -- AUTO_INCREMENT de la tabla `viajes`
            --
            ALTER TABLE `viajes`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

            --
            -- Restricciones para tablas volcadas
            --

            --
            -- Filtros para la tabla `viajes`
            --
            ALTER TABLE `viajes`
              ADD CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`),
              ADD CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`id_destinos`) REFERENCES `destinos` (`id`);
            COMMIT;

                            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
                            /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
                            /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


        SQL;

        $this->db->exec($sql);
    }
  }
}