<?php

namespace App\Ruzenka\Presenters;


use App\Model\Entities\Reservation;
use App\Model\ReservationsFacade;
use App\Model\UserFacade;
use App\Ruzenka\Presenters\RequireLoggedUser;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\SimpleIdentity;



class ReservationsPresenter extends \Nette\Application\UI\Presenter
{
    use RequireLoggedUser;



    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function renderReservations(): void
    {
        $reservations = $this->em->getRepository(Reservation::class)->findAll();

        $this->template->reservations = $reservations;

       $this->template->loginUser = $this->getUser()->getId();

    }

}