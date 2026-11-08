@extends('layouts.app')

@section('title')
Acceptation du règlement - Bibliothèques sonores Centre Val de Loire
@endsection

@section('content')
<div class="container py-5" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="row justify-content-center w-100">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg" style="border: none; border-radius: 15px; overflow: hidden; background: white;">
                <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; border-radius: 15px 15px 0 0; padding: 2rem; text-align: center;">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid mb-3" style="max-height: 60px;">
                    <h2 class="mb-0" style="font-weight: 700;">Acceptation du règlement</h2>
                </div>
                
                <div class="card-body" style="padding: 2.5rem; text-align: center;">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 4rem; color: #ffc107;"></i>
                    </div>
                    
                    <h3 style="color: #002D5D; margin-bottom: 1.5rem;">Acceptation requise</h3>
                    
                    <p style="line-height: 1.8; color: #495057; font-size: 1.1rem; margin-bottom: 2rem;">
                        Pour accéder à l'espace membre, vous devez accepter le règlement du site des Bibliothèques sonores 
                        de la région Centre - Val de Loire.
                    </p>
                    
                    <p style="line-height: 1.8; color: #495057; font-size: 1rem; margin-bottom: 2rem;">
                        Veuillez lire attentivement notre <a href="{{ route('reglement') }}" target="_blank" style="color: #002D5D; text-decoration: underline; font-weight: 600;">règlement du site</a> 
                        avant de continuer.
                    </p>
                    
                    <form method="POST" action="{{ route('accept.reglement') }}">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; font-weight: 600; border-radius: 10px; padding: 12px;">
                                <i class="bi bi-check-circle-fill me-2"></i> J'accepte le règlement et je continue
                            </button>
                            <a href="{{ route('reglement') }}" target="_blank" class="btn btn-lg btn-outline-secondary" style="border-radius: 10px; padding: 12px; color: #002D5D; border-color: #002D5D;">
                                <i class="bi bi-file-text me-2"></i> Lire le règlement d'abord
                            </a>
                        </div>
                    </form>
                    
                    @if(session('error'))
                        <div class="alert alert-danger mt-3" style="border-radius: 8px; border: none;">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
