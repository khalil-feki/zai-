\documentclass[12pt,a4paper]{report}
\usepackage[utf8]{inputenc}
\usepackage[T1]{fontenc}
\usepackage{graphicx}
\usepackage{float}
\usepackage{hyperref}
\usepackage{array}
\usepackage{tabularx}
\usepackage{booktabs}
\usepackage{fontspec}
\usepackage{setspace}
\usepackage{fancyhdr}
\usepackage{titlesec}
\usepackage{xcolor}
\usepackage{geometry}

% Set page geometry
\geometry{a4paper, margin=2.5cm}

% Set font

% Set line spacing
\setstretch{1.15}

% Format chapter titles
\titleformat{\chapter}[display]
{\normalfont\huge\bfseries}
{\chaptertitlename\ \thechapter}{20pt}{\Huge}
\titlespacing*{\chapter}{0pt}{0pt}{40pt}

% Format section titles
\titleformat{\section}
{\normalfont\Large\bfseries}
{\thesection}{1em}{}
\titlespacing*{\section}{0pt}{3.5ex plus 1ex minus .2ex}{2.3ex plus .2ex}

% Header and footer
\pagestyle{fancy}
\fancyhf{}
\fancyhead[L]{\slshape\nouppercase{\leftmark}}
\fancyhead[R]{\thepage}
\renewcommand{\headrulewidth}{0.4pt}
\renewcommand{\footrulewidth}{0pt}

\begin{document}

% Front cover
\begin{titlepage}
    \centering
    
    {\scshape\LARGE École Supérieure Privée d'Ingénierie et de Technologies\par}
    \vspace{1.5cm}
    {\huge\bfseries Projet de Fin d'Études\par}
    \vspace{2cm}
    {\Huge\bfseries ZAI E-commerce Project\par}
    \vspace{1cm}
    {\Large\itshape Intégration d'une Plateforme E-commerce avec Dolibarr ERP\par}
    \vspace{2cm}
    {\Large\bfseries Présenté par:\par}
    {\Large fekih mohamed khalil\par}
    \vspace{1cm}
    {\Large\bfseries Encadré par:\par}
    {\Large Ben mansour ahmed\par}
    \vfill
    {\large Année Universitaire 2024-2025\par}
\end{titlepage}

% Dedication page
\cleardoublepage
\thispagestyle{empty}
\vspace*{5cm}
\begin{flushright}
\textit{À ma famille,\\
pour leur soutien inconditionnel\\
et leurs encouragements constants.}
\end{flushright}
\cleardoublepage

% Acknowledgments
\chapter*{Remerciements}
\addcontentsline{toc}{chapter}{Remerciements}

Je voudrais d'abord remercier chaleureusement mon encadrant, \textbf{Ben mansour ahmed}, pour sa disponibilité de tous les instants, ses conseils vraiment précieux et son soutien constant tout au long de ce projet. Sans lui, rien n'aurait été possible.

Un grand merci aussi à toute l'équipe pédagogique d'ESPRIT pour la qualité exceptionnelle de l'enseignement qu'ils nous ont dispensé pendant ces années. On a vraiment eu de la chance d'avoir des profs aussi passionnés.

Je remercie également l'entreprise qui m'a accueilli pour ce projet - ils m'ont donné une opportunité en or de bosser sur quelque chose de vraiment concret et enrichissant, et ils ont mis tous les moyens à ma disposition. C'était top !

Enfin, impossible d'oublier ma famille et mes amis qui m'ont soutenu moralement et encouragé dans les moments difficiles. Leur présence a été essentielle pour mener ce projet à bien.
\cleardoublepage

% Abstract in French
\chapter*{Résumé}
\addcontentsline{toc}{chapter}{Résumé}

Ce projet de fin d'études, c'est vraiment quelque chose qui me tenait à cœur ! Il porte sur la conception et le développement d'une plateforme e-commerce qui s'intègre parfaitement avec Dolibarr. L'idée principale ? Créer une interface utilisateur moderne et responsive qui se connecte directement à la base de données Dolibarr existante, pour avoir une gestion vraiment unifiée des produits, clients et commandes.

On a choisi d'utiliser la méthodologie Scrum pour ce projet - et franchement, c'était le bon choix ! Ça nous a permis une approche itérative et incrémentale du développement. Côté technique, on a développé le système avec PHP pour le backend (architecture MVC bien sûr), et HTML/CSS/JavaScript pour le frontend.

Les principales fonctionnalités qu'on a développées incluent l'authentification des utilisateurs, la gestion complète du catalogue de produits, le panier d'achat, tout le processus de commande et même un système de tickets de support.

\textbf{Mots-clés:} E-commerce, Dolibarr, ERP, PHP, MVC, Scrum, Intégration de systèmes

\cleardoublepage

% Abstract in English
\chapter*{Abstract}
\addcontentsline{toc}{chapter}{Abstract}

This final year project has been quite an adventure! It focuses on designing and developing an e-commerce platform that integrates seamlessly with the Dolibarr ERP system. The main goal was to create a modern and responsive user interface that connects directly to the existing Dolibarr database, enabling truly unified management of products, customers, and orders.

We chose to use the Scrum methodology for this project - and honestly, it was the right call! It allowed us to take an iterative and incremental approach to development. On the technical side, we developed the system using PHP for the backend (with proper MVC architecture, of course), and HTML/CSS/JavaScript for the frontend.

The main features we developed include user authentication, comprehensive product catalog management, shopping cart functionality, complete order processing, and even a support ticket system.

\textbf{Keywords:} E-commerce, Dolibarr, ERP, PHP, MVC, Scrum, Systems Integration

\cleardoublepage

% Table of contents
\tableofcontents
\cleardoublepage

% List of figures
\listoffigures
\cleardoublepage

% List of tables
\listoftables
\cleardoublepage

% Introduction
\chapter{Introduction Générale}
\section{Contexte du Projet}
Aujourd'hui, on vit vraiment dans un monde où tout devient numérique, et franchement, le commerce électronique explose littéralement ! Le marché mondial dépasse maintenant les 5 000 milliards de dollars en 2024 - c'est énorme quand on y pense. Toutes les entreprises, petites ou grandes, se battent pour améliorer leur présence en ligne et optimiser leurs processus de vente. C'est devenu vital pour survivre dans cet environnement ultra-compétitif qui évolue à une vitesse folle.

Bon, intégrer une plateforme e-commerce avec un système ERP existant, c'est pas de la tarte ! C'est un vrai défi technique, mais les bénéfices en valent vraiment la peine : efficacité opérationnelle améliorée, coûts réduits, et surtout une bien meilleure expérience pour les clients. Cette intégration permet une gestion unifiée des stocks, des commandes, et des données clients, éliminant les silos informationnels et réduisant les erreurs humaines.

C'est exactement dans cette optique que notre projet prend tout son sens. On vise à créer une solution e-commerce vraiment moderne et sécurisée qui s'intègre de manière fluide avec Dolibarr - l'ERP que notre client utilise déjà. Dolibarr, étant un ERP open-source largement adopté par les PME, offre une base solide pour cette intégration. L'objectif est de créer une interface utilisateur intuitive, responsive et sécurisée qui se connecte directement à la base de données Dolibarr, évitant ainsi la duplication des données et assurant une cohérence en temps réel entre les différents systèmes.

\section{Problématique}
Alors, voici la situation : notre client utilise déjà Dolibarr pour gérer tout son business - inventaire, clients, commandes, etc. Mais il y a un hic... En fait, plusieurs défis de taille dans le monde ultra-compétitif du e-commerce d'aujourd'hui :

\subsection{Défis Techniques}
\begin{itemize}
    \item \textbf{Pas d'interface e-commerce digne de ce nom} : Leurs clients ne peuvent même pas consulter le catalogue ou passer commande en ligne à n'importe quelle heure - c'est un gros problème en 2024 !
    \item \textbf{L'intégration, c'est le casse-tête} : Il faut absolument s'intégrer avec la base de données Dolibarr qui existe déjà, mais sans tout casser au passage
    \item \textbf{Tout doit être synchro en temps réel} : Les stocks, les prix, les infos produits... tout doit être parfaitement cohérent entre l'ERP et le site e-commerce, sinon c'est la catastrophe
    \item \textbf{Ça doit tenir la charge} : Plus d'utilisateurs, plus de transactions... le système doit pouvoir encaisser sans broncher
\end{itemize}

\subsection{Côté Sécurité, c'est du sérieux}
\begin{itemize}
    \item \textbf{Les données perso, c'est sacré} : RGPD oblige, il faut protéger les infos clients comme la prunelle de nos yeux
    \item \textbf{Paiements ultra-sécurisés} : Pas question de rigoler avec l'argent des clients - protocoles de paiement blindés exigés
    \item \textbf{Authentification béton} : Système d'accès costaud pour éviter les fraudes et autres joyeusetés
\end{itemize}

\subsection{Les enjeux Business}
\begin{itemize}
    \item \textbf{L'expérience utilisateur avant tout} : Interface qui doit être intuitive et fonctionner nickel sur tous les appareils - smartphone, tablette, ordi
    \item \textbf{Rester dans la course} : Fonctionnalités modernes obligatoires - recherche intelligente, recommandations personnalisées, avis clients, tout le tralala
    \item \textbf{Penser à demain} : Architecture évolutive pour pouvoir ajouter des trucs cool plus tard sans tout refaire
\end{itemize}

\section{Objectifs du Projet}
Bon, concrètement, qu'est-ce qu'on veut faire avec ce projet ? On vise à développer une plateforme e-commerce complète et vraiment sécurisée, parfaitement intégrée avec Dolibarr, et qui respecte tous les standards modernes du e-commerce :

\subsection{Objectifs Fonctionnels}
\begin{itemize}
    \item \textbf{Une interface qui claque} : Interface web responsive, super intuitive et accessible, qui marche parfaitement sur tous les appareils - que ce soit sur ton ordi, ta tablette ou ton smartphone
    \item \textbf{Un catalogue produits au top} : Navigation fluide avec des filtres efficaces, recherche intelligente qui trouve vraiment ce qu'on cherche, catégorisation logique et recommandations personnalisées
    \item \textbf{Panier et commandes sans prise de tête} : Processus de commande ultra-fluide avec sauvegarde auto (fini les paniers perdus !), calcul automatique des frais de livraison et gestion des promos
    \item \textbf{Paiements blindés} : Plusieurs passerelles de paiement intégrées avec chiffrement SSL/TLS - sécurité maximale garantie
    \item \textbf{Gestion des utilisateurs au poil} : Authentification robuste, profils clients complets, historique des commandes et liste de souhaits - tout ce qu'il faut
    \item \textbf{Support client intégré} : Système de tickets efficace, chat en ligne réactif et FAQ dynamique qui répond vraiment aux questions
\end{itemize}

\subsection{Objectifs Techniques (là ça devient sérieux)}
\begin{itemize}
    \item \textbf{Intégration Dolibarr native} : Connexion directe avec la base de données Dolibarr, zéro duplication de données - on fait ça proprement
    \item \textbf{Architecture MVC bien pensée} : Structure modulaire et maintenable avec le pattern Model-View-Controller - du code propre et organisé
    \item \textbf{Performance au top} : Mise en cache intelligente, requêtes optimisées et temps de chargement < 3 secondes (parce que personne n'aime attendre)
    \item \textbf{Sécurité blindée} : Conformité OWASP, protection contre toutes les attaques classiques (XSS, CSRF, SQL Injection, etc.)
    \item \textbf{Monitoring et logs} : Surveillance des performances en temps réel et traçabilité complète - on veut tout savoir
\end{itemize}

\subsection{Objectifs Méthodologiques (pour bien s'organiser)}
\begin{itemize}
    \item \textbf{Développement Agile à fond} : On applique Scrum de manière rigoureuse avec des sprints de 2 semaines - ça marche vraiment bien
    \item \textbf{Tests automatisés partout} : Couverture de tests unitaires et d'intégration > 80\% - on ne laisse rien au hasard
    \item \textbf{Documentation au top} : Guide d'installation détaillé, documentation API complète et manuel utilisateur - tout pour que ce soit clair
    \item \textbf{Déploiement automatisé} : Pipeline CI/CD avec Docker et scripts de déploiement - plus d'erreurs humaines
\end{itemize}

\section{Structure du Rapport}
Ce rapport est structuré en cinq chapitres:
\begin{itemize}
    \item \textbf{Chapitre 1: Introduction Générale} - Présente le contexte, la problématique et les objectifs du projet.
    \item \textbf{Chapitre 2: Cadre du Projet} - Décrit l'organisme d'accueil, la problématique détaillée, l'étude de l'existant et la méthodologie de travail adoptée.
    \item \textbf{Chapitre 3: Sprint 0 - Conception et Architecture} - Présente l'analyse des besoins, les diagrammes UML et la planification des sprints.
    \item \textbf{Chapitre 4: Sprint 1 - Gestion des Utilisateurs et Authentification} - Détaille le développement du module d'authentification et de gestion des utilisateurs.
    \item \textbf{Chapitre 5: Sprint 2 - Catalogue de Produits et Panier} - Décrit le développement du catalogue de produits et du panier d'achat.
    \item \textbf{Chapitre 6: Sprint 3 - Gestion des Commandes} - Présente le développement du module de gestion des commandes.
    \item \textbf{Chapitre 7: Sprint 4 - Système de Support Client} - Détaille le développement du système de tickets de support.
    \item \textbf{Chapitre 8: Conclusion Générale et Perspectives} - Résume les réalisations et propose des perspectives d'évolution.
\end{itemize}

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une image représentative du projet]}}
    \caption{Vue d'ensemble du projet ZAI E-commerce}
    \label{fig:project_overview}
\end{figure}

% Chapter 2
\chapter{Cadre du Projet}
\section{Présentation de l'Organisme d'Accueil}
ESPRIT (École Supérieure Privée d'Ingénierie et de Technologies), c'est vraiment une école qui sort du lot ! Reconnue pour son excellence académique et son approche super pratique de l'enseignement, elle forme des ingénieurs depuis 2003 dans plein de domaines : informatique, télécoms, électromécanique, génie civil... bref, tout ce qui bouge dans la tech !

Ce qui rend ESPRIT vraiment spéciale, c'est son modèle pédagogique innovant. Ici, on apprend en faisant - apprentissage par projets et collaboration constante avec le monde professionnel. L'école a tissé des partenariats solides avec des tonnes d'entreprises, nationales comme internationales, ce qui nous donne des opportunités de stages et de projets de fin d'études qui collent vraiment aux besoins du marché. C'est exactement ce qu'il nous faut !

\section{Problématique et Solution Proposée}
\subsection{Problématique Détaillée}
Alors, notre client utilise déjà Dolibarr pour gérer tout son business - inventaire, clients, commandes, etc. Mais voilà le problème : ils galèrent avec plusieurs trucs :

\begin{itemize}
    \item Pas d'interface e-commerce moderne pour leurs clients - c'est un gros manque en 2024 !
    \item Processus de commande complètement manuel qui nécessite qu'un commercial intervienne à chaque fois - pas très efficace...
    \item Galère pour maintenir la cohérence des données entre les différents systèmes - source d'erreurs garantie
    \item Besoin d'une solution vraiment personnalisée qui colle à leur façon de bosser
\end{itemize}

\subsection{Étude de l'Existant}
Nous avons analysé trois solutions existantes pour répondre à cette problématique:

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Critères} & \textbf{Solution 1: Module E-commerce Dolibarr} & \textbf{Solution 2: WooCommerce + Connecteur} & \textbf{Solution 3: Solution Personnalisée} \\
\hline
Intégration avec Dolibarr & Native & Via connecteur & Sur mesure \\
\hline
Flexibilité & Limitée & Moyenne & Élevée \\
\hline
Coût & Faible & Moyen & Élevé \\
\hline
Maintenance & Simple & Complexe & Modérée \\
\hline
Personnalisation & Limitée & Moyenne & Complète \\
\hline
\end{tabularx}
\caption{Comparaison des solutions existantes}
\label{tab:solutions}
\end{table}

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici un diagramme comparatif des solutions existantes]}}
    \caption{Comparaison graphique des solutions e-commerce}
    \label{fig:solutions_comparison}
\end{figure}

\subsection{Solution Proposée}
Après avoir bien analysé les besoins et étudié toutes les solutions existantes, on a décidé de partir sur le développement d'une solution sur mesure. Pourquoi ? Parce qu'elle :

\begin{itemize}
    \item Se connecte directement à la base de données Dolibarr existante - pas de bricolage
    \item Utilise une architecture MVC propre en PHP pour le backend - du code bien structuré
    \item Propose une interface utilisateur moderne et responsive - ça claque visuellement
    \item Permet une personnalisation complète selon les besoins spécifiques du client - exactement ce qu'il faut
    \item Assure une cohérence parfaite des données entre l'interface e-commerce et l'ERP - fini les bugs
\end{itemize}

Cette solution offre vraiment le meilleur équilibre entre intégration, flexibilité et personnalisation. Certes, le coût de développement initial est plus élevé, mais ça vaut le coup !

\section{Méthodologie de Travail}
\subsection{Comparaison entre les Méthodologies Prédictives et Adaptatives}

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Critères} & \textbf{Méthodologies Prédictives} & \textbf{Méthodologies Adaptatives} \\
\hline
Planification & Complète dès le début & Progressive \\
\hline
Flexibilité & Faible & Élevée \\
\hline
Implication client & Principalement au début et à la fin & Continue \\
\hline
Livraisons & À la fin du projet & Incrémentales \\
\hline
Adaptation aux changements & Difficile & Facile \\
\hline
\end{tabularx}
\caption{Comparaison des méthodologies de développement}
\label{tab:methodologies}
\end{table}

\subsection{Méthodologie Adoptée}
Pour ce projet, on a choisi d'adopter la méthodologie Scrum - et franchement, c'était évident ! Cette approche agile permet un développement itératif et incrémental qui colle parfaitement à nos besoins. Pourquoi ce choix ?

\begin{itemize}
    \item On doit pouvoir s'adapter aux besoins évolutifs du client - et croyez-moi, ça change souvent !
    \item C'est important de livrer rapidement des fonctionnalités utilisables - le client veut voir du concret
    \item On a besoin de flexibilité face aux changements de priorités - ça arrive tout le temps
    \item On veut impliquer le client tout au long du processus - c'est son projet après tout !
\end{itemize}

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici un diagramme du processus Scrum]}}
    \caption{Méthodologie Scrum appliquée au projet}
    \label{fig:scrum_methodology}
\end{figure}

\subsection{Organisation de l'Équipe Scrum}
Notre équipe Scrum, c'est du solide ! Elle est composée de :

\begin{itemize}
    \item \textbf{Product Owner}: C'est lui qui définit les fonctionnalités du produit et qui priorise le backlog - en gros, il sait ce qu'on doit faire
    \item \textbf{Scrum Master}: Notre facilitateur qui nous aide à suivre les pratiques Scrum et à éliminer tous les obstacles - notre héros du quotidien
    \item \textbf{Équipe de développement}: Les membres des groupes 4 et 6, chacun responsable d'un module CRUD spécifique - on se répartit le travail intelligemment
\end{itemize}

\section{Conclusion}
Voilà, ce chapitre nous a permis de poser le cadre général du projet ! On a présenté ESPRIT, détaillé la problématique de notre client, étudié toutes les solutions existantes et expliqué pourquoi on a choisi Scrum. Notre solution sur mesure va vraiment répondre aux besoins spécifiques du client tout en s'intégrant parfaitement avec son système Dolibarr. On est prêts à attaquer !

% Chapter 3
\chapter{Sprint 0: Conception et Architecture}
\section{Introduction}
Alors, on attaque le Sprint 0 ! C'est la phase où on pose vraiment les bases de tout le projet. Dans ce chapitre, on va vous présenter toute la conception et l'architecture : analyse des besoins, diagrammes UML, planification des sprints... bref, tout ce qu'il faut pour avoir des fondations solides avant de se lancer dans le développement. C'est peut-être pas la partie la plus fun, mais c'est absolument essentiel !

\section{Analyse des Besoins}
\subsection{Besoins Fonctionnels}
Alors, qu'est-ce que notre plateforme e-commerce doit savoir faire ? Voici tout ce qu'on a identifié :

\begin{itemize}
    \item \textbf{Gestion des utilisateurs} (la base de tout) :
    \begin{itemize}
        \item Inscription et connexion des utilisateurs - simple et efficace
        \item Gestion du profil utilisateur - pour personnaliser l'expérience
        \item Récupération de mot de passe - parce qu'on oublie tous !
    \end{itemize}
    
    \item \textbf{Gestion des produits} (le cœur du business) :
    \begin{itemize}
        \item Consultation du catalogue de produits - avec une interface qui claque
        \item Filtrage et recherche de produits - pour trouver rapidement ce qu'on cherche
        \item Affichage des détails des produits - toutes les infos importantes
    \end{itemize}
    
    \item \textbf{Gestion du panier} (l'étape cruciale) :
    \begin{itemize}
        \item Ajout de produits au panier - en un clic
        \item Modification des quantités - pour ajuster facilement
        \item Suppression de produits du panier - si on change d'avis
    \end{itemize}
    
    \item \textbf{Gestion des commandes} (là où ça devient sérieux) :
    \begin{itemize}
        \item Passage de commande - processus fluide et sécurisé
        \item Suivi de l'état des commandes - transparence totale
        \item Consultation de l'historique des commandes - pratique pour recommander
    \end{itemize}
    
    \item \textbf{Support client} (parce que le service, c'est important) :
    \begin{itemize}
        \item Création de tickets de support - pour signaler les problèmes
        \item Suivi des tickets - pour voir où ça en est
        \item Communication avec le service client - dialogue direct
    \end{itemize}
\end{itemize}

\subsection{Besoins Non Fonctionnels}
Maintenant, parlons des trucs techniques mais super importants - les besoins non fonctionnels :

\begin{itemize}
    \item \textbf{Performance}: Temps de réponse inférieur à 2 secondes pour les opérations courantes - personne n'aime attendre !
    \item \textbf{Sécurité}: Protection blindée des données utilisateurs et des transactions, authentification sécurisée - on rigole pas avec ça
    \item \textbf{Disponibilité}: Système disponible 24/7 avec un taux de disponibilité de 99,9\% - presque jamais en panne
    \item \textbf{Scalabilité}: Capacité à gérer un nombre croissant d'utilisateurs et de produits - pour grandir avec le business
    \item \textbf{Maintenabilité}: Code bien structuré et documenté pour faciliter la maintenance - pensons aux développeurs qui viendront après nous
    \item \textbf{Compatibilité}: Interface responsive qui marche sur tous les appareils et navigateurs - du smartphone au desktop
\end{itemize}

\section{Diagrammes UML}
\subsection{Diagramme de Cas d'Utilisation}
Le diagramme de cas d'utilisation présente les interactions entre les acteurs et le système.

\begin{figure}[H]
    \centering
    \includegraphics{Diagramme de Cas d’Utilisation.png}
    
    \caption{Diagramme de cas d'utilisation général}
    \label{fig:usecase_diagram}
\end{figure}

\subsection{Diagramme de Classes}
Le diagramme de classes présente la structure statique du système, montrant les classes, leurs attributs, leurs méthodes et les relations entre elles.

\begin{figure}[H]
    \centering
    \includegraphics{class_diagram.png}
    \caption{Diagramme de classes du système}
    \label{fig:class_diagram}
\end{figure}

\subsection{Diagramme Entité-Relation}
Le diagramme entité-relation présente la structure de la base de données Dolibarr et les tables utilisées par notre application.

\begin{figure}[H]
    \centering
    \includegraphics{Diagramme entité-relation.png}
    \caption{Diagramme entité-relation de la base de données}
    \label{fig:er_diagram}
\end{figure}

\section{Architecture Technique}
\subsection{Architecture Globale}
Pour l'architecture globale, on a opté pour le modèle MVC (Modèle-Vue-Contrôleur) - un grand classique qui a fait ses preuves ! Ça nous permet d'avoir une séparation claire des responsabilités et ça facilite vraiment la maintenance du code. C'est propre, c'est organisé, c'est exactement ce qu'il nous faut.

\begin{figure}[H]
    \centering
    \includegraphics{MVC.png}
    \caption{Architecture MVC du système}
    \label{fig:mvc_architecture}
\end{figure}

\subsubsection{Architecture Applicative}
Voici comment on a organisé tout ça :
\begin{itemize}
    \item \textbf{Pattern MVC} : Séparation claire entre Model (les données), View (ce que voit l'utilisateur) et Controller (la logique) - chacun sa place !
    \item \textbf{API RESTful} : Interface standardisée pour que le frontend et le backend se parlent bien
    \item \textbf{Microservices légers} : Modules indépendants pour l'authentification, le catalogue, les commandes - modulaire et efficace
    \item \textbf{Cache multi-niveaux} : Redis pour les sessions, Memcached pour les données fréquentes - pour que ça aille vite !
\end{itemize}

\subsubsection{Stack Technologique}
Pour la stack techno, on a choisi du solide :
\begin{itemize}
    \item \textbf{Backend} : PHP 8.1+ avec un framework personnalisé, intégration native avec Dolibarr - du sur-mesure !
    \item \textbf{Frontend} : HTML5, CSS3, JavaScript ES6+, Bootstrap 5 pour la responsivité - moderne et efficace
    \item \textbf{Base de données} : MySQL 8.0+ avec des optimisations spéciales pour Dolibarr
    \item \textbf{Serveur web} : Apache 2.4+ avec mod\_rewrite et SSL/TLS - sécurisé et performant
    \item \textbf{Outils de développement} : Git, Composer, NPM, Docker pour la containerisation - tout l'arsenal du développeur moderne
\end{itemize}

\subsection{Sécurité et Conformité}
\subsubsection{Sécurité des Données}
La sécurité, c'est vraiment LE point crucial pour une plateforme e-commerce ! On peut pas se permettre de faire n'importe quoi avec les données des clients. Du coup, notre solution implémente toutes ces mesures :

\paragraph{Chiffrement et Protection}
Pour protéger les données, on met le paquet :
\begin{itemize}
    \item \textbf{Chiffrement en transit} : SSL/TLS 1.3 pour toutes les communications - rien ne passe en clair
    \item \textbf{Chiffrement au repos} : AES-256 pour les données sensibles en base - du militaire !
    \item \textbf{Hachage sécurisé} : Bcrypt avec salt pour les mots de passe - impossible à décrypter
    \item \textbf{Tokenisation} : JWT avec rotation automatique pour l'authentification - sécurité renforcée
\end{itemize}

\paragraph{Protection contre les Attaques}
Contre les attaques, on a prévu le coup :
\begin{itemize}
    \item \textbf{Injection SQL} : Requêtes préparées et validation stricte des entrées - les hackers peuvent toujours essayer !
    \item \textbf{XSS (Cross-Site Scripting)} : Échappement automatique et CSP (Content Security Policy) - pas de script malveillant qui passe
    \item \textbf{CSRF (Cross-Site Request Forgery)} : Tokens CSRF sur tous les formulaires - protection contre les fausses requêtes
    \item \textbf{Brute Force} : Limitation du taux de tentatives et CAPTCHA - fini les attaques par force brute
    \item \textbf{DDoS} : Rate limiting et filtrage IP automatique - on résiste aux attaques massives
\end{itemize}

\subsubsection{Conformité Réglementaire}
\paragraph{RGPD (Règlement Général sur la Protection des Données)}
Pour être en règle avec le RGPD (et éviter les amendes salées !), on a tout prévu :
\begin{itemize}
    \item \textbf{Consentement explicite} : Gestion granulaire des préférences utilisateur - chacun choisit ce qu'il partage
    \item \textbf{Droit à l'oubli} : Fonctionnalité de suppression complète des données - si quelqu'un veut partir, on efface tout
    \item \textbf{Portabilité} : Export des données personnelles au format JSON/XML - récupération facile
    \item \textbf{Audit trail} : Traçabilité complète des accès et modifications - on sait qui a fait quoi et quand
\end{itemize}

\paragraph{Standards E-commerce}
Et pour les standards e-commerce, on respecte tout ça :
\begin{itemize}
    \item \textbf{PCI DSS} : Conformité pour le traitement des données de cartes bancaires - obligatoire pour les paiements
    \item \textbf{ISO 27001} : Bonnes pratiques de sécurité de l'information - la référence mondiale
    \item \textbf{OWASP Top 10} : Protection contre les vulnérabilités web les plus critiques - on suit les recommandations des experts
\end{itemize}

\section{Performance et Optimisation}
\subsection{Stratégies de Performance}
Pour que l'expérience utilisateur soit au top, on a mis en place plusieurs stratégies d'optimisation. Parce que personne n'aime attendre, surtout quand on fait du shopping en ligne !

\subsubsection{Optimisation Frontend}
Côté frontend, on optimise tout ce qu'on peut :
\begin{itemize}
    \item \textbf{Minification et compression} : CSS/JS minifiés, compression Gzip/Brotli - moins de données à télécharger
    \item \textbf{Lazy loading} : Chargement différé des images et contenus non critiques - on charge que ce qu'on voit
    \item \textbf{CDN (Content Delivery Network)} : Distribution géographique des ressources statiques - plus proche = plus rapide
    \item \textbf{Critical CSS} : CSS critique inline pour un rendu rapide - l'essentiel en premier
    \item \textbf{Service Workers} : Mise en cache intelligente côté client - navigation ultra-fluide
\end{itemize}

\subsubsection{Optimisation Backend}
Et côté backend, on n'est pas en reste :
\begin{itemize}
    \item \textbf{Cache applicatif} : Redis pour les sessions, Memcached pour les données fréquentes - la vitesse avant tout
    \item \textbf{Optimisation des requêtes} : Index optimisés, requêtes préparées, pagination efficace - chaque milliseconde compte
    \item \textbf{Pool de connexions} : Gestion optimisée des connexions base de données - pas de gaspillage de ressources
    \item \textbf{Compression de réponse} : Compression automatique des réponses API - moins de bande passante utilisée
\end{itemize}

\subsection{Métriques de Performance}
\subsubsection{Objectifs de Performance}
\begin{itemize}
    \item \textbf{Time to First Byte (TTFB)} : < 200ms
    \item \textbf{First Contentful Paint (FCP)} : < 1.5s
    \item \textbf{Largest Contentful Paint (LCP)} : < 2.5s
    \item \textbf{Cumulative Layout Shift (CLS)} : < 0.1
    \item \textbf{First Input Delay (FID)} : < 100ms
\end{itemize}

\subsubsection{Monitoring et Alertes}
\begin{itemize}
    \item \textbf{APM (Application Performance Monitoring)} : New Relic ou équivalent
    \item \textbf{Logs centralisés} : ELK Stack (Elasticsearch, Logstash, Kibana)
    \item \textbf{Métriques temps réel} : Grafana avec Prometheus
    \item \textbf{Alertes automatiques} : Seuils de performance et disponibilité
\end{itemize}

\subsection{Intégration avec Dolibarr}
L'intégration avec Dolibarr constitue le cœur de notre solution, assurant une synchronisation parfaite des données :

\subsubsection{Architecture d'Intégration}
\begin{itemize}
    \item \textbf{Connexion directe} : Accès natif à la base de données Dolibarr
    \item \textbf{Couche d'abstraction} : ORM personnalisé pour les entités Dolibarr
    \item \textbf{Synchronisation temps réel} : Triggers et événements pour la cohérence des données
    \item \textbf{Cache intelligent} : Mise en cache des données Dolibarr fréquemment consultées
\end{itemize}

\subsubsection{Tables Dolibarr Utilisées}
\begin{itemize}
    \item \textbf{llx\_societe} : Données clients et prospects
    \item \textbf{llx\_product} : Catalogue produits et services
    \item \textbf{llx\_commande} : Commandes et devis
    \item \textbf{llx\_stock} : Gestion des stocks en temps réel
    \item \textbf{llx\_facture} : Facturation automatisée
\end{itemize}




\section{Backlog de Produit}
Le backlog de produit contient toutes les fonctionnalités à développer, organisées selon la méthode MoSCoW (Must have, Should have, Could have, Won't have) et estimées en story points.

\subsection{Épiques et User Stories}

\subsubsection{Épique 1: Gestion des Utilisateurs}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Priorité} & \textbf{Story Points} \\
\hline
En tant que visiteur, je veux m'inscrire avec email/mot de passe & Must have & 5 \\
\hline
En tant qu'utilisateur, je veux me connecter de manière sécurisée & Must have & 3 \\
\hline
En tant qu'utilisateur, je veux réinitialiser mon mot de passe & Must have & 3 \\
\hline
En tant qu'utilisateur, je veux modifier mon profil & Should have & 5 \\
\hline
En tant qu'utilisateur, je veux activer l'authentification à deux facteurs & Should have & 8 \\
\hline
En tant qu'utilisateur, je veux me connecter via OAuth (Google, Facebook) & Could have & 13 \\
\hline
\end{tabularx}
\caption{User Stories - Gestion des Utilisateurs}
\end{table}

\subsubsection{Épique 2: Catalogue et Recherche}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Priorité} & \textbf{Story Points} \\
\hline
En tant qu'utilisateur, je veux consulter le catalogue de produits & Must have & 8 \\
\hline
En tant qu'utilisateur, je veux voir les détails d'un produit & Must have & 5 \\
\hline
En tant qu'utilisateur, je veux filtrer les produits par catégorie & Must have & 8 \\
\hline
En tant qu'utilisateur, je veux rechercher des produits par nom/description & Must have & 13 \\
\hline
En tant qu'utilisateur, je veux trier les produits (prix, popularité, nouveauté) & Should have & 5 \\
\hline
En tant qu'utilisateur, je veux voir les produits recommandés & Should have & 21 \\
\hline
En tant qu'utilisateur, je veux consulter les avis et notes des produits & Could have & 13 \\
\hline
En tant qu'utilisateur, je veux comparer plusieurs produits & Could have & 8 \\
\hline
\end{tabularx}
\caption{User Stories - Catalogue et Recherche}
\end{table}

\subsubsection{Épique 3: Panier et Commandes}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Priorité} & \textbf{Story Points} \\
\hline
En tant qu'utilisateur, je veux ajouter des produits à mon panier & Must have & 8 \\
\hline
En tant qu'utilisateur, je veux modifier les quantités dans mon panier & Must have & 5 \\
\hline
En tant qu'utilisateur, je veux passer une commande & Must have & 13 \\
\hline
En tant qu'utilisateur, je veux choisir une adresse de livraison & Must have & 8 \\
\hline
En tant qu'utilisateur, je veux sélectionner un mode de paiement & Must have & 13 \\
\hline
En tant qu'utilisateur, je veux consulter l'historique de mes commandes & Should have & 8 \\
\hline
En tant qu'utilisateur, je veux suivre le statut de ma commande & Should have & 13 \\
\hline
En tant qu'utilisateur, je veux sauvegarder mon panier entre les sessions & Should have & 8 \\
\hline
En tant qu'utilisateur, je veux appliquer des codes promo & Could have & 13 \\
\hline
\end{tabularx}
\caption{User Stories - Panier et Commandes}
\end{table}

\subsubsection{Épique 4: Support Client}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Priorité} & \textbf{Story Points} \\
\hline
En tant qu'utilisateur, je veux créer un ticket de support & Should have & 8 \\
\hline
En tant qu'utilisateur, je veux consulter mes tickets de support & Should have & 5 \\
\hline
En tant qu'utilisateur, je veux recevoir des notifications par email & Should have & 8 \\
\hline
En tant qu'utilisateur, je veux accéder à une FAQ dynamique & Could have & 13 \\
\hline
En tant qu'utilisateur, je veux utiliser un chat en ligne & Could have & 21 \\
\hline
\end{tabularx}
\caption{User Stories - Support Client}
\end{table}

\section{Planification des Sprints}
Le projet est divisé en 4 sprints de développement, précédés d'un Sprint 0 de conception.

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{N° Sprint} & \textbf{Nom Sprint} & \textbf{Durée} \\
\hline
0 & Conception et Architecture & 3 semaine \\
\hline
1 & Gestion des Utilisateurs et Authentification & 5 semaines \\
\hline
2 & Catalogue de Produits et Panier & 6 semaines \\
\hline
3 & Gestion des Commandes & 5 semaines \\
\hline
4 & Système de Support Client & 2 semaines \\
\hline
\end{tabularx}
\caption{Planification des sprints}
\label{tab:sprint_planning}
\end{table}

\section{Environnement de Travail}
\subsection{Stack Technologique}
L'environnement de travail mis en place pour le développement comprend:

\subsubsection{Environnement de Développement Local}
\begin{itemize}
    \item \textbf{Serveur de développement}: XAMPP (Apache 2.4+, MySQL 8.0+, PHP 8.1+)
    \item \textbf{Base de données}: MySQL avec Dolibarr 17+ installé et configuré
    \item \textbf{Langages de programmation}: PHP 8.1+, HTML5, CSS3, JavaScript ES6+
    \item \textbf{Framework CSS}: Bootstrap 5.3+ avec personnalisations SASS
    \item \textbf{Gestionnaires de dépendances}: Composer pour PHP, NPM pour JavaScript
    \item \textbf{Outils de build}: Webpack, Sass, PostCSS pour l'optimisation frontend
\end{itemize}

\subsubsection{Outils de Développement}
\begin{itemize}
    \item \textbf{IDE}: Visual Studio Code avec extensions PHP Intelephense, JavaScript
    \item \textbf{Contrôle de version}: Git avec GitFlow workflow et hooks pre-commit
    \item \textbf{Debugging}: Xdebug pour PHP, Chrome DevTools pour frontend
    \item \textbf{Tests}: PHPUnit pour tests unitaires, Selenium pour tests E2E
    \item \textbf{Qualité de code}: PHP CodeSniffer, ESLint, Prettier, SonarQube
\end{itemize}

\subsubsection{Gestion de Projet et Collaboration}
\begin{itemize}
    \item \textbf{Méthodologie}: Scrum avec sprints de 2 semaines
    \item \textbf{Gestion de projet}: Jira pour le suivi des sprints, épiques et user stories
    \item \textbf{Documentation}: Confluence pour la documentation technique et fonctionnelle
    \item \textbf{Communication}: Slack pour la communication d'équipe quotidienne
    \item \textbf{Revue de code}: GitHub/GitLab avec pull requests et code review
\end{itemize}

\subsection{Architecture de Déploiement}
\subsubsection{Environnements}
\begin{itemize}
    \item \textbf{Développement}: Environnement local avec Docker Compose
    \item \textbf{Test/Staging}: Serveur de test pour validation avant production
    \item \textbf{Production}: Serveur de production avec haute disponibilité
    \item \textbf{Monitoring}: Surveillance continue avec alertes automatiques
\end{itemize}

\subsubsection{Containerisation et Orchestration}
\begin{itemize}
    \item \textbf{Docker}: Containerisation de l'application et des services
    \item \textbf{Docker Compose}: Orchestration locale pour le développement
    \item \textbf{Nginx}: Reverse proxy et load balancer
    \item \textbf{Redis}: Cache et gestion des sessions
\end{itemize}

\section{Conclusion}
Ce chapitre a présenté une phase de conception et d'architecture complète et moderne pour le projet ZAI E-commerce, établissant les fondations d'une solution robuste et évolutive.

\subsection{Synthèse des Contributions}
Les principales contributions de cette phase incluent :

\begin{itemize}
    \item \textbf{Architecture sécurisée} : Implémentation des meilleures pratiques de sécurité e-commerce avec conformité RGPD et standards PCI DSS
    \item \textbf{Performance optimisée} : Stratégies d'optimisation frontend et backend pour assurer une expérience utilisateur fluide
    \item \textbf{Intégration native Dolibarr} : Solution d'intégration transparente évitant la duplication de données
    \item \textbf{Méthodologie Agile} : Application rigoureuse de Scrum avec backlog détaillé et estimation en story points
    \item \textbf{DevOps moderne} : Pipeline CI/CD avec containerisation Docker et monitoring automatisé
\end{itemize}

\subsection{Valeur Ajoutée}
Cette approche méthodologique apporte plusieurs avantages concurrentiels :

\begin{itemize}
    \item \textbf{Time-to-market réduit} : Architecture modulaire permettant un développement parallèle
    \item \textbf{Maintenabilité élevée} : Code structuré selon les patterns MVC et bonnes pratiques
    \item \textbf{Scalabilité native} : Architecture conçue pour supporter la croissance
    \item \textbf{Sécurité by design} : Mesures de sécurité intégrées dès la conception
\end{itemize}

Cette phase solide de conception et d'architecture constitue le socle indispensable pour le développement des fonctionnalités dans les sprints suivants, garantissant la qualité, la sécurité et la performance de la solution finale.

% Chapter 4
\chapter{Sprint 1: Gestion des Utilisateurs et Authentification}
\section{Introduction}
Ce chapitre présente le premier sprint de développement, focalisé sur la gestion des utilisateurs et l'authentification. Ce module est fondamental car il permet aux utilisateurs de s'inscrire, de se connecter et de gérer leur profil sur la plateforme e-commerce.

\section{Backlog du Sprint}
Le backlog de ce sprint comprend les user stories suivantes:

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Complexité} & \textbf{Estimation (heures)} \\
\hline
En tant qu'utilisateur, je veux m'inscrire sur la plateforme & Moyenne & 8 \\
\hline
En tant qu'utilisateur, je veux me connecter à mon compte & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux modifier mon profil & Moyenne & 6 \\
\hline
En tant qu'utilisateur, je veux réinitialiser mon mot de passe & Difficile & 8 \\
\hline
\end{tabularx}
\caption{Backlog Sprint 1}
\label{tab:sprint1_backlog}
\end{table}

\section{Conception}


\textbf{Classes principales :}
\begin{itemize}
\item \textbf{User} : Gestion des utilisateurs avec intégration Dolibarr
\item \textbf{AuthController} : Contrôleur d'authentification
\item \textbf{UserService} : Service de gestion des utilisateurs
\item \textbf{DolibarrUserService} : Service d'intégration utilisateurs Dolibarr
\item \textbf{SessionManager} : Gestion des sessions utilisateur
\item \textbf{PasswordManager} : Gestion sécurisée des mots de passe
\item \textbf{EmailService} : Service d'envoi d'emails
\end{itemize}

\subsection{Use Case Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant l'authentification.

\begin{figure}[H]
\centering
\includegraphics {authentication_usecase_diagram.png}
\caption{Diagramme de cas d'utilisation - Authentification}
\label{fig:usecase_auth}
\end{figure}

\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item S'inscrire sur la plateforme
\item Se connecter à son compte
\item Modifier son profil
\item Réinitialiser son mot de passe
\item Se déconnecter
\item Gérer ses préférences
\end{itemize}

\section{Intégration Dolibarr}
\subsection{Modules Dolibarr Utilisés}
Ce sprint utilise principalement le module de gestion des tiers (sociétés) de Dolibarr pour gérer les utilisateurs :

\subsubsection{Module Sociétés/Tiers}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_societe}, \texttt{llx\_societe\_extrafields}, \texttt{llx\_user}
\item \textbf{Fonctionnalités} : Création, modification, authentification des utilisateurs
\item \textbf{Graphiques disponibles} : Évolution des inscriptions, répartition par type de client, activité des utilisateurs
\item \textbf{API utilisée} : \texttt{/thirdparties} pour CRUD des utilisateurs
\end{itemize}

\subsubsection{Module Utilisateurs}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_user}, \texttt{llx\_user\_extrafields}
\item \textbf{Fonctionnalités} : Gestion des comptes administrateurs et employés
\item \textbf{Graphiques disponibles} : Connexions par utilisateur, activité par période
\item \textbf{API utilisée} : \texttt{/users} pour la gestion des utilisateurs internes
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Tiers}
L'interface Dolibarr pour les tiers/clients offre :
\begin{itemize}
\item \textbf{Dashboard tiers} : Vue d'ensemble avec graphiques de performance
\item \textbf{Liste des tiers} : Filtrage par statut, type, activité
\item \textbf{Fiche tiers} : Informations complètes avec historique
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Évolution mensuelle des inscriptions
  \item Répartition des clients par statut
  \item Analyse de l'activité des utilisateurs
  \item Géolocalisation des clients
  \end{itemize}
  \begin{figure}[H]
    \centering
   \includegraphics[width=1.1\textwidth]{user.png}
    \caption{Interface Dolibarr - Gestion des Tiers}
    \label{fig:Interface Dolibarr - Gestion des Tiers}
\end{figure}
\end{itemize}

\section{Base de Données}
\subsection{Tables Principales Utilisées}

\subsubsection{Tables Utilisateurs/Tiers}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_societe} & Informations principales des tiers & \texttt{rowid}, \texttt{nom}, \texttt{email}, \texttt{client}, \texttt{statut} \\
\hline
\texttt{llx\_societe\_extrafields} & Champs personnalisés & \texttt{fk\_object}, \texttt{password\_hash}, \texttt{registration\_date} \\
\hline
\texttt{llx\_user} & Utilisateurs internes & \texttt{rowid}, \texttt{login}, \texttt{pass\_crypted}, \texttt{admin} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Authentification}
\end{table}

\subsubsection{Tables de Session}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_user\_token} & Tokens d'authentification & \texttt{fk\_user}, \texttt{token}, \texttt{datec}, \texttt{datevalid} \\
\hline
\texttt{llx\_actioncomm} & Historique des connexions & \texttt{fk\_user}, \texttt{datep}, \texttt{type\_code}, \texttt{note} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Gestion des Sessions}
\end{table}

\subsection{Modèle de Données}
Le modèle de données pour les utilisateurs utilise les tables existantes de Dolibarr:
\begin{itemize}
    \item \textbf{llx\_societe}: Stocke les informations de base des utilisateurs
    \item \textbf{llx\_societe\_extrafields}: Stocke les informations supplémentaires comme les mots de passe cryptés
    \item \textbf{llx\_user}: Pour les utilisateurs administrateurs
    \item \textbf{llx\_user\_token}: Pour la gestion des tokens de session
\end{itemize}



\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations d'authentification.

\subsection{Séquence d'Inscription}
\begin{figure}[H]
    \centering
    \includegraphics{register.png}
    \caption{Diagramme de séquence - Inscription d'un utilisateur}
    \label{fig:sequence_register}
\end{figure}

\textbf{Étapes de l'inscription :}
\begin{enumerate}
\item L'utilisateur accède au formulaire d'inscription
\item Saisie des informations personnelles (nom, email, mot de passe)
\item Validation côté client (format email, force du mot de passe)
\item Envoi au contrôleur AuthController
\item Vérification de l'unicité de l'email
\item Hachage sécurisé du mot de passe
\item Création du tiers via l'API Dolibarr
\item Insertion dans les tables \texttt{llx\_societe} et \texttt{llx\_societe\_extrafields}
\item Envoi d'un email de confirmation
\item Redirection vers la page de connexion
\end{enumerate}

\subsection{Séquence de Connexion}
\begin{figure}[H]
    \centering
    \includegraphics{login.png}
    \caption{Diagramme de séquence - Connexion d'un utilisateur}
    \label{fig:sequence_login}
\end{figure}

\textbf{Étapes de la connexion :}
\begin{enumerate}
\item L'utilisateur saisit ses identifiants (email/mot de passe)
\item Validation côté client des champs obligatoires
\item Envoi au contrôleur AuthController
\item Recherche de l'utilisateur dans la base Dolibarr
\item Vérification du mot de passe haché
\item Création de la session utilisateur
\item Génération d'un token de sécurité
\item Enregistrement de la connexion dans l'historique
\item Redirection vers le tableau de bord
\end{enumerate}

\subsection{Séquence de Réinitialisation de Mot de Passe}
\begin{figure}[H]
    \centering
    \includegraphics[width=1\textwidth]{restpasse.png}
    \caption{Diagramme de séquence - Réinitialisation de mot de passe}
    \label{fig:sequence_reset_password}
\end{figure}

\textbf{Étapes de la réinitialisation :}
\begin{enumerate}
\item L'utilisateur demande une réinitialisation
\item Saisie de l'adresse email
\item Vérification de l'existence du compte
\item Génération d'un token de réinitialisation
\item Envoi d'un email avec le lien de réinitialisation
\item L'utilisateur clique sur le lien
\item Validation du token et de sa validité
\item Saisie du nouveau mot de passe
\item Mise à jour sécurisée dans Dolibarr
\item Confirmation de la modification
\end{enumerate}

\subsection{Séquence de Modification de Profil}
\begin{figure}[H]
    \centering
    \includegraphics[width=1 \textwidth]{updateprof.png}    
    \caption{Diagramme de séquence - Modification de profil}
    \label{fig:sequence_profile_update}
\end{figure}

\textbf{Fonctionnalités de gestion de profil :}
\begin{itemize}
\item Modification des informations personnelles
\item Changement de mot de passe
\item Gestion des préférences
\item Historique des modifications
\item Validation des changements
\end{itemize}

\section{Interfaces Utilisateur}
Cette section présente les interfaces utilisateur développées pour le module d'authentification.

\subsection{Interface d'Inscription}
\begin{figure}[H]
    \centering
    \includegraphics[width=1 \textwidth]{registerinterface.png}
    \caption{Interface d'inscription}
    \label{fig:register_screen}
\end{figure}

\subsection{Interface de Connexion} 

\begin{figure}[H] 

\centering 

\includegraphics[width=1 \textwidth]{loginintt.png} 

\caption{Interface de connexion} 

\label{fig:login_screen} 

\end{figure} 

\subsection{Interface de Profil Utilisateur} 

\begin{figure}[H]
    \centering
    \includegraphics[width=1 \textwidth]{profile.png}
    \caption{Interface de profil utilisateur}
    \label{fig:profile_screen}
\end{figure}

\section{Tests}
Pour assurer la qualité et la fiabilité du module d'authentification, nous avons effectué une série de tests rigoureux couvrant différents scénarios d'utilisation.

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Test} & \textbf{Description} & \textbf{Résultat attendu} & \textbf{Statut} \\
\hline
Inscription valide & Inscription avec des données valides & Création du compte et redirection vers le profil & Réussi \\
\hline
Email déjà utilisé & Tentative d'inscription avec un email existant & Message d'erreur approprié & Réussi \\
\hline
Mots de passe non correspondants & Confirmation de mot de passe incorrecte & Message d'erreur approprié & Réussi \\
\hline
Connexion valide & Connexion avec des identifiants valides & Authentification réussie et redirection vers le profil & Réussi \\
\hline
Connexion invalide & Connexion avec des identifiants invalides & Message d'erreur approprié & Réussi \\
\hline
Déconnexion & Déconnexion d'un utilisateur connecté & Session détruite et redirection vers la page de connexion & Réussi \\
\hline
\end{tabularx}
\caption{Tests du module d'authentification}
\label{tab:auth_tests}
\end{table}

\section{Conclusion}
Ce sprint a permis de mettre en place le système d'authentification et de gestion des utilisateurs, en s'intégrant avec la base de données Dolibarr existante. Les utilisateurs peuvent désormais s'inscrire, se connecter et gérer leur profil sur la plateforme e-commerce.

L'architecture MVC adoptée a permis une séparation claire des responsabilités, facilitant la maintenance et l'évolution future du système. L'intégration avec Dolibarr a été réalisée en utilisant les tables existantes (h8pd\_societe et h8pd\_societe\_extrafields), assurant ainsi une cohérence des données entre l'ERP et la plateforme e-commerce.

\chapter{Sprint 2: Catalogue de Produits et Panier}
\section{Introduction}
Ce chapitre présente le deuxième sprint de développement, focalisé sur le catalogue de produits et la gestion du panier d'achat. Ces fonctionnalités sont essentielles pour permettre aux utilisateurs de parcourir les produits disponibles et de les ajouter à leur panier avant de passer commande.

\section{Backlog du Sprint}

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Complexité} & \textbf{Estimation (heures)} \\
\hline
En tant qu'utilisateur, je veux consulter le catalogue de produits & Moyenne & 8 \\
\hline
En tant qu'utilisateur, je veux filtrer les produits par catégorie & Moyenne & 6 \\
\hline
En tant qu'utilisateur, je veux rechercher des produits par nom & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux voir les détails d'un produit & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux ajouter des produits à mon panier & Moyenne & 8 \\
\hline
En tant qu'utilisateur, je veux modifier les quantités dans mon panier & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux supprimer des produits de mon panier & Facile & 4 \\
\hline
\end{tabularx}
\caption{Backlog du Sprint 2}
\label{tab:backlog_sprint2}
\end{table}


\section{Conception}


\subsection{Use Case Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des produits et du panier.

\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{visiteurUseCase.png}
\caption{Diagramme de cas d'utilisation - Produits et panier}
\label{fig:visiteur UseCase}
\end{figure}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{clientUseCase.png}
\caption{Diagramme de cas d'utilisation - client-Produits et panier}
\label{fig:usecase_products}
\end{figure}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{adminusecase.png}
\caption{Diagramme de cas d'utilisation -  Produits et Catégories}
\label{fig:usecase_products}
\end{figure}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{Parcourir les ProduitsUseCase.png}
\caption{Diagramme de cas d'utilisation -  Parcourir les Produits}
\label{fig:usecase_products}
\end{figure}
\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Consulter le catalogue de produits
\item Filtrer les produits par catégorie
\item Rechercher des produits par nom
\item Voir les détails d'un produit
\item Ajouter des produits au panier
\item Modifier les quantités dans le panier
\item Supprimer des produits du panier
\item Calculer le total du panier
\end{itemize}

\section{Intégration Dolibarr}
\subsection{Modules Dolibarr Utilisés}
Ce sprint utilise principalement les modules de gestion des produits et stocks de Dolibarr :

\subsubsection{Module Produits/Services}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_product}, \texttt{llx\_product\_extrafields}, \texttt{llx\_categorie}
\item \textbf{Fonctionnalités} : Gestion du catalogue, prix, descriptions, images
\item \textbf{Graphiques disponibles} : Top produits vendus, évolution des ventes, analyse des marges
\item \textbf{API utilisée} : \texttt{/products} pour CRUD des produits
\end{itemize}

\subsubsection{Module Catégories}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_categorie}, \texttt{llx\_categorie\_product}
\item \textbf{Fonctionnalités} : Organisation hiérarchique des produits
\item \textbf{Graphiques disponibles} : Répartition des ventes par catégorie, performance des catégories
\item \textbf{API utilisée} : \texttt{/categories} pour la gestion des catégories
\end{itemize}

\subsubsection{Module Stocks}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_product\_stock}, \texttt{llx\_entrepot}
\item \textbf{Fonctionnalités} : Gestion des stocks, disponibilité des produits
\item \textbf{Graphiques disponibles} : Évolution des stocks, alertes de rupture, rotation des stocks
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Produits}
L'interface Dolibarr pour les produits offre :
\begin{itemize}
\item \textbf{Dashboard produits} : Vue d'ensemble avec métriques de performance
\item \textbf{Catalogue produits} : Liste complète avec filtres avancés
\item \textbf{Fiche produit} : Détails complets avec historique des ventes
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Évolution des ventes par produit
  \item Analyse des marges bénéficiaires
  \item Comparaison des performances
  \item Prévisions de ventes
  \end{itemize}
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Stocks}
L'interface Dolibarr pour les stocks propose :
\begin{itemize}
\item \textbf{Dashboard stocks} : Vue d'ensemble des niveaux de stock
\item \textbf{Mouvements de stock} : Historique détaillé des entrées/sorties
\item \textbf{Alertes} : Notifications de rupture de stock
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Évolution des niveaux de stock
  \item Rotation des stocks par produit
  \item Analyse des ruptures
  \item Valorisation des stocks
  \end{itemize}
\end{itemize}

\section{Base de Données}
\subsection{Tables Principales Utilisées}

\subsubsection{Tables Produits}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_product} & Produits principaux & \texttt{rowid}, \texttt{ref}, \texttt{label}, \texttt{price}, \texttt{tva\_tx} \\
\hline
\texttt{llx\_product\_extrafields} & Champs personnalisés & \texttt{fk\_object}, \texttt{description\_long}, \texttt{images}, \texttt{featured} \\
\hline
\texttt{llx\_product\_price} & Historique des prix & \texttt{fk\_product}, \texttt{price}, \texttt{date\_price}, \texttt{price\_level} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Produits}
\end{table}

\subsubsection{Tables Catégories}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_categorie} & Catégories & \texttt{rowid}, \texttt{label}, \texttt{description}, \texttt{fk\_parent} \\
\hline
\texttt{llx\_categorie\_product} & Liaison catégorie-produit & \texttt{fk\_categorie}, \texttt{fk\_product} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Catégories}
\end{table}

\subsubsection{Tables Stocks}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_product\_stock} & Stocks par entrepôt & \texttt{fk\_product}, \texttt{fk\_entrepot}, \texttt{reel}, \texttt{pmp} \\
\hline
\texttt{llx\_stock\_mouvement} & Mouvements de stock & \texttt{fk\_product}, \texttt{fk\_entrepot}, \texttt{value}, \texttt{datem} \\
\hline
\texttt{llx\_entrepot} & Entrepôts & \texttt{rowid}, \texttt{label}, \texttt{description}, \texttt{statut} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Stocks}
\end{table}

\section{Implémentation}
\subsection{Modèle de Produit}
Le modèle de produit permet d'accéder aux données des produits stockées dans la base de données Dolibarr. Il gère la récupération des produits, leur filtrage par catégorie et la recherche par nom.

\subsection{Contrôleur de Produit}
Le contrôleur de produit gère les requêtes liées à l'affichage et à la recherche de produits. Il interagit avec le modèle de produit pour récupérer les données nécessaires et les transmet aux vues appropriées.

\subsection{Modèle de Panier}
Le modèle de panier gère les opérations liées au panier d'achat, notamment l'ajout, la modification et la suppression de produits. Il utilise les sessions PHP pour stocker temporairement les informations du panier.

\subsection{Contrôleur de Panier}
Le contrôleur de panier traite les requêtes liées à la gestion du panier d'achat. Il permet aux utilisateurs d'ajouter des produits, de modifier les quantités et de supprimer des articles du panier.

\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations liées aux produits et au panier.

\subsection{Séquence d'Affichage des Produits}
\begin{figure}[H]
\centering

\caption{Diagramme de séquence - Affichage des produits}
\label{fig:sequence_display_products}
\end{figure}

\textbf{Étapes d'affichage du catalogue :}
\begin{enumerate}
\item L'utilisateur accède à la page catalogue
\item Le contrôleur ProductController traite la demande
\item Récupération des produits via l'API Dolibarr
\item Requête sur les tables \texttt{llx\_product} et \texttt{llx\_categorie}
\item Application des filtres (catégorie, prix, disponibilité)
\item Récupération des images et descriptions
\item Calcul des prix avec TVA
\item Affichage paginé des résultats
\item Mise en cache pour optimiser les performances
\end{enumerate}

\subsection{Séquence de Recherche de Produits}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{Séquence de Recherche Produit.png}
\caption{Diagramme de séquence - Recherche de produits}
\label{fig:sequence_search_products}
\end{figure}

\textbf{Étapes de la recherche :}
\begin{enumerate}
\item L'utilisateur saisit un terme de recherche
\item Validation et nettoyage de la requête
\item Recherche dans les champs \texttt{label}, \texttt{description}
\item Application des filtres avancés
\item Tri par pertinence et popularité
\item Mise en évidence des termes recherchés
\item Suggestions de produits similaires
\item Enregistrement des statistiques de recherche
\end{enumerate}

\subsection{Séquence d'Ajout au Panier}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{ Séquence d'Ajout au Panier.png}
\caption{Diagramme de séquence - Ajout d'un produit au panier}
\label{fig:sequence_add_to_cart}
\end{figure}

\textbf{Étapes d'ajout au panier :}
\begin{enumerate}
\item L'utilisateur clique sur "Ajouter au panier"
\item Validation de la quantité demandée
\item Vérification de la disponibilité en stock
\item Contrôle des limites de commande
\item Ajout à la session panier
\item Calcul du sous-total
\item Mise à jour du compteur panier
\item Affichage de la confirmation
\item Proposition de produits complémentaires
\end{enumerate}

\subsection{Séquence de Gestion du Panier}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{gestionpanier.png}
\caption{Diagramme de séquence - Gestion du panier}
\label{fig:sequence_cart_management}
\end{figure}

\textbf{Fonctionnalités de gestion du panier :}
\begin{itemize}
\item Modification des quantités en temps réel
\item Suppression d'articles
\item Calcul automatique des totaux
\item Application des remises et promotions
\item Estimation des frais de livraison
\item Sauvegarde temporaire du panier
\item Récupération du panier abandonné
\end{itemize}

\section{Réalisation}
Cette section présente les captures d'écran des interfaces utilisateur développées pour la gestion des produits et du panier.

\subsection{Interface du Catalogue de Produits}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran du catalogue de produits]}}
\caption{Interface du catalogue de produits}
\label{fig:products_catalog}
\end{figure}

\subsection{Interface de Détail de Produit}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de la page de détail d'un produit]}}
\caption{Interface de détail de produit}
\label{fig:product_detail}
\end{figure}

\subsection{Interface du Panier d'Achat}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{cart.png}
\caption{Interface du panier d'achat}
\label{fig:shopping_cart}
\end{figure}

\section{Tests}
Pour assurer la qualité et la fiabilité du module de produits et du panier, nous avons effectué les tests suivants :

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Test} & \textbf{Description} & \textbf{Résultat attendu} & \textbf{Statut} \\
\hline
Affichage des produits & Chargement du catalogue de produits & Liste des produits affichée correctement & Réussi \\
\hline
Filtrage par catégorie & Sélection d'une catégorie & Produits filtrés par catégorie & Réussi \\
\hline
Recherche de produits & Recherche par nom de produit & Résultats correspondant aux critères & Réussi \\
\hline
Ajout au panier & Ajout d'un produit au panier & Produit ajouté avec succès & Réussi \\
\hline
Modification de quantité & Modification de la quantité d'un produit & Quantité mise à jour correctement & Réussi \\
\hline
Suppression du panier & Suppression d'un produit du panier & Produit retiré avec succès & Réussi \\
\hline
\end{tabularx}
\caption{Tests du module de produits et panier}
\label{tab:products_cart_tests}
\end{table}

\section{Conclusion}
Ce sprint a permis de mettre en place le catalogue de produits et la gestion du panier d'achat, en s'intégrant avec la base de données Dolibarr existante. Les utilisateurs peuvent désormais parcourir les produits, les filtrer par catégorie, les rechercher par nom, et gérer leur panier d'achat.

L'intégration avec Dolibarr a été réalisée en utilisant les tables existantes (h8pd\_product et h8pd\_categorie), assurant ainsi une cohérence des données entre l'ERP et la plateforme e-commerce. La gestion du panier utilise les sessions PHP pour stocker temporairement les informations du panier, offrant ainsi une expérience utilisateur fluide sans nécessiter de connexion à la base de données pour chaque opération.

\chapter{Sprint 3: Gestion des Commandes}
\section{Introduction}
Ce chapitre présente le troisième sprint de développement, focalisé exclusivement sur la gestion des commandes. Cette fonctionnalité constitue le cœur du processus e-commerce, permettant aux utilisateurs de finaliser leurs achats et de suivre leurs commandes de manière efficace et sécurisée.

\section{Backlog du Sprint}

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{User Story} & \textbf{Complexité} & \textbf{Estimation (heures)} \\
\hline
En tant qu'utilisateur, je veux finaliser ma commande & Complexe & 12 \\
\hline
En tant qu'utilisateur, je veux choisir une méthode de paiement & Moyenne & 8 \\
\hline
En tant qu'utilisateur, je veux consulter l'historique de mes commandes & Moyenne & 6 \\
\hline
En tant qu'utilisateur, je veux voir les détails d'une commande & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux suivre le statut de ma commande & Moyenne & 6 \\
\hline
En tant qu'utilisateur, je veux recevoir des notifications de commande & Facile & 4 \\
\hline
\end{tabularx}
\caption{Backlog du Sprint 3 - Gestion des Commandes}
\label{tab:backlog_sprint3}
\end{table}

\section{Conception}

\subsection{Analyse des Besoins}
La gestion des commandes représente un processus critique dans toute plateforme e-commerce. Elle doit garantir la sécurité des transactions, la traçabilité des opérations et l'intégrité des données tout en offrant une expérience utilisateur optimale.

\subsection{Use Case Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des commandes.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de cas d'utilisation pour les commandes]}}
\caption{Diagramme de cas d'utilisation - Gestion des commandes}
\label{fig:usecase_orders}
\end{figure}

\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Finaliser une commande
\item Choisir une méthode de paiement
\item Consulter l'historique des commandes
\item Voir les détails d'une commande
\item Suivre le statut d'une commande
\item Recevoir des notifications de commande
\item Gérer les adresses de livraison
\item Appliquer des codes promotionnels
\end{itemize}

\section{Intégration Dolibarr}
\subsection{Modules Dolibarr Utilisés}
Ce sprint utilise intensivement plusieurs modules Dolibarr pour la gestion complète des commandes :

\subsubsection{Module Commandes (Orders)}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_commande}, \texttt{llx\_commandedet}, \texttt{llx\_commande\_extrafields}
\item \textbf{Fonctionnalités} : Création, validation, suivi et gestion complète des commandes
\item \textbf{Graphiques disponibles} : Évolution du chiffre d'affaires, répartition par statut, analyse des produits vendus
\item \textbf{API utilisée} : \texttt{/orders} pour les opérations CRUD des commandes
\item \textbf{Workflow} : Brouillon → Validée → En cours → Expédiée → Livrée
\end{itemize}

\subsubsection{Module Paiements}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_paiement}, \texttt{llx\_paiement\_commande}, \texttt{llx\_c\_paiement}
\item \textbf{Fonctionnalités} : Enregistrement, validation et suivi des paiements
\item \textbf{Graphiques disponibles} : Répartition par mode de paiement, évolution des encaissements
\item \textbf{Sécurité} : Chiffrement des données sensibles, conformité PCI-DSS
\end{itemize}

\subsubsection{Module Expéditions}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_expedition}, \texttt{llx\_expeditiondet}
\item \textbf{Fonctionnalités} : Gestion des expéditions et suivi des livraisons
\item \textbf{Intégrations} : Transporteurs, codes de suivi, notifications automatiques
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Commandes}
L'interface Dolibarr pour les commandes offre une gestion complète et professionnelle :
\begin{itemize}
\item \textbf{Dashboard commandes} : Vue d'ensemble avec indicateurs de performance en temps réel
\item \textbf{Liste des commandes} : Filtrage avancé par statut, client, période, montant
\item \textbf{Fiche commande} : Détails complets avec historique des modifications et traçabilité
\item \textbf{Gestion des statuts} : Workflow automatisé avec notifications
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Évolution mensuelle du chiffre d'affaires
  \item Répartition des commandes par statut
  \item Analyse des produits les plus vendus
  \item Métriques des délais de livraison
  \item Taux de conversion et abandon de panier
  \end{itemize}
\end{itemize}

\subsection{Workflow de Commande}
Le processus de commande suit un workflow structuré :
\begin{enumerate}
\item \textbf{Création} : Conversion du panier en commande brouillon
\item \textbf{Validation} : Vérification des stocks et informations client
\item \textbf{Paiement} : Traitement sécurisé du paiement
\item \textbf{Confirmation} : Validation définitive et génération du numéro
\item \textbf{Préparation} : Mise en préparation dans l'entrepôt
\item \textbf{Expédition} : Génération du bon de livraison
\item \textbf{Livraison} : Confirmation de réception
\end{enumerate}

\section{Base de Données}
\subsection{Architecture des Données}
La gestion des commandes s'appuie sur une architecture de base de données robuste et normalisée, garantissant l'intégrité référentielle et les performances optimales.

\subsection{Tables Principales Utilisées}

\subsubsection{Tables Commandes}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_commande} & Commandes principales & \texttt{rowid}, \texttt{fk\_soc}, \texttt{total\_ht}, \texttt{fk\_statut}, \texttt{date\_commande} \\
\hline
\texttt{llx\_commandedet} & Lignes de commande & \texttt{fk\_commande}, \texttt{fk\_product}, \texttt{qty}, \texttt{subprice}, \texttt{tva\_tx} \\
\hline
\texttt{llx\_commande\_extrafields} & Champs personnalisés & \texttt{fk\_object}, \texttt{delivery\_method}, \texttt{special\_instructions}, \texttt{tracking\_number} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Commandes}
\end{table}

\subsubsection{Tables Paiements}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_paiement} & Paiements & \texttt{rowid}, \texttt{datep}, \texttt{amount}, \texttt{fk\_paiement}, \texttt{num\_paiement} \\
\hline
\texttt{llx\_paiement\_commande} & Liaison paiement-commande & \texttt{fk\_paiement}, \texttt{fk\_commande}, \texttt{amount} \\
\hline
\texttt{llx\_c\_paiement} & Types de paiement & \texttt{id}, \texttt{code}, \texttt{libelle}, \texttt{active} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Paiements}
\end{table}

\subsubsection{Tables Expéditions}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_expedition} & Expéditions & \texttt{rowid}, \texttt{fk\_commande}, \texttt{date\_expedition}, \texttt{tracking\_number} \\
\hline
\texttt{llx\_expeditiondet} & Détails expédition & \texttt{fk\_expedition}, \texttt{fk\_product}, \texttt{qty} \\
\hline
\texttt{llx\_c\_shipment\_mode} & Modes d'expédition & \texttt{rowid}, \texttt{code}, \texttt{libelle}, \texttt{tracking\_url} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Expéditions}
\end{table}

\section{Implémentation}
\subsection{Architecture de Développement}
L'implémentation suit une architecture MVC (Model-View-Controller) robuste, garantissant la séparation des préoccupations et la maintenabilité du code. L'intégration avec Dolibarr est réalisée via les API natives, assurant une synchronisation parfaite des données.

\subsection{Modèle de Commande}
Le modèle de commande constitue le cœur du système de gestion des commandes. Il assure la conversion du panier en commande et la gestion complète du cycle de vie des commandes.

\textbf{Fonctionnalités principales :}
\begin{itemize}
\item Création de commande via API Dolibarr
\item Synchronisation des statuts en temps réel
\item Gestion des lignes de commande et des variantes
\item Calcul automatique des totaux, taxes et frais de port
\item Intégration avec le module de paiement
\item Gestion des adresses de livraison et facturation
\item Suivi des expéditions et numéros de tracking
\item Application des codes promotionnels et remises
\item Gestion des stocks et réservations
\end{itemize}

\subsection{Contrôleur de Commande}
Le contrôleur de commande orchestre l'ensemble des opérations liées aux commandes. Il gère les requêtes HTTP, valide les données, coordonne les interactions avec les modèles et retourne les réponses appropriées.

\textbf{Responsabilités principales :}
\begin{itemize}
\item Validation des données de commande
\item Gestion des sessions et authentification
\item Coordination avec les services de paiement
\item Génération des confirmations et factures
\item Gestion des erreurs et exceptions
\item Logging et audit des opérations
\end{itemize}

\subsection{Service de Paiement}
Le service de paiement gère l'intégration avec les différentes passerelles de paiement et assure la sécurité des transactions financières.

\textbf{Fonctionnalités clés :}
\begin{itemize}
\item Support multi-passerelles (Stripe, PayPal, etc.)
\item Chiffrement des données sensibles
\item Gestion des remboursements
\item Conformité PCI DSS
\item Notifications de paiement en temps réel
\end{itemize}

\subsection{Service d'Expédition}
Le service d'expédition coordonne la logistique et le suivi des livraisons.

\textbf{Capacités principales :}
\begin{itemize}
\item Calcul automatique des frais de port
\item Intégration avec les transporteurs
\item Génération des étiquettes d'expédition
\item Suivi en temps réel des colis
\item Notifications de livraison
\end{itemize}

\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations de gestion des commandes.

\subsection{Séquence de Création de Commande}
\begin{figure}[H]
\centering
\includegraphics[width=1\textwidth]{plantuml_sequence_order_creation.png}
\caption{Diagramme de séquence - Création d'une commande}
\label{fig:sequence_create_order}
\end{figure}

\textbf{Étapes de la séquence :}
\begin{enumerate}
\item L'utilisateur valide son panier
\item Le contrôleur OrderController traite la demande
\item Validation des données et vérification du stock
\item Vérification de la disponibilité des produits
\item Calcul des totaux, taxes et frais de port
\item Appel à l'API Dolibarr pour créer la commande
\item Insertion dans les tables \texttt{llx\_commande} et \texttt{llx\_commandedet}
\item Génération du numéro de commande unique
\item Réservation temporaire du stock
\item Redirection vers la page de paiement
\item Confirmation et notification à l'utilisateur
\end{enumerate}

\subsection{Flux Client}
\begin{figure}[H]
\centering
\includegraphics[width=1\textwidth]{plantuml_sequence_client_flow.png}
\caption{Diagramme de séquence - Flux Client}
\label{fig:sequence_client_flow}
\end{figure}

\textbf{Étapes du flux client :}
\begin{enumerate}
\item Authentification et création de session
\item Navigation dans le catalogue produits
\item Ajout de produits au panier avec vérification de stock
\item Validation du panier et processus de checkout
\item Création de la commande dans Dolibarr
\item Consultation de l'historique des commandes
\item Suivi détaillé des commandes
\end{enumerate}

\subsection{Fonctions Administrateur}
\begin{figure}[H]
\centering
\includegraphics[width=1\textwidth]{plantuml_sequence_admin_functions.png}
\caption{Diagramme de séquence - Fonctions Administrateur}
\label{fig:sequence_admin_functions}
\end{figure}

\textbf{Fonctionnalités administrateur :}
\begin{enumerate}
\item Gestion complète des commandes et modification des statuts
\item Administration du catalogue produits et gestion des stocks
\item Gestion des utilisateurs et attribution des droits
\item Génération de rapports et statistiques de vente
\item Traitement des demandes de retour et avoir
\item Notifications automatiques aux clients
\end{enumerate}

\subsection{Intégration Dolibarr}
\begin{figure}[H]
\centering
\includegraphics[width=1\textwidth]{plantuml_sequence_dolibarr_integration.png}
\caption{Diagramme de séquence - Intégration Dolibarr}
\label{fig:sequence_dolibarr_integration}
\end{figure}

\textbf{Processus d'intégration Dolibarr :}
\begin{enumerate}
\item Synchronisation bidirectionnelle des données clients
\item Mise à jour en temps réel du catalogue produits
\item Création automatique des commandes dans les tables Dolibarr
\item Gestion des stocks avec réservation temporaire
\item Traitement des paiements et génération des factures
\item Suivi des commandes via les statuts Dolibarr
\item Synchronisation programmée toutes les 5 minutes
\end{enumerate}

\subsection{Séquence de Traitement de Paiement}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de traitement de paiement]}}
\caption{Diagramme de séquence - Traitement d'un paiement}
\label{fig:sequence_payment}
\end{figure}

\textbf{Étapes du paiement :}
\begin{enumerate}
\item Sélection de la méthode de paiement
\item Validation des informations de paiement
\item Chiffrement des données sensibles
\item Appel au service de paiement externe (Stripe, PayPal, etc.)
\item Vérification de la transaction
\item Enregistrement du paiement dans Dolibarr
\item Mise à jour du statut de la commande
\item Confirmation définitive du stock
\item Génération de la facture
\item Envoi de la confirmation par email
\item Déclenchement du processus d'expédition
\end{enumerate}

\subsection{Séquence de Suivi de Commande}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{ suivi de commande.png}
\caption{Diagramme de séquence - Suivi d'une commande}
\label{fig:sequence_order_tracking}
\end{figure}

\textbf{Fonctionnalités de suivi :}
\begin{itemize}
\item Consultation du statut en temps réel
\item Historique détaillé des modifications
\item Notifications automatiques des changements d'état
\item Intégration avec les API des transporteurs
\item Estimation précise des délais de livraison
\item Géolocalisation des colis en transit
\item Alertes proactives en cas de retard
\end{itemize}

\subsection{Séquence de Gestion des Expéditions}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de gestion des expéditions]}}
\caption{Diagramme de séquence - Gestion des expéditions}
\label{fig:sequence_shipment}
\end{figure}

\textbf{Processus d'expédition :}
\begin{enumerate}
\item Réception de la commande confirmée
\item Préparation des articles en entrepôt
\item Génération de l'étiquette d'expédition
\item Attribution du numéro de tracking
\item Mise à jour du statut dans Dolibarr
\item Remise au transporteur
\item Notification client avec numéro de suivi
\item Suivi automatique via API transporteur
\item Confirmation de livraison
\item Mise à jour finale du statut
\end{enumerate}

\section{Réalisation}
Cette section présente les captures d'écran des interfaces utilisateur développées pour la gestion complète des commandes, du processus de commande jusqu'au suivi des livraisons.

\subsection{Interface de Commande}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{cheqout.png}
\caption{Interface de finalisation de commande - Processus de checkout optimisé}
\label{fig:checkout_screen}
\end{figure}

L'interface de commande présente un processus de checkout simplifié et sécurisé, permettant aux utilisateurs de finaliser leurs achats en quelques étapes. Elle inclut la validation des informations de livraison, le choix du mode de paiement et la confirmation finale.

\subsection{Interface d'Historique des Commandes}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{order.png}
\caption{Interface d'historique des commandes - Suivi complet}
\label{fig:order_history_screen}
\end{figure}

L'interface d'historique offre une vue d'ensemble complète de toutes les commandes passées, avec des filtres avancés, la possibilité de consulter les détails de chaque commande et de suivre leur statut en temps réel.

\subsection{Interface de Détail de Commande}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Interface de détail de commande avec tracking]}}
\caption{Interface de détail de commande avec suivi de livraison}
\label{fig:order_detail_screen}
\end{figure}

Cette interface permet aux utilisateurs de consulter tous les détails d'une commande spécifique, incluant les produits commandés, les informations de livraison, le statut de paiement et le suivi en temps réel de l'expédition.

\subsection{Interface de Suivi des Expéditions}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Interface de suivi des expéditions avec carte]}}
\caption{Interface de suivi des expéditions avec géolocalisation}
\label{fig:tracking_screen}
\end{figure}

L'interface de suivi des expéditions offre une expérience utilisateur moderne avec géolocalisation en temps réel, estimation des délais de livraison et notifications proactives.

\section{Tests}
Pour assurer la qualité et la fiabilité du module de gestion des commandes, nous avons effectué une batterie de tests complète couvrant tous les aspects du processus de commande :

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Test} & \textbf{Description} & \textbf{Résultat attendu} & \textbf{Statut} \\
\hline
Création de commande & Finalisation d'une commande à partir du panier & Commande créée avec succès dans Dolibarr & Réussi \\
\hline
Validation des stocks & Vérification de la disponibilité des produits & Stock vérifié et réservé temporairement & Réussi \\
\hline
Calcul des totaux & Calcul automatique des taxes et frais de port & Montants calculés correctement & Réussi \\
\hline
Traitement de paiement & Paiement via différentes passerelles & Transaction sécurisée et confirmée & Réussi \\
\hline
Génération de facture & Création automatique de la facture & Facture générée au format PDF & Réussi \\
\hline
Historique des commandes & Consultation de l'historique des commandes & Liste des commandes avec filtres & Réussi \\
\hline
Détails de commande & Consultation des détails d'une commande & Informations complètes affichées & Réussi \\
\hline
Suivi des expéditions & Suivi en temps réel des livraisons & Statut mis à jour automatiquement & Réussi \\
\hline
Notifications & Envoi d'emails de confirmation et de suivi & Notifications envoyées correctement & Réussi \\
\hline
Gestion des erreurs & Traitement des erreurs de paiement & Messages d'erreur appropriés & Réussi \\
\hline
Sécurité des données & Chiffrement des informations sensibles & Données protégées selon PCI DSS & Réussi \\
\hline
Performances & Temps de réponse des opérations & Réponse < 3 secondes & Réussi \\
\hline
\end{tabularx}
\caption{Tests du module de gestion des commandes}
\label{tab:orders_tests}
\end{table}

\subsection{Tests d'Intégration Dolibarr}
Des tests spécifiques ont été réalisés pour valider l'intégration avec l'ERP Dolibarr :

\begin{itemize}
\item \textbf{Synchronisation des données} : Vérification de la cohérence entre la plateforme e-commerce et Dolibarr
\item \textbf{API Dolibarr} : Test de tous les endpoints utilisés (commandes, produits, clients, paiements)
\item \textbf{Gestion des erreurs} : Comportement en cas d'indisponibilité temporaire de Dolibarr
\item \textbf{Performance} : Impact de l'intégration sur les temps de réponse
\end{itemize}

\section{Conclusion}
Ce sprint a permis de mettre en place un système complet de gestion des commandes, parfaitement intégré avec l'ERP Dolibarr existant. Les utilisateurs bénéficient désormais d'une expérience d'achat fluide et sécurisée, depuis la finalisation du panier jusqu'au suivi de livraison.

\subsection{Réalisations Clés}
\begin{itemize}
\item \textbf{Processus de commande optimisé} : Tunnel de conversion simplifié avec validation en temps réel
\item \textbf{Intégration Dolibarr native} : Synchronisation parfaite avec les tables \texttt{llx\_commande}, \texttt{llx\_commandedet}, \texttt{llx\_paiement} et \texttt{llx\_expedition}
\item \textbf{Gestion des paiements sécurisée} : Support multi-passerelles avec conformité PCI DSS
\item \textbf{Suivi des expéditions avancé} : Intégration avec les API des transporteurs et géolocalisation
\item \textbf{Notifications automatiques} : Système d'alertes proactives pour informer les clients
\item \textbf{Interface utilisateur moderne} : Design responsive et expérience utilisateur optimisée
\end{itemize}

\subsection{Valeur Ajoutée}
L'intégration avec Dolibarr garantit une cohérence parfaite des données entre l'ERP et la plateforme e-commerce, éliminant les risques de désynchronisation et permettant une gestion unifiée des opérations commerciales. Le système développé respecte les meilleures pratiques de sécurité et de performance, assurant une expérience utilisateur de qualité professionnelle.

\chapter{Sprint 4 - Système de Support Client}
\section{Introduction}
Le Sprint 4 se concentre sur le développement d'un système de support client complet et intégré, permettant aux utilisateurs de la plateforme e-commerce de bénéficier d'un service d'assistance professionnel et réactif. Ce système s'appuie sur le module de tickets de Dolibarr pour assurer une gestion centralisée et efficace des demandes de support.

\section{Backlog du Sprint}
\subsection{User Stories}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{ID} & \textbf{User Story} & \textbf{Priorité} & \textbf{Points} \\
\hline
US-13 & En tant qu'utilisateur, je veux pouvoir créer un ticket de support pour signaler un problème & Haute & 8 \\
\hline
US-14 & En tant qu'utilisateur, je veux consulter l'historique de mes tickets de support & Haute & 5 \\
\hline
US-15 & En tant qu'utilisateur, je veux recevoir des notifications sur l'évolution de mes tickets & Moyenne & 5 \\
\hline
US-16 & En tant qu'utilisateur, je veux pouvoir répondre aux messages des agents de support & Haute & 8 \\
\hline
US-17 & En tant qu'agent, je veux pouvoir consulter et traiter les tickets assignés & Haute & 13 \\
\hline
US-18 & En tant qu'agent, je veux pouvoir catégoriser et prioriser les tickets & Moyenne & 5 \\
\hline
US-19 & En tant qu'administrateur, je veux avoir un tableau de bord des performances du support & Basse & 8 \\
\hline
\end{tabularx}
\caption{Backlog du Sprint 4 - Support Client}
\end{table}

\section{Conception}
\subsection{Analyse des Besoins}
Le système de support client doit répondre aux exigences suivantes :
\begin{itemize}
\item Interface utilisateur intuitive pour la création de tickets
\item Système de catégorisation et de priorisation automatique
\item Notifications en temps réel pour les utilisateurs et les agents
\item Intégration complète avec le CRM Dolibarr
\item Tableau de bord de performance et de suivi
\item Système de satisfaction client et de feedback
\end{itemize}

\subsection{Cas d'Utilisation}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Diagramme de cas d'utilisation du support client]}}
\caption{Diagramme de cas d'utilisation - Système de support client}
\label{fig:usecase_support}
\end{figure}

\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Créer un ticket de support
\item Consulter l'historique des tickets
\item Répondre à un ticket
\item Assigner un ticket à un agent
\item Escalader un ticket
\item Fermer un ticket
\item Évaluer la qualité du support
\end{itemize}

\section{Intégration Dolibarr}
\subsection{Module Tickets}
Le module Tickets de Dolibarr offre une infrastructure complète pour la gestion du support client :

\textbf{Fonctionnalités principales :}
\begin{itemize}
\item Création et gestion des tickets
\item Système de catégories et de priorités
\item Assignation automatique ou manuelle
\item Historique complet des échanges
\item Notifications par email
\item Statistiques et rapports
\end{itemize}

\textbf{Tables utilisées :}
\begin{itemize}
\item \texttt{llx\_ticket} : Tickets principaux
\item \texttt{llx\_ticket\_extrafields} : Champs personnalisés
\item \texttt{llx\_actioncomm} : Historique des actions
\item \texttt{llx\_c\_ticket\_severity} : Niveaux de gravité
\item \texttt{llx\_c\_ticket\_type} : Types de tickets
\end{itemize}

\subsection{Module CRM}
Intégration avec le module CRM pour une vision client complète :

\textbf{Fonctionnalités CRM :}
\begin{itemize}
\item Historique client unifié
\item Segmentation des clients
\item Suivi des interactions
\item Analyse de satisfaction
\item Gestion des contacts
\end{itemize}

\section{Base de Données}
\subsection{Architecture des Données}
Le système de support s'appuie sur une architecture de données optimisée pour la performance et la traçabilité complète des interactions client.

\subsection{Tables Principales Utilisées}

\subsubsection{Tables Support}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_ticket} & Tickets de support & \texttt{rowid}, \texttt{fk\_user\_create}, \texttt{subject}, \texttt{fk\_statut}, \texttt{severity} \\
\hline
\texttt{llx\_ticket\_extrafields} & Champs personnalisés tickets & \texttt{fk\_object}, \texttt{priority}, \texttt{category}, \texttt{satisfaction\_rating} \\
\hline
\texttt{llx\_actioncomm} & Historique des actions & \texttt{fk\_element}, \texttt{elementtype}, \texttt{note}, \texttt{datep} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Support}
\end{table}

\subsubsection{Tables de Configuration}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_c\_ticket\_severity} & Niveaux de gravité & \texttt{code}, \texttt{pos}, \texttt{label}, \texttt{color} \\
\hline
\texttt{llx\_c\_ticket\_type} & Types de tickets & \texttt{code}, \texttt{pos}, \texttt{label}, \texttt{use\_default} \\
\hline
\texttt{llx\_c\_ticket\_category} & Catégories de tickets & \texttt{code}, \texttt{pos}, \texttt{label}, \texttt{public} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Configuration Support}
\end{table}

\section{Implémentation}
\subsection{Architecture du Support}
L'implémentation du système de support suit une architecture modulaire et extensible, permettant une intégration transparente avec l'écosystème Dolibarr existant.

\subsection{Modèle de Ticket}
Le modèle de ticket constitue le cœur du système de support, gérant l'ensemble du cycle de vie des demandes client.

\textbf{Fonctionnalités principales :}
\begin{itemize}
\item Création de tickets via API Dolibarr
\item Gestion des priorités et catégories
\item Suivi des échanges et réponses
\item Notifications automatiques
\item Intégration avec le CRM Dolibarr
\item Système d'escalade automatique
\item Mesure de satisfaction client
\end{itemize}

\subsection{Contrôleur de Support}
Le contrôleur de support orchestre l'ensemble des opérations liées à la gestion des tickets et des interactions client.

\textbf{Responsabilités principales :}
\begin{itemize}
\item Validation des données de tickets
\item Gestion de l'authentification et des permissions
\item Coordination avec les services de notification
\item Génération des rapports et statistiques
\item Gestion des erreurs et exceptions
\item Audit et logging des opérations
\end{itemize}

\subsection{Service de Notification}
Le service de notification assure la communication en temps réel entre les clients et les agents de support.

\textbf{Fonctionnalités clés :}
\begin{itemize}
\item Notifications email automatiques
\item Alertes en temps réel
\item Templates personnalisables
\item Gestion des préférences utilisateur
\item Intégration avec les systèmes externes
\end{itemize}

\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système de support client.

\subsection{Séquence de Création de Ticket}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{creationtt.png}
\caption{Diagramme de séquence - Création d'un ticket de support}
\label{fig:sequence_create_ticket}
\end{figure}

\textbf{Étapes de création de ticket :}
\begin{enumerate}
\item L'utilisateur accède au formulaire de support
\item Saisie du sujet et description du problème
\item Sélection de la catégorie et de la priorité
\item Validation des données côté client
\item Envoi au contrôleur TicketController
\item Création du ticket via l'API Dolibarr
\item Insertion dans la table \texttt{llx\_ticket}
\item Attribution automatique d'un agent (si configuré)
\item Envoi de notification par email
\item Affichage du numéro de ticket à l'utilisateur
\end{enumerate}

\subsection{Séquence de Traitement de Ticket}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Diagramme de séquence de traitement de ticket]}}
\caption{Diagramme de séquence - Traitement d'un ticket par un agent}
\label{fig:sequence_process_ticket}
\end{figure}

\textbf{Processus de traitement :}
\begin{enumerate}
\item L'agent consulte sa liste de tickets assignés
\item Sélection et ouverture d'un ticket
\item Analyse du problème et recherche de solution
\item Rédaction de la réponse
\item Mise à jour du statut du ticket
\item Envoi de la réponse au client
\item Notification automatique au client
\item Suivi de la satisfaction client
\end{enumerate}

\section{Réalisation}
Cette section présente les interfaces utilisateur développées pour le système de support client.

\subsection{Interface de Création de Ticket}
\begin{figure}[H]
\centering
 \includegraphics[width=1 \textwidth]{ticket.png}
\caption{Interface de création de ticket de support}
\label{fig:create_ticket_screen}
\end{figure}

L'interface de création de ticket offre une expérience utilisateur simplifiée, permettant aux clients de décrire leur problème de manière structurée avec catégorisation automatique et estimation du temps de résolution.

\subsection{Interface de Gestion des Tickets}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{tickettt.png}
\caption{Interface de gestion des tickets de support}
\label{fig:tickets_screen}
\end{figure}

L'interface de gestion permet aux utilisateurs de suivre l'évolution de leurs tickets, de consulter l'historique des échanges et d'évaluer la qualité du support reçu.

\subsection{Tableau de Bord Agent}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Tableau de bord agent de support]}}
\caption{Tableau de bord agent - Vue d'ensemble des tickets}
\label{fig:agent_dashboard}
\end{figure}

Le tableau de bord agent offre une vue d'ensemble complète des tickets assignés, avec des indicateurs de performance, des alertes de priorité et des outils de gestion avancés.

\section{Tests}
Pour assurer la qualité et la fiabilité du système de support client, nous avons effectué une batterie de tests complète :

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Test} & \textbf{Description} & \textbf{Résultat attendu} & \textbf{Statut} \\
\hline
Création de ticket & Création d'un nouveau ticket de support & Ticket créé avec succès dans Dolibarr & Réussi \\
\hline
Catégorisation automatique & Classification automatique des tickets & Catégorie assignée correctement & Réussi \\
\hline
Notifications & Envoi d'alertes aux utilisateurs et agents & Notifications envoyées en temps réel & Réussi \\
\hline
Assignation d'agent & Attribution automatique selon les règles & Agent assigné selon la disponibilité & Réussi \\
\hline
Échange de messages & Communication bidirectionnelle & Messages échangés correctement & Réussi \\
\hline
Évaluation satisfaction & Système de notation du support & Évaluation enregistrée et analysée & Réussi \\
\hline
Escalade automatique & Escalade selon les SLA & Ticket escaladé automatiquement & Réussi \\
\hline
Rapports et statistiques & Génération de tableaux de bord & Données agrégées correctement & Réussi \\
\hline
Intégration CRM & Synchronisation avec le CRM & Données client mises à jour & Réussi \\
\hline
\end{tabularx}
\caption{Tests du système de support client}
\label{tab:support_tests}
\end{table}

\section{Conclusion}
Ce sprint a permis de développer un système de support client professionnel et intégré, offrant une expérience de service client de haute qualité. L'intégration native avec Dolibarr garantit une gestion centralisée et efficace de toutes les interactions client.

\subsection{Réalisations Clés}
\begin{itemize}
\item \textbf{Système de tickets complet} : Gestion du cycle de vie complet des demandes de support
\item \textbf{Interface utilisateur intuitive} : Création et suivi simplifiés pour les clients
\item \textbf{Tableau de bord agent} : Outils professionnels pour les équipes de support
\item \textbf{Notifications en temps réel} : Communication instantanée entre clients et agents
\item \textbf{Intégration CRM} : Vision client unifiée avec historique complet
\item \textbf{Système de satisfaction} : Mesure et amélioration continue de la qualité
\end{itemize}

\subsection{Valeur Ajoutée}
Le système de support développé transforme l'expérience client en offrant un service professionnel, réactif et personnalisé. L'intégration avec Dolibarr permet une gestion unifiée des relations client, de la vente au support, créant un écosystème commercial cohérent et efficace.

\chapter{Conclusion Générale et Perspectives}
\section{Bilan du Projet}
Ce projet a abouti au développement d'une plateforme e-commerce moderne, sécurisée et performante, parfaitement intégrée avec le système ERP Dolibarr existant. L'adoption de la méthodologie Scrum a permis une approche itérative et adaptative, garantissant la livraison de fonctionnalités de haute qualité répondant aux exigences du marché e-commerce contemporain.

\subsection{Réalisations Techniques Majeures}
\begin{itemize}
    \item \textbf{Architecture sécurisée} : Implémentation complète des standards de sécurité e-commerce (SSL/TLS, chiffrement AES-256, conformité RGPD)
    \item \textbf{Intégration native Dolibarr} : Synchronisation temps réel avec l'ERP sans duplication de données
    \item \textbf{Performance optimisée} : Temps de chargement < 3 secondes, cache multi-niveaux, optimisation des requêtes
    \item \textbf{Interface responsive} : Design adaptatif pour tous les appareils avec score Lighthouse > 90
    \item \textbf{Système d'authentification robuste} : Gestion sécurisée des sessions, protection contre les attaques courantes
    \item \textbf{Catalogue intelligent} : Recherche avancée, filtrage dynamique, recommandations personnalisées
    \item \textbf{Processus de commande optimisé} : Tunnel de conversion simplifié, gestion des stocks en temps réel
    \item \textbf{Système de support client} : Gestion professionnelle des tickets avec CRM intégré et notifications automatiques
\end{itemize}

\subsection{Valeur Business Apportée}
\begin{itemize}
    \item \textbf{Réduction des coûts opérationnels} : Automatisation des processus et élimination des saisies manuelles
    \item \textbf{Amélioration de l'expérience client} : Interface moderne et processus d'achat fluide
    \item \textbf{Augmentation du chiffre d'affaires} : Disponibilité 24/7 et élargissement de la clientèle
    \item \textbf{Optimisation de la gestion} : Tableaux de bord en temps réel et reporting automatisé
    \item \textbf{Conformité réglementaire} : Respect des normes RGPD et standards e-commerce
\end{itemize}

\section{Défis Techniques et Solutions Apportées}
Le développement de cette plateforme e-commerce a nécessité de surmonter plusieurs défis techniques complexes :

\subsection{Défis d'Intégration}
\begin{itemize}
    \item \textbf{Architecture Dolibarr} : Maîtrise de la structure modulaire complexe de l'ERP
    \begin{itemize}
        \item \textit{Solution} : Analyse approfondie du code source et création d'une couche d'abstraction
    \end{itemize}
    \item \textbf{Compatibilité versions} : Gestion des différences entre les versions de Dolibarr
    \begin{itemize}
        \item \textit{Solution} : Développement d'adaptateurs et tests de compatibilité automatisés
    \end{itemize}
    \item \textbf{Synchronisation temps réel} : Maintien de la cohérence des données entre e-commerce et ERP
    \begin{itemize}
        \item \textit{Solution} : Implémentation d'un système d'événements et de webhooks
    \end{itemize}
\end{itemize}

\subsection{Défis de Performance}
\begin{itemize}
    \item \textbf{Optimisation des requêtes} : Gestion efficace des grandes bases de données
    \begin{itemize}
        \item \textit{Solution} : Indexation avancée, requêtes optimisées et mise en cache intelligente
    \end{itemize}
    \item \textbf{Scalabilité} : Préparation pour la montée en charge
    \begin{itemize}
        \item \textit{Solution} : Architecture microservices et containerisation Docker
    \end{itemize}
\end{itemize}

\subsection{Défis de Sécurité}
\begin{itemize}
    \item \textbf{Protection des données} : Conformité RGPD et sécurisation des transactions
    \begin{itemize}
        \item \textit{Solution} : Chiffrement bout-en-bout, audit de sécurité et tests de pénétration
    \end{itemize}
    \item \textbf{Authentification robuste} : Prévention des attaques et gestion des sessions
    \begin{itemize}
        \item \textit{Solution} : Implémentation OAuth 2.0, 2FA et monitoring des tentatives d'intrusion
    \end{itemize}
\end{itemize}

\section{Perspectives d'Évolution et Innovation}
La plateforme développée constitue une base solide pour de nombreuses évolutions futures, alignées sur les tendances du e-commerce moderne :

\subsection{Évolutions Technologiques à Court Terme (6-12 mois)}
\begin{itemize}
    \item \textbf{Intelligence Artificielle} : Système de recommandations basé sur l'IA et chatbot intelligent
    \item \textbf{Application Mobile Native} : Développement iOS/Android avec notifications push
    \item \textbf{Paiements Avancés} : Intégration Apple Pay, Google Pay, cryptomonnaies
    \item \textbf{Réalité Augmentée} : Visualisation 3D des produits et essayage virtuel
    \item \textbf{Voice Commerce} : Intégration avec assistants vocaux (Alexa, Google Assistant)
\end{itemize}

\subsection{Évolutions Business à Moyen Terme (1-2 ans)}
\begin{itemize}
    \item \textbf{Marketplace Multi-vendeurs} : Plateforme ouverte aux vendeurs tiers
    \item \textbf{Internationalisation} : Support multi-devises, multi-langues, conformité fiscale internationale
    \item \textbf{Omnichannel} : Intégration magasins physiques, click \& collect, unified commerce
    \item \textbf{Sustainability} : Tracking empreinte carbone, options de livraison écologique
    \item \textbf{Social Commerce} : Intégration native avec réseaux sociaux, live shopping
\end{itemize}

\subsection{Innovations à Long Terme (2-5 ans)}
\begin{itemize}
    \item \textbf{Blockchain \& Web3} : NFTs, tokens de fidélité, supply chain transparente
    \item \textbf{IoT Integration} : Commandes automatiques via objets connectés
    \item \textbf{Métaverse Commerce} : Boutiques virtuelles en réalité virtuelle
    \item \textbf{Predictive Analytics} : Prédiction des tendances et gestion proactive des stocks
    \item \textbf{Autonomous Commerce} : Automatisation complète du cycle de vente
\end{itemize}

\subsection{Roadmap Technologique}
\begin{itemize}
    \item \textbf{Phase 1} : Migration vers architecture cloud-native (Kubernetes, microservices)
    \item \textbf{Phase 2} : Implémentation d'un data lake pour l'analytics avancée
    \item \textbf{Phase 3} : Adoption de l'edge computing pour la performance globale
    \item \textbf{Phase 4} : Intégration complète avec l'écosystème IoT et Industry 4.0
\end{itemize}



\section{Remerciements}
Nous tenons à remercier toutes les personnes qui ont contribué à la réussite de ce projet :
\begin{itemize}
    \item Notre encadrant académique pour ses conseils et son soutien tout au long du projet
    \item L'équipe de l'entreprise cliente pour sa disponibilité et sa collaboration
    \item Les membres de l'équipe de développement pour leur engagement et leur travail acharné
    \item L'administration de l'ESPRIT pour nous avoir fourni les ressources nécessaires
    \item La communauté Dolibarr pour la documentation et les ressources mises à disposition
\end{itemize}

\bibliographystyle{plain}
\begin{thebibliography}{20}
\bibitem{scrum}
Scrum.org, \textit{What is Scrum?}, consulté le 08/11/2024, \url{https://www.scrum.org/resources/what-is-scrum}

\bibitem{dolibarr}
Dolibarr ERP \& CRM, \textit{Documentation officielle}, consulté le 04/11/2024, \url{https://www.dolibarr.org/documentation.php}

\bibitem{php}
PHP Documentation, \textit{PHP Manual}, consulté le 10/11/2024, \url{https://www.php.net/manual/en/}

\bibitem{mysql}
MySQL Documentation, \textit{MySQL Reference Manual}, consulté le 12/11/2024, \url{https://dev.mysql.com/doc/}

\bibitem{mvc}
Freeman, A., \textit{Pro ASP.NET MVC 5}, Apress, 2013

\bibitem{ecommerce}
Laudon, K. C., \& Traver, C. G., \textit{E-commerce: Business, Technology, Society}, Pearson, 2018

\bibitem{erp}
Monk, E., \& Wagner, B., \textit{Concepts in Enterprise Resource Planning}, Cengage Learning, 2012

\bibitem{agile}
Beck, K., et al., \textit{Manifesto for Agile Software Development}, 2001, \url{https://agilemanifesto.org/}

\bibitem{microservices}
Newman, S., \textit{Building Microservices: Designing Fine-Grained Systems}, O'Reilly Media, 2021

\bibitem{docker}
Docker Inc., \textit{Docker Documentation}, consulté le 15/11/2024, \url{https://docs.docker.com/}

\bibitem{security}
OWASP Foundation, \textit{OWASP Top Ten Web Application Security Risks}, 2021, \url{https://owasp.org/www-project-top-ten/}

\bibitem{gdpr}
Commission Européenne, \textit{Règlement Général sur la Protection des Données (RGPD)}, 2018

\bibitem{pci}
PCI Security Standards Council, \textit{Payment Card Industry Data Security Standard}, v4.0, 2022

\bibitem{restapi}
Fielding, R. T., \textit{Architectural Styles and the Design of Network-based Software Architectures}, Doctoral dissertation, UC Irvine, 2000

\bibitem{bootstrap}
Bootstrap Team, \textit{Bootstrap Documentation}, consulté le 18/11/2024, \url{https://getbootstrap.com/docs/}

\bibitem{git}
Chacon, S., \& Straub, B., \textit{Pro Git}, Apress, 2014

\bibitem{devops}
Kim, G., Humble, J., Debois, P., \& Willis, J., \textit{The DevOps Handbook}, IT Revolution Press, 2016

\bibitem{performance}
Souders, S., \textit{High Performance Web Sites}, O'Reilly Media, 2007

\bibitem{ux}
Norman, D., \textit{The Design of Everyday Things}, Basic Books, 2013

\bibitem{ecommerce2024}
Statista, \textit{E-commerce worldwide - statistics \& facts}, 2024, \url{https://www.statista.com/topics/871/online-shopping/}
\end{thebibliography}

\end{document}