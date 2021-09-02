<?php
    class Calendario {

        public function dia_mes($mes, $ano){
            return cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        }

        public function dia_semana($dia, $mes, $ano){
            $dia = GregorianToJD($mes, $dia, $ano);
            return JDDayOfWeek($dia, 0);
        }

        public function dia_anterior($mes, $ano){
            $mes = $mes == 1 ? 12 : $mes-1;
            $ano = $mes == 12 ? $ano-1 : $ano;

            return $this->dia_mes($mes, $ano);
        }

        public function montar($mes, $ano){
            $quant_dia  = $this->dia_mes($mes, $ano);
            $quant_ant = $this->dia_anterior($mes, $ano);
            $semana_inicio = $this->dia_semana(1, $mes, $ano);
            $semana_final = $this->dia_semana($quant_dia, $mes, $ano);

            $array_dia = [];
            for($i=1;$i<=$quant_dia;$i++) $array_dia[] = $i;
            $array_ant = [];
            for($i=1;$i<=$semana_inicio;$i++) $array_ant[] = $quant_ant--;
            $array_ant = array_reverse($array_ant);
            $array_pos = [];
            for($i=1;$i<=6-$semana_final;$i++) $array_pos[] = $i;
            return [
                'anterior' => $array_ant,
                'mes' => $array_dia,
                'proximo' => $array_pos
            ];
        }
    }
