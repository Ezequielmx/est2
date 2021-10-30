INSERT INTO `eventos` (`id`, `lugar`, `ubicacion`, `direccion`, `speach`, `precio`, `precio_esp`, `precio_prom`, `imagen`, `activo`, `created_at`, `updated_at`) VALUES (NULL, 'ROSARIO', 'qweqweqwe', 'qweqweqwe', 'qweqweqwe', 500, 300, 400, 'asdasdsa', '1', NULL, NULL), (NULL, 'CASTELAR', 'qweqweqwe', 'qweqweqwe', 'qweqweqwe', 500, 300, 400, 'asdasdsa', '1', NULL, NULL)


INSERT INTO `temas` (`id`, `titulo`, `descripcion`, `imagen`, `video`, `duracion`, `created_at`, `updated_at`) VALUES (NULL, 'DINOSAURIOS', 'dinos asd asdasdasd', 'img/dinos.jpg', 'vid/dinos.mp4', '35', NULL, NULL), (NULL, 'UNIVERSO', 'universo para toda la familia', 'img/universo.jpg', 'vid/universo.mp4', '45', NULL, NULL);

INSERT INTO 
`funciones` (`id`, `evento_id`, `tema_id`, `fecha`, `horario`, `capacidad`, `created_at`, `updated_at`) 
VALUES 
(NULL, '2', '1', '2021-10-30', '12:00', '60', NULL, NULL), 
(NULL, '2', '2', '2021-10-30', '13:00', '70', NULL, NULL),
(NULL, '2', '1', '2021-10-30', '14:00', '60', NULL, NULL), 
(NULL, '2', '2', '2021-10-30', '14:00', '70', NULL, NULL),
(NULL, '1', '1', '2021-10-31', '12:00', '60', NULL, NULL), 
(NULL, '1', '2', '2021-10-31', '13:00', '70', NULL, NULL),
(NULL, '1', '1', '2021-10-31', '14:00', '60', NULL, NULL), 
(NULL, '1', '2', '2021-10-31', '14:00', '70', NULL, NULL)



INSERT INTO 
`reservas` (`id`, `usuario`, `telefono`, `codigo_res`, `importe`, `cant_adul`, `cant_esp`, `wppconf`, `wpprecord`, `created_at`, `updated_at`) 
VALUES (NULL, 'andrea', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'martin', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'jose', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'pedrito', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'juan', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'paula', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'marcela', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'rogelio', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'marcos', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL),
(NULL, 'piouyh', '1160208707', '1-123', '800', '1', '2', '0', '0', NULL, NULL)


INSERT INTO `funcione_reserva` (`id`, `funcione_id`, `reserva_id`, `created_at`, `updated_at`) 
VALUES 
(NULL, '2', '3', NULL, NULL),
(NULL, '2', '1', NULL, NULL),
(NULL, '1', '2', NULL, NULL),
(NULL, '5', '2', NULL, NULL),
(NULL, '6', '3', NULL, NULL),
(NULL, '7', '3', NULL, NULL),
(NULL, '8', '4', NULL, NULL),
(NULL, '8', '5', NULL, NULL),
(NULL, '3', '5', NULL, NULL),
(NULL, '3', '6', NULL, NULL),
(NULL, '4', '7', NULL, NULL),
(NULL, '1', '8', NULL, NULL),
(NULL, '2', '8', NULL, NULL),
(NULL, '2', '9', NULL, NULL),
(NULL, '7', '10', NULL, NULL),
(NULL, '7', '1', NULL, NULL),
(NULL, '8', '2', NULL, NULL)

