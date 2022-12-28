<?php

namespace App\Http\Controllers\Api;

use App\Services\Contracts\ExamplesServiceInterface;
use Illuminate\Http\Request;

/**
 * Class ExamplesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ExamplesController extends HttpController
{
    /**
     * Parameter
     *
     * @var ExamplesServiceInterface
     */
    protected $examplesService;

    /**
     * ExamplesServiceInterface constructor.
     *
     * @param ExamplesServiceInterface $examplesService
     */
    public function __construct(ExamplesServiceInterface $examplesService)
    {
        $this->examplesService = $examplesService;
    }

    public function index(Request $request)
    {
        $data = $this->examplesService->index($request);
        return $this->responseSuccess($data);
    }

    public function store(Request $request)
    {
        $this->examplesService->store($request);
        return $this->responseOk();
    }
}
