Lien Git: https://github.com/CaptnLevi96/ProjetLaravel1.git

## Projet de Bibliothèque en Ligne avec Laravel

## Introduction

Ce projet est une application web de bibliothèque en ligne développée avec le framework Laravel. Il permet aux utilisateurs de parcourir un catalogue de livres, d'ajouter des livres à leur panier, de passer des commandes et d'effectuer des paiements via Stripe ou PayPal. L'application comprend un système d'authentification sécurisé, une gestion des autorisations pour les administrateurs et l'intégration de passerelles de paiement tierces.

## Fonctionnalités principales

## Authentification et Autorisations

Le projet utilise le système d'authentification intégré de Laravel pour gérer l'inscription, la connexion et la déconnexion des utilisateurs. Les mots de passe des utilisateurs sont hachés de manière sécurisée avant d'être stockés dans la base de données.

En plus des utilisateurs réguliers, il existe un rôle d'utilisateur spécial appelé "administrateur". Les administrateurs ont des privilèges supplémentaires leur permettant d'accéder à des fonctionnalités de gestion avancées, telles que l'ajout, la modification et la suppression de livres du catalogue, ainsi que la visualisation de l'historique complet des paiements de tous les utilisateurs.

Pour différencier les administrateurs des utilisateurs réguliers, un champ booléen "is_admin" a été ajouté à la table "users" dans la base de données. La méthode "isAdmin()" du modèle User est utilisée pour vérifier le statut d'administrateur d'un utilisateur.

Un middleware personnalisé appelé "AdminMiddleware" a été créé pour protéger les routes et les actions réservées aux administrateurs. Ce middleware vérifie si l'utilisateur actuellement authentifié a le statut d'administrateur avant d'autoriser l'accès aux ressources protégées. Les utilisateurs non autorisés sont redirigés vers une page d'erreur appropriée.

## Gestion du Catalogue

Les administrateurs ont la possibilité d'ajouter de nouveaux livres au catalogue, de modifier les informations des livres existants et de supprimer des livres si nécessaire. Les utilisateurs réguliers peuvent parcourir le catalogue et voir les détails de chaque livre.

## Panier d'Achat

Les utilisateurs peuvent ajouter des livres à leur panier d'achat en naviguant dans le catalogue. Le panier permet aux utilisateurs de modifier les quantités des livres sélectionnés et de supprimer des livres du panier s'ils changent d'avis. Le contenu du panier est affiché avec le prix total des articles sélectionnés.

## Paiements

Le projet intègre deux passerelles de paiement populaires : Stripe et PayPal. L'intégration de Stripe a été réalisée à l'aide du package officiel "laravel/cashier", tandis que pour PayPal, la bibliothèque "omnipay/paypal" a été utilisée.
Les informations sensibles, telles que les clés d'API Stripe et les informations d'identification PayPal, sont stockées de manière sécurisée dans le fichier d'environnement ".env".
Lors du processus de paiement, des jetons (tokens) sont utilisés pour représenter les transactions, garantissant qu'aucune donnée sensible n'est stockée sur le serveur de l'application.
Les administrateurs ont accès à un historique complet des paiements effectués par tous les utilisateurs.

## Sécurité

La sécurité est une priorité absolue dans cette application. Toutes les communications avec les passerelles de paiement sont effectuées via HTTPS pour garantir un transfert sécurisé des données. Les clés d'API et les informations d'identification sont stockées de manière sécurisée et ne sont pas accessibles publiquement.
La protection CSRF intégrée de Laravel est utilisée pour prévenir les attaques de type "Cross-Site Request Forgery". Les requêtes entrantes sont validées et les formulaires de paiement incluent le jeton CSRF nécessaire.

Toutes les données entrantes sont soigneusement validées et assainies côté serveur avant d'être traitées ou stockées dans la base de données, afin de prévenir les injections SQL et autres attaques basées sur les entrées utilisateur malveillantes.

## Conclusion

En résumé, notre projet Laravel offre une plateforme robuste et sécurisée pour une bibliothèque en ligne. Grâce à un système d'authentification fiable, à une gestion fine des autorisations pour les administrateurs et à l'intégration de passerelles de paiement de confiance, notre application garantit une expérience utilisateur fluide et sûre.

L'utilisation de middlewares pour protéger les routes sensibles, la validation stricte des données et l'emploi de jetons pour les transactions financières renforcent la sécurité globale de l'application.

Avec notre implémentation soignée, les utilisateurs peuvent profiter pleinement des fonctionnalités de la bibliothèque en ligne tout en ayant l'assurance que leurs informations personnelles et financières sont traitées avec le plus haut niveau de sécurité et de confidentialité.







PHP ARTISAN TINKER

$admin->email = 'admin@example.com';
= "admin@example.com"

$admin->password = Hash::make('admin123')
= "$2y$12$Q2EzEXDo1W8VabbRfICzJe8lO6Jk5ack7DhzazGKSdwBYZw4ff8xW"












