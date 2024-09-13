<?php
namespace App\Functions;

class TransformString
{

    /**
     * Analiza una cadena para convertirla en una clave, quitando espacios y convirtiendo a min sculas
     *
     * @param string $string La cadena a analizar
     *
     * @return string La cadena analizada
     */
    static  function parseStringInKey(string $string): string
    {
        $string = trim(strtolower($string));
        $string = preg_replace('/\s+/', '_', $string);
        return $string;
    }
}
