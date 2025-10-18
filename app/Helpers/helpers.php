<?php

/**
 * Fichier de fonctions helper globales
 * 
 * Ce fichier contient des fonctions utilitaires qui peuvent être utilisées
 * partout dans l'application Laravel.
 */

if (!function_exists('format_date')) {
    /**
     * Formate une date selon le format français
     *
     * @param string|\DateTime $date
     * @param string $format
     * @return string
     */
    function format_date($date, string $format = 'd/m/Y'): string
    {
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        
        return $date->format($format);
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Tronque un texte à une longueur donnée
     *
     * @param string $text
     * @param int $length
     * @param string $suffix
     * @return string
     */
    function truncate_text(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        
        return mb_substr($text, 0, $length) . $suffix;
    }
}
