<?php
/**
 * Created by PhpStorm.
 * User: Takson
 * Date: 12/04/2017
 * Time: 17:18
  * Class UI - Site user interface
 *
 */
 /**
 * Get a list of files/folders in the given directory
 *
 * @param dir $dir
 *
 * @return array
 */
function dir_list($dir) {
  $dir_list = array();
 	if ($handle = opendir($dir)) {
    while ($filename = readdir($handle)) { if (preg_match('#^\.#',$filename)==0) $dir_list[] = $filename; }
 	  closedir($handle);
  }
 	asort($dir_list);
	return $dir_list;
}// /dir_list()

?>