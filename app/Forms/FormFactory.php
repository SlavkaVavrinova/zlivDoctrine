<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Form;

class FormFactory
{
    public function create(): Form
    {

        $form = new Form;

        return $form;
    }
}