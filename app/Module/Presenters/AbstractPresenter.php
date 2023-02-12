<?php

namespace App\Presenters;


use Nette\Application\UI\Presenter;

abstract class AbstractPresenter extends Presenter
{
    protected function startup()
    {
        if ($this->isAjax()) {
            $this->redrawControl("content");
        }
        parent::startup();
    }

}