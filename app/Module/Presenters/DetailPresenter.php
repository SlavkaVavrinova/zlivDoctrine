<?php

namespace App\Ruzenka\Presenters;

use App\Forms\ReservationsForm\ReservationsForm;
use App\Forms\ReservationsForm\ReservationsFormFactory;
use App\Model\ReservationsRepository;
use DateTime;
use Nette\Application\UI\Presenter;

class DetailPresenter extends Presenter
{
    use RequireLoggedUser;

//    private ReservationsFacade $reservationsFacade;
//    private ReservationsFormFactory $reservationsFormFactory;

    public function __construct(private ReservationsFormFactory $reservationsFormFactory, private ReservationsRepository $reservationsRepository)
    {
//        $this->reservationsFormFactory = $reservationsFormFactory;
//        $this->reservationsFacade = $reservationsFacade;
    }


    protected function createComponentReservationsForm(): ReservationsForm
    {
        $form = $this->reservationsFormFactory->create();
        $form->onSuccess[] = function () {
            $this->flashMessage('Rezervace uložena');
            $this->redirect('Reservations:Reservations');
        };
        return $form;
    }


    public function renderDetail($id): void
    {
        $selectedReservation = $this->reservationsRepository->getReservation($id);

        if (!$selectedReservation) {
            $this->error();
        }

        $this->template->selectedReservation = $selectedReservation;
        $this->template->id = $id;
    }


    public function renderEdit(int $id): void
    {
        $editedReservation = $this->reservationsRepository->getReservation($id);
        $defaults['id'] = $id;

        foreach ($editedReservation as $key => $data) {
            if ($data instanceof DateTime) {
                $defaults[$key] = $data->format('d.m.Y');
            } else {
                $defaults[$key] = $data;
            }
        }

        $form = $this->getComponent('reservationsForm');
        $form->setDefaults($defaults);
    }


    public function handleDelete(int $id): void
    {

        $this->reservationsRepository->delete($id);
        $this->redirect('Reservations:Reservations');
    }


}