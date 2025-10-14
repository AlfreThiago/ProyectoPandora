<?php

class DateHelper
{
    // Meses y días abreviados en español
    private static array $mes = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
    private static array $dia = ['dom','lun','mar','mié','jue','vie','sáb'];

    /**
     * Devuelve un texto "amigable":
     * - < 60s: "hace Ns"
     * - < 1h:  "hace Nm"
     * - < 24h: "hace Nh"
     * - < 48h: "ayer HH:MM"
     * - < 7d:  "lun HH:MM" (día de semana)
     * - otro:  "dd mes yyyy HH:MM"
     */
    public static function smart(?string $iso): string
    {
        if (!$iso) return '—';
        $ts = strtotime($iso);
        if ($ts === false) return '—';
        $now = time();
        $diff = $now - $ts;
        if ($diff < 0) $diff = 0; // por si viene futuro

        if ($diff < 60) return 'hace ' . $diff . 's';
        if ($diff < 3600) return 'hace ' . floor($diff/60) . 'm';
        if ($diff < 86400) return 'hace ' . floor($diff/3600) . 'h';

        // Ayer
        $hoyY = (int)date('Y', $now); $hoym = (int)date('m', $now); $hoyd = (int)date('d', $now);
        $ayer = mktime(0,0,0,$hoym,$hoyd-1,$hoyY);
        if ($ts >= $ayer && $ts < $ayer + 86400) {
            return 'ayer ' . date('H:i', $ts);
        }

        if ($diff < 7*86400) {
            $dow = (int)date('w', $ts); // 0=dom
            return self::$dia[$dow] . ' ' . date('H:i', $ts);
        }

        $d = (int)date('d', $ts);
        $m = (int)date('n', $ts); // 1..12
        $y = date('Y', $ts);
        return sprintf('%02d %s %s %s', $d, self::$mes[$m-1], $y, date('H:i', $ts));
    }

    /**
     * Fecha exacta estándar: dd/mm/yyyy HH:MM
     */
    public static function exact(?string $iso): string
    {
        if (!$iso) return '—';
        $ts = strtotime($iso);
        if ($ts === false) return '—';
        return date('d/m/Y H:i', $ts);
    }
}

?>
