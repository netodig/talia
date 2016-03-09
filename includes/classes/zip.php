<?php

/**
 * Class to dynamically create a zip file (archive)
 *
 * @author Rochak Chauhan
 */

class createZip {
	
	public $compressedData = array ();
	public $centralDirectory = array (); // central directory   
	public $endOfCentralDirectory = "\x50\x4b\x05\x06\x00\x00\x00\x00"; //end of Central directory record
	public $oldOffset = 0;
	/**
	 * Function to create the directory where the file(s) will be unzipped
	 *
	 * @param $directoryName string 
	 *
	 */
	public function addDirectory($directoryName) {
		$directoryName = str_replace ( "\\", "/", $directoryName );
		
		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x0a\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x00\x00\x00\x00";
		
		$feedArrayRow .= pack ( "V", 0 );
		$feedArrayRow .= pack ( "V", 0 );
		$feedArrayRow .= pack ( "V", 0 );
		$feedArrayRow .= pack ( "v", strlen ( $directoryName ) );
		$feedArrayRow .= pack ( "v", 0 );
		$feedArrayRow .= $directoryName;
		
		$feedArrayRow .= pack ( "V", 0 );
		$feedArrayRow .= pack ( "V", 0 );
		$feedArrayRow .= pack ( "V", 0 );
		
		$this->compressedData [] = $feedArrayRow;
		
		$newOffset = strlen ( implode ( "", $this->compressedData ) );
		
		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .= "\x00\x00";
		$addCentralRecord .= "\x0a\x00";
		$addCentralRecord .= "\x00\x00";
		$addCentralRecord .= "\x00\x00";
		$addCentralRecord .= "\x00\x00\x00\x00";
		$addCentralRecord .= pack ( "V", 0 );
		$addCentralRecord .= pack ( "V", 0 );
		$addCentralRecord .= pack ( "V", 0 );
		$addCentralRecord .= pack ( "v", strlen ( $directoryName ) );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";
		$addCentralRecord .= pack ( "V", 16 );
		
		$addCentralRecord .= pack ( "V", $this->oldOffset );
		$this->oldOffset = $newOffset;
		
		$addCentralRecord .= $directoryName;
		
		$this->centralDirectory [] = $addCentralRecord;
	}
	
	/**
	 * Function to add file(s) to the specified directory in the archive 
	 *
	 * @param $directoryName string 
	 *
	 */
	
	public function addFile($data, $directoryName) {
		
		$directoryName = str_replace ( "\\", "/", $directoryName );
		
		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x14\x00";
		$feedArrayRow .= "\x00\x00";
		$feedArrayRow .= "\x08\x00";
		$feedArrayRow .= "\x00\x00\x00\x00";
		
		$uncompressedLength = strlen ( $data );
		$compression = crc32 ( $data );
		$gzCompressedData = gzcompress ( $data );
		$gzCompressedData = substr ( substr ( $gzCompressedData, 0, strlen ( $gzCompressedData ) - 4 ), 2 );
		$compressedLength = strlen ( $gzCompressedData );
		$feedArrayRow .= pack ( "V", $compression );
		$feedArrayRow .= pack ( "V", $compressedLength );
		$feedArrayRow .= pack ( "V", $uncompressedLength );
		$feedArrayRow .= pack ( "v", strlen ( $directoryName ) );
		$feedArrayRow .= pack ( "v", 0 );
		$feedArrayRow .= $directoryName;
		
		$feedArrayRow .= $gzCompressedData;
		
		$feedArrayRow .= pack ( "V", $compression );
		$feedArrayRow .= pack ( "V", $compressedLength );
		$feedArrayRow .= pack ( "V", $uncompressedLength );
		
		$this->compressedData [] = $feedArrayRow;
		
		$newOffset = strlen ( implode ( "", $this->compressedData ) );
		
		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .= "\x00\x00";
		$addCentralRecord .= "\x14\x00";
		$addCentralRecord .= "\x00\x00";
		$addCentralRecord .= "\x08\x00";
		$addCentralRecord .= "\x00\x00\x00\x00";
		$addCentralRecord .= pack ( "V", $compression );
		$addCentralRecord .= pack ( "V", $compressedLength );
		$addCentralRecord .= pack ( "V", $uncompressedLength );
		$addCentralRecord .= pack ( "v", strlen ( $directoryName ) );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "v", 0 );
		$addCentralRecord .= pack ( "V", 32 );
		
		$addCentralRecord .= pack ( "V", $this->oldOffset );
		$this->oldOffset = $newOffset;
		
		$addCentralRecord .= $directoryName;
		
		$this->centralDirectory [] = $addCentralRecord;
	}
	
	/**
	 * Fucntion to return the zip file
	 *
	 * @return zipfile (archive)
	 */
	
	public function getZippedfile() {
		
		$data = implode ( "", $this->compressedData );
		$controlDirectory = implode ( "", $this->centralDirectory );
		
		return $data . $controlDirectory . $this->endOfCentralDirectory . pack ( "v", sizeof ( $this->centralDirectory ) ) . pack ( "v", sizeof ( $this->centralDirectory ) ) . pack ( "V", strlen ( $controlDirectory ) ) . pack ( "V", strlen ( $data ) ) . "\x00\x00";
	
	}
	
	/**
	 *
	 * Function to force the download of the archive as soon as it is created
	 *
	 * @param $f string - name of the created archive file
	 */
	
	public function desarc($f, $tmpCarpeta) {
		if (file_exists ( $tmpCarpeta."/".$f )) {
			header ( "Content-type: application/zip" );
			header ( 'Content-Disposition: attachment; filename="' . $f . '"' );
			$fp = fopen ( $tmpCarpeta."/".$f, "r" );
			fpassthru ( $fp );
		} 
	}
}
?>