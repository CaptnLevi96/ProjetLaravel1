Lien Git: https://github.com/CaptnLevi96/ProjetLaravel1.git

## RAPPORT PROJET

## Introduction

Notre projet Laravel est une application web de bibliothèque en ligne permettant aux utilisateurs de parcourir un catalogue de livres, d'ajouter des livres à leur panier et de passer des commandes. L'application comprend un système d'authentification sécurisé, une gestion des autorisations pour les administrateurs et l'intégration de passerelles de paiement tierces.

## Authentification et autorisations

Nous avons implémenté un système d'authentification basé sur les fonctionnalités d'authentification intégrées de Laravel. Les utilisateurs peuvent s'inscrire, se connecter et se déconnecter de l'application. Les mots de passe des utilisateurs sont hachés de manière sécurisée avant d'être stockés dans la base de données.

En plus des utilisateurs réguliers, nous avons introduit un rôle d'utilisateur spécial appelé "administrateur". Les administrateurs bénéficient de privilèges supplémentaires leur permettant d'accéder à des fonctionnalités de gestion avancées. Ils peuvent ajouter, modifier et supprimer des livres du catalogue, ainsi que visualiser l'historique complet des paiements de tous les utilisateurs.

Pour différencier les administrateurs des utilisateurs réguliers, nous avons ajouté un champ booléen "is_admin" à la table des utilisateurs dans la base de données. Lorsqu'un utilisateur se connecte, son statut d'administrateur est vérifié en utilisant la méthode "isAdmin()" définie dans le modèle User.

Nous avons créé un middleware personnalisé appelé "AdminMiddleware" pour protéger les routes et les actions réservées aux administrateurs. Ce middleware vérifie si l'utilisateur actuellement authentifié a le statut d'administrateur avant d'autoriser l'accès aux ressources protégées. Si un utilisateur non autorisé tente d'accéder à une page réservée aux administrateurs, il est redirigé vers une page d'erreur appropriée.

## Intégration des passerelles de paiement

Pour permettre aux utilisateurs d'effectuer des achats dans notre application, nous avons intégré deux passerelles de paiement populaires : Stripe et PayPal.

L'intégration de Stripe a été réalisée à l'aide du package officiel "laravel/cashier" qui facilite l'interaction avec l'API Stripe. Nous avons configuré les clés d'API Stripe dans notre fichier d'environnement ".env" pour assurer la sécurité et la confidentialité. Lorsqu'un utilisateur procède au paiement via Stripe, un token de paiement est généré côté client à l'aide de Stripe.js et envoyé à notre serveur. Nous utilisons ensuite ce token pour effectuer la transaction via l'API Stripe et enregistrer les détails du paiement dans notre base de données.

Pour l'intégration de PayPal, nous avons utilisé la bibliothèque "omnipay/paypal" qui fournit une interface simplifiée pour communiquer avec l'API PayPal. Similaire à Stripe, les informations d'identification PayPal sont stockées de manière sécurisée dans notre fichier ".env". Lorsqu'un utilisateur choisit de payer avec PayPal, il est redirigé vers la page de paiement PayPal où il peut se connecter à son compte et confirmer le paiement.

 Une fois le paiement effectué, PayPal notifie notre application du statut de la transaction via des webhooks. Nous capturons ces notifications et mettons à jour les enregistrements de paiement correspondants dans notre base de données.
Sécurité des paiements.

La sécurité des transactions financières est d'une importance capitale dans notre application. Nous avons mis en place plusieurs mesures pour protéger les informations de paiement des utilisateurs.

Tout d'abord, toutes les communications avec les passerelles de paiement (Stripe et PayPal) sont effectuées via HTTPS pour garantir un transfert sécurisé des données. Les clés d'API et les informations d'identification sont stockées exclusivement dans notre fichier ".env" qui n'est pas accessible publiquement.

Nous ne stockons aucune information de carte de crédit ou de compte bancaire sur nos serveurs. Au lieu de cela, nous utilisons des jetons (tokens) générés par les passerelles de paiement pour référencer les transactions. Ces jetons sont uniques à chaque transaction et ne contiennent aucune donnée sensible.

Pour prévenir les attaques de type "Cross-Site Request Forgery" (CSRF), Laravel fournit une protection CSRF intégrée. Nous incluons le middleware "VerifyCsrfToken" dans nos routes de paiement pour valider les requêtes entrantes et nous assurons que les formulaires de paiement incluent le jeton CSRF nécessaire.
Enfin, nous validons et assainissons soigneusement toutes les données entrantes côté serveur avant de les traiter ou de les stocker dans la base de données. Cela nous protège contre les injections SQL et autres attaques basées sur les entrées utilisateur malveillantes.

## Conclusion

En résumé, notre projet Laravel offre une plateforme robuste et sécurisée pour une bibliothèque en ligne. Grâce à un système d'authentification fiable, à une gestion fine des autorisations pour les administrateurs et à l'intégration de passerelles de paiement de confiance, notre application garantit une expérience utilisateur fluide et sûre.

L'utilisation de middlewares pour protéger les routes sensibles, la validation stricte des données et l'emploi de jetons pour les transactions financières renforcent la sécurité globale de l'application.

Avec notre implémentation soignée, les utilisateurs peuvent profiter pleinement des fonctionnalités de la bibliothèque en ligne tout en ayant l'assurance que leurs informations personnelles et financières sont traitées avec le plus haut niveau de sécurité et de confidentialité.


PHP ARTISAN TINKER

$admin->email = 'admin@example.com';
= "admin@example.com"

$admin->password = Hash::make('admin123')
= "$2y$12$Q2EzEXDo1W8VabbRfICzJe8lO6Jk5ack7DhzazGKSdwBYZw4ff8xW"












