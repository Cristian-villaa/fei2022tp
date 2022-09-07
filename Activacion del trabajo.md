# fei2022tp

INSTALACIÓN DE SCRIPTS DE PROYECTO CLONADO

1)Crear archivo .ENV CON LAS VARIABLES DE ENTORNO

2)INSTALAR BIN/first_start.sh

3)Instalacion de las migraciones bin/yii.sh migrate

4)iNSTALACION PARA EL FRONTEND:
 docker run --rm -v "/home/usuario/Escritorio/fei2022tp/frontend:/fei2022tp" -w "/fei2022tp" -it node:17.8.0-alpine3.14 sh -c "npm install"

