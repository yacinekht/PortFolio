# Portfolio — Yacine Khiat

Portfolio personnel développé avec **Symfony**, présentant mon parcours en cybersécurité et réseau : compétences, formations, expériences professionnelles et passions. Le contenu est entièrement gérable depuis une interface d'administration sécurisée, sans jamais toucher au code.

🔗 **Site en ligne :** à compléter avec l'URL Render
🔗 **Dépôt GitHub :** à compléter

## Aperçu

Le site présente dynamiquement :
- Un en-tête de présentation (nom, statut, certifications, localisation)
- Les compétences techniques, groupées par catégorie
- Le parcours de formation
- Les expériences professionnelles
- Les centres d'intérêt
- Un CV téléchargeable, mis à jour directement depuis l'administration
- Un formulaire de contact par e-mail

## Stack technique

| Composant | Technologie |
|---|---|
| Framework | Symfony 8.1 |
| Langage | PHP 8.4 |
| Base de données | MariaDB / MySQL (via Doctrine ORM) |
| Templates | Twig |
| Authentification | Symfony Security (formulaire de connexion, rôles) |
| Administration | EasyAdminBundle 5 |
| Conteneurisation | Docker |
| Hébergement | Render |
| Versionnage | Git / GitHub |

## Fonctionnalités

### Partie publique
- Page d'accueil responsive avec design sombre personnalisé
- Contenu entièrement dynamique, lu depuis la base de données
- Téléchargement direct du CV

### Partie administration (`/admin`)
- Accès protégé par authentification (email + mot de passe haché)
- Gestion complète (ajout, modification, suppression) des compétences, formations, expériences et passions
- Upload du CV au format PDF, remplaçant automatiquement l'ancienne version

## Modèle de données

- **Skill** : compétence technique (nom, catégorie, position d'affichage)
- **Training** : formation suivie (établissement, description, période)
- **Experience** : expérience professionnelle (intitulé, description, date)
- **Passion** : centre d'intérêt (nom, description)
- **User** : compte administrateur
- **CvDocument** : fichier CV téléchargeable

## Installation en local

### Prérequis
- PHP 8.4 ou supérieur
- Composer
- Symfony CLI
- Docker (optionnel pour un environnement local conteneurisé)
- Une base de données MySQL/MariaDB

### Étapes

```bash
# Cloner le dépôt
git clone <url-du-depot>
cd portfolio

# Installer les dépendances
composer install

# Configurer la base de données
# Renseigner DATABASE_URL dans un fichier .env.local

# Créer la base et exécuter les migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Lancer le serveur local
symfony server:start
```

Le site est alors accessible sur `https://127.0.0.1:8000`.

### Créer un compte administrateur

```bash
php bin/console security:hash-password
```

Insérer ensuite une ligne dans la table `user` avec l'e-mail choisi, le rôle `["ROLE_ADMIN"]` et le hash généré.

## Variables d'environnement

| Variable | Description |
|---|---|
| `APP_ENV` | `dev` en local, `prod` en production |
| `APP_SECRET` | Clé secrète de l'application |
| `DATABASE_URL` | Chaîne de connexion à la base de données |

## Déploiement

Le projet est conteneurisé avec Docker et déployé sur Render, avec redéploiement automatique à chaque mise à jour du dépôt GitHub (intégration continue).

```bash
# Construire l'image localement
docker build -t portfolio .

# Lancer le conteneur
docker run -p 8080:80 -e APP_SECRET=... -e DATABASE_URL=... portfolio
```

## Auteur

**Yacine Khiat**
Étudiant en Coordination de Projets Informatiques — Enigma School
Lille, France
[LinkedIn](https://www.linkedin.com/in/yacine-khiat-994b69386/) · yacine.khiat8@gmail.com
