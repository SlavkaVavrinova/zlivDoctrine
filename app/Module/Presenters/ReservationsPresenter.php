<?php

namespace App\Ruzenka\Presenters;


use App\Model\Entities\Reservation;

use App\Model\ReservationsRepository;
use App\Model\UserFacade;
use App\Ruzenka\Presenters\RequireLoggedUser;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\SimpleIdentity;



class ReservationsPresenter extends \Nette\Application\UI\Presenter
{
    use RequireLoggedUser;



    public function __construct(protected ReservationsRepository$reservationsRepository)
    {
    }

    public function renderReservations(): void
    {
        $reservations = $this->reservationsRepository->getAllReservations();

        $this->template->reservations = $reservations;
       $this->template->loginUser = $this->getUser()->getId();

    }

}