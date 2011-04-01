<?php
namespace Icone\Acn;

/**
 * Acn.php
 * 
 * Acn is a PHP-CLI class to browse directory and compare 
 * 
 * @author  Joris Berthelot <joris.berthelot@gmail.com>
 *          Chama Laatik <chama.laatik@gmail.com>
 * @copyright Copyright (c) 2011
 */
class Acn
{
    /**
     * The image base path
     * 
     * @access protected
     */
    protected $_img_path;

    /**
     * The OCR file base path
     * 
     * @access protected
     */
    protected $_ocr_path;
    
    /**
     * The Finder instance
     * 
     * @access protected
     */
    protected $_finder;
    
    /**
     * Verité Terrain file to use for comparaison
     * 
     * @access protected
     */
    protected $_vt_file_content;
    
    /**
     * Class constructor
     * 
     * @param string {@see Acn::$_vt_file_content}
     * @access public
     */
    public function __construct($vt_file)
    {
        if (is_file($vt_file) && is_readable($vt_file)) {
            $this->_vt_file_content = file_get_contents($vt_file);
        }
    }
    
    /**
     * Symfony Finder setter
     * 
     * @param \Symfony\Component\Finder\Finder
     * @return \Icone\Acn\Acn
     * @access public
     */
    public function setFinder(\Symfony\Component\Finder\Finder $finder)
    {
        $this->_finder = $finder;
        return $this;
    }
    
    /**
     * Symfony Finder getter
     * 
     * @return \Symfony\Component\Finder\Finder
     * @access public
     */
    public function getFinder()
    {
        return $this->_finder;
    }
    
    /**
     * Image base path setter
     * 
     * @param string
     * @throws \Icone\Acn\Exception
     * @return \Icone\Acn\Acn
     * @access public
     */
    public function setImgPath($path)
    {
        if (!is_dir($path)) {
            throw new Exception("Unable to read image path!");
        }
        
        $this->_img_path = $path;
        
        return $this;
    }
    
    /**
     * Image base path getter
     * 
     * @return string
     * @access public
     */
    public function getImgPath()
    {
        return $this->_img_path;
    }
    
    /**
     * OCR file base path setter
     * 
     * @param string
     * @throws \Icone\Acn\Exception
     * @return \Icone\Acn\Acn
     * @access public
     */
    public function setOcrPath($path)
    {
        if (!is_dir($path)) {
            throw new Exception("Unable to read OCR path!");
        }
        
        $this->_ocr_path = $path;
        
        return $this;
    }
    
    /**
     * OCR file base path getter
     * 
     * @return string
     * @access public
     */
    public function getOcrPath()
    {
        return $this->_ocr_path;
    }
    
    /**
     * Browse files with the Finder and outputs the result
     * 
     * @param \Closure
     * @param [array]
     * @access public
     */
    public function exec(\Closure $file_weight_formatter, array $extensions = array())
    {
        if (!$this->_finder instanceof \Symfony\Component\Finder\Finder) {
            throw new Exception("Finder not found!");
        }
        
        foreach ($this->_finder as $file) {
            $image_file = $this->_getImage($file, $extensions);
            $image_weight = $file_weight_formatter(filesize($image_file));
            $image_ext = substr($image_file, strrpos($image_file, '.'));
            
            similar_text($this->_vt_file_content, file_get_contents($file), $percent);
            $percent = round($percent, 4);
            
            if ($percent >= 98) {
                $color = '0;32';
            } else if ($percent < 98 && $percent >= 94) {
                $color = '0;33';
            } else if ($percent < 40) {
                $color = '0;31';
            } else {
                $color = '0;34';
            }
            
            printf("%s%s => \033[%sm%.4f%%\033[0m (%d Ko)\n",
                basename($file), $image_ext, $color, $percent, $image_weight
            );
        }
    }
    
    /**
     * Image retriever. Acn::exec() does not loop on images but on OCR files though
     * this method gets the image file of the current OCR file.
     * 
     * @param \SplFileInfo
     * @param [array]
     * @return string
     * @access protected
     */
    protected function _getImage(\SplFileInfo $file, array $extensions = array())
    {
        $image_file = $this->getImgPath() . DIRECTORY_SEPARATOR . basename($file);
        
        // No extensions were given so we just want to get the file no matter
        // the extension
        if (empty($extensions)) {
            if (is_file($image_file)) {
                return $image_file;
            }
        }
        
        // Looks for the right file with given extension as filter
        foreach ($extensions as $ext) {
            if (is_file($image_file . $ext)) {
                return $image_file . $ext;
            }
        }
    }
}
