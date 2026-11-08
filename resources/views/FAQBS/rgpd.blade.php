@extends('layouts.app')

@section('title')
Politique de confidentialité - RGPD - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container py-5" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- En-tête -->
            <div class="card mb-4 shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background: white;">
                <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; border-radius: 15px 15px 0 0; padding: 2rem;">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid mb-3" style="max-height: 80px;">
                        <h1 class="mb-2" style="font-weight: 700; font-size: 2rem;">Politique de confidentialité et RGPD</h1>
                        <p class="mb-0 opacity-90">Bibliothèques sonores de la région Centre - Val de Loire</p>
                    </div>
                </div>
            </div>

            <!-- Contenu RGPD -->
            <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background: white;">
                <div class="card-body" style="padding: 2.5rem;">
                    
                    <!-- Introduction -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Introduction</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Conformément au Règlement Général sur la Protection des Données (RGPD) de l'Union européenne, 
                            les Bibliothèques sonores de la région Centre - Val de Loire s'engagent à protéger vos données personnelles 
                            et à respecter votre vie privée.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Cette politique explique comment nous collectons, utilisons, conservons et protégeons vos informations.
                        </p>
                    </section>

                    <!-- Données collectées -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Données personnelles collectées</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Nous collectons les informations suivantes lorsque vous vous inscrivez ou utilisez nos services :
                        </p>
                        <ul style="line-height: 2; color: #495057; font-size: 1.05rem; padding-left: 20px;">
                            <li><strong>Nom et prénom</strong> : pour personnaliser votre expérience</li>
                            <li><strong>Adresse email</strong> : pour la communication et l'envoi d'informations</li>
                            <li><strong>Coordonnées téléphoniques</strong> : pour le contact direct si nécessaire</li>
                            <li><strong>Adresse postale</strong> : pour l'envoi de documents si applicable</li>
                            <li><strong>Informations de connexion</strong> : identifiant et mot de passe chiffré</li>
                        </ul>
                    </section>

                    <!-- Finalité -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Finalité du traitement</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Vos données sont utilisées uniquement pour :
                        </p>
                        <ul style="line-height: 2; color: #495057; font-size: 1.05rem; padding-left: 20px;">
                            <li>Gérer votre adhésion à l'association</li>
                            <li>Faciliter la communication entre bénévoles</li>
                            <li>Organiser les activités des Bibliothèques sonores</li>
                            <li>Respecter nos obligations légales</li>
                        </ul>
                    </section>

                    <!-- Droits -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Vos droits</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Conformément au RGPD, vous disposez des droits suivants :
                        </p>
                        <ul style="line-height: 2; color: #495057; font-size: 1.05rem; padding-left: 20px;">
                            <li><strong>Droit d'accès</strong> : obtenir une copie de vos données personnelles</li>
                            <li><strong>Droit de rectification</strong> : corriger vos informations si elles sont inexactes</li>
                            <li><strong>Droit à l'effacement</strong> : demander la suppression de vos données</li>
                            <li><strong>Droit à la limitation</strong> : limiter le traitement de vos données</li>
                            <li><strong>Droit à la portabilité</strong> : récupérer vos données dans un format structuré</li>
                            <li><strong>Droit d'opposition</strong> : vous opposer au traitement de vos données</li>
                        </ul>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem; margin-top: 1.5rem;">
                            Pour exercer ces droits, contactez-nous à : <a href="mailto:contact@bibliothèques-sonores-centrevaldeloire.fr" style="color: #002D5D; text-decoration: underline; font-weight: 600;">contact@bibliothèques-sonores-centrevaldeloire.fr</a>
                        </p>
                    </section>

                    <!-- Conservation -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Durée de conservation</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Vos données sont conservées pendant toute la durée de votre adhésion à l'association, 
                            puis pendant 3 ans après votre départ pour des besoins de traçabilité. Au-delà, elles sont 
                            anonymisées ou supprimées.
                        </p>
                    </section>

                    <!-- Sécurité -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Sécurité des données</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Nous mettons en œuvre des mesures techniques et organisationnelles pour protéger vos données 
                            contre toute perte, utilisation abusive ou accès non autorisé. Vos informations sont stockées 
                            sur des serveurs sécurisés et accessibles uniquement aux personnes autorisées.
                        </p>
                    </section>

                    <!-- Cookies -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Cookies</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Notre site utilise des cookies strictement nécessaires au fonctionnement du service. 
                            Nous n'utilisons pas de cookies de suivi publicitaire.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section class="mb-4">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Contact</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Pour toute question concernant cette politique de confidentialité ou vos données personnelles, 
                            vous pouvez nous contacter par email ou par courrier.
                        </p>
                        <div style="margin-top: 1.5rem;">
                            <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                                <strong>Email :</strong> <a href="mailto:contact@bibliothèques-sonores-centrevaldeloire.fr" style="color: #002D5D; text-decoration: underline;">contact@bibliothèques-sonores-centrevaldeloire.fr</a>
                            </p>
                            <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                                <strong>Adresse :</strong> Bibliothèques sonores Centre Val de Loire<br>
                                [Adresse complète à préciser]
                            </p>
                        </div>
                    </section>

                    <!-- Date -->
                    <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 2px solid #e9ecef; text-align: right;">
                        <p style="color: #6c757d; margin-bottom: 0;">Mise à jour : {{ date('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
