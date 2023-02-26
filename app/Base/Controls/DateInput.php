<?php

declare(strict_types=1);

namespace App\Base\Controls;

use Nette\Forms\Controls\BaseControl;
use Nette\InvalidArgumentException;
use Nette\Utils\Html;

class DateInput extends BaseControl
{
    const ErrorNotValid = 'Datum neni platné';

    private string $d = '', $m = '', $y = '';

    function __construct($caption = null)
    {
        parent::__construct($caption);
        $this->addRule($this->isValid(...), self::ErrorNotValid);

    }


    function setValue($value)
    {
        // musi akceptovat null  (reset)
        if ($value === null) {
            $this->d = $this->m = $this->y = '';
        } elseif (! $value instanceof \DateTimeInterface) {
            throw new InvalidArgumentException();
        } else {
            $this->d = $value->format('j');
            $this->m = $value->format('n');
            $this->y = $value->format('Y');
        }
    }

    function getValue(): ?\DateTimeImmutable
    {
        return $this->isValid()
            ? (new \DateTimeImmutable())->setDate((int)$this->y, (int)$this->m, (int)$this->d)
                ->setTime(0,0,0)
            : null;
    }

    function isValid(): bool
    {
        return checkdate((int)$this->m, (int)$this->d, (int)$this->y);
    }

    function isFilled(): bool
    {
        return $this->d || $this->m || $this->y;
    }


    // {input date}
    function getControl()
    {
        return $this->getControlPart('d')
            . $this->getControlPart('m')
            . $this->getControlPart('y');
    }

    // {input date:d}
    function getControlPart($part = null): ?Html
    {
        $name = $this->getHtmlName();
        return match ($part) {
            'd' => Html::el('input')->name($name . '[d]')->type('number')->value($this->d)->id($this->getHtmlId()),
            'm' => Html::el('input')->name($name . '[m]')->type('number')->value($this->m),
            'y' => Html::el('input')->name($name . '[y]')->type('number')->value($this->y),
        };
    }

    function loadHttpData(): void
    {
        $name = $this->getHtmlName();
        $form = $this->getForm();
        $this->d = $form->getHttpData($form::DATA_LINE, $name . '[d]');
        $this->m = $form->getHttpData($form::DATA_LINE, $name . '[m]');
        $this->y = $form->getHttpData($form::DATA_LINE, $name . '[y]');
    }
}

