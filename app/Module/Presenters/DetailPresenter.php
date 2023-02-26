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
public ?int $id = null;
//    private ReservationsFacade $reservationsFacade;
//    private ReservationsFormFactory $reservationsFormFactory;

    public function __construct(private ReservationsFormFactory $reservationsFormFactory, private ReservationsRepository $reservationsRepository)
    {
//        $this->reservationsFormFactory = $reservationsFormFactory;
//        $this->reservationsFacade = $reservationsFacade;
    }


    protected function createComponentReservationsForm(): ReservationsForm
    {
        bdump($this->id);
        $form = $this->reservationsFormFactory->create($this->id);
        bdump($this->id);
bdump("xxxxxxxxxxxxxxxxxxxxx");
        $form->onSuccess[] = function () {
            bdump($this->id);
            if (!empty($this->id)) {
                $this->flashMessage('Rezervace upravena');
                $this->redirect('Detail:Detail');
            } else {
                $this->flashMessage('Rezervace uložena');
                $this->redirect('Reservations:Reservations');
            }
        };
        bdump($form->onSuccess);

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
        $this->id = $id;
        $this->template->id = $id;
        $editedReservation = $this->reservationsRepository->getReservation($id);
        $defaults['id'] = $id;

        foreach ($editedReservation as $key => $data) {
            if ($data instanceof DateTime) {
                $defaults[$key] = $data->format('Y-m-d');
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