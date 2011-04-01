<?php
/**
 * Main application file (also aka index.php)
 * 
 * @author  Joris Berthelot <joris.berthelot@gmail.com>
 *          Chama Laatik <chama.laatik@gmail.com>
 * @copyright Copyright (c) 2011
 * @version 1.0
 */

// Sets the class loader
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

use \Icone\Acn\Acn;
use \Symfony\Component\Finder\Finder;

// =============================
// = Application configuration =
// =============================
// Base directories path (user may change it if directory structure changes)
define('IMG_PATH', '%s/../../Bases/Base%d');
define('OCR_PATH', IMG_PATH . '/ocr');
// Number of OCR to browse
define('OCR_DIR_NUM', 10);
// ====================================
// = End of application configuration =
// ====================================

try {
    // Creates a new application with the VT file name
    $acn = new Acn(__DIR__ . DIRECTORY_SEPARATOR . 'Image_VT');

    // Outputs the OCR which was used to generate OCR files
    echo "OCR was: http://www.newocr.com\n";

    // Loops on OCR file directories
    for ($i = 1; $i < OCR_DIR_NUM; $i++) {
        
        // Starts output buffering
        ob_start();

        // Outputs the current working base name (colored)
        printf("\n\033[0;30m\033[46m\033[1m=Base %d=\033[0m\n", $i);

        // Sets paths to the application
        $acn->setImgPath(vsprintf(IMG_PATH, array(
            __DIR__, $i
        )))->setOcrPath(vsprintf(OCR_PATH, array(
            __DIR__, $i
        )));

        // Creates a new Finder, sets parameters and loads it into the application
        $finder = new Finder();
        $finder->files()->in($acn->getOcrPath())->sort(function(\SplFileInfo $a, \SplFileInfo $b) {
            return strnatcmp($a->getRealPath(), $b->getRealPath());
        });
        $acn->setFinder($finder);

        // Execute the application
        $acn->exec(function($filesize) {
            return round($filesize / 1e3);
        }, array('.tiff', '.jpg', '.png'));

        // Ends output buffering
        ob_end_flush();
    }
} catch (Exception $e) {
    trigger_error($e->getMessage(), E_USER_ERROR);
    exit;
}
?>