<?php

namespace App\Ruzenka\Presenters;


use App\Model\ReservationsManager;
use App\Model\UserFacade;
use App\Ruzenka\Presenters\RequireLoggedUser;


class ReservationsPresenter extends \Nette\Application\UI\Presenter
{
    use RequireLoggedUser;

    private UserFacade $userFacade;

    public function __construct(protected ReservationsManager $reservationsManager, UserFacade $userFacade)
    {
        $this->userFacade = $userFacade;
    }

    public function renderReservations(): void
    {
        $reservations = $this->reservationsManager->getAllReservations();

        $this->template->reservations = $reservations;

        $user = $this->userFacade->getLogedUserRow($this->getUser()->getId());
       $this->template->loginUserUsername = $user->getUsername();

    }
}