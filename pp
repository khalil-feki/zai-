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

% Define colors
\definecolor{primarycolor}{RGB}{0, 83, 156}
\definecolor{secondarycolor}{RGB}{0, 120, 174}

% Format chapter titles
\titleformat{\chapter}[display]
{\normalfont\huge\bfseries\color{primarycolor}}
{\chaptertitlename\ \thechapter}{20pt}{\Huge}
\titlespacing*{\chapter}{0pt}{0pt}{40pt}

% Format section titles
\titleformat{\section}
{\normalfont\Large\bfseries\color{secondarycolor}}
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

Je tiens tout d'abord à remercier mon encadrant, \textbf{Nom de l'Encadrant}, pour sa disponibilité, ses conseils précieux et son soutien tout au long de ce projet.

Je remercie également l'ensemble du corps professoral de l'École Supérieure Privée d'Ingénierie et de Technologies (ESPRIT) pour la qualité de l'enseignement dispensé durant ces années d'études.

Mes remerciements s'adressent aussi à l'entreprise qui m'a accueilli pour ce projet de fin d'études, pour m'avoir offert l'opportunité de travailler sur un projet aussi enrichissant et pour avoir mis à ma disposition tous les moyens nécessaires à sa réalisation.

Enfin, je tiens à exprimer ma profonde gratitude envers ma famille et mes amis pour leur soutien moral et leurs encouragements qui m'ont permis de mener à bien ce projet.
\cleardoublepage

% Abstract in French
\chapter*{Résumé}
\addcontentsline{toc}{chapter}{Résumé}

Ce projet de fin d'études porte sur la conception et le développement d'une plateforme e-commerce intégrée avec le système ERP Dolibarr. L'objectif principal est de créer une interface utilisateur moderne et responsive qui se connecte directement à la base de données Dolibarr existante, permettant ainsi une gestion unifiée des produits, des clients et des commandes.

La méthodologie Scrum a été adoptée pour ce projet, permettant une approche itérative et incrémentale du développement. Le système a été développé en utilisant PHP pour le backend, avec une architecture MVC, et HTML/CSS/JavaScript pour le frontend.

Les principales fonctionnalités développées comprennent l'authentification des utilisateurs, la gestion du catalogue de produits, le panier d'achat, le processus de commande et un système de tickets de support.

\textbf{Mots-clés:} E-commerce, Dolibarr, ERP, PHP, MVC, Scrum, Intégration de systèmes

\cleardoublepage

% Abstract in English
\chapter*{Abstract}
\addcontentsline{toc}{chapter}{Abstract}

This final year project focuses on the design and development of an e-commerce platform integrated with the Dolibarr ERP system. The main objective is to create a modern and responsive user interface that connects directly to the existing Dolibarr database, enabling unified management of products, customers, and orders.

The Scrum methodology was adopted for this project, allowing an iterative and incremental approach to development. The system was developed using PHP for the backend, with an MVC architecture, and HTML/CSS/JavaScript for the frontend.

The main features developed include user authentication, product catalog management, shopping cart, order processing, and a support ticket system.

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
Dans un monde de plus en plus numérisé, le commerce électronique connaît une croissance exponentielle avec un marché mondial estimé à plus de 5 000 milliards de dollars en 2024. Les entreprises cherchent constamment à améliorer leur présence en ligne et à optimiser leurs processus de vente pour rester compétitives dans cet environnement en constante évolution.

L'intégration d'une plateforme e-commerce avec un système ERP (Enterprise Resource Planning) existant représente un défi technique majeur mais offre des avantages considérables en termes d'efficacité opérationnelle, de réduction des coûts, et d'amélioration de l'expérience client. Cette intégration permet une gestion unifiée des stocks, des commandes, et des données clients, éliminant les silos informationnels et réduisant les erreurs humaines.

Ce projet s'inscrit dans ce contexte stratégique, visant à développer une solution e-commerce moderne et sécurisée qui s'intègre parfaitement avec le système ERP Dolibarr déjà utilisé par l'entreprise cliente. Dolibarr, étant un ERP open-source largement adopté par les PME, offre une base solide pour cette intégration. L'objectif est de créer une interface utilisateur intuitive, responsive et sécurisée qui se connecte directement à la base de données Dolibarr, évitant ainsi la duplication des données et assurant une cohérence en temps réel entre les différents systèmes.

\section{Problématique}
L'entreprise cliente utilise actuellement Dolibarr comme système ERP pour gérer son inventaire, ses clients et ses commandes. Cependant, elle fait face à plusieurs défis majeurs dans le contexte concurrentiel actuel du commerce électronique :

\subsection{Défis Techniques}
\begin{itemize}
    \item \textbf{Absence d'interface e-commerce moderne} : Pas de plateforme permettant aux clients de consulter le catalogue et passer des commandes en ligne 24/7
    \item \textbf{Intégration complexe} : Nécessité d'intégrer avec la structure de base de données Dolibarr existante sans compromettre l'intégrité des données
    \item \textbf{Synchronisation en temps réel} : Assurer la cohérence des stocks, prix et informations produits entre l'ERP et l'interface e-commerce
    \item \textbf{Performance et scalabilité} : Gérer un nombre croissant d'utilisateurs simultanés et de transactions
\end{itemize}

\subsection{Défis Sécuritaires}
\begin{itemize}
    \item \textbf{Protection des données personnelles} : Conformité RGPD et sécurisation des informations clients
    \item \textbf{Sécurité des transactions} : Implémentation de protocoles de paiement sécurisés
    \item \textbf{Authentification robuste} : Système de gestion des accès et prévention des fraudes
\end{itemize}

\subsection{Défis Business}
\begin{itemize}
    \item \textbf{Expérience utilisateur} : Création d'une interface intuitive et responsive sur tous les appareils
    \item \textbf{Compétitivité} : Intégration de fonctionnalités modernes (recherche avancée, recommandations, avis clients)
    \item \textbf{Maintenance et évolutivité} : Architecture permettant des mises à jour et extensions futures
\end{itemize}

\section{Objectifs du Projet}
Ce projet vise à développer une plateforme e-commerce complète et sécurisée, intégrée avec Dolibarr, qui répond aux standards modernes du commerce électronique :

\subsection{Objectifs Fonctionnels}
\begin{itemize}
    \item \textbf{Interface utilisateur moderne} : Développer une interface web responsive, intuitive et accessible, optimisée pour tous les appareils (desktop, tablette, mobile)
    \item \textbf{Catalogue produits avancé} : Système de navigation avec filtres, recherche intelligente, catégorisation et recommandations personnalisées
    \item \textbf{Gestion du panier et commandes} : Processus de commande fluide avec sauvegarde automatique, calcul des frais de livraison et gestion des promotions
    \item \textbf{Système de paiement sécurisé} : Intégration de passerelles de paiement multiples avec chiffrement SSL/TLS
    \item \textbf{Gestion des utilisateurs} : Authentification robuste, profils clients, historique des commandes et liste de souhaits
    \item \textbf{Support client intégré} : Système de tickets, chat en ligne et FAQ dynamique
\end{itemize}

\subsection{Objectifs Techniques}
\begin{itemize}
    \item \textbf{Intégration Dolibarr} : Connexion native avec la base de données Dolibarr sans duplication de données
    \item \textbf{Architecture MVC} : Structure modulaire et maintenable utilisant le pattern Model-View-Controller
    \item \textbf{Performance optimisée} : Mise en cache, optimisation des requêtes et temps de chargement < 3 secondes
    \item \textbf{Sécurité renforcée} : Conformité OWASP, protection contre les attaques courantes (XSS, CSRF, SQL Injection)
    \item \textbf{Monitoring et logs} : Système de surveillance des performances et traçabilité des actions
\end{itemize}

\subsection{Objectifs Méthodologiques}
\begin{itemize}
    \item \textbf{Développement Agile} : Application rigoureuse de la méthodologie Scrum avec sprints de 2 semaines
    \item \textbf{Tests automatisés} : Couverture de tests unitaires et d'intégration > 80\%
    \item \textbf{Documentation complète} : Guide d'installation, API documentation et manuel utilisateur
    \item \textbf{Déploiement automatisé} : Pipeline CI/CD avec Docker et scripts de déploiement
\end{itemize}

\section{Structure du Rapport}
Ce rapport est structuré en cinq chapitres:
\begin{itemize}
    \item \textbf{Chapitre 1: Introduction Générale} - Présente le contexte, la problématique et les objectifs du projet.
    \item \textbf{Chapitre 2: Cadre du Projet} - Décrit l'organisme d'accueil, la problématique détaillée, l'étude de l'existant et la méthodologie de travail adoptée.
    \item \textbf{Chapitre 3: Sprint 0 - Conception et Architecture} - Présente l'analyse des besoins, les diagrammes UML et la planification des sprints.
    \item \textbf{Chapitre 4: Sprint 1 - Gestion des Utilisateurs et Authentification} - Détaille le développement du module d'authentification et de gestion des utilisateurs.
    \item \textbf{Chapitre 5: Sprint 2 - Catalogue de Produits et Panier} - Décrit le développement du catalogue de produits et du panier d'achat.
    \item \textbf{Chapitre 6: Sprint 3 - Commandes et Support Client} - Présente le développement du module de commandes et du système de tickets de support.
    \item \textbf{Chapitre 7: Conclusion Générale et Perspectives} - Résume les réalisations et propose des perspectives d'évolution.
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
ESPRIT (École Supérieure Privée d'Ingénierie et de Technologies) est une institution d'enseignement supérieur reconnue pour son excellence académique et son approche pratique de l'enseignement de l'ingénierie et des technologies. Fondée en 2003, ESPRIT forme des ingénieurs dans divers domaines tels que l'informatique, les télécommunications, l'électromécanique et le génie civil.

L'école se distingue par son modèle pédagogique innovant, basé sur l'apprentissage par projets et la collaboration avec le monde professionnel. ESPRIT entretient des partenariats avec de nombreuses entreprises nationales et internationales, offrant ainsi à ses étudiants des opportunités de stages et de projets de fin d'études en adéquation avec les besoins du marché.

\section{Problématique et Solution Proposée}
\subsection{Problématique Détaillée}
L'entreprise cliente utilise Dolibarr comme système ERP pour gérer son inventaire, ses clients et ses commandes. Cependant, elle fait face à plusieurs défis:

\begin{itemize}
    \item Absence d'une interface e-commerce moderne pour ses clients
    \item Processus de commande manuel nécessitant l'intervention d'un commercial
    \item Difficulté à maintenir la cohérence des données entre différents systèmes
    \item Besoin d'une solution personnalisée adaptée à son modèle d'affaires spécifique
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
Après analyse des besoins et des solutions existantes, nous avons opté pour le développement d'une solution personnalisée qui:

\begin{itemize}
    \item Se connecte directement à la base de données Dolibarr existante
    \item Utilise une architecture MVC en PHP pour le backend
    \item Propose une interface utilisateur moderne et responsive
    \item Permet une personnalisation complète selon les besoins spécifiques du client
    \item Assure une cohérence des données entre l'interface e-commerce et l'ERP
\end{itemize}

Cette solution offre le meilleur équilibre entre intégration, flexibilité et personnalisation, malgré un coût de développement initial plus élevé.

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
Pour ce projet, nous avons choisi d'adopter la méthodologie Scrum, une approche agile qui permet un développement itératif et incrémental. Ce choix a été motivé par:

\begin{itemize}
    \item La nécessité d'adapter le développement aux besoins évolutifs du client
    \item L'importance de livrer rapidement des fonctionnalités utilisables
    \item Le besoin de flexibilité face aux changements de priorités
    \item La volonté d'impliquer le client tout au long du processus de développement
\end{itemize}

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici un diagramme du processus Scrum]}}
    \caption{Méthodologie Scrum appliquée au projet}
    \label{fig:scrum_methodology}
\end{figure}

\subsection{Organisation de l'Équipe Scrum}
Notre équipe Scrum est composée de:

\begin{itemize}
    \item \textbf{Product Owner}: Responsable de définir les fonctionnalités du produit et de prioriser le backlog
    \item \textbf{Scrum Master}: Facilitateur qui aide l'équipe à suivre les pratiques Scrum et à éliminer les obstacles
    \item \textbf{Équipe de développement}: Membres des groupes 4 et 6, chacun responsable d'un module CRUD spécifique
\end{itemize}

\section{Conclusion}
Ce chapitre a présenté le cadre général du projet, incluant l'organisme d'accueil, la problématique détaillée, l'étude des solutions existantes et la méthodologie de travail adoptée. La solution personnalisée proposée, développée selon la méthodologie Scrum, permettra de répondre aux besoins spécifiques du client tout en assurant une intégration optimale avec le système Dolibarr existant.

% Chapter 3
\chapter{Sprint 0: Conception et Architecture}
\section{Introduction}
Ce chapitre présente la phase initiale de conception et d'architecture du projet, incluant l'analyse des besoins, les diagrammes UML et la planification des sprints. Cette phase, appelée Sprint 0, est essentielle pour poser les bases solides du projet avant de commencer le développement proprement dit.

\section{Analyse des Besoins}
\subsection{Besoins Fonctionnels}
Les besoins fonctionnels identifiés pour la plateforme e-commerce sont:

\begin{itemize}
    \item \textbf{Gestion des utilisateurs}:
    \begin{itemize}
        \item Inscription et connexion des utilisateurs
        \item Gestion du profil utilisateur
        \item Récupération de mot de passe
    \end{itemize}
    
    \item \textbf{Gestion des produits}:
    \begin{itemize}
        \item Consultation du catalogue de produits
        \item Filtrage et recherche de produits
        \item Affichage des détails des produits
    \end{itemize}
    
    \item \textbf{Gestion du panier}:
    \begin{itemize}
        \item Ajout de produits au panier
        \item Modification des quantités
        \item Suppression de produits du panier
    \end{itemize}
    
    \item \textbf{Gestion des commandes}:
    \begin{itemize}
        \item Passage de commande
        \item Suivi de l'état des commandes
        \item Consultation de l'historique des commandes
    \end{itemize}
    
    \item \textbf{Support client}:
    \begin{itemize}
        \item Création de tickets de support
        \item Suivi des tickets
        \item Communication avec le service client
    \end{itemize}
\end{itemize}

\subsection{Besoins Non Fonctionnels}
Les besoins non fonctionnels identifiés sont:

\begin{itemize}
    \item \textbf{Performance}: Temps de réponse inférieur à 2 secondes pour les opérations courantes
    \item \textbf{Sécurité}: Protection des données utilisateurs et des transactions, authentification sécurisée
    \item \textbf{Disponibilité}: Système disponible 24/7 avec un taux de disponibilité de 99,9\%
    \item \textbf{Scalabilité}: Capacité à gérer un nombre croissant d'utilisateurs et de produits
    \item \textbf{Maintenabilité}: Code bien structuré et documenté pour faciliter la maintenance
    \item \textbf{Compatibilité}: Interface responsive fonctionnant sur différents appareils et navigateurs
\end{itemize}

\section{Diagrammes UML}
\subsection{Diagramme de Cas d'Utilisation}
Le diagramme de cas d'utilisation présente les interactions entre les acteurs et le système.

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de cas d'utilisation général]}}
    \caption{Diagramme de cas d'utilisation général}
    \label{fig:usecase_diagram}
\end{figure}

\subsection{Diagramme de Classes}
Le diagramme de classes présente la structure statique du système, montrant les classes, leurs attributs, leurs méthodes et les relations entre elles.

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de classes]}}
    \caption{Diagramme de classes du système}
    \label{fig:class_diagram}
\end{figure}

\subsection{Diagramme Entité-Relation}
Le diagramme entité-relation présente la structure de la base de données Dolibarr et les tables utilisées par notre application.

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme entité-relation]}}
    \caption{Diagramme entité-relation de la base de données}
    \label{fig:er_diagram}
\end{figure}

\section{Architecture Technique}
\subsection{Architecture Globale}
L'architecture globale du système est basée sur le modèle MVC (Modèle-Vue-Contrôleur), qui permet une séparation claire des responsabilités et facilite la maintenance du code.

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme d'architecture MVC]}}
    \caption{Architecture MVC du système}
    \label{fig:mvc_architecture}
\end{figure}

\subsubsection{Architecture Applicative}
\begin{itemize}
    \item \textbf{Pattern MVC} : Séparation claire entre Model (données), View (présentation) et Controller (logique)
    \item \textbf{API RESTful} : Interface standardisée pour la communication frontend-backend
    \item \textbf{Microservices légers} : Modules indépendants pour l'authentification, le catalogue, les commandes
    \item \textbf{Cache multi-niveaux} : Redis pour les sessions, Memcached pour les données fréquentes
\end{itemize}

\subsubsection{Stack Technologique}
\begin{itemize}
    \item \textbf{Backend} : PHP 8.1+ avec framework personnalisé, intégration native Dolibarr
    \item \textbf{Frontend} : HTML5, CSS3, JavaScript ES6+, Bootstrap 5 pour la responsivité
    \item \textbf{Base de données} : MySQL 8.0+ avec optimisations pour Dolibarr
    \item \textbf{Serveur web} : Apache 2.4+ avec mod\_rewrite et SSL/TLS
    \item \textbf{Outils de développement} : Git, Composer, NPM, Docker pour la containerisation
\end{itemize}

\subsection{Sécurité et Conformité}
\subsubsection{Sécurité des Données}
La protection des données constitue un enjeu majeur pour toute plateforme e-commerce. Notre solution implémente les mesures suivantes :

\paragraph{Chiffrement et Protection}
\begin{itemize}
    \item \textbf{Chiffrement en transit} : SSL/TLS 1.3 pour toutes les communications
    \item \textbf{Chiffrement au repos} : AES-256 pour les données sensibles en base
    \item \textbf{Hachage sécurisé} : Bcrypt avec salt pour les mots de passe
    \item \textbf{Tokenisation} : JWT avec rotation automatique pour l'authentification
\end{itemize}

\paragraph{Protection contre les Attaques}
\begin{itemize}
    \item \textbf{Injection SQL} : Requêtes préparées et validation stricte des entrées
    \item \textbf{XSS (Cross-Site Scripting)} : Échappement automatique et CSP (Content Security Policy)
    \item \textbf{CSRF (Cross-Site Request Forgery)} : Tokens CSRF sur tous les formulaires
    \item \textbf{Brute Force} : Limitation du taux de tentatives et CAPTCHA
    \item \textbf{DDoS} : Rate limiting et filtrage IP automatique
\end{itemize}

\subsubsection{Conformité Réglementaire}
\paragraph{RGPD (Règlement Général sur la Protection des Données)}
\begin{itemize}
    \item \textbf{Consentement explicite} : Gestion granulaire des préférences utilisateur
    \item \textbf{Droit à l'oubli} : Fonctionnalité de suppression complète des données
    \item \textbf{Portabilité} : Export des données personnelles au format JSON/XML
    \item \textbf{Audit trail} : Traçabilité complète des accès et modifications
\end{itemize}

\paragraph{Standards E-commerce}
\begin{itemize}
    \item \textbf{PCI DSS} : Conformité pour le traitement des données de cartes bancaires
    \item \textbf{ISO 27001} : Bonnes pratiques de sécurité de l'information
    \item \textbf{OWASP Top 10} : Protection contre les vulnérabilités web les plus critiques
\end{itemize}

\section{Performance et Optimisation}
\subsection{Stratégies de Performance}
Pour assurer une expérience utilisateur optimale, plusieurs stratégies d'optimisation sont mises en œuvre :

\subsubsection{Optimisation Frontend}
\begin{itemize}
    \item \textbf{Minification et compression} : CSS/JS minifiés, compression Gzip/Brotli
    \item \textbf{Lazy loading} : Chargement différé des images et contenus non critiques
    \item \textbf{CDN (Content Delivery Network)} : Distribution géographique des ressources statiques
    \item \textbf{Critical CSS} : CSS critique inline pour un rendu rapide
    \item \textbf{Service Workers} : Mise en cache intelligente côté client
\end{itemize}

\subsubsection{Optimisation Backend}
\begin{itemize}
    \item \textbf{Cache applicatif} : Redis pour les sessions, Memcached pour les données fréquentes
    \item \textbf{Optimisation des requêtes} : Index optimisés, requêtes préparées, pagination efficace
    \item \textbf{Pool de connexions} : Gestion optimisée des connexions base de données
    \item \textbf{Compression de réponse} : Compression automatique des réponses API
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

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme d'intégration avec Dolibarr]}}
    \caption{Intégration avec Dolibarr}
    \label{fig:dolibarr_integration}
\end{figure}

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
Le projet est divisé en 3 sprints de développement, précédés d'un Sprint 0 de conception.

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{N° Sprint} & \textbf{Nom Sprint} & \textbf{Durée} \\
\hline
0 & Conception et Architecture & 1 semaine \\
\hline
1 & Gestion des Utilisateurs et Authentification & 2 semaines \\
\hline
2 & Catalogue de Produits et Panier & 2 semaines \\
\hline
3 & Commandes et Support Client & 2 semaines \\
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
\subsection{Diagramme de Classes}
Le diagramme de classes ci-dessous illustre la structure des classes impliquées dans la gestion des utilisateurs et l'authentification, incluant l'intégration avec les modules Dolibarr correspondants.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de classes pour l'authentification]}}
\caption{Diagramme de classes - Module d'authentification}
\label{fig:auth_class_diagram}
\end{figure}

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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de cas d'utilisation pour l'authentification]}}
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

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le modèle de données pour les utilisateurs]}}
    \caption{Modèle de données - Utilisateurs}
    \label{fig:user_data_model}
\end{figure}

\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations d'authentification.

\subsection{Séquence d'Inscription}
\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence d'inscription]}}
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
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de connexion]}}
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
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de réinitialisation]}}
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
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de modification de profil]}}
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
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de l'interface d'inscription]}}
    \caption{Interface d'inscription}
    \label{fig:register_screen}
\end{figure}

\subsection{Interface de Connexion} 

\begin{figure}[H] 

\centering 

\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de l'interface de connexion]}} 

\caption{Interface de connexion} 

\label{fig:login_screen} 

\end{figure} 

\subsection{Interface de Profil Utilisateur} 

\begin{figure}[H]
    \centering
    \fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de l'interface de profil utilisateur]}}
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
\subsection{Diagramme de Classes}
Le diagramme de classes ci-dessous illustre la structure des classes impliquées dans la gestion du catalogue de produits et du panier, incluant l'intégration avec les modules Dolibarr correspondants.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de classes pour les produits et le panier]}}
\caption{Diagramme de classes - Module produits et panier}
\label{fig:products_class_diagram}
\end{figure}

\textbf{Classes principales :}
\begin{itemize}
\item \textbf{Product} : Gestion des produits avec intégration Dolibarr
\item \textbf{Category} : Gestion des catégories de produits
\item \textbf{Cart} : Gestion du panier d'achat
\item \textbf{CartItem} : Éléments du panier
\item \textbf{ProductController} : Contrôleur des produits
\item \textbf{CartController} : Contrôleur du panier
\item \textbf{DolibarrProductService} : Service d'intégration produits Dolibarr
\item \textbf{SearchService} : Service de recherche de produits
\end{itemize}

\subsection{Use Case Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des produits et du panier.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de cas d'utilisation pour les produits et le panier]}}
\caption{Diagramme de cas d'utilisation - Produits et panier}
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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence d'affichage des produits]}}
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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de recherche]}}
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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence d'ajout au panier]}}
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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de gestion du panier]}}
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
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran du panier d'achat]}}
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

\chapter{Sprint 3: Commandes et Support Client}
\section{Introduction}
Ce chapitre présente le troisième sprint de développement, focalisé sur la gestion des commandes et le système de tickets de support. Ces fonctionnalités sont essentielles pour permettre aux utilisateurs de finaliser leurs achats et de communiquer avec le service client en cas de besoin.

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
En tant qu'utilisateur, je veux créer un ticket de support & Moyenne & 8 \\
\hline
En tant qu'utilisateur, je veux consulter mes tickets de support & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux répondre à un ticket de support & Facile & 4 \\
\hline
\end{tabularx}
\caption{Backlog du Sprint 3}
\label{tab:backlog_sprint3}
\end{table}

\section{Conception}
\subsection{Diagramme de Classes}
Le diagramme de classes ci-dessous illustre la structure des classes impliquées dans la gestion des commandes et des tickets de support, incluant l'intégration avec les modules Dolibarr correspondants.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de classes pour les commandes et tickets]}}
\caption{Diagramme de classes - Module de commandes et support}
\label{fig:orders_class_diagram}
\end{figure}

\textbf{Classes principales :}
\begin{itemize}
\item \textbf{Order} : Gestion des commandes avec intégration Dolibarr
\item \textbf{OrderItem} : Éléments de commande liés aux produits
\item \textbf{Payment} : Gestion des paiements et méthodes
\item \textbf{Ticket} : Système de tickets de support
\item \textbf{TicketMessage} : Messages et réponses des tickets
\item \textbf{DolibarrOrderService} : Service d'intégration commandes Dolibarr
\item \textbf{DolibarrTicketService} : Service d'intégration tickets Dolibarr
\end{itemize}

\subsection{Use Case Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des commandes et des tickets de support.

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de cas d'utilisation pour les commandes et tickets]}}
\caption{Diagramme de cas d'utilisation - Commandes et support}
\label{fig:usecase_orders}
\end{figure}

\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Finaliser une commande
\item Choisir une méthode de paiement
\item Consulter l'historique des commandes
\item Voir les détails d'une commande
\item Créer un ticket de support
\item Consulter les tickets de support
\item Répondre à un ticket de support
\item Suivre le statut d'une commande
\end{itemize}

\section{Intégration Dolibarr}
\subsection{Modules Dolibarr Utilisés}
Ce sprint utilise intensivement plusieurs modules Dolibarr pour la gestion des commandes et du support :

\subsubsection{Module Commandes (Orders)}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_commande}, \texttt{llx\_commandedet}, \texttt{llx\_commande\_extrafields}
\item \textbf{Fonctionnalités} : Création, validation, suivi des commandes
\item \textbf{Graphiques disponibles} : Évolution du chiffre d'affaires, répartition par statut, top produits vendus
\item \textbf{API utilisée} : \texttt{/orders} pour CRUD des commandes
\end{itemize}

\subsubsection{Module Tickets}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_ticket}, \texttt{llx\_ticket\_extrafields}
\item \textbf{Fonctionnalités} : Gestion des demandes de support, suivi des tickets
\item \textbf{Graphiques disponibles} : Tickets par statut, temps de résolution moyen, satisfaction client
\item \textbf{API utilisée} : \texttt{/tickets} pour la gestion des tickets
\end{itemize}

\subsubsection{Module Paiements}
\begin{itemize}
\item \textbf{Tables utilisées} : \texttt{llx\_paiement}, \texttt{llx\_paiement\_commande}
\item \textbf{Fonctionnalités} : Enregistrement et suivi des paiements
\item \textbf{Graphiques disponibles} : Répartition par mode de paiement, évolution des encaissements
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Commandes}
L'interface Dolibarr pour les commandes offre :
\begin{itemize}
\item \textbf{Dashboard commandes} : Vue d'ensemble avec graphiques de performance
\item \textbf{Liste des commandes} : Filtrage par statut, client, période
\item \textbf{Fiche commande} : Détails complets avec historique des modifications
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Évolution mensuelle du CA
  \item Répartition des commandes par statut
  \item Top 10 des produits les plus vendus
  \item Analyse des délais de livraison
  \end{itemize}
\end{itemize}

\subsection{Interface Dolibarr - Gestion des Tickets}
L'interface Dolibarr pour les tickets propose :
\begin{itemize}
\item \textbf{Dashboard support} : Métriques de performance du support
\item \textbf{Liste des tickets} : Vue organisée par priorité et statut
\item \textbf{Fiche ticket} : Historique complet des échanges
\item \textbf{Graphiques intégrés} :
  \begin{itemize}
  \item Répartition des tickets par catégorie
  \item Temps de résolution moyen
  \item Taux de satisfaction client
  \item Charge de travail par agent
  \end{itemize}
\end{itemize}

\section{Base de Données}
\subsection{Tables Principales Utilisées}

\subsubsection{Tables Commandes}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_commande} & Commandes principales & \texttt{rowid}, \texttt{fk\_soc}, \texttt{total\_ht}, \texttt{fk\_statut} \\
\hline
\texttt{llx\_commandedet} & Lignes de commande & \texttt{fk\_commande}, \texttt{fk\_product}, \texttt{qty}, \texttt{subprice} \\
\hline
\texttt{llx\_commande\_extrafields} & Champs personnalisés & \texttt{fk\_object}, \texttt{delivery\_method}, \texttt{special\_instructions} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Commandes}
\end{table}

\subsubsection{Tables Support}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_ticket} & Tickets de support & \texttt{rowid}, \texttt{fk\_user\_create}, \texttt{subject}, \texttt{fk\_statut} \\
\hline
\texttt{llx\_ticket\_extrafields} & Champs personnalisés tickets & \texttt{fk\_object}, \texttt{priority}, \texttt{category} \\
\hline
\texttt{llx\_actioncomm} & Historique des actions & \texttt{fk\_element}, \texttt{elementtype}, \texttt{note} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Support}
\end{table}

\subsubsection{Tables Paiements}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{Table} & \textbf{Description} & \textbf{Champs Clés} \\
\hline
\texttt{llx\_paiement} & Paiements & \texttt{rowid}, \texttt{datep}, \texttt{amount}, \texttt{fk\_paiement} \\
\hline
\texttt{llx\_paiement\_commande} & Liaison paiement-commande & \texttt{fk\_paiement}, \texttt{fk\_commande}, \texttt{amount} \\
\hline
\texttt{llx\_c\_paiement} & Types de paiement & \texttt{id}, \texttt{code}, \texttt{libelle} \\
\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Paiements}
\end{table}

\section{Implémentation}
\subsection{Modèle de Commande}
Le modèle de commande permet de créer et de gérer les commandes dans la base de données Dolibarr. Il assure la conversion du panier en commande et la gestion des statuts de commande.

\textbf{Fonctionnalités principales :}
\begin{itemize}
\item Création de commande via API Dolibarr
\item Synchronisation des statuts
\item Gestion des lignes de commande
\item Calcul automatique des totaux
\item Intégration avec le module de paiement
\end{itemize}

\subsection{Contrôleur de Commande}
Le contrôleur de commande gère les requêtes liées à la création et à la consultation des commandes. Il interagit avec le modèle de commande pour effectuer les opérations nécessaires et transmet les données aux vues appropriées.

\subsection{Modèle de Ticket}
Le modèle de ticket permet de créer et de gérer les tickets de support dans la base de données Dolibarr. Il assure la création, la mise à jour et la consultation des tickets.

\textbf{Fonctionnalités principales :}
\begin{itemize}
\item Création de tickets via API Dolibarr
\item Gestion des priorités et catégories
\item Suivi des échanges et réponses
\item Notifications automatiques
\item Intégration avec le CRM Dolibarr
\end{itemize}

\subsection{Contrôleur de Ticket}
Le contrôleur de ticket traite les requêtes liées à la gestion des tickets de support. Il permet aux utilisateurs de créer des tickets, de consulter leur historique et d'y répondre.

\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations liées aux commandes et aux tickets de support.

\subsection{Séquence de Création de Commande}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de création de commande]}}
\caption{Diagramme de séquence - Création d'une commande}
\label{fig:sequence_create_order}
\end{figure}

\textbf{Étapes de la séquence :}
\begin{enumerate}
\item L'utilisateur valide son panier
\item Le contrôleur OrderController traite la demande
\item Validation des données et vérification du stock
\item Appel à l'API Dolibarr pour créer la commande
\item Insertion dans les tables \texttt{llx\_commande} et \texttt{llx\_commandedet}
\item Génération du numéro de commande
\item Redirection vers la page de paiement
\item Confirmation et notification à l'utilisateur
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
\item Appel au service de paiement externe (si applicable)
\item Enregistrement du paiement dans Dolibarr
\item Mise à jour du statut de la commande
\item Génération de la facture
\item Envoi de la confirmation par email
\end{enumerate}

\subsection{Séquence de Création de Ticket}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de création de ticket]}}
\caption{Diagramme de séquence - Création d'un ticket de support}
\label{fig:sequence_create_ticket}
\end{figure}

\textbf{Étapes de création de ticket :}
\begin{enumerate}
\item L'utilisateur accède au formulaire de support
\item Saisie du sujet et description du problème
\item Validation des données côté client
\item Envoi au contrôleur TicketController
\item Création du ticket via l'API Dolibarr
\item Insertion dans la table \texttt{llx\_ticket}
\item Attribution automatique d'un agent (si configuré)
\item Envoi de notification par email
\item Affichage du numéro de ticket à l'utilisateur
\end{enumerate}

\subsection{Séquence de Suivi de Commande}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici le diagramme de séquence de suivi de commande]}}
\caption{Diagramme de séquence - Suivi d'une commande}
\label{fig:sequence_order_tracking}
\end{figure}

\textbf{Fonctionnalités de suivi :}
\begin{itemize}
\item Consultation du statut en temps réel
\item Historique des modifications
\item Notifications automatiques des changements d'état
\item Intégration avec les transporteurs (si applicable)
\item Estimation des délais de livraison
\end{itemize}

\section{Réalisation}
Cette section présente les captures d'écran des interfaces utilisateur développées pour la gestion des commandes et des tickets de support.

\subsection{Interface de Commande}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran du processus de commande]}}
\caption{Interface de commande}
\label{fig:checkout_screen}
\end{figure}

\subsection{Interface d'Historique des Commandes}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de l'historique des commandes]}}
\caption{Interface d'historique des commandes}
\label{fig:order_history_screen}
\end{figure}

\subsection{Interface de Création de Ticket}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de création de ticket]}}
\caption{Interface de création de ticket de support}
\label{fig:create_ticket_screen}
\end{figure}

\subsection{Interface de Gestion des Tickets}
\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici une capture d'écran de gestion des tickets]}}
\caption{Interface de gestion des tickets de support}
\label{fig:tickets_screen}
\end{figure}

\section{Tests}
Pour assurer la qualité et la fiabilité du module de commandes et de support, nous avons effectué les tests suivants :

\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{Test} & \textbf{Description} & \textbf{Résultat attendu} & \textbf{Statut} \\
\hline
Création de commande & Finalisation d'une commande à partir du panier & Commande créée avec succès & Réussi \\
\hline
Choix de paiement & Sélection d'une méthode de paiement & Méthode enregistrée correctement & Réussi \\
\hline
Historique des commandes & Consultation de l'historique des commandes & Liste des commandes affichée & Réussi \\
\hline
Détails de commande & Consultation des détails d'une commande & Détails affichés correctement & Réussi \\
\hline
Création de ticket & Création d'un nouveau ticket de support & Ticket créé avec succès & Réussi \\
\hline
Liste des tickets & Consultation de la liste des tickets & Liste affichée correctement & Réussi \\
\hline
Réponse à un ticket & Ajout d'une réponse à un ticket existant & Réponse ajoutée avec succès & Réussi \\
\hline
\end{tabularx}
\caption{Tests du module de commandes et support}
\label{tab:orders_support_tests}
\end{table}

\section{Conclusion}
Ce sprint a permis de mettre en place le système de gestion des commandes et des tickets de support, en s'intégrant avec la base de données Dolibarr existante. Les utilisateurs peuvent désormais finaliser leurs achats, consulter l'historique de leurs commandes, et communiquer avec le service client via le système de tickets.

L'intégration avec Dolibarr a été réalisée en utilisant les tables existantes (h8pd\_commande, h8pd\_commande\_det, h8pd\_ticket et h8pd\_ticket\_msg), assurant ainsi une cohérence des données entre l'ERP et la plateforme e-commerce.

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
    \item \textbf{Support client intégré} : Système de tickets avec traçabilité complète et notifications automatiques
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

\begin{figure}[H]
\centering
\fbox{\parbox{0.8\textwidth}{\centering\Large [PLACEHOLDER: Insérer ici un diagramme des évolutions futures]}}
\caption{Perspectives d'évolution du projet}
\label{fig:future_perspectives}
\end{figure}

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