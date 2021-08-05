<?php

namespace App\Http\Controllers\Api\v1;

use App\Traits\Response;
use Illuminate\Routing\Controller;

abstract class ApiController extends Controller
{
    use Response;
}
