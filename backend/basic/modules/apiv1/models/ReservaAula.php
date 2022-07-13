<?php

namespace app\modules\apiv1\models;

class Reserva_aula extends \app\models\ReservaAula
{
    public function fields(){
    return ['id','id_aula','fh_desde','observacion'];
    }


}