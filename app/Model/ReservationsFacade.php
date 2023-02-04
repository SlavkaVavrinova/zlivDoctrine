<?php

declare(strict_types=1);

namespace App\Model;

use App\Forms\ReservationsForm\RezervationsDbFormData;
use App\Model\Entities\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Database\Explorer;

class ReservationsFacade
{


	public function __construct(private EntityManagerInterface $em)
	{
	}

//	public function addReservation(RezervationsDbFormData $data)
//	{
//
//        $this->db->query('INSERT INTO `rezervationsDb`', (array) $data);
//
//	}

	public function getAllReservations()
	{
		return $this->em->getRepository(Reservation::class)->findBy([], ['id' => 'DESC']);
	}

    public function getReservation(int $id)
    {
        return $this->em->getRepository(Reservation::class)
            ->findBy(['id' => $id]);
    }

    public function updateReservation(RezervationsDbFormData $data)
    {
        $entity = $this->em->getRepository(Reservation::class)->update((array) $data);
        $this->em->persist($entity);
        $this->em->flush();

        $this->redirect("this");
    }

    public function delete(int $id)
	{
        $reservationToDelete = $this->em->getRepository(Reservation::class)->find($id);
        $this->em->remove($reservationToDelete);
        $this->em->flush();
        $this->redirect("this");

    }
}
