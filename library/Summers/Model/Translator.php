<?php
class Summers_Model_Translator {

    function __construct() {
        $this->setTranslates(
          $this->getTranslatorList_formFiles()
        );
    }
    protected $_translates=array();
    protected $_errors=array();

    /**
     * @param array $errors
     */
    private function setError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }


    /**
     * @param array $translates
     */
    public function setTranslates($translates)
    {
        $this->_translates = $translates;
    }

    /**
     * @param array $translates
     */
    public function setTranslate($options)
    {
        if(!isset($options['label'])) return;

        if( !isset($options['en']) &&
            !isset($options['ru']) &&
            !isset($options['uk'])) return;
        if(!(
            $options['en'].
            $options['ru'].
            $options['uk'])) return;

        foreach ($options as $k => $v) {
            if($k=='label') continue;
            $this->_translates[$options['label']][$k] = $v;
        }
    }

    /**
     * @return array
     */
    public function getTranslates()
    {
        return $this->_translates;
    }

    public function find($label) {
        return $this->getTranslates()[$label];
    }

    /**
     * загружаєсмо переклади
     * @return array
     */
    public function getTranslatorList_formFiles(){
        $en = (new Zend_Config(require APPLICATION_PATH . '/../languages/en/interface.php'))->toArray();
        $ru = (new Zend_Config(require APPLICATION_PATH . '/../languages/ru/interface.php'))->toArray();
        $uk = (new Zend_Config(require APPLICATION_PATH . '/../languages/uk/interface.php'))->toArray();

        $arr = array();
        /*загальний масив перекладів*/
        foreach($uk as $k=>$v){
            $arr[$k] =array('en'=> $en[$k],'ru'=> $ru[$k],'uk'=> $uk[$k],);
        }

        return $arr;
    }

    public function fromArray($values) {
        $this->setTranslate(
            $values
        );
    }

    public function save() {
        $transl = $this->getTranslates();

        $en=array();
        $ru=array();
        $uk=array();

        /*загальний масив перекладів*/
        foreach($transl as $k=>$v) {
            $en[$k] = $v['en'];
            $ru[$k] = $v['ru'];
            $uk[$k] = $v['uk'];
        }

        $lang_dir = Zend_Registry::get('config')->lang->dir;
        $f[$lang_dir.'/en/interface.php'] = $en;
        $f[$lang_dir.'/ru/interface.php'] = $ru;
        $f[$lang_dir.'/uk/interface.php'] = $uk;

        try
        {
            foreach($f as $k=>$v) {
                $config = new Zend_Config_Writer_Array();
                $config->write($k, new Zend_Config($v));

//                $writer = new Zend_Config_Writer_Array(
//                    array('config' => $v, 'filename' => $k)
//                );
//                $writer->write();
            }
        } catch (Exception $e) {
            $this->setError($e->getMessage());
        }

    }


}