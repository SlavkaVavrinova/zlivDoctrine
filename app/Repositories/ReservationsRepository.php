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

//	public function addReservation(RezervationsDbFormData $data)
//	{
//
//        $this->db->query('INSERT INTO `rezervationsDb`', (array) $data);
//
//	}

	public function getAllReservations()
	{
    	return $this->em->getRepository(Reservation::class)->findAll();
	}

    public function getReservation(int $id)
    {
        return $this->em->find(Reservation::class, $id);
    }

    public function updateReservation(int $id, RezervationsDbFormData $data)
    {
        if (empty($id)) {
$reservation =$this->em->getRepository(Reservation::class);
    $this->em->persist($data);
            $this->em->flush();
        } else {
            $reservation = $this->em->getRepository(Reservation::class)->find($id);
            if (!$reservation) {
                throw new EntityNotFoundException('Reservation with ID ' . $id . ' not found');
            }
            foreach ($data as $key => $value) {
                $reservation->$key = $value;
            }
            $this->em->flush();

            $this->redirect("this");
        }



    }



    public function delete(int $id)
	{
        $reservationToDelete = $this->em->getRepository(Reservation::class)->find($id);
        $this->em->remove($reservationToDelete);
        $this->em->flush();


    }
}
