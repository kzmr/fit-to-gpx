<?php
/**
 * FitToGpx
 */
class FitToGpx
{
    protected $pFFA;
    protected $errorMessage;

    public function __construct($input_fit_file){
        try {
            $this->pFFA = new adriangibbons\phpFITFileAnalysis($input_fit_file);
        } catch ( Exception $ex ) {
            $this->errorMessage = $ex->getMessage();
        }
    }

    public function getError()
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        return null;
    }

    public function saveAsGpx($output_gpx_file)
    {
        $rootNode = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="no"?><gpx xmlns="http://www.topografix.com/GPX/1/1" version="1.1"></gpx>');
        $trkNode = $rootNode->addChild('trk');
        $trksegNode = $trkNode->addChild('trkseg');

        try {
            foreach ($this->pFFA->data_mesgs['record']['timestamp'] as $timestamp) {
                $trkptNode = $trksegNode->addChild('trkpt');
                $trkptNode->addAttribute('lat', $this->pFFA->data_mesgs['record']['position_lat'][$timestamp]);
                $trkptNode->addAttribute('lon', $this->pFFA->data_mesgs['record']['position_long'][$timestamp]);
                $trkptNode->addChild('ele', $this->pFFA->data_mesgs['record']['altitude'][$timestamp]);
                $trkptNode->addChild('time', date('Y-m-d\TH:i:s.000\Z', $timestamp));
            }
            file_put_contents($output_gpx_file, $rootNode->asXML());
        } catch ( Exception $ex ) {
            $this->errorMessage = $ex->getMessage();
        }
    }
}