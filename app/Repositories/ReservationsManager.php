<?php

declare(strict_types=1);

namespace App\Model;

use App\Base\Database\BaseRepository;
use App\Model\Entities\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class ReservationsManager extends BaseRepository
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
        $entity = $this->em->getRepository(Reservation::class)->find($reservation->getId());
        if (!$entity) {
            throw new EntityNotFoundException('Reservation with ID ' . $reservation->getId() . ' not found');
        }
        $entity->setAgency($reservation->agency);
        $entity->setName($reservation->name);
        $entity->setInfo($reservation->info);
        $entity->setPrice($reservation->price);
        $entity->setPaid($reservation->paid);
        $entity->setOrderID($reservation->orderID);
        $entity->setPhone($reservation->phone);
        $entity->setEmail($reservation->email);
        if (!empty($reservation->emailDate)) {
            $entity->setEmailDate($reservation->emailDate);
        }
        $entity->setDateFrom($reservation->dateFrom);
        $entity->setDateTo($reservation->dateTo);
        $entity->setStatus($reservation->status);
        bdump($entity);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete(int $id)
	{
        $reservationToDelete = $this->em->getRepository(Reservation::class)->find($id);
        $this->em->remove($reservationToDelete);
        $this->em->flush();
    }
}
