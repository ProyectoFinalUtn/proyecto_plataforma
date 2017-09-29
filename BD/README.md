# proyecto_app
En esta carpeta van todos los  archivos SQL de la base de datos
En el archivo tablas, va la base de datos completa, cada tabla que creemos se debe agregar a ese archivo 
Tambien cada tabla nueva se debe poner en un archivo alter versionado, parar ir updeteando nuestra base de datos actual
Ejemplo: Ayer esteban se instalo la bd, yo hoy cambie unos campos entonces tendria que correr el alter_bd_version_1.1.sql para updetear su bd y que le ande todo.
Si otro hiciera otro cambio en la bd debe crear un nuevo alter_bd_version_1.2.sql
Los archivos alters se pueden ir borrando una vez que todos los hayan corrido
