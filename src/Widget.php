<?php

namespace yidas;

/**
 * Widget Alpha
 * 
 * @author  Nick Tsai
 * @version 0.1.0
 * @todo    Asset
 */
class Widget
{
    /**
     * @var object Widget object instance
     */
    private static $_instance;
    
    /**
     * @var array Widget config cache
     * @todo magic method
     */
    private static $_config;

    /**
     * @var string Widget view path cache
     */
    private static $_viewPath;

    function __construct()
    {
        // Do nothing
    }
    
    /**
     * Creates a widget instance and runs it.
     * The widget rendering result is returned by this method.
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @return string the rendering result of the widget.
     * @throws \Exception
     */
    public static function widget($config=[])
    {
        // Create instance at the first call
        if (!self::$_instance) {
            $widget = get_called_class();
            self::$_instance = new $widget;
        }

        // Cache config
        self::$_config = $config;
        
        return self::$_instance->run();
    }

    /**
     * Returns the directory containing the view files for this widget.
     * The default implementation returns the 'views' subdirectory under the directory containing the widget class file.
     * @return string the directory containing the view files for this widget.
     */
    public function getViewPath()
    {
        // Cache mechanism
        if (self::$_viewPath) {
            return self::$_viewPath;
        }
        
        // Called widget filepath
        $reflectionClass = new ReflectionClass($this);
        $widgetPath = dirname($reflectionClass->getFileName());
        $relativePath = str_replace(APPPATH, '', $widgetPath);

        return self::$_viewPath = "../{$relativePath}/views/";
    }

    /**
     * @param string View file path
     */
    protected function render($viewFile)
    {
        $ci = & get_instance();
        $ci->load->view($this->getViewPath(). $viewFile);
    }

    /**
     * @param string|int Key for config array
     * @return mixed Config data
     */
    protected function getConfig($key=null)
    {
        if ($key) {

            return isset(self::$_config[$key]) ? self::$_config[$key] : null;
        
        } else {

            return self::$_config;
        }
    }
}
