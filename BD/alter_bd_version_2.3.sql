update menus set name = 'Solicitudes de Excepción' where id = 3;
update menus set name = 'Procesar Solicitudes' where id = 8;
update menus set name = 'Contenido', slug = 'normativas' where id = 5;
INSERT INTO menus (id, parent, name, icono, slug, orden) VALUES
(9, null, 'Configuración', '', 'configuracion', 4),
(10, 9, 'Usuarios Administradores', '', 'usuarios_admin', 1);