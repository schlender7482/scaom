@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        Login realizado com sucesso!
                    </h5>
                    <p class="card-text">
                        Bem-vindo, <strong>{{ Auth::user()->name }}</strong>!
                    </p>
                    <p class="text-muted small mb-0">
                        Seu perfil: <span class="badge bg-{{ Auth::user()->role->cor }}">{{ Auth::user()->role->nome }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection