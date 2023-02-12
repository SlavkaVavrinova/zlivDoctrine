<?php

namespace App\Presenters;


use Nette\Application\Responses\JsonResponse;
use App\Model\ReservationsFacade;
use Nette\Utils\Json;

class ApiPresenter extends AbstractPresenter
{
    private ReservationsFacade $reservationsFacade;

    public function __construct(ReservationsFacade $reservationsFacade)
    {
        $this->reservationsFacade = $reservationsFacade;
        parent::__construct();
    }

    public function actionDefault()
    {
        // adresa http://localhost/zliv/www/api/
        $reservations = $this->reservationsFacade->getAllReservations();
        $data = [];
        foreach ($reservations as $reservation) {
            $id = $reservation->id;
            $row = [];
            foreach ($reservation as $key => $value) {
                if ($key !== 'id') {
                    $row[$key] = $value;
                }
            }
            $data[$id] = $row;
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
            
            $this->reservationsFacade->addReservation($dataCoPrisla);
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