@extends('layouts.app')

@section('title', 'Detail Produk')
@section('header_title', 'Katalog Produk')

@section('content')
    <x-product-detail :product="$product" :isAdmin="true" />
@endsection