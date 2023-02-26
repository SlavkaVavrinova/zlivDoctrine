<?php

declare(strict_types=1);

namespace App\Model;

use App\Base\Database\BaseRepository;
use App\Forms\ReservationsForm\RezervationsDbFormData;
use App\Model\Entities\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Database\Explorer;

class ReservationsRepository extends BaseRepository
{


	public function __construct(private EntityManagerInterface $em)
	{
	}

	public function addReservation(Reservation $data)
	{

        $this->em->getRepository(Reservation::class);
        $this->em->persist($data);
        $this->em->flush();

	}

	public function getAllReservations()
	{
        return $this->em->createQueryBuilder()
            ->select('r')
            ->from(Reservation::class, 'r')
            ->orderBy('r.dateFrom')
            ->getQuery()
            ->getResult();
	}

    public function getReservation(int $id)
    {
        return $this->em->find(Reservation::class, $id);
    }

    public function updateReservation(Reservation $reservation)
    {
        bdump("je to tu");
        bdump($reservation);
        if (!$reservation) {
            throw new EntityNotFoundException('Reservation with ID ' . $reservation->getId() . ' not found');
        }


            $this->em->getRepository(Reservation::class);
    $this->em->persist($reservation);
            $this->em->flush();





    }



    public function delete(int $id)
	{
        $reservationToDelete = $this->em->getRepository(Reservation::class)->find($id);
        $this->em->remove($reservationToDelete);
        $this->em->flush();


    }
}
