<?php

namespace App\Forms\ReservationsForm;

interface ReservationsFormFactory
{
    public function create(int|null $id = null): ReservationsForm;

}