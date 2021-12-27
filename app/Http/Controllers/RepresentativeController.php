<?php

namespace App\Http\Controllers;

use App\Http\Requests\Representative\StoreRepresentativeRequest;
use App\Http\Requests\Representative\UpdateRepresentativeRequest;
use App\Http\Resources\RepresentativeResource;
use App\Models\Representative;
use App\Models\User;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
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
        $this->authorizeResource(Representative::class, 'representative');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Retrieve representatives with pagination
         */
        $representatives = Representative::with('user')->simplePaginate();

        /**
         * Return a resource collection of representatives
         */
        return RepresentativeResource::collection($representatives);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepresentativeRequest $request)
    {
        /**
         * Create user for representative
         */
        $user = User::create(array_merge(
            $request->validated(),
            ['role' => 'REPRESENTATIVE']
        ));

        /**
         * Create representative
         */
        $representative = $user->representative()->create($request->validated());


        /**
         * Return a resource of the representative
         */
        return new RepresentativeResource($representative->load('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Representative  $representative
     * @return \Illuminate\Http\Response
     */
    public function show(Representative $representative)
    {
        /**
         * Return a resource of the representative
         */
        return new RepresentativeResource($representative->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Representative  $representative
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepresentativeRequest $request, Representative $representative)
    {
        /**
         * Update user model of representative
         */
        $representative->user->update($request->validated());

        /**
         * Update representative model
         */
        $representative->update($request->validated());

        /**
         * Return a resource of the representative
         */
        return new RepresentativeResource($representative);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Representative  $representative
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representative $representative)
    {
        /**
         * Delete user model of representative
         * for it will also delete the representative
         * model connected to it
         */
        $representative->user->delete();

        /**
         * Return a 204 null response
         */
        return response()->json(null, 204);
    }
}
