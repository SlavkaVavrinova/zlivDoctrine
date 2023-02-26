<?php

namespace App\Presenters;


use App\Model\ReservationsRepository;
use Nette\Application\Responses\JsonResponse;
use App\Model\ReservationsFacade;
use Nette\Utils\Json;

class ApiPresenter extends AbstractPresenter
{
    private ReservationsRepository $reservationsRepository;

    public function __construct(ReservationsRepository $reservationsRepository)
    {
        parent::__construct();
        $this->reservationsRepository = $reservationsRepository;
    }

    public function actionDefault()
    {
        // adresa http://localhost/zlivDoctrine/www/api/
        $reservations = $this->reservationsRepository->getAllReservations();
        $data = [];
        $dateFrom = null;
        $dateTo = null;
        foreach ($reservations as $reservation) {
            $id = $reservation->id;
            $row = [];
            foreach ($reservation as $key => $value) {
                if ($key === 'dateFrom') {
                    $dateFrom = $value->format('d.m.Y');
                }
                if ($key === 'dateTo') {
                    $dateTo = $value->format('d.m.Y');
                }
                if ($key === 'id') {
                    $row[$key] = $value;
                } if ($key === 'status') {
                    $row[$key] = $value;
                }
            }

            $row['term'] = $dateFrom . " - " . $dateTo;
            $data[$dateFrom] = $row;
        }

        $response = new JsonResponse($data);

        header("Access-Control-Allow-Origin: *");
        $this->sendResponse($response);

        if ($this->getHttpRequest()->getMethod() === "POST") {
            $dataCoPrisla = Json::decode($this->getHttpRequest()->getRawBody());
            print_r($dataCoPrisla);
        }
    }

    public function actionRequest()
    {

// adresa http://localhost/zliv/www/api/request
        if ($this->getHttpRequest()->getMethod() === "POST") {
            $dataCoPrisla = Json::decode($this->getHttpRequest()->getRawBody());
            
            $this->reservationsRepository->addReservation($dataCoPrisla);
// todo takto má vypadat json odeslaný jako json, raw, post i GET funguje. Jde poslat jen 1
//
//{
//   "id":1000,
//   "Termin":"20.05.2024-27.05.2024",
//   "Stav":"Před zálohou",
//   "Agentura":"Naši",
//   "Jmeno":"Jana "
//}
        }
    }
}