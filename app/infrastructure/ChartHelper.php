<?php

namespace app\infrastructure;

class ChartHelper
{
    public static function getCoordinates($data, $reduce = true)
    {
        $coordinates = [];
        $counter = 1;
        foreach ($data as $drug) {
            $y = ($counter / count($data)) * 100;
            $coordinates[] = ['x' => (int)$drug, 'y' => $y];
            $counter++;
        }
        $coordinates[] = ['x' => 0, 'y' => 100];
        if ($reduce) {
            $coordinates = self::reduceCoordsArray($coordinates);
        }
        return $coordinates;
    }

    public static function reduceCoordsArray($array)
    {
        $cycles = 0;
        $count = count($array);
        while ($count > 1000) {
            $count = $count/2;
            $cycles++;
        }
        for ($i = 0; $i < $cycles; $i++) {
            $newArray = [];
            $index = 0;
            foreach ($array as $value) {
                if (isset($array[$index])) {
                    if (isset($array[$index + 1])) {
                        $newElement = [
                            'x' => ($array[$index]['x'] + $array[$index + 1]['x']) / 2,
                            'y' => ($array[$index]['y'] + $array[$index + 1]['y']) / 2
                        ];
                    } else {
                        $newElement = $array[$index];
                    }
                    $newArray[] = $newElement;
                    $index += 2;
                }
            }
            $array = $newArray;
        }
        return $array;
    }

}