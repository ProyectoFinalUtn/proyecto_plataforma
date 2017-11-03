update menus set name = 'Solicitudes de Excepción' where id = 3;
update menus set name = 'Procesar Solicitudes' where id = 8;
update menus set name = 'Contenido', slug = 'normativas' where id = 5;
INSERT INTO menus (id, parent, name, icono, slug, orden) VALUES
(9, null, 'Configuración', '', 'configuracion', 4),
(10, 9, 'Usuarios Administradores', '', 'usuarios_admin', 1);
update menus set icono = 'fa d-inline fa-lg fa-2x fa-clone' where id = 1;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-address-book-o' where id = 2;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-inbox' where id = 3;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-map-o' where id = 4;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-file-text-o' where id = 5;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-calendar-o' where id = 6;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-area-chart' where id = 7;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-retweet' where id = 8;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-cog' where id = 9;
update menus set icono = 'fa d-inline fa-lg fa-2x fa-user' where id = 10;