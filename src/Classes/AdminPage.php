<?php

namespace Bws\Core\Classes;

use Illuminate\Contracts\Support\Renderable;

class AdminPage implements Renderable
{
    protected $title = '';
    protected $actions = [];
    protected $styles = [];
    protected $scripts = [];
    protected $content = [];

    /**
     * @param string $title
     * @return AdminPage
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param $styles
     * @return AdminPage
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * @param $scripts
     * @return AdminPage
     */
    public function setScripts($scripts)
    {
        $this->scripts = $scripts;
        return $this;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function render()
    {
        $pageTitle = $this->title;
        $pageActions = $this->actions;
        $pageStyles = $this->styles;
        $pageScripts = $this->scripts;
        $pageContent = $this->content;

        return view('bws@core::utilities.crud.page', compact(
            'pageTitle', 'pageActions', 'pageStyles', 'pageScripts', 'pageContent'
        ));
    }
}
