<?php
/**
 * User: Adolis
 * Date: 07.04.15
 * Time: 11:16
 * my personal library for functions
 */

class Summers_Snenko
{

    static function getTitleProducts() {
        $res='';
        if($titleProducts = self::getSettings_config()->admin->titleProducts)
            $res = $titleProducts->toarray();
        return $res;
    }

    static function getImageSize() {
        $imageSize = array(
            'minwidth'  => 340,
            'minheight' => 170,
            'maxwidth'  => 2500,
            'maxheight' => 2500
        );
        return $imageSize;
    }

    /**
     * Генеруємо потрібний шлях до зображення
     * @param       $file_name
     * @param array $options = array(no-photo, dir, mask-dir=array(orig, md, thumbnail))
     *
     * @return string
     */
    static function img_src($file_name, $options=array())
    {
        $no_photo = ($options['no-photo'])?$options['no-photo']:'no-photo.png';
        $dir = ($options['dir'])?$options['dir'] : Summers_Snenko::getPhotoMdDir();

        switch ($options['mask-dir']) {
            case 'orig':
                $dir = Summers_Snenko::getPhotoDir();
                break;
            case 'md':
                $dir = Summers_Snenko::getPhotoMdDir();
                break;
            case 'thumbnail':
                $dir = Summers_Snenko::getPhotoThumbnailsDir();
                break;
        }

        return $dir.'/'.(($file_name)?$file_name: $no_photo);
    }

    static function getLanguages() {
        $lang = array(
            'uk_UA'=>'українська',
            'ru_RU'=>'русский',
            'en_US'=>'english'
        );


//        $lang
        return $lang;
    }

    static function getCurrentDate()
    {
        return date('Y-m-d H:i:s', mktime());
    }

    static function getNewFileName($catalog = '')
    {
        if (!$catalog) {
            $catalog = self::getPhotoDir();
        }
        do {
            $fn = uniqid("image_" /*,true*/);
        } while (count(glob("{$catalog}/{$fn}*")) > 0);

        return $fn;
    }

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

        foreach ($files as $key => $file) {
            $files[$key] = trim($file);
        }

        return $files;
    }

    /**
     * видалення заданих файлів
     *
     * @param array $files
     * @param array $dirs : Видалення в тому числі і підфайлів
     *
     * @return bool
     */
    public static function deletePictures($files, $dirs = array())
    {
        if (!$files) {
            return false;
        }

        if (!is_array($files)) {
            $files = array($files);
        }

        if (!$dirs) {
            $dirs = self::getPhotoDirs();
        }

        foreach ($files as $key => $value) {
            foreach ($dirs as $dir) {
                $file = "{$dir}/{$value}";

                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        return true;
    }

    /**
     * Збереження зображення з перейменуванням
     * @param $adapter
     * @param $old_fn
     *
     * @return mixed
     */
    public static function SavePicture($adapter, $old_fn)
    {
        //нове імя файла
        $gen_fn = Summers_Snenko::getNewFileName(self::getPhotoDir()) . "." . pathinfo($old_fn, PATHINFO_EXTENSION);

        //змінюємо розмір файла
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

        try {
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
     * @param       $fn         : Назва зображення
     * @param       $dir        : Шлях до файла
     * @param array $options    : array(out, height, width, quality, strategy)
     *
     * @return string
     */
    public static function Save_ResizePictures($fn, $dir, $options)
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
        $filter->setOutputPathBuilder(new SnenkoPathBuilder("$out"));

        $filter->getConfig()
            ->setHeight($options['height'])
            ->setWidth($options['width'])
            ->setQuality($options['quality'])
            ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL)
            //->setOutputImageType(Polycast_Filter_ImageSize::TYPE_JPEG)
            ->setStrategy($strategy);

        return $filter->filter("{$dir}/{$fn}");
    }

    // шляхи до файлів

    /**
     * Повертає массив папок шляхів до зображень
     * @return mixed
     */
    public static function getPhotoDirs()
    {
        $dirs['galleryPhotoDir'] = Zend_Registry::get('config')->uploads->galleryPhotoDir;
        $dirs['upload_thumbnails'] = Zend_Registry::get('config')->upload_thumbnails->dir;
        $dirs['upload_md'] = Zend_Registry::get('config')->upload_md->dir;
        return $dirs;
    }

    /**
     * Повертає шлях до базової папки зображень
     * @return mixed
     */
    static function getPhotoDir()
    {
        return Zend_Registry::get('config')->photos->dir;
    }

    static function getPhotoMdDir()
    {
        return Zend_Registry::get('config')->md->dir;
    }

    static function getPhotoThumbnailsDir()
    {
        return Zend_Registry::get('config')->thumbnails->dir;
    }

    /**
     * get path to settings file
     * @return mixed
     */

    static function getSetting_path(){
        return Zend_Registry::get('config')->configs->localConfigPath;
    }

    static function getSettings_config()
    {
        $configs = Zend_Registry::get('config')->configs->localConfigPath;
        //$i = new Zend_Config_Ini($configs['localConfigPath']);
        $i = new Zend_Config_Ini($configs);
        return $i;
    }

    // settings

    /**
     * get admin's settings
     * logExceptionsToFile, itemsPerPage, adminEmailAddress
     * @return mixed
     */
    static function getSettings_admin()
    {
        //дізнаємось конфігурацію файла
        $configs = self::getSettings_config();
        return $configs->admin;
    }

    /**
     * get guest's settings
     * guestEmailAddress, displaySellerInfo
     * @return mixed
     */
    static function getSettings_guest()
    {
        //дізнаємось конфігурацію файла
        $configs = self::getSettings_config();
        return $configs->guest;
    }

    /**
     * get user's settings
     * guestEmailAddress, displaySellerInfo
     * @return mixed
     */
    static function getSettings_user()
    {
        //дізнаємось конфігурацію файла
        $configs = self::getSettings_config();
        return $configs->user;
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

        switch ($config->getOutputImageType()) {

            case 'jpeg':
                $ext = '.jpg';
                break;
            case 'gif':
                $ext = '.gif';
                break;
            case 'png':
                $ext = '.png';
                break;

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

        $path = sprintf(
            '%s/%s%s',
            $this->_outputDir,
            $basename,
            $ext
        );

        return $path;
    }
}
