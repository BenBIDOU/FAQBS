@extends('layouts.app')

@section('title')
Règlement du site - Bibliothèques sonores de la région Centre - Val de Loire
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
                        <h1 class="mb-2" style="font-weight: 700; font-size: 2rem;">Règlement du site</h1>
                        <p class="mb-0 opacity-90">Bibliothèques sonores de la région Centre - Val de Loire</p>
                    </div>
                </div>
            </div>

            <!-- Contenu du règlement -->
            <div class="card shadow-sm" style="border: none; border-radius: 15px; overflow: hidden; background: white;">
                <div class="card-body" style="padding: 2.5rem;">
                    
                    <!-- Préambule -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Préambule</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Le présent règlement définit les conditions d'utilisation du site des Bibliothèques sonores 
                            de la région Centre - Val de Loire. Tout utilisateur accédant à ce site s'engage à respecter 
                            ces règles.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Ce site est réservé aux membres de l'association et aux bénévoles autorisés.
                        </p>
                    </section>

                    <!-- Accès au site -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 1 - Accès au site</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            L'accès au site est réservé aux membres en règle de cotisation et aux bénévoles 
                            de l'association Bibliothèques sonores Centre Val de Loire.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Chaque utilisateur reçoit des identifiants de connexion personnels qu'il s'engage à ne 
                            pas divulguer.
                        </p>
                    </section>

                    <!-- Utilisation -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 2 - Utilisation du site</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Le site a pour vocation de faciliter la communication entre les bénévoles et l'organisation 
                            des activités de l'association.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Les utilisateurs s'engagent à utiliser le site conformément à sa destination et à ne pas 
                            l'utiliser à des fins commerciales, politiques ou illégales.
                        </p>
                    </section>

                    <!-- Comportement -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 3 - Règles de comportement</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Les échanges sur le site doivent respecter les règles suivantes :
                        </p>
                        <ul style="line-height: 2; color: #495057; font-size: 1.05rem; padding-left: 20px;">
                            <li>Respect mutuel entre tous les membres</li>
                            <li>Pas de propos diffamatoires, injurieux ou discriminatoires</li>
                            <li>Pas de messages à caractère politique, religieux ou commercial</li>
                            <li>Respect de la vie privée de chacun</li>
                            <li>Interdiction de publier des informations confidentielles sur l'association ou ses membres</li>
                        </ul>
                    </section>

                    <!-- Responsabilités -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 4 - Responsabilités</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Chaque utilisateur est responsable des contenus qu'il publie sur le site. L'association 
                            se réserve le droit de supprimer tout contenu ne respectant pas le présent règlement.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Les administrateurs du site peuvent, à tout moment, suspendre ou supprimer l'accès 
                            d'un utilisateur ne respectant pas ces règles.
                        </p>
                    </section>

                    <!-- Propriété intellectuelle -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 5 - Propriété intellectuelle</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Tous les contenus publiés sur ce site (textes, images, logos, etc.) sont la propriété 
                            de l'association Bibliothèques sonores Centre Val de Loire, sauf mention contraire.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Toute reproduction ou utilisation non autorisée de ces contenus est interdite.
                        </p>
                    </section>

                    <!-- Protection des données -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 6 - Protection des données personnelles</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Les données personnelles des utilisateurs sont traitées conformément à notre <a href="{{ route('rgpd') }}" style="color: #002D5D; text-decoration: underline; font-weight: 600;">politique de confidentialité</a> 
                            et au Règlement Général sur la Protection des Données (RGPD).
                        </p>
                    </section>

                    <!-- Modifications -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 7 - Modifications du règlement</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            L'association se réserve le droit de modifier le présent règlement à tout moment. 
                            Les utilisateurs seront informés des modifications par email ou via une notification 
                            sur le site.
                        </p>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            La continuation de l'utilisation du site après modification vaut acceptation du nouveau 
                            règlement.
                        </p>
                    </section>

                    <!-- Sanctions -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 8 - Sanctions</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            En cas de manquement au présent règlement, les sanctions suivantes peuvent être appliquées :
                        </p>
                        <ul style="line-height: 2; color: #495057; font-size: 1.05rem; padding-left: 20px;">
                            <li>Avertissement écrit</li>
                            <li>Suspension temporaire de l'accès au site</li>
                            <li>Exclusion définitive du site</li>
                            <li>Exclusion de l'association (pour les membres)</li>
                        </ul>
                    </section>

                    <!-- Litiges -->
                    <section class="mb-5">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Article 9 - Litiges</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Tout litige concernant l'interprétation ou l'application du présent règlement sera 
                            soumis au Conseil d'Administration de l'association.
                        </p>
                    </section>

                    <!-- Contact -->
                    <section class="mb-4">
                        <h2 style="color: #002D5D; font-weight: 700; margin-bottom: 1.5rem;">Contact</h2>
                        <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                            Pour toute question concernant ce règlement, contactez-nous :
                        </p>
                        <div style="margin-top: 1.5rem;">
                            <p style="line-height: 1.8; color: #495057; font-size: 1.05rem;">
                                <strong>Email :</strong> <a href="mailto:contact@bibliothèques-sonores-centrevaldeloire.fr" style="color: #002D5D; text-decoration: underline;">contact@bibliothèques-sonores-centrevaldeloire.fr</a>
                            </p>
                        </div>
                    </section>

                    <!-- Date -->
                    <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 2px solid #e9ecef; text-align: right;">
                        <p style="color: #6c757d; margin-bottom: 0;">Dernière mise à jour : {{ date('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
