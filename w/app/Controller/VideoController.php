<?php 

namespace Controller;

use \W\Controller\Controller;
use Model\VideoModel;

/**
* 
*/
class VideoController extends Controller
{
	
	function search()
	{
		$videos = new VideoModel();

		if (!empty($_POST['search'])) {
			$search = trim($_POST['search']);
			$search = $_POST['search'];
			$result = $videos->getVideoSearch($search);
		} else {
			$search = NULL;
			$result = $videos->getVideo();
		}

		
		$this->show('video/displayVideo', ['videos' => $result , 'search' => $search]);

	}
}