**Cahier des charges : Gestion de la bibliothèque personnelle**
**1. Introduction**
   Le projet consiste à concevoir et développer une application Web personnalisée pour la gestion
   efficace des collections personnelles en utilisant le framework Symfony. L'application permettra aux
   utilisateurs de cataloguer et de gérer leurs livres, jeux vidéo, mangas et jeux de société, avec la
   possibilité d'ajouter des images pour chaque élément de la collection (image optionnelle). La
   conception de l'interface utilisateur devra obligatoirement utiliser Tailwind CSS pour une expérience
   utilisateur moderne et optimisée.

**2. Objectifs du projet :**
- Permettre aux utilisateurs de gérer facilement leurs collections personnelles en ligne.
- Offrir une interface conviviale pour la gestion des emprunts et des retours.
- Faciliter le suivi des éléments empruntés pour une meilleure organisation.

**3. Spécifications techniques :**
- _L'application sera développée en utilisant le framework Symfony pour garantir une structure
  robuste et évolutive._
- _Tailwind CSS sera utilisé pour la conception de l'interface utilisateur, offrant une personnalisation
  facile et des éléments visuels modernes._
- _La base de données sera conçue en mysql pour stocker les informations utilisateur, les détails de la
  collection, ainsi que les informations d'emprunt et de retour._
  -Validations et vérifications pour tout formulaire.

**4. Fonctionnalités clés :**
- __Authentification sécurisée des utilisateurs avec gestion de profils.__
- __Gestion complète des collections de livres, jeux vidéo, mangas et jeux de société. (Création, ajout
  d’éléments, modifications, suppressions d’éléments, suppression de la collection...)__
- __Suivi des emprunts et des retours.__
- __Option d'ajout d'images pour chaque élément de la collection pour une meilleure visualisation
  (fonctionnalité en option).__

**5. Fonctionnalités de recherche avancée :**
- __Recherche par mots-clés pour trouver des éléments spécifiques dans la collection.__
- __Recherche par nom de l'éditeur pour filtrer les éléments en fonction de leur source.__
- Recherche par date d’emprunts si l’emprunt n’est pas terminé.
- __Recherche par date d'ajout pour accéder rapidement aux éléments récemment ajoutés à la
  collection.__
- __Possibilité de filtrer les résultats de recherche en fonction de critères spécifiques tels que le type,
  la catégorie (optionnelle)__

**6. Entités clés :**
- Utilisateur avec des informations de profil et d'authentification (date de naissance, pseudo...).
- Collection incluant des catégories telles que livres, jeux vidéo, mangas et jeux de société.
- Livre avec des détails tels que titre, auteur, éditeur, et autres métadonnées pertinentes.
- Jeu vidéo avec titre, développeur, plateforme, éditeur, et autres métadonnées pertinentes.
- Manga avec titre, auteur, éditeur, et autres métadonnées pertinentes.
- Jeu de société avec nom, fabricant, nombre de joueurs, éditeur, et autres métadonnées
  pertinentes.
- Emprunt avec des détails de l'utilisateur emprunteur, l'élément emprunté, la date de début et la
  date d'échéance.
  D’autres entités seront possibles voir nécessaire !

**7. Livrables attendus :**
- _Repository GitHub._
- Documentation complète comprenant le guide d'installation et le documentation PHP du projet.
- _MCD-MLD._
- _Maquette._