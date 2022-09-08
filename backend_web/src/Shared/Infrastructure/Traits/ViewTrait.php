<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\ViewTrait
 * @file ViewTrait.php 1.0.0
 * @date 30-10-2021 15:00 SPAIN
 * @observations
 * @tags: #ui
 */
namespace App\Shared\Infrastructure\Traits;
use App\Shared\Infrastructure\Views\AppView;

trait ViewTrait
{
    protected ?AppView $view = null;

    protected function _load_view(): AppView
    {
        if(!$this->view) $this->view = new AppView();
        return $this->view;
    }

    protected function set_layout(string $pathlayout): AppView
    {
        $this->_load_view()->set_layout($pathlayout);
        return $this->view;
    }

    protected function set_template(string $pathtemplate): AppView
    {
        $this->_load_view()->set_template($pathtemplate);
        return $this->view;
    }

    protected function add_var(string $varname, $value): AppView
    {
        $this->_load_view()->add_var($varname, $value);
        return $this->view;
    }

    protected function add_header(int $code): AppView
    {
        $this->_load_view()->add_header($code);
        return $this->view;
    }

    protected function render($vars=[], string $pathtemplate=""): void
    {
        $this->_load_view();
        foreach ($vars as $k => $v)
            $this->view->add_var($k,$v);
        if($pathtemplate) $this->view->set_template($pathtemplate);
        $this->view->render();
    }

}
