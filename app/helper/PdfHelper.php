<?php

use Barryvdh\DomPDF\Facade\Pdf as PDF;

if (!function_exists('setPdfMemoryLimit')) {
    /**
     * Set memory limit untuk generate PDF
     * 
     * @param string $limit Default 512M
     * @return void
     */
    function setPdfMemoryLimit($limit = '512M')
    {
        ini_set('memory_limit', $limit);
        ini_set('max_execution_time', '300');
    }
}

if (!function_exists('generatePdfOptions')) {
    /**
     * Get default PDF options untuk DomPDF
     * 
     * @return array
     */
    function generatePdfOptions()
    {
        return [
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'chroot' => public_path(),
            'dpi' => 96,
            'defaultFont' => 'Arial',
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => false,
        ];
    }
}

if (!function_exists('createPdfWithOptions')) {
    /**
     * Create PDF dengan options yang sudah di-set
     * 
     * @param string $view
     * @param array $data
     * @param string|array $paper Default 'a4', bisa custom array [width, height] dalam mm
     * @param string $orientation Default 'portrait'
     * @return \Barryvdh\DomPDF\PDF
     */
    function createPdfWithOptions($view, $data, $paper = 'a4', $orientation = 'portrait')
    {
        setPdfMemoryLimit();
        
        // Convert mm to points (1mm = 2.83465 points)
        if (is_array($paper)) {
            $paper = [
                0,
                0,
                $paper[0] * 2.83465, // width in points
                $paper[1] * 2.83465  // height in points
            ];
        }
        
        $pdf = PDF::loadView($view, $data)->setPaper($paper, $orientation);
        
        foreach (generatePdfOptions() as $key => $value) {
            $pdf->setOption($key, $value);
        }
        
        return $pdf;
    }
}
