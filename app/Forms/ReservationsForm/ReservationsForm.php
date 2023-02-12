<?php

namespace App\Forms\ReservationsForm;

use App\Forms\ReservationsForm\ReservationsFormFactory;
use App\Model\ReservationsFacade;
use App\Forms\BaseForm;
use App\Model\ReservationsRepository;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class ReservationsForm extends BaseForm
{
    private ReservationsRepository $reservationsRepository;
    private ReservationsFormFactory $reservationsFormFactory;

    /** @var callable[] */
    public $onSuccess = [];

    public function __construct(ReservationsRepository $reservationsRepository, ReservationsFormFactory $reservationsFormFactory)
    {
        $this->reservationsRepository = $reservationsRepository;
        $this->reservationsFormFactory = $reservationsFormFactory;
//todo schovat id, termín jen zobrazit
        $this->addInteger('id', 'Id:');
        $this->addText('Termin', 'Termin:')
            ->setRequired()
            ->addRule(Form::MAX_LENGTH, null, 255);
        $this->addText('Stav', 'Stav:')
            ->addRule(Form::MAX_LENGTH, null, 255);
        $this->addText('Agentura', 'Agentura:')
            ->addRule(Form::MAX_LENGTH, null, 255);
        $this->addText('Jmeno', 'Jmeno:')
            ->addRule(Form::MAX_LENGTH, null, 255);
        $this->addTextArea('Info', 'Info:');
        $this->addTextArea('Cena', 'Cena:');
        $this->addTextArea('Zaplaceno', 'Zaplaceno:');
        $this->addTextArea('orderID', 'OrderID:');
        $this->addTextArea('Email', 'Email:');
        $this->addTextArea('emailDate', 'EmailDate:');
        $this->addTextArea('Telefon', 'Telefon:');
        $this->addTextArea('arrivalTime', 'ArrivalTime:');
        $this->addSubmit('send', 'Uložit změněné')->setHtmlAttribute('class', 'btn btn-danger');
        $this->addProtection();

        if ($id !== null) {

        }
        $this->onSuccess[] = $this->ReservationsFormSucceeded(...);
    }

    public function ReservationsFormSucceeded($form, RezervationsDbFormData $reservationsData)
    {
        $this->reservationsRepository->updateReservation($reservationsData);
    }

}