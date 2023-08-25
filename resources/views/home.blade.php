@extends('layouts.app')
@section('titulo')
   Devstagram
@endsection

@section('contenido')

  <x-listar-post :posts="$posts"/> {{-- componente --}}

@endsection