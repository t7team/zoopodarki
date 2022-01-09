<?php

namespace App\Traits;

trait Delivery
{
    private $kadSpb = [[59.920246038, 30.526355561], [59.903690554, 30.52674064], [59.887471304, 30.524722459], [59.878583408, 30.530408163], [59.873363147, 30.53273603], [59.86900378, 30.531287348], [59.866065809, 30.529495342], [59.86261046, 30.522896818], [59.854836627, 30.508326479], [59.852174993, 30.474336367], [59.8476539, 30.460688708], [59.84054497, 30.455280795], [59.826840237, 30.437941836], [59.820034355, 30.414079746], [59.817142665, 30.392812777], [59.815113835, 30.369829195], [59.814379584, 30.353025422], [59.810387118, 30.340675324], [59.809847296, 30.327295258], [59.820979965, 30.301927459], [59.833834189, 30.277932951], [59.83304674, 30.264016443], [59.828635922, 30.244606771], [59.823879373, 30.226055406], [59.818604343, 30.214370495], [59.812681112, 30.201054802], [59.809174026, 30.18293259], [59.801176878, 30.17116185], [59.798359415, 30.157331172], [59.812042396, 30.115226389], [59.814393869, 30.070141404], [59.813292767, 30.024369774], [59.820780298, 29.990725663], [59.820554059, 29.963947247], [59.815840101, 29.937168831], [59.812074985, 29.919145146], [59.811417093, 29.896314942], [59.814589759, 29.847907952], [59.825269646, 29.825765152], [59.845270949, 29.809887234], [59.855784327, 29.801948275], [59.861812859, 29.789889443], [59.867652223, 29.767059998], [59.868331122, 29.74380064], [59.873835196, 29.721914574], [59.881567536, 29.692690742], [59.893087042, 29.664840202], [59.906334546, 29.659154678], [59.917855937, 29.662395546], [59.94260636, 29.674370445], [59.978999858, 29.688363884], [59.99838333, 29.699480476], [60.014667061, 29.720896751], [60.021513664, 29.735022002], [60.021154468, 29.77867301], [60.029698753, 29.86528838], [60.035411569, 29.938342502], [60.038867722, 29.973152949], [60.04095195, 30.011053301], [60.059570279, 30.144801925], [60.063695854, 30.163280032], [60.070390452, 30.174548361], [60.077854359, 30.184615061], [60.082919431, 30.199144956], [60.085030313, 30.22345955], [60.088739421, 30.237505122], [60.092276929, 30.245714208], [60.095728476, 30.256326552], [60.098495069, 30.267968865], [60.0996356, 30.283988543], [60.098380071, 30.296231671], [60.095561302, 30.317802734], [60.094282875, 30.355509967], [60.091589476, 30.36904208], [60.086327759, 30.37708103], [60.070663369, 30.382859247], [60.062635631, 30.387507884], [60.056319674, 30.393529813], [60.0496838, 30.414843384], [60.047093893, 30.426701799], [60.043475184, 30.435813632], [60.02843362, 30.448029151], [60.018071478, 30.458613886], [60.015823595, 30.466839064], [60.012545998, 30.472660984], [60.006264707, 30.477109612], [60.000840519, 30.476408399], [59.996338236, 30.477938784], [59.992350447, 30.480499137], [59.986090809, 30.490083039], [59.982492252, 30.504473459], [59.980095679, 30.521953785], [59.975251019, 30.539176618], [59.972398914, 30.546243082], [59.969031101, 30.55124961], [59.96347192, 30.554367863], [59.95842744, 30.552679597], [59.949195813, 30.543123255], [59.933993076, 30.537743482], [59.926948229, 30.53307949], ];

    public function getDeliveryCostsByBoxberry($totalWeight, $zip)
    {
        $boxberryToken = config('constants.boxberry_token');

        if ($this->checkZip($zip, $boxberryToken)) {
            $url = 'http://api.boxberry.ru/json.php?token='
            . $boxberryToken
            . '&method=DeliveryCosts&weight='
            . $totalWeight
            . '&target=010&targetstart=010&zip='
            . $zip;

            $handle = fopen($url, 'rb');
            $contents = stream_get_contents($handle);
            fclose($handle);
            $data = json_decode($contents, true);

            if (count($data) <= 0 || array_key_exists('err', $data)) {
                logger($data['err']);
            } else {
                logger($data);
            }
        }
    }

    public function checkZip($zip, $boxberryToken)
    {

        // TODO неработает, возможно заблокировали
        $url = 'https://api.boxberry.ru/json.php?token=' . $boxberryToken . '&method=ZipCheck&Zip=' . $zip;

        $handle = fopen($url, 'rb');
        $contents = stream_get_contents($handle);
        fclose($handle);
        $data = json_decode($contents, true);

        if (count($data) <= 0 || array_key_exists('err', $data)) {
            logger($data['err']);

            return false;
        } else {
            logger($data);

            return true;
        }
    }

    public function checkIfAddressInCad($latTo, $lngTo)
    {
        $point = [[$latTo, $lngTo]];

        if ($this->pointInPolygon($point, $this->kadSpb) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function getDeliveryCostsByStore($amount, $latTo, $lngTo)
    {
        $point = [[$latTo, $lngTo]];

        if ($this->pointInPolygon($point, $this->kadSpb) === false) {
            return 999999;
        }

        $distans = $this->getDistance($latTo, $lngTo);

        //Zone 1 Радиус 1.5 до 3 км
        if ($distans <= 1500) {
            if ($amount >= 1000) {
                // бесплатная доставка от 1000 руб.,
                return 0;
            } else {
                // если меньше 1000, то доставка стоит 300 руб.
                return 300;
            }
        }

        //Zone 2 Радиус 1.5-10 км
        if ($distans >= 1500 && $distans < 10000) {
            if ($amount >= 1500) {
                // бесплатная доставка от 1500,
                return 0;
            } else {
                // если меньше 1500, то доставка стоит 300 руб.
                return 300;
            }
        }

        //Zone 3 Радиус 10-15 км
        if ($distans >= 10000 && $distans < 15000) {
            if ($amount >= 2000) {
                // бесплатная доставка от 2000,
                return 0;
            } else {
                // если меньше 2000, то доставка стоит 500 руб.
                return 500;
            }
        }

        //Zone 4 Радиус от 15 км
        if ($distans >= 15000) {
            if ($amount >= 3500) {
                // бесплатная доставка от 3500,
                return 0;
            } else {
                // если меньше 3500, то доставка стоит 700 руб.
                return 700;
            }
        }
    }

    public function getDistance($latTo, $lngTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad(config('constants.lat_departure'));
        $lngFrom = deg2rad(config('constants.lng_departure'));
        $latTo = deg2rad($latTo);
        $lngTo = deg2rad($lngTo);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));

        return intval($angle * $earthRadius);
    }

    public function pointInPolygon($p, $polygon)
    {
        //if you operates with (hundred)thousands of points
        $p = $p[0];
        $c = 0;
        $p1 = $polygon[0];
        $n = count($polygon);
        $found = false;
        for ($i = 1; $i <= $n; $i++) {
            $p2 = $polygon[$i % $n];

            if ($p[1] > min($p1[1], $p2[1])
            && ($p[1] <= max($p1[1], $p2[1]))
            && ($p[0] <= max($p1[0], $p2[0]))
            && ($p1[1] != $p2[1])) {
                $xinters = ($p[1] - $p1[1]) * ($p2[0] - $p1[0]) / ($p2[1] - $p1[1]) + $p1[0];

                if ($p1[0] == $p2[0] || $p[0] <= $xinters) {
                    $c++;
                }
            }

            $p1 = $p2;
        }
        // if the number of edges we passed through is even, then it's not in the poly.
        return $c % 2 != 0; // here is modified code. before was: $c%2!=0; I do not know why, but now works fine! //$c == 2
    }
}
