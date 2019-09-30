<?php

require __DIR__.'/vendor/autoload.php';

/**
 * FitToGpx
 */
class FitToGpx
{

    protected $pFFA;

    public function __construct($input_fit_file){
        $this->pFFA = new phpFITFileAnalysis($input_fit_file);
    }

    public function saveAsGpx($output_gpx_file)
    {
        $rootNode = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="no"?><gpx xmlns="http://www.topografix.com/GPX/1/1" version="1.1"></gpx>');
        $trkNode = $rootNode->addChild('trk');
        $trksegNode = $trkNode->addChild('trkseg');

        foreach ($this->pFFA->data_mesgs['record']['timestamp'] as $timestamp) {
            $trkptNode = $trksegNode->addChild('trkpt');
            $trkptNode->addAttribute('lat', $this->pFFA->data_mesgs['record']['position_lat'][$timestamp]);
            $trkptNode->addAttribute('lon', $this->pFFA->data_mesgs['record']['position_long'][$timestamp]);
            $trkptNode->addChild('ele', $this->pFFA->data_mesgs['record']['altitude'][$timestamp]);
            $trkptNode->addChild('time', date('Y-m-d\TH:i:s.000\Z', $timestamp));
        }

        file_put_contents($output_gpx_file, $rootNode->asXML());
    }
}
