<?php

namespace Models;


const UPLOADS_DIR = 'public/'; // @var UPLOADS_DIR Répertoire ou seront uploadés les fichiers
/**
 * @var FILE_EXT_IMG  extensions acceptées pour les images
 */
const FILE_EXT_IMG = ['jpg','jpeg','gif','png'];


const MIME_TYPES = array(

    'txt' => 'text/plain',
    'htm' => 'text/html',
    'html' => 'text/html',
    'php' => 'text/html',
    'css' => 'text/css',
    'js' => 'application/javascript',
    'json' => 'application/json',
    'xml' => 'application/xml',
    'swf' => 'application/x-shockwave-flash',
    'flv' => 'video/x-flv',

    // images
    'png' => 'image/png',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'svgz' => 'image/svg+xml',

    // archives
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
    'exe' => 'application/x-msdownload',
    'msi' => 'application/x-msdownload',
    'cab' => 'application/vnd.ms-cab-compressed',

    // audio/video
    'mp3' => 'audio/mpeg',
    'qt' => 'video/quicktime',
    'mov' => 'video/quicktime',

    // adobe
    'pdf' => 'application/pdf',
    'psd' => 'image/vnd.adobe.photoshop',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',

    // ms office
    'doc' => 'application/msword',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',

    // open office
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
);

class Upload {
    
    public function upload(array $file, string $dossier = '', array &$errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG) {
    
            
        $filename = '';
        // On récupère l'extension du fichier pour vérifier si elle est dans $fileExtensions
        $tmpNameArray = explode(".", $file["name"]);
        $tmpExt = end($tmpNameArray);
    
        if ($file["error"] === UPLOAD_ERR_OK) {
              $tmpName = $file["tmp_name"];
    
              if(in_array($tmpExt,$fileExtensions)) {
                   $filename = uniqid().'-'.basename($file["name"]);
                   if(!move_uploaded_file($tmpName, $folder.$dossier."/".$filename)) {
                        $errors[] = "Le fichier n'a pas été enregistré correctement";
                   }
                   // mime_content_type 
                   // Détecte le type de contenu d'un fichier. 
                   // On vérifie le contenue de fichier, pour voir s'il appartient aux MIMES autorises.
                   if(!in_array(mime_content_type($folder.$dossier."/".$filename), MIME_TYPES, true)) {
                        // var_dump(mime_content_type($folder.$filename));
                        $errors[] = "Le fichier n'a pas été enregistré car son contenu ne correspond pas à son extention !";
                   }
              }
              else{
                   $errors[] = "Ce type de fichier n'est pas autorisé !";
              }
         }
         else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
              //fichier trop volumineux
              $errors[] = "Le fichier est trop volumineux";
         }
         else {
              $errors[] = "Une erreur a eu lieu au moment de l'upload";
         }
         return $filename;
    }
}