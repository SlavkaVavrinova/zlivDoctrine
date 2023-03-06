<?php

namespace App\Forms\ReservationsForm;

use App\Base\Controls\DateInput;
use App\Forms\ReservationsForm\ReservationsFormFactory;
use App\Model\Entities\Reservation;
use App\Model\Enums\Status;
use App\Model\ReservationsFacade;
use App\Forms\BaseForm;
use App\Model\ReservationsManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Tester\Assert;
use DateTimeInterface;

class ReservationsForm extends BaseForm
{
    private ReservationsManager $reservationsManager;
    private ReservationsFormFactory $reservationsFormFactory;

    /** @var callable[] */
    public $onSuccess = [];
    private $id;

    public function __construct(ReservationsManager $reservationsManager, ReservationsFormFactory $reservationsFormFactory, $id)
    {
        $this->reservationsManager = $reservationsManager;
        $this->reservationsFormFactory = $reservationsFormFactory;
        $this->id = $id;
        $this->addHidden("id");

        $this->addText('dateFrom', 'Date from:')
            ->setNullable()
            ->setHtmlType('date');

        $this->addText('dateTo', 'Date to:')
            ->setRequired()
            ->setHtmlType('date');
        $this->addText('name', 'Jmeno:')
            ->addRule(Form::MAX_LENGTH, null, 255);
        $statuses = [
            Status::VOLNO => 'Volno',
            Status::ZADOST => 'Žádost klienta',
            Status::BLOKACE_MAJITEL=> 'Blokace majitelem',
            Status::REZERVACE_ZALOHA_NEZAPLACENA => 'Rezervace záloha nezaplacena',
            Status::REZERVACE_SE_ZALOHOU => 'Rezervace se zálohou',
        ];
        $this->addSelect('status', 'Status:', $statuses);
        $this->addText('agency', 'Agentura:')
            ->addRule(Form::MAX_LENGTH, null, 255);

        $this->addTextArea('info', 'Info:');
        $this->addText('price', 'Cena:');
        $this->addText('paid', 'Zaplaceno:');
        $this->addText('orderID', 'OrderID:');
        $this->addText('email', 'Email:');
        $this->addText('emailDate', 'EmailDate:')        ->setHtmlType('date')
        ;

        $this->addText('phone', 'Telefon:');
        if (empty($id)) {
            $this->addSubmit('send', 'Uložit novou rezervaci')->setHtmlAttribute('class', 'btn btn-danger');
        } else{$this->addSubmit('send', 'Uložit změněné')->setHtmlAttribute('class', 'btn btn-danger');}

        $this->addProtection();
        $this->onSuccess[] = $this->ReservationsFormSucceededAdd(...);
    }

    public function ReservationsFormSucceededAdd($form, array $reservationsData)
    {
        $dateFrom = $reservationsData['dateFrom'];
        if ($dateFrom !== null) {
            $dateFrom = \DateTime::createFromFormat('Y-m-d', $dateFrom);
        }

        $dateTo = $reservationsData['dateTo'];
        if ($dateTo !== null) {
            $dateTo= \DateTime::createFromFormat('Y-m-d', $dateTo);
        }

        $emailDate= $reservationsData['emailDate'];
        if ($emailDate !== null) {
            $emailDate= \DateTime::createFromFormat('Y-m-d', $emailDate);
        }

        $reservation = new Reservation();

        $reservation->setDateFrom($dateFrom);
        $reservation->setDateTo($dateTo);
        $reservation->setName($reservationsData['name']);
             $reservation->setStatus($reservationsData['status']);
        $reservation->setAgency($reservationsData['agency']);

        $reservation->setInfo($reservationsData['info']);
        $reservation->setPrice($reservationsData['price']);
        $reservation->setPaid($reservationsData['paid']);
        $reservation->setOrderID($reservationsData['orderID']);
        $reservation->setEmail($reservationsData['email']);
        if (!empty($emailDate)) {
            $reservation->setEmailDate($emailDate);
        }

        $reservation->setPhone($reservationsData['phone']);

        if (!empty($reservationsData['id'])) {
            $reservation->setId($reservationsData['id']);
            $this->reservationsManager->updateReservation($reservation);
            $this->onSuccess = $reservation->getId();
        } else {
            $this->reservationsManager->addReservation($reservation);
        }
    }
}