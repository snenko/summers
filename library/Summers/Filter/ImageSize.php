<?php
class Summers_Filter_ImageSize implements Zend_Filter_Interface
{
    protected $_options = array();

    /**
     * width,height,strategy(fit|crop|)
     * @param array $options
     */
    public function __construct($options)
    {
        //вибираємо опції
        foreach($options as $key=>$value)
        {
            switch ($key) {
                case "width":
                    $this->_options[$key] = $value;
                    break;
                case "height":
                    $this->_options[$key] = $value;
                    break;
                case "strategy":
                    $this->_options[$key] = $value;
                    break;
                case "quality":
                    $this->_options[$key] = $value;
                    break;
            }
        }
    }

    public function filter($value)
    {
        $fn = basename($value);
        $dir = '/photos';

        $filter = new Polycast_Filter_ImageSize();
        $config = $filter->getConfig();

        //Обираємо Стратегію
        $strategy = '';
        switch ($this->_options["strategy"]) {
            case "fit":
                $strategy = new Polycast_Filter_ImageSize_Strategy_Fit();
                break;
            case "crop":
                $strategy = new Polycast_Filter_ImageSize_Strategy_Crop();
                break;
        }

        $config = new NamedConfig('product-thumbnail-100x100');
        $config
            ->setWidth($this->_options['width'])
            ->setHeight($this->_options['height'])
            ->setQuality($this->_options['quality'])
            ->setStrategy($strategy)
            ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL);

        $filter->setConfig($config);
        $filter->setOutputPathBuilder(new CustomPathBuilder('/photos/thumbnails/'));

        $outputPath = $filter->filter('{$dir}/{$fn}');

        return $value;
    }
}

class NamedConfig extends Polycast_Filter_ImageSize_Configuration_Standard
{
    protected $_templateName = null;

    public function __construct($templateName)
    {
        $this->_templateName = $templateName;
    }

    public function getTemplateName()
    {
        return $this->_templateName;
    }
}

class CustomPathBuilder implements Polycast_Filter_ImageSize_PathBuilder_Interface
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
            '%s/%s-%s%s',
            $this->_outputDir,
            $basename,
            $postfix,
            $ext
        );

        return $path;
    }
}


/*
 *         $FN  = 'product_552d006dd9658.jpg';
        $dir = 'C:\wamp\www\summers\public\photos';
        $thumbnails_dir ='C:\wamp\www\summers\public\photos\thumbnails';

        $filter = new Polycast_Filter_ImageSize();

        $filter->setOutputPathBuilder(
            new Polycast_Filter_ImageSize_PathBuilder_Standard($thumbnails_dir));

        $filter->getConfig()
            ->setHeight(300)
            ->setWidth(300)
            ->setQuality(75)
            ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL)
            ->setStrategy(new Polycast_Filter_ImageSize_Strategy_Fit());
            //->setStrategy(new Polycast_Filter_ImageSize_Strategy_Crop());

        $output = $filter->filter("{$dir}\\{$FN}");

        $this->view->message = $output;
 * */