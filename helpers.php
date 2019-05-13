<?php

/**
 * TransFecha traduce el mes de ingles a castellano.
 * 
 * @param string $date   Una fecha en string formatao '2000-02-20'
 * @param string $format Un striong con el formato
 * 
 * @return string $newDate con una fecha en string '20 Febrero'
 */
function transFecha($date, $format = 'j F')
{
    $newDate = new DateTime($date);
    $newDate = date_format($newDate, $format);
    $newDate = str_replace("January", "Enero", $newDate);
    $newDate = str_replace("February", "Febrero", $newDate);
    $newDate = str_replace("March", "Marzo", $newDate);
    $newDate = str_replace("April", "Abril", $newDate);
    $newDate = str_replace("May", "Mayo", $newDate);
    $newDate = str_replace("June", "Junio", $newDate);
    $newDate = str_replace("July", "Julio", $newDate);
    $newDate = str_replace("August", "Agosto", $newDate);
    $newDate = str_replace("September", "Septiembre", $newDate);
    $newDate = str_replace("October", "Octubre", $newDate);
    $newDate = str_replace("November", "Noviembre", $newDate);
    $newDate = str_replace("December", "Diciembre", $newDate);
    return $newDate;
}
/* *** Pasar los meses a array y foreachear *** */

/**
 * Transforma la fecha pero devuelve solo el mes
 * 
 * @param string $date Toma una fecha en formato '2000-02-20'
 * 
 * @return string una fecha en string 'Febrero'
 */
function fechaMes($date)
{
    return transFecha($date, 'F');
}

/**
 * Toma el texto de un mes y lo devuelve cortado
 * 
 * @param string $month  Un mes en formato 'Febrero'
 * @param int    $amount Numero de letras a devolver. Defecto 3
 * @param int    $start  Numero en donde empieza a devolver. Defecto 1
 * 
 * @return string El mes cortado. por defecto 'Feb'
 */
function fechaFormatoMes($month, $amount = 3, $start = 0)
{
    return mb_substr($month, $start, $amount);
}

/**
 * Transforma la fecha pero devuelve solo el dia
 * 
 * @param string $date Toma una fecha en formato '2000-02-20'
 * 
 * @return string una fecha en string '20'
 */
function fechaDia($date)
{
    return transFecha($date, 'j');
}

/**
 * Calcula el total de un curso tomando el neto y el descuento
 * 
 * @param int $precio    El precio neto del curso
 * @param int $descuento El descuento en porcentaje
 * 
 * @return string El precio y el precio con el descuento redondeado
 */
function totalCalc($precio, $descuento)
{
    $total = finalPrice($precio, $descuento);
    return $precio . '-' . $total;
}

/**
 * Calcula el total de un curso tomando el neto y el descuento
 * 
 * @param int $precio    El precio neto del curso
 * @param int $descuento El descuento en porcentaje
 * 
 * @return int El precio con el descuento redondeado
 */
function finalPrice($precio, $descuento)
{
    $total = $precio;
    if ($descuento !== 0) {
        $total = round($precio - $precio * $descuento / 100);
    }
    return $total;
}

/**
 * Formatea los texto que vienen de la API y necesitan formato
 * 
 * @param string $info Un string largo que requiere formato
 * 
 * @return string Un HTML con formatos
 */
function apiFormat($info)
{
    return blendMaker(str_replace('|', '<br>', $info));
}

/**
 * Cambia texto por HTML con funcionalidad
 * 
 * @param string $string El string que necesita formato
 * 
 * @return string con HTML necesario
 */
function blendMaker($string)
{
    $blendedTag = '<a onclick="popBlend(event)">
        <strong id="blend" class="blended-tool">BLENDED
        <i class="far fa-question-circle">
        </i></strong></a>';
    if (strpos($string, 'blend') == strpos($string, 'blended') && strpos($string, 'blended') != false ) {
        $string = str_replace('blended', $blendedTag, $string);
    } else {
        $string = str_replace('blend', $blendedTag, $string);
    }
    return $string;
}

/**
 * Toma una colleccion de Comisiones y devuelve el descuento maximo
 *
 * @param collection $collection De objs Comisiones
 * 
 * @return int $maxOff Es un numero del descuento maximo
 */
function offDiscount($collection)
{
    $maxOff = 0;
    foreach ($collection as $item) {
        if ($item->discount >= $maxOff) {
            $maxOff = $item->discount;
        }
    }
    return $maxOff;
}

/**
 * Toma un elemento para mostrar en forma de var_dump comentado en HTML
 *
 * @param any $item es un elemento a imprimir como comentario
 * 
 * @return void No devuelve nada sino que imprime
 */
function arrowify($item)
{
    echo '<!--';
    var_dump($item);
    echo '!-->';
}

/**
 * Toma un array de sedes y avisa si es partner o no.
 *
 * @param collection $places Sedes
 * 
 * @return boolean de si tiene o no sede partner
 */
function hasPartner($places)
{
    foreach ($places as $place) {
        // arrowify($place->isPartner);
        if ($place->isPartner == 1) {
            return ($place->isPartner != null && $place->isPartner == 1);
        }
    }
    return false;
}

/**
 * Toma un array de sedes y uno de comisiones y devuelve un array con las sedes que 
 * pretenecen a esas comisiones
 *
 * @param collection $allSedes  todas las sedes
 * @param collection $filterCom todas las comosiones
 * 
 * @return array de sedes filtradas
 */
function makeSedesArry( $allSedes, $filterCom )
{
    $trueSedes = [];
    $sedesExistentes = [];
    foreach ($filterCom as $com) {
        $sedesExistentes[] = $com->sede_id;
    }
    $sedesExistentes = array_unique($sedesExistentes);
    foreach ($allSedes as $sede) {
        foreach ($sedesExistentes as $sedeId) {
            if ($sede->id === $sedeId) {
                $trueSedes[] = $sede;
            }
        }
    }
    return $trueSedes;
}

/**
 * Toma un array de eventos y devuelve un array 
 * con aquellos que siguen vigentes.
 * vigentes significa que la fecha un no paso.
 * Tambien agrega un atributo $time que tiene 
 * la fecha en formato " 20 Febrero"
 *
 * @param array $events 
 * 
 * @return array de eventos vigentes
 */
function eventFilter($events)
{
    $validEvents = [];
    foreach ($events as $event) {
        $hoy = explode("T", $event->dates->dates[0]->title);
        $time = new DateTime($hoy[0]);
        $time = $time->format('Y-m-d H:i:s');;
        if ($event->type_id === 1 && !timeHasPassed($time)) {
            $time = transFecha($time);
            $event->time = $time;
            $validEvents[] = $event;
        }
    }
    return $validEvents;
}

/**
 * Toma un array de eventos y devuelve un array 
 * con aquellos que siguen vigentes.
 * vigentes significa que la fecha un no paso.
 * Tambien agrega un atributo $time que tiene 
 * la fecha en formato " 20 Febrero"
 *
 * @param array $events de eventos
 * 
 * @return array de eventos vigentes
 */
function eventHomeFilter($events)
{
    $validEvents = [];
    foreach ($events as $event) {
        $hoy = explode("T", $event['date']);
        $time = $hoy[0];
        if (!timeHasPassed($time)) {
            $time = transFecha($time);
            arrowify($time);
            $event['time'] = $time;
            $validEvents[] = $event;
        }
    }
    return $validEvents;
}

/**
 * Toma una fecha y pregunta si ya paso
 * 
 * @param int $time Fecha de un evento
 * 
 * @return boolean
 */
function timeHasPassed( $time )
{
    $time = new DateTime($time);
    $now =  new DateTime();
    date_sub($now, date_interval_create_from_date_string('1 day'));
    $time = $time->format('Y-m-d H:i:s');
    $now = $now->format('Y-m-d H:i:s');
    $between = strtotime($time) - strtotime($now);
    return $between < 0;
}

/**
 * Toma los arrays de areas y cursos y devuelve un array de areas 
 * filtradas por los cursos que hay
 * 
 * @param array $areas   This
 * @param array $courses This
 * 
 * @return array
 */
function filterAreasWithCourses($areas, $courses)
{
    $finalAreas = [];
    foreach ($areas as $area) {
        foreach ($courses as $course) {
            if ($course['area_id'] === $area['id'] ) {
                $finalAreas[] = $area;
            }
        }
    }
    $finalAreas = multiUnique($finalAreas);
    return $finalAreas;
}

/**
 * Toma un array multi-dimencional y lo devuelve con valores unicos
 * 
 * @param array $array Array Multi-dimencioanl
 * 
 * @return array
 */
function multiUnique($array)
{
    $output = array_map(
        "unserialize",
        array_unique(array_map("serialize", $array))
    );
    return $output;
}

/**
 * Pone el punto del mil
 * 
 * @param string $number un precio
 * 
 * @return string $newNumber numero con el punto cada 3
 */
function priceFormater($number)
{
    $number = strrev($number);
    $priceArr = str_split($number, 3);
    for ($i=0; $i < count($priceArr); $i++) { 
        $num = strrev($priceArr[$i]);
        $priceArr[$i] = $num;
    }
    $priceArr = array_reverse($priceArr);
    $number = implode('.', $priceArr);

    return $number;
}