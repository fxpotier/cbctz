<?php

namespace CityByCitizen\Http\Controllers;



class BackOfficeController extends Controller {

    function __construct() {
        $this->middleware('auth');
        // TODO add admin middleware
    }

    public function getIndex() {
        return view('backOffice/dashboard');
    }
}