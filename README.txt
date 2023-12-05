Proyecto Taller de Programación 2023-II
CASO: SISTEMA DE PRESTAMOS BIBLIOTECA MUNICIPAL ESTACIÓN CENTRAL (BEC)

Grupo: Breaking Good

Integrantes:
    -Diego Rivera Jara
    -Benjamín Zunino Núñez
    -Ignacio Maldonado Faúndes
    -Carlos Lagos Cortés
    -José Pinto Muñoz


Tecnologías a usadas en el desarrollo:
    -Oracle Database 21c Express Edition for Windows x64
    -sqldeveloper 23.1.0 (JRE o NO JRE)
    -Xampp Windows x64 8.0.30
    -JDK-11.0.21 (Obligatorio, en caso de usar sqldeveloper NO JRE)
    -Instantclient Basic Windows x64 21.12.0 (Obligatorio, en caso de usar sqldeveloper JRE)


Replicacón del proyecto:
    -El proyecto está pensado para ser utilizado en AWS, pero dado los costos se dejan instrucciones para ejecutar en localhost.

    -En caso de usar sqldeveloper JRE se debe configurar instantclient, para aquello dirigirse al archivo "C:\xampp\php\php.ini" y modificar lo siguiente:

        ;extension=oci8_12c  ; Use with Oracle Database 12c Instant Client
        ;extension=oci8_19  ; Use with Oracle Database 19 Instant Client

                        ||||
                        ||||
                        ||||
                        ||||
                      ||||||||
                       ||||||
                        ||||
                         ||

        extension=oci8_12c  ; Use with Oracle Database 12c Instant Client
        ;extension=oci8_19  ; Use with Oracle Database 19 Instant Client   

                        O (Puede haber diferencias según el sistema)                    (Notar el cambio de ";")

        ;extension=oci8_12c  ; Use with Oracle Database 12c Instant Client
        extension=oci8_19  ; Use with Oracle Database 19 Instant Client   

        Luego asegurarse que en las variables de entorno del sistema esten:
            -ORACLE_HOME
            -TNS_ADMIN

        Si no lo están, abrir cmd con permisos de administrador y ejcutar:
            -  set ORACLE_HOME=C:\instantclient
            -  set TNS_ADMIN=C:\instantclient

        Siendo C:\instantclient la ubicación de la carpeta instantclient con sus dependencias correspondientes

    -En caso de usar sqldeveloper NO JRE, al primer inicio solicitará una ruta al JDK, que idealmente debe estar ubicada en:
     "C:\Program Files\Java"
            
    -Los archivos de programa de la carpeta contenedora del entregable, deben ser colocados en "C:\xampp\htdocs" 
    
    -Para realizar la ejecucion, dirigirse a "conexion.php" en la raíz de la capeta contenedora y modificar las siguientes
     variables:

        Valores por defecto:
            $usuario_bd = 'admin'; 
            $clave_bd = 'push1234'; 
            $host_bd = 'database-1.cgklsm5ek2li.us-east-2.rds.amazonaws.com'; 
            $puerto_bd = '1521'; 
            $sid_bd = 'ORCL'; 

        Valores a modificar:
            $usuario_bd = 'xxxx';     -> Normalmente es "system"
            $clave_bd = 'xxxxxxx';    -> Depende de la instalación de Oracle Database en el equipo
            $host_bd = 'localhost'; (O la IP que aparezca en tnsnames.ora y listener.ora (Archivos de instalación de Oracle Database en 
                                    "C:\app\[nombreUsuarioSistema]\product\21c\homes\OraDB21Home1\network\admin") 
                                    de preferencia cambiarla a localhost en ambos archivos si hay diferencias y reiniciar los listener de Oracle
                                    y las BBDD de Oracle para que existan cambios)
            $puerto_bd = '1521'; 
            $sid_bd = 'xxxx';    -> Depende de la instalación de Oracle Database en el equipo, ver tnsnames.ora o en su defecto listener.ora, por defecto es "XE"
    
    -Para conectarse a la BBDD en sqldeveloper se debe crear una conexion manualmente con los mismos datos que se colocaron en "conexion.php"
     De preferencia usar SID en ves de Nombre de Servicio (Puede configurarse en tnsnames.ora)

    -Una vez conectado en la BBDD, se debe realizar la creacion de las tablas, sus secuencias autoincrementales e insertar los ejemplos
     (Dichas Querys estarán en el archivo querys.txt)

     En caso de tener problemas con las tablas, conisderar lo siguiente: (Se recomineda realizar antes de la ejecución)
            REVISAR RESTRICCIONES EN SQLDEVELOPER EN CASO DE ERRORES:

            Que diga ELIMINADA/DESHABILITADA no implica eliminar la columna de la tabla, sino eliminar o deshabilitar la restriccion.

            CUENTAS_PERSONAL: PK (IDCUENTA) HABILITADA 
            CUENTAS_USUARIO: PK (RUT) HABILITADA LISTO
            DETALLE_SOLICITUD_PRESTAMO: FKs (IDSOLICITUD, IDEJEMPLAR) HABILITADAS 
            DOCUMENTO: PK (IDENTIFICADOR) DESHABILITADA
            EJEMPLAR: PK (IDEJEMPLAR) HABILITADA, FK (IDDOCUMENTO) ELIMINADA/DESHABILITADA
            PRESTAMO: PK (IDPRESTAMO) ELIMINADA/DESHABILITADA, FK (IDEJEMPLAR) HABILITADA
            SOLICITUD_PRESTAMO: PK (IDSOLICITUD) Y FK (IDUSUARIO) HABILITADAS 
            USUARIO: PK(IDENTIFICADOR) HABILITADA

     Modificar en sqldeveloper para que se cumpla lo anterior
        
    -Finalmente, para ejecutar el programa se debe iniciar Xampp Control Panel y encender Apache en los puertos definidos por defecto,
     y luego dirigirse al navegador web de preferencia y colocar localhost en la URL

     En este momento deberías estar viendo el menú principal del programa, completamente operativo

Notas sobre el Funcionamineto del Proyecto:
    
    -Para entrar como usuario común, solo basta registrarse y después loguearse para realizar las solicitudes

    -Para entrar como admin de biblioteca o bibliotecario se debe crear un registro para cada tipo de usuario en la Tabla: CUENTAS_PERSONAL
     indicando en la columna TIPO_CUENTA "admin" o "bibliotecario" para cada usuario respectivamente

    -Los filtros pueden usarse combinados o en solitario (Son key-sensitive)

    -La búsqueda de documentos por filtro incluye una barra de búsqueda (Key-sensitive) por título del documento

    -Se deben agregar al carrito los documentos, una vez se esté satisfecho se manda la solicitudes

    -El bibliotecario procesa la solicitud y las devoluciones, tambien puede modificar documentos y eliminarlos

    -El administrador de biblioteca puede consultar el catalogo, administra fichas de usuario y revisa prestamos vencidos

Casos de uso abordados: 

    -CU1
    -CU2
    -CU3
    -CU6
    -CU7
    -CU8
    -CU9
    -CU10
    -CU13
    -CU15
    -CU16