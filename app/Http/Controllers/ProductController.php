<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use Response;

class ProductController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return response()->json( Product::all() );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$rules     = Product::$rules;
		$validator = Validator::make( $request->all(), $rules );
		if ( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ] );
		}
		$product = Product::create( [
			'name'  => $request->get( 'name' ),
			'code'  => $request->get( 'code' ),
			'price' => $request->get( 'price' )
		] );

		return response()->json( $product, 201 );

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product $product
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( Product $product ) {
		return response()->json( Product::find( $product )->first() );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Product $product
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Product $product ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Product $product
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, Product $product ) {
		$rules         = Product::$rules;
		$rules['code'] = $rules['code'] . ',code,' . $product->id;
		$validator     = Validator::make( $request->all(), $rules );
		if ( $validator->fails() ) {
			return response()->json( [ 'errors' => $validator->errors() ] );
		}
		$product = Product::findOrFail( $product );
		$product->each->update( [
			'name'  => $request->get( 'name' ),
			'code'  => $request->get( 'code' ),
			'price' => $request->get( 'price' )
		] );

		return response()->json( $product, 200 );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Product $product
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Product $product ) {
		$product = Product::findOrFail( $product );
		$product->each->delete();

		return response()->json( '', 204 );
	}

	public function checkUniqueCode( Request $request ) {
		$data = $request->only( 'code', 'id' );
		if ( ! isset( $data['id'] ) ) {
			$data['id'] = null;
		}
		$result = Product::where( 'code', '=', $data['code'] )->where( 'id', '!=', $data['id'] )->first();
		if ( $result ) {
			return response( 'false' );
		}

		return response( 'true' );
	}
}
