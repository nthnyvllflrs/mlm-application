<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenealogyWalletResource;
use App\Models\GenealogyWallet;
use Illuminate\Http\Request;

class GenealogyWalletController extends Controller
{
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
        $this->authorizeResource(GenealogyWallet::class, 'genealogyWallet');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Retrieve genealogy wallets with pagination
         */
        $genealogyWallets = GenealogyWallet::with('genealogy')->simplePaginate();

        /**
         * Return a resource collection of genealogy wallets
         */
        return GenealogyWalletResource::collection($genealogyWallets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Function is disabled, genealogies are not editable after creation
         */

        return response()->json(['message' => 'Function is disabled'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return \Illuminate\Http\Response
     */
    public function show(GenealogyWallet $genealogyWallet)
    {
        /**
         * Return a resource of genealogy wallet
         */
        return new GenealogyWalletResource($genealogyWallet->load('genealogy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GenealogyWallet $genealogyWallet)
    {
        /**
         * Function is disabled, genealogies are not editable after creation
         */

        return response()->json(['message' => 'Function is disabled'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GenealogyWallet  $genealogyWallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenealogyWallet $genealogyWallet)
    {
        /**
         * Function is disabled, genealogies are not editable after creation
         */

        return response()->json(['message' => 'Function is disabled'], 200);
    }
}
