<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genealogy\StoreGenealogyRequest;
use App\Http\Resources\GenealogyResource;
use App\Models\Genealogy;
use App\Traits\GenealogyTrait;
use Illuminate\Http\Request;

class GenealogyController extends Controller
{
    use GenealogyTrait;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * @dev This controller uses policies to restrict access.
         */
        $this->authorizeResource(Genealogy::class, 'genealogy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Retrieve genealogies with pagination
         */
        $genealogies = Genealogy::with('referral', 'reference')
            ->simplePaginate();

        /**
         * Retrun a resource collection of genealogies
         */
        return GenealogyResource::collection($genealogies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenealogyRequest $request)
    {
        /**
         * Create genealogy
         */

        $genealogy = Genealogy::create($request
            ->validated());

        // Call onNewGenealogyCreated from GenealogyTrait trait
        $this->onNewGenealogyCreated($genealogy);

        /**
         * Return a resource of genealogy
         */
        return new GenealogyResource($genealogy
            ->load('referral', 'reference'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return \Illuminate\Http\Response
     */
    public function show(Genealogy $genealogy)
    {
        /**
         * Return a resource of genealogy
         */
        return new GenealogyResource($genealogy
            ->load('referral', 'reference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genealogy  $genealogy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genealogy $genealogy)
    {
        /**
         * Function is disabled, genealogies are not editable after creation
         */

        return response()->json(['message' => 'Function is disabled'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genealogy  $genealogy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genealogy $genealogy)
    {
        /**
         * Function is disabled, genealogies are not deletable after creation
         */

        return response()->json(['message' => 'Function is disabled'], 200);
    }
}
