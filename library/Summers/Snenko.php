<?php
/**
 * User: Adolis
 * Date: 07.04.15
 * Time: 11:16
 * my personal library for functions
 */

class Summers_Snenko
{

    /**
     * get Generated unique file name in set catalog
     *
     * @param $catalog  : path to files catalog
     * @param $id       : product's id
     *
     * @return string
     */

    static function getCurrentDate()
    {
        return date('Y-m-d H:i:s', mktime());
    }

    static function getNewFileName($catalog)
    {
        do {
            $fn = uniqid("image_" /*,true*/);
        } while (count(glob("{$catalog}/{$fn}*")) > 0);

        return $fn;
    }

//    static function getNewFileName($catalog, $id) {
//        do {
//            $gen = uniqid();
//            $fn= "product_{$id}_{$gen}";
//
//        } while (count(glob("{$catalog}/[$fn]*"))>0);
//
//        return $fn;
//    }

    /**
     * from string to array
     *
     * @param $string
     *
     * @return array|bool
     */
    static function getArray($string)
    {
        if (!$string) {
            return false;
        }
        //завантажуємо масив фоток
        $files = array();

        $string = trim($string);

        if ($string) {
            $files = explode(",", $string);
        }

        foreach($files as $key=>$file) {
            $files[$key] = trim($file);
        }

        return $files;
    }

    //-------------------------------------------------


    /**
     * Збереження зображення з перейменуванням
     * @param $adapter
     * @param $old_fn
     */
    public static function SavePicture($adapter, $old_fn)
    {
        $galleryDir = Zend_Registry::get('config')->uploads->galleryPhotoDir;
        $gen = Summers_Snenko::getNewFileName($galleryDir);
        $gen_fn = "{$gen}." . pathinfo($old_fn, PATHINFO_EXTENSION);

        return Summers_Snenko::SaveFileWithRandomName($adapter, $gen_fn, $old_fn);
    }
    //-------------------------------------------------

    /**
     * Збереження файлів з перейменуванням
     * @param $adapter
     * @param $new_fn
     * @param $atribute_label
     *
     * @return mixed
     * @throws Zend_Controller_Action_Exception
     */
    public static function SaveFileWithRandomName($adapter, $new_fn, $atribute_label)
    {
        //$adapter, $gen_fn, $old_fn
        //--------------------------------------
        /**
         * @var Zend_File_Transfer
         */
        $adapter->addFilter(
            new Zend_Filter_File_Rename(
                array('target' => $new_fn, 'overwrite' => true)
            )
        );

        $dir = Zend_Registry::get('config')->uploads->galleryPhotoDir;

        $thumbnails = Zend_Registry::get('config')->upload_thumbnails->dir;
        $md = Zend_Registry::get('config')->upload_md->dir;

        try
        {
            //Перейменовуємо зображення
            $adapter->receive($atribute_label);

            //Зберігаємо зображення thumbnails
            $options = array('height' => 120, 'width' => 120, 'quality' => 75, "strategy" => 'fit',
                             'out'    => $thumbnails,);
            Summers_Snenko::Save_ResizePictures($new_fn, $dir, $options);

            //Зберігаємо зображення md
            $options = array('height' => 340, 'width' => 340, 'quality' => 75, "strategy" => 'fit',
                             'out'    => $md,);
            Summers_Snenko::Save_ResizePictures($new_fn, $dir, $options);

            return $new_fn;
        } catch (Zend_File_Transfer_Exception $e) {
            throw new Zend_Controller_Action_Exception('File could not be
                                        renamed. An error occured while
                                        processing the file.');
        }
        //return false;
    }

    /**
     * Зберігає нове зображення з новим розміром
     * @param $fn   : Назва зображення
     * @param $dir  : Шлях до файла
     * @param array $options    : array(out, height, width, quality, strategy)
     *
     * @return string
     */
    static function Save_ResizePictures($fn, $dir, $options)
    {

        $out = $options['out'];

        $strategy = '';
        switch ($options["strategy"]) {
            case "fit":
                $strategy = new Polycast_Filter_ImageSize_Strategy_Fit();
                break;
            case "crop":
                $strategy = new Polycast_Filter_ImageSize_Strategy_Crop();
                break;
            default:
                $strategy = new Polycast_Filter_ImageSize_Strategy_Fit();
        }

        $filter = new Polycast_Filter_ImageSize();
        $filter->setOutputPathBuilder( new SnenkoPathBuilder("$out"));

        $filter->getConfig()
            ->setHeight($options['height'])
            ->setWidth($options['width'])
            ->setQuality($options['quality'])
            ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL)
            //->setOutputImageType(Polycast_Filter_ImageSize::TYPE_JPEG)
            ->setStrategy($strategy);

        return $filter->filter("{$dir}/{$fn}");
    }
}

/**
 * Ця штука зроблена для того щоб давати файлам нормальні імена, без постфіксів
 * Class SnenkoPathBuilder
 */
class SnenkoPathBuilder implements Polycast_Filter_ImageSize_PathBuilder_Interface
{
    private $_outputDir = null;

    public function __construct($outputDir)
    {
        $this->_outputDir = $outputDir;
    }

    public function buildPath($filename, Polycast_Filter_ImageSize_Configuration_Interface $config)
    {
        $chunks = explode('.', strrev(basename($filename)), 2);
        $basename = strrev(array_pop($chunks));
        $ext = strrev(array_pop($chunks));

        switch($config->getOutputImageType()) {

            case 'jpeg': $ext = '.jpg'; break;
            case 'gif': $ext = '.gif'; break;
            case 'png': $ext = '.png'; break;

            case 'auto':
            case null:
            default:
                $ext = ".$ext";
        }

        if ($config instanceof NamedConfig) {
            $postfix = $config->getTemplateName();
        } else {
            $postfix = sprintf('%sx%s-q%s', $config->getWidth(), $config->getHeight(), $config->getQuality());
        }

        $path = sprintf('%s/%s%s',
            $this->_outputDir,
            $basename,
            $ext
        );

        return $path;
    }
}
//$path = Zend_Registry::get('config')->uploads->galleryPhotoDir;
