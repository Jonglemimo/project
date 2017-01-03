<?php

namespace Controller;
use \Model\ApiModel;


class ApiController {
    private $transcodeResult = false;
    private $request     = false;
    private $usersFolder = false;
    private $ffmpegBin   = false;
    private $ffprobeBin  = false;
    private $transcodeId = false;



    function __construct() {
        $this->request = new ApiModel();
        $os = new \Tivie\OS\Detector();

        $ds = DIRECTORY_SEPARATOR;

        putenv('TMPDIR='.dirname(dirname(dirname(__FILE__))).$ds.'php-tmp');
        $ffmpegPath = dirname(dirname(dirname(__FILE__))).$ds.'bin';
        $this->usersFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.DIRECTORY_SEPARATOR.'users'.$ds;


        if($os->getType() == 33) {
            //OSX
            $this->ffmpegBin = $ffmpegPath.$ds.'osx'.$ds.'ffmpeg';
            $this->ffprobeBin = $ffmpegPath.$ds.'osx'.$ds.'ffprobe';
        } else if($os->getType() == 10) {
            if(PHP_INT_SIZE == 8) {
                // Windows 64
                $this->ffmpegBin = $ffmpegPath.$ds.'windows'.$ds.'64'.$ds.'ffmpeg.exe';
                $this->ffprobeBin = $ffmpegPath.$ds.'windows'.$ds.'64'.$ds.'ffprobe.exe';

            } else {
                // Windows 32
                $this->ffmpegBin = $ffmpegPath.$ds.'windows'.$ds.'32'.$ds.'ffmpeg.exe';
                $this->ffprobeBin = $ffmpegPath.$ds.'windows'.$ds.'32'.$ds.'ffprobe.exe';
            }
        } else {
            //unknown
        }
    }

    function transcode() {


        if(!$this->request->checkCurrentTranscoding()) {
            $this->transcodeResult = $this->request->getNextNotTranscoded();

            if($this->transcodeResult) {

                $this->request->setTable('video');
                $this->request->update([
                    'encoding' => 2
                ], $this->transcodeResult['id']);


                if(!$this->ffprobeBin || !$this->ffmpegBin){
                    return false;
                }

                $ffmpeg = \FFMpeg\FFMpeg::create(array(
                    'ffmpeg.binaries' => $this->ffmpegBin,
                    'ffprobe.binaries' => $this->ffprobeBin,
                    'ffmpeg.threads'   => 4
                ));

                $file = $this->usersFolder.$this->transcodeResult['id_user'].DIRECTORY_SEPARATOR.$this->transcodeResult['shortTitle'].DIRECTORY_SEPARATOR.$this->transcodeResult['url'];
                $info = pathinfo($file);

                $output = dirname($file).DIRECTORY_SEPARATOR.$info['filename'].'.webm';

                $video = $ffmpeg->open($file);

                $format = new \FFMpeg\Format\Video\WebM();

                $this->request->setTable('transcode');

                $this->transcodeId = $this->request->insert([
                    'percentage' => 0,
                    'id_video'  => $this->transcodeResult['id']
                ]);
                $this->transcodeId = $this->transcodeId['id'];


                $format->on('progress', function ($video, $format, $percentage) {

                   $this->request->update([
                       'percentage' => $percentage,
                       'id_video'   => $this->transcodeResult['id']
                   ],$this->transcodeId);
                });

                $video->save($format, $output);



                $this->request->delete($this->transcodeId);

                $this->request->setTable('video');
                $this->request->update([
                    'encoding' => 1,
                    'url' => $info['filename'].'.webm'
                ],$this->transcodeResult['id']);

                unlink($file);

            }
        }
    }

    public function getPercentage($id) {

        $this->request->setTable('video');
        $video = $this->request->find($id);

        if($video && isset($_SESSION['user']) && $_SESSION['user']['id'] == $video['id_user']){
            $percentage = 0;
            if($video['encoding'] == 1){
                $percentage = 100;
            } else if ($video['encoding'] == 2){
                $this->request->setTable('transcode');
                $this->request->setPrimaryKey('id_video');

                $encoding = $this->request->find($id);
                if($encoding){
                    $percentage = $encoding['percentage'];
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'id_video'   => $id,
                'percentage' => $percentage
            ));
        } else {
            $controller = new \W\Controller\Controller();
            $controller->showNotFound();
        }
    }

    public function deleteTokens() {

        $this->request->setTable('recoverytokens');
        $dateTokens = $this->request->findAll();

        if(count($dateTokens) > 0){
            foreach ($dateTokens as $dateToken){
                $timenow = time();
                $checktime = strtotime($dateToken['date_created']);
                if($checktime <= ($timenow - 1800)) {
                    $this->request->delete($dateToken['id']);
                }
            }
        }
    }
}