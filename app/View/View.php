<?php
namespace Notes\View;

class View
{
    protected $renderEngine;
    
    public function render($fileName, $response = null)
    {
        require_once __dir__ . "/$fileName";
    }
    
    public function __construct()
    {
        
        $this->renderEngine = new \Mustache_Engine(array(
            'loader' => new \Mustache_Loader_FilesystemLoader(__DIR__ . '/../../public/templates/')
        ));
        
    }
    
    public function renderMeta($meta)
    {
        return $this->renderEngine->render('meta.mustache', $meta);
    }
    
    public function renderScript($script)
    {
        return $this->renderEngine->render('script.mustache', $script);
    }
    
    public function renderStyle($style)
    {
        return $this->renderEngine->render('style.mustache', $style);
    }
    
    public function renderHeader($header)
    {
        return $this->renderEngine->render('header.mustache', $header);
    }
    
    public function renderFooter($footer)
    {
        return $this->renderEngine->render('footer.mustache', $footer);
    }
    
    public function renderContent($contentTemplateName, $content)
    {
        return $this->renderEngine->render($contentTemplateName . '.mustache', $content);
    }
    
    public function renderHidden($hidden)
    {
        return $this->renderEngine->render('hidden.mustache', $hidden);
    }
    
    public function renderPage($contentTemplateName, $layout)
    {
        return $this->renderEngine->render('layout.mustache', array(
            
            'meta' => $this->renderMeta($layout['meta']),
            'style' => $this->renderStyle($layout['style']),
            'hidden' => $this->renderHidden($layout['hidden']),
            'script' => $this->renderScript($layout['script']),
            'header' => $this->renderHeader($layout['header']),
            'content' => $this->renderContent($contentTemplateName, $layout['content']),
            'footer' => $this->renderFooter($layout['footer'])
        ));
    }
}
