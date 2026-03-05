# 🚛 TPI Livraisons Locales - Ferme Cretegny

Ce projet est une application de gestion de livraisons locales développée dans le cadre d'un TPI. Elle permet de gérer un catalogue de produits, des utilisateurs et des sessions de livraison.

## 🌟 Points Forts du Projet

* Migration Symfony 6.4 (LTS) : Application mise à jour pour bénéficier des derniers correctifs de sécurité.
* Environnement Dockerisé : Infrastructure complète (Serveur Web + Base de données) prête à l'emploi.
* Architecture ORM : Gestion automatisée du schéma de base de données avec Doctrine.
* Données de Test : Système de Fixtures pour une mise en service immédiate.

## 🛠️ Stack Technique

* Backend : PHP 8.4 / Symfony 6.4
* Base de données : MySQL 8.0
* Serveur : Apache (via Docker)
* Assets : Webpack Encore

---

## 🚀 Installation Rapide

### 1. Prérequis
* Docker & Docker Compose
* Composer (installé en local sur l'hôte)

### 2. Clonage et Dépendances

    git clone https://github.com/anthohn/tpi-livraisons-locales.git
    cd tpi-livraisons-locales
    composer install


### 3. Lancement des Conteneurs

    # Construction et démarrage de l'infrastructure
    docker-compose up -d --build


### 4. Initialisation de la Base de Données
On utilise docker exec pour lancer les commandes directement dans le conteneur PHP :

    # Génération de la structure des tables
    docker exec -it tpi-livraisons-locales-web-1 php bin/console doctrine:schema:update --force

    # Chargement des fixtures (Utilisateurs et produits de test)
    docker exec -it tpi-livraisons-locales-web-1 php bin/console doctrine:fixtures:load --no-interaction


### 5. Assets (Frontend)

    npm install
    npx encore dev


---

## 🔑 Accès à l'Application

L'application est accessible à l'adresse suivante : http://localhost:8080

Compte Administrateur de test :
* Login : admin@cretegny.ch
* Password : 12345678$

---

## 📖 Commandes Utiles

* Logs en temps réel : docker logs -f tpi-livraisons-locales-web-1
* Arrêter le projet : docker-compose down
* Vider le cache Symfony : docker exec -it tpi-livraisons-locales-web-1 php bin/console cache:clear
