<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Fileuploader hook
 *
 * @package        CodeIgniter
 * @author        Anton_Gorodezkiy, antongorodezkiy@gmail.com
 * @contributor    Valums
 * @license        GNU GPL 2
 * @since        Version 1.0
 * @filesource
 *
 * based on the https://github.com/valums/file-uploader/blob/master/server/php.php (c) Valums
 */
 
class Fileuploader_hook {
     
     
    private $error = 0;
    private $name = '';
     
    /**
    * Save the file to the specified path
    * @return boolean TRUE on success
    */
        private function getFile() {
            
            $path = tmpfile();
            
            $input = fopen("php://input", "r");
            $temp = tmpfile();
            $realSize = stream_copy_to_stream($input, $temp);
            fclose($input);
            
            if ($realSize != $this->getSize()){
                return '';
            }
            
            $target = fopen($path, "w");
            fseek($temp, 0, SEEK_SET);
            stream_copy_to_stream($temp, $target);
            fclose($target);
            
            return $path;
        }
        
        private function getName() {
            return isset($_GET[$this->name]) ? $_GET[$this->name] : '';
        }
        
        private function getSize() {
            if (isset($_SERVER["CONTENT_LENGTH"])){
                return (int)$_SERVER["CONTENT_LENGTH"];
            } else {
                $this->error = 'Getting content length is not supported';
                return 0;
            }
        }
        
        private function getType()
        {
            $ci =& get_instance();
            $ci->load->helper('file');
            
            return get_mime_by_extension($this->getName());
        }
        
        function fillGlobalFiles($params)
        {
            $this->name = $params['name'];
            
            if ($params['name'] && $this->getName() && !isset($_FILES[$this->name]))
            {
                $file = $this->getFile();
 
                if (file)
                {
                   $_FILES[$this->name] = array(
                       'name'     => $this->getName(),
                       'type'     => $this->getType(),
                       'tmp_name' => file,
                       'error'    => $this->error,
                       'size'     => $this->getSize()
                   );
                }
            }
        }
        
}