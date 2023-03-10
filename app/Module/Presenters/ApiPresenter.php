<?php

namespace App\Presenters;


use App\Email\EmailService;
use App\Model\ReservationsManager;
use Nette\Application\Responses\JsonResponse;
use App\Model\ReservationsFacade;
use Nette\Utils\Json;

class ApiPresenter extends AbstractPresenter
{
    private ReservationsManager $reservationsManager;
    private EmailService $emailService;


    public function __construct(ReservationsManager $reservationsManager,  EmailService $emailService)
    {
        parent::__construct();
        $this->reservationsManager = $reservationsManager;
        $this->emailService = $emailService;
    }

    public function actionDefault()
    {
        // adresa http://localhost/zlivDoctrine/www/api/
        $reservations = $this->reservationsManager->getAllReservations();
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
            $data[] = $row;
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
bdump($dataCoPrisla);
            $today = new DateTime();
            $dataCoPrisla['emailDate'] = $today->format('Y-m-d');
            $this->emailService->sendReservationEmail($dataCoPrisla);

            $this->reservationsManager->updateReservationApi($dataCoPrisla);
// todo takto m?? vypadat json odeslan?? jako json, raw, post i GET funguje. Jde poslat jen 1
//{
//   "id":1000,
//   "Termin":"20.05.2024-27.05.2024",
//   "Stav":"P??ed z??lohou",
//   "Agentura":"Na??i",
//   "Jmeno":"Jana "
//}
        }
    }
}