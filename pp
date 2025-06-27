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
\usepackage[french]{babel}
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






\begin{document}

% Front cover
\includegraphics[width=0.95 \textwidth]{11.png}

% Dedication page
\includegraphics[width=1.15 \textwidth]{22.png}

\thispagestyle{empty}
\vspace*{5cm}
\
\chapter*{Dédicaces}


Avant toute chose, je rends grâce à Dieu, le Tout-Puissant, pour m’avoir accordé la force, la patience et le courage nécessaires pour mener ce projet à bien. Sa bienveillance m’a accompagné tout au long de ce parcours, même dans les moments les plus difficiles.

Je dédie ce travail à ma famille, pilier fondamental de mon équilibre et de ma motivation. À mes parents, dont l’amour inconditionnel, le soutien sans relâche et les encouragements constants m’ont porté chaque jour. Merci pour votre confiance, votre patience et pour avoir toujours cru en moi, même lorsque moi-même j’en doutais. Vous êtes ma source première de force et d’inspiration.

À mes frères et sœurs, merci pour votre affection, votre complicité et votre présence rassurante. Votre soutien, parfois discret mais toujours sincère, m’a été précieux tout au long de cette aventure. Vous avez su m’apporter du réconfort et de la légèreté dans les moments les plus intenses.

Je souhaite également dédier ce travail à toutes les personnes qui ont été présentes à mes côtés, que ce soit par un mot d’encouragement, un geste d’aide ou simplement par leur écoute. Leur bienveillance, leur patience et leur confiance ont été des sources de motivation inestimables. À mes amis, mes collègues et toutes celles et ceux qui, de près ou de loin, ont contribué à rendre cette expérience plus humaine, plus riche et plus belle : ce projet vous est aussi dédié.

% Acknowledgments
\chapter*{Remerciements}


Au terme de mon projet de fin d'études, je souhaite exprimer ma profonde reconnaissance à toutes les personnes qui ont, d’une manière ou d’une autre, contribué à la réalisation de ce travail. Ce projet n’aurait pu aboutir sans l’encadrement, le soutien et les encouragements que j’ai reçus tout au long de cette période. Je remercie tout particulièrement mon encadrante académique pour la qualité de son accompagnement, sa disponibilité constante, ainsi que la pertinence de ses remarques et conseils, qui m’ont permis de progresser et de mieux structurer ma réflexion.

Je tiens également à exprimer ma gratitude envers l’équipe encadrante au sein de l’entreprise, pour leur accueil, leur patience et leur soutien tout au long de mon stage. Leur encadrement professionnel, leur écoute attentive et les échanges constructifs que nous avons partagés m’ont beaucoup apporté, tant sur le plan technique que sur le plan humain.

Enfin, je remercie sincèrement les membres du jury pour l’intérêt qu’ils portent à mon travail. Leur implication et le temps qu’ils consacrent à son évaluation sont pour moi une réelle marque de considération, que j’apprécie vivement. À toutes les personnes qui m’ont accompagné de près ou de loin dans cette aventure, je tiens à adresser mes remerciements les plus sincères.
\cleardoublepage



% Table des matières
\tableofcontents
\cleardoublepage

% Liste des figures
\listoffigures
\cleardoublepage

% Liste des tableaux 
\listoftables
\cleardoublepage
\section*{Introduction Générale}
Aujourd'hui, on vit vraiment dans un monde où tout devient numérique, et 

franchement, le commerce électronique explose littéralement ! Le marché mondial 

dépasse maintenant les 5 000 milliards de dollars en 2025 - c'est énorme quand on y 

pense. Toutes les entreprises, petites ou grandes, se battent pour améliorer leur 

présence en ligne et optimiser leurs processus de vente. C'est devenu vital pour 

survivre dans cet environnement ultra-compétitif qui évolue à une vitesse folle.

Bon, intégrer une plateforme e-commerce avec un système ERP existant, c'est pas de la tarte ! C'est un vrai défi technique, mais les bénéfices en valent vraiment la peine : efficacité opérationnelle améliorée, coûts réduits, et surtout une bien meilleure expérience pour les clients. Cette intégration permet une gestion unifiée des stocks, des commandes, et des données clients, éliminant les silos informationnels et réduisant les erreurs humaines.

C'est exactement dans cette optique que notre projet prend tout son sens. On vise à créer une solution e-commerce vraiment moderne et sécurisée qui s'intègre de manière fluide avec Dolibarr - l'ERP que notre client utilise déjà. Dolibarr, étant un ERP open-source largement adopté par les PME, offre une base solide pour cette intégration. L'objectif est de créer une interface utilisateur intuitive, responsive et sécurisée qui se connecte directement à la base de données Dolibarr, évitant ainsi la duplication des données et assurant une cohérence en temps réel entre les différents systèmes.
% Chapitre 1 : Présentation du cadre de projet
\chapter{Présentation du cadre de projet}

\section{Introduction}
Ce chapitre présente mon stage au sein de ZAI, spécialiste des solutions retail en Tunisie. Nous analyserons d'abord son écosystème (1 000+ clients, et ses innovations (systèmes de caisse, outils e-commerce). Puis nous détaillerons la méthodologie appliquée dans le développement de ses solutions pour environnements commerciaux complexes, au sein d'une équipe de 15 experts.

\section{Problématique}
Alors, voici la situation : notre client utilise déjà Dolibarr pour gérer tout son business - inventaire, clients, commandes, etc. Mais il y a un hic... En fait, plusieurs défis de taille dans le monde ultra-compétitif du e-commerce d'aujourd'hui :



\section{Objectifs du Projet}
Bon, concrètement, qu'est-ce qu'on veut faire avec ce projet ? On vise à développer une plateforme e-commerce complète et vraiment sécurisée, parfaitement intégrée avec Dolibarr, et qui respecte tous les standards modernes du e-commerce :



\section{Présentation de l'Organisme d'Accueil}
ZAI, fondée en 2002 en tant que spécialiste tunisien des technologies pour le commerce de détail, s'est imposée comme leader du marché des solutions de gestion commerciale et de points de vente, servant plus de 1 000 clients à travers l'Afrique du Nord avec près de 500 systèmes installés. La société maintient un taux de croissance annuel de 30 pour cent  grâce à ses solutions innovantes et sur mesure pour divers secteurs du commerce, notamment la mode, la restauration, les pressing et la distribution en gros, proposant des systèmes de gestion adaptés aux commerces indépendants comme aux enseignes multi-sites. Avec 15 techniciens qualifiés et 10 revendeurs agréés en Tunisie, Algérie, Maroc et Libye, ZAI fournit des systèmes de caisse intelligents, des solutions pour environnements commerciaux à fort trafic et des plateformes e-commerce intégrées, ayant déployé plus de 1 000 terminaux POS et 100 systèmes antivol adaptés à plus de 40 types d'activités. La société garantit une innovation continue grâce à des partenariats techniques européens et maintient la satisfaction client via un support technique dédié et des réseaux de service localisés, tout en préparant une expansion régionale accrue avec ses technologies éprouvées de gestion commerciale. 

\begin{figure}[H]
\centering
\includegraphics {logo.jpeg}
\caption{zai}
\label{fig:zai}
\end{figure}

\section{Problématique et Solution Proposée}
\subsection{Problématique Détaillée}
Alors, notre client utilise déjà Dolibarr pour gérer tout son business - inventaire, clients, commandes, etc. Mais voilà le problème : ils galèrent avec plusieurs trucs :

\begin{itemize}
    \item Pas d'interface e-commerce moderne pour leurs clients - c'est un gros manque en 2025 !
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

{
\centering
\includegraphics[width=0.4\textwidth]{SOLU.JPEG}
\par
}

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
     \includegraphics[width=1 \textwidth]{Scrum.jpg}
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

% Chapter 2
\chapter{Sprint 0: Analyse Et spécifications des besoins}
\section{Introduction}
C'est la phase où on pose vraiment les bases de tout le projet. Dans ce chapitre, on va vous présenter toute la conception et l'architecture : analyse des besoins, diagrammes UML, planification des sprints... bref, tout ce qu'il faut pour avoir des fondations solides avant de se lancer dans le développement. C'est peut-être pas la partie la plus fun, mais c'est absolument essentiel !

\section{Analyse des Besoins}
\subsection{Besoins Fonctionnels}
Les besoins fonctionnels sont un concept clé de la gestion de projet et dudéveloppement de logiciels. Il désigne les fonctionnalités ou les aspects qu'un systèmedoitprésenter afin de répondre aux besoins et aux exigences des utilisateurs.
\begin{itemize}
    \item \textbf{Gestion des utilisateurs}  :
    \begin{itemize}
        \item Inscription et connexion des utilisateurs 
        \item Gestion du profil utilisateur 
        \item Récupération de mot de passe 
    \end{itemize}
    
    \item \textbf{Gestion des produits}  :
    \begin{itemize}
        \item Consultation du catalogue de produits 
        \item Filtrage et recherche de produits 
        \item Affichage des détails des produits 
    \end{itemize}
    
    \item \textbf{Gestion du panier}  :
    \begin{itemize}
        \item Ajout de produits au panier 
        \item Modification des quantités 
        \item Suppression de produits du panier 
    \end{itemize}
    
    \item \textbf{Gestion des commandes}  :
    \begin{itemize}
        \item Passage de commande 
        \item Suivi de l'état des commandes 
        \item Consultation de l'historique des commandes 
    \end{itemize}
    
    \item \textbf{Support client}  :
    \begin{itemize}
        \item Création de tickets de support 
        \item Suivi des tickets 
        
    \end{itemize}
\end{itemize}

\subsection{Besoins Non Fonctionnels}
Les besoins non fonctionnels sont des indications de qualité pour les exigencesfonctionnelles. Elles servent de complément aux besoins fonctionnels  :

\begin{itemize}
    \item \textbf{Performance}: Temps de réponse inférieur à 2 secondes pour les opérations courantes 
    \item \textbf{Sécurité}: Protection blindée des données utilisateurs et des transactions, authentification sécurisée 
    \item \textbf{Disponibilité}: Système disponible 24/7 avec un taux de disponibilité de 99,9\% 
    \item \textbf{Scalabilité}: Capacité à gérer un nombre croissant d'utilisateurs et de produits 
    \item \textbf{Maintenabilité}: Code bien structuré et documenté pour faciliter la maintenance 
    \item \textbf{Compatibilité}: Interface responsive qui marche sur tous les appareils et navigateurs 
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
    \includegraphics[width=1.1\textwidth]{class_diagram.png}
    \caption{Diagramme de classes du système}
    
    \label{fig:class_diagram}
\end{figure}



\section{Architecture Technique}
\subsection{Architecture Globale}
Pour l'architecture globale, on a opté pour le modèle MVC (Modèle-Vue-Contrôleur) - un grand classique qui a fait ses preuves ! Ça nous permet d'avoir une séparation claire des responsabilités et ça facilite vraiment la maintenance du code. C'est propre, c'est organisé, c'est exactement ce qu'il nous faut.



\begin{figure}[H]
    
    {
\centering
\includegraphics[width=0.5\textwidth]{java-mvc-project.jpeg}
\par
}
    \caption{Architecture MVC}
    \label{fig:mvc}
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





\subsection{Intégration avec Dolibarr}
L'intégration avec Dolibarr constitue le cœur de notre solution, assurant une synchronisation parfaite des données :

\subsubsection{Architecture d'Intégration}
\begin{itemize}
    \item \textbf{Connexion directe} : Accès natif à la base de données Dolibarr
    \item \textbf{Couche d'abstraction} : ORM personnalisé pour les entités Dolibarr
    \item \textbf{Synchronisation temps réel} : Triggers et événements pour la cohérence des données
    \item \textbf{Cache intelligent} : Mise en cache des données Dolibarr fréquemment consultées
\end{itemize}






\section{Backlog de Produit}
Le backlog de produit contient toutes les fonctionnalités à développer, organisées par sprints avec leur priorité et estimation en story points.

\begin{table}[H]
\centering
\resizebox{\textwidth}{!}{ % This ensures the table fits the page width
\begin{tabular}{|l|l|p{7cm}|l|}
\hline
\textbf{Sprint ID} & \textbf{Priorité} & \textbf{User Story} & \textbf{Estimation} \\ \hline

\multicolumn{4}{|c|}{\textbf{Épique 1: Gestion des Utilisateurs}} \\ \hline
1.1 & Élevé & En tant que visiteur, je veux m'inscrire avec email/mot de passe & 5 \\ \hline
1.2 & Élevé & En tant qu'utilisateur, je veux me connecter de manière sécurisée & 3 \\ \hline
1.3 & Élevé & En tant qu'utilisateur, je veux réinitialiser mon mot de passe & 3 \\ \hline
1.4 & Moyenne & En tant qu'utilisateur, je veux modifier mon profil & 5 \\ \hline
1.5 & Moyenne & En tant qu'utilisateur, je veux activer l'authentification à deux facteurs & 8 \\ \hline
1.6 & Faible & En tant qu'utilisateur, je veux me connecter via OAuth (Google, Facebook) & 13 \\ \hline

\multicolumn{4}{|c|}{\textbf{Épique 2: Catalogue et Recherche}} \\ \hline
2.1 & Élevé & En tant qu'utilisateur, je veux consulter le catalogue de produits & 8 \\ \hline
2.2 & Élevé & En tant qu'utilisateur, je veux voir les détails d'un produit & 5 \\ \hline
2.3 & Élevé & En tant qu'utilisateur, je veux filtrer les produits par catégorie & 8 \\ \hline
2.4 & Élevé & En tant qu'utilisateur, je veux rechercher des produits par nom/description & 13 \\ \hline
2.5 & Moyenne & En tant qu'utilisateur, je veux trier les produits (prix, popularité, nouveauté) & 5 \\ \hline
2.6 & Moyenne & En tant qu'utilisateur, je veux voir les produits recommandés & 21 \\ \hline
2.7 & Faible & En tant qu'utilisateur, je veux consulter les avis et notes des produits & 13 \\ \hline
2.8 & Faible & En tant qu'utilisateur, je veux comparer plusieurs produits & 8 \\ \hline

\multicolumn{4}{|c|}{\textbf{Épique 3: Panier et Commandes}} \\ \hline
3.1 & Élevé & En tant qu'utilisateur, je veux ajouter des produits à mon panier & 8 \\ \hline
3.2 & Élevé & En tant qu'utilisateur, je veux modifier les quantités dans mon panier & 5 \\ \hline
3.3 & Élevé & En tant qu'utilisateur, je veux passer une commande & 13 \\ \hline
3.4 & Élevé & En tant qu'utilisateur, je veux choisir une adresse de livraison & 8 \\ \hline
3.5 & Élevé & En tant qu'utilisateur, je veux sélectionner un mode de paiement & 13 \\ \hline
3.6 & Moyenne & En tant qu'utilisateur, je veux consulter l'historique de mes commandes & 8 \\ \hline
3.7 & Moyenne & En tant qu'utilisateur, je veux suivre le statut de ma commande & 13 \\ \hline
3.8 & Moyenne & En tant qu'utilisateur, je veux sauvegarder mon panier entre les sessions & 8 \\ \hline
3.9 & Faible & En tant qu'utilisateur, je veux appliquer des codes promo & 13 \\ \hline
\multicolumn{4}{|c|}{\textbf{Épique 4: Support Client}} \\ \hline
4.1 & Moyenne & En tant qu'utilisateur, je veux créer un ticket de support & 8 \\ \hline
4.2 & Moyenne & En tant qu'utilisateur, je veux consulter mes tickets de support & 5 \\ \hline
4.3 & Moyenne & En tant qu'utilisateur, je veux recevoir des notifications par email & 8 \\ \hline
4.4 & Faible & En tant qu'utilisateur, je veux accéder à une FAQ dynamique & 13 \\ \hline
4.5 & Faible & En tant qu'utilisateur, je veux utiliser un chat en ligne & 21 \\ \hline
\end{tabular}
}
\caption{Product Backlog consolidé}
\label{tab:backlog}
\end{table}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|}
\hline
\textbf{N° Sprint} & \textbf{Nom Sprint} & \textbf{Durée} \\
\hline
0 & Conception et Architecture & 3 semaine \\
\hline
1 & Gestion des Utilisateurs et Authentification & 3 semaines \\
\hline
2 & Catalogue de Produits et Panier & 3 semaines \\
\hline
3 & Gestion des Commandes & 3 semaines \\
\hline
4 & Système de Support Client & 3 semaines \\
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

% Chapter 3
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



\subsection{Modèle de Données}
Le modèle de données pour les utilisateurs utilise les tables existantes de Dolibarr:
\begin{itemize}
    \item \textbf{llx\_societe}: Stocke les informations de base des utilisateurs
    \item \textbf{llx\_societe\_extrafields}: Stocke les informations supplémentaires comme les mots de passe cryptés
    \item \textbf{llx\_user}: Pour les utilisateurs administrateurs
   
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
\item Enregistrement de la connexion dans l'historique
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

% Chapter 4
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
\includegraphics[width=0.6 \textwidth]{AffichageProduits.png}
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
 \includegraphics[width=0.5 \textwidth]{Recherche de Produits.png}
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
 \includegraphics[width=1 \textwidth]{ajouter.png}
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



\section{Gestion du Panier}

\subsection{Affichage du Panier}
\begin{figure}[H]
\centering
\includegraphics[width=0.8\textwidth]{affichage_panier.png}
\caption{Diagramme d'affichage du panier}
\label{fig:affichage_panier}
\end{figure}

\textbf{Processus :} Le client consulte son panier via l'interface. Le système récupère et affiche les articles stockés avec leurs informations complètes (prix, quantité, etc.). Cette fonctionnalité permet une visualisation claire du contenu actuel du panier.

\subsection{Modification de Quantité}
\begin{figure}[H]
\centering
\includegraphics[width=0.8\textwidth]{modification_quantite.png}
\caption{Diagramme de modification de quantité}
\label{fig:modification_quantite}
\end{figure}

\textbf{Processus :} Le client modifie une quantité. Le système vérifie le stock disponible avant mise à jour, puis recalcule le total. Affiche une erreur si stock insuffisant. Cette interaction se fait en temps réel sans rechargement de page.

\subsection{Suppression d'Article}
\begin{figure}[H]
\centering
\includegraphics[width=0.8\textwidth]{suppression_article.png}
\caption{Diagramme de suppression d'article}
\label{fig:suppression_article}
\end{figure}

\textbf{Processus :} Le client supprime un article du panier. Le système actualise immédiatement le contenu et recalcule le montant total pour affichage. La suppression est confirmée visuellement à l'utilisateur.



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

% Chapter 5
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
En tant qu'utilisateur, je veux consulter l'historique de mes commandes & Moyenne & 6 \\
\hline
En tant qu'utilisateur, je veux voir les détails d'une commande & Facile & 4 \\
\hline
En tant qu'utilisateur, je veux suivre le statut de ma commande & Moyenne & 6 \\

\hline
\end{tabularx}
\caption{Backlog du Sprint 3 - Gestion des Commandes}
\label{tab:backlog_sprint3}
\end{table}

\section{Conception}

\subsection{Analyse des Besoins}
La gestion des commandes représente un processus critique dans toute plateforme e-commerce. Elle doit garantir la sécurité des transactions, la traçabilité des opérations et l'intégrité des données tout en offrant une expérience utilisateur optimale.

\subsection{Use Case }
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des commandes.

\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{lescommandes.png}
\caption{Diagramme de cas d'utilisation - Gestion des commandes}
\label{fig:usecase_orders}
\end{figure}

\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Finaliser une commande
\item Choisir une méthode de paiement
\item Consulter l'historique des commandes
\item Voir les détails d'une commande
\item Gérer les adresses de livraison

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





\subsection{Interface Dolibarr - Gestion des Commandes}
L'interface Dolibarr pour les commandes offre une gestion complète et professionnelle :


\begin{figure}[h]
\centering
\includegraphics[width=1\textwidth]{dolibarr_commande.png}
\caption{Interface de commande dans Dolibarr}
\label{fig:dolibarr_commande}
\end{figure}

L'interface de commande Dolibarr permet la gestion complète des commandes clients, depuis la création jusqu'au suivi. Elle intègre automatiquement les informations produits, clients et paiements.


\begin{itemize}
\item \textbf{Dashboard commandes} : Vue d'ensemble avec indicateurs de performance en temps réel
\item \textbf{Liste des commandes} : Filtrage avancé par statut, client, période, montant
\item \textbf{Fiche commande} : Détails complets avec historique des modifications et traçabilité
\item \textbf{Gestion des statuts} : Workflow automatisé avec notifications
\item \textbf{Graphiques intégrés} :
  
  \item Évolution mensuelle du chiffre d'affaires
  \item Répartition des commandes par statut
  \item Analyse des produits les plus vendus
  \item Métriques des délais de livraison
  \item Taux de conversion et abandon de panier
  \end{itemize}


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
\item Gestion des adresses de livraison et facturation
\item Suivi des expéditions et numéros de tracking
\item Application des codes promotionnels et remises
\end{itemize}




\section{Diagrammes de Séquence}
Les diagrammes de séquence suivants illustrent les interactions entre les différents composants du système lors des opérations de gestion des commandes.

\subsection{Séquence de Création de Commande}
\begin{figure}[H]
\centering
\includegraphics[width=0.6\textwidth]{mvc_commande.png}
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
\includegraphics[width=1 \textwidth]{FLUX.png}
\caption{Diagramme de cas d’utilisation - Flux Client}
\label{fig:cas d’utilisation_client_flow}
\end{figure}

\textbf{Étapes du flux client :}
\begin{enumerate}
\item Création de commande
\item Paiement sécurisé
\item Suivi en temps réel
\item Annulation de commande
\item Consultation de l'historique des commandes
\item Suivi détaillé des commandes
\end{enumerate}

\subsection{Fonctions Administrateur}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{ADMINZAI.png}
\caption{Diagramme de cas d’utilisation - Fonctions Administrateur}
\label{fig:cas d’utilisation_admin_functions}
\end{figure}


\textbf{Fonctionnalités administrateur :}
\begin{enumerate}
\item Gestion complète des commandes et modification des statuts
\item Administration du catalogue produits et gestion des stocks
\item Génération des factures
\item Traitement des demandes de retour et avoir
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

\subsection{Interface de confirmation de commande réussie}
\begin{figure}[h]
\centering
\includegraphics[width=0.8\textwidth]{order_success.png}
\caption{Interface de confirmation de commande réussie}
\label{fig:order_success}
\end{figure}

L'interface de confirmation affiche les détails essentiels de la commande validée, incluant le numéro de référence, le montant total et les prochaines étapes de livraison. Une notification par email est automatiquement envoyée au client.

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
\includegraphics[width=1 \textwidth]{COMMANDESUIVIE.png}
\caption{Interface de détail de commande }
\label{fig:order_detail_screen}
\end{figure}

Cette interface permet aux utilisateurs de consulter tous les détails d'une commande spécifique, incluant les produits commandés, les informations de livraison.


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
Calcul des totaux & Calcul automatique des taxes et frais de port & Montants calculés correctement & Réussi \\

\hline
Génération de facture & Création automatique de la facture & Facture générée au format PDF & Réussi \\
\hline
Historique des commandes & Consultation de l'historique des commandes & Liste des commandes  & Réussi \\
\hline
Détails de commande & Consultation des détails d'une commande & Informations complètes affichées & Réussi \\
\hline
Gestion des erreurs & Traitement des erreurs de paiement & Messages d'erreur appropriés & Réussi \\
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
\item \textbf{Intégration Dolibarr native} : Synchronisation parfaite avec les tables \texttt{llx\_commande}, \texttt{llx\_commandedet} 
\item \textbf{Notifications automatiques} : Système d'alertes proactives pour informer les clients
\item \textbf{Interface utilisateur moderne} : Design responsive et expérience utilisateur optimisée
\end{itemize}

\subsection{Valeur Ajoutée}
L'intégration avec Dolibarr garantit une cohérence parfaite des données entre l'ERP et la plateforme e-commerce, éliminant les risques de désynchronisation et permettant une gestion unifiée des opérations commerciales. Le système développé respecte les meilleures pratiques de sécurité et de performance, assurant une expérience utilisateur de qualité professionnelle.

% Chapter 6
\chapter{Sprint 4 - Système de Support Client}
\section{Introduction}
Le Sprint 4 se concentre sur le développement d'un système de support client complet et intégré, permettant aux utilisateurs de la plateforme e-commerce de bénéficier d'un service d'assistance professionnel et réactif. Ce système s'appuie sur le module de tickets de Dolibarr pour assurer une gestion centralisée et efficace des demandes de support.

\section{Backlog du Sprint}
\subsection{User Stories}
\begin{table}[H]
\centering
\begin{tabularx}{\textwidth}{|X|X|X|X|}
\hline
\textbf{ID} & \textbf{User Story} & \textbf{Priorité}  \\
\hline
1 & En tant qu'utilisateur, je veux pouvoir créer un ticket de support pour signaler un problème & Haute  \\
\hline
2 & En tant qu'utilisateur, je veux consulter l'historique de mes tickets de support & Haute  \\
\hline
3 & En tant qu'utilisateur, je veux recevoir des notifications sur l'évolution de mes tickets & Moyenne  \\
\hline
4 & En tant qu'agent, je veux pouvoir catégoriser et prioriser les tickets & Moyenne  \\
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
\includegraphics[width=0.85\textwidth]{support_client_admin.png}
\caption{Diagramme de cas d'utilisation - Système de support client}
\label{fig:usecase_support}

\vspace{1cm}

Le système distingue clairement les fonctionnalités clients (création et suivi de tickets) des outils administrateurs (gestion complète et configuration du système de support).
\end{figure}
\textbf{Cas d'utilisation principaux :}
\begin{itemize}
\item Créer un ticket de support
\item Assigner un ticket à un agent
\item Fermer un ticket

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

\hline
\end{tabularx}
\caption{Tables Dolibarr - Module Support}
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
\item Intégration avec le CRM Dolibarr
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



\section{Diagrammes de Séquence}
Le diagramme de séquence suivant illustrent le interaction entre les différents composants du système de support client.

\subsection{Séquence de Création de Ticket}
\begin{figure}[H]
\centering
 \includegraphics[width=0.6 \textwidth]{creationtt.png}
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

\subsection{Tableau de Bord Agent}
\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{tickettt.png}
\caption{Interface de gestion des tickets de support}
\label{fig:tickets_screen}
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
Assignation d'agent & Attribution automatique selon les règles & Agent assigné selon la disponibilité & Réussi \\
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
\vspace{1cm}
\vspace{1cm}
\vspace{1cm}

\section*{Conclusion Générale et Perspectives}

Dans ce rapport, nous avons détaillé l'ensemble des étapes de réalisation de notre projet ZAI E-commerce, construit de façon incrémentale et itérative en utilisant la méthode agile Scrum. Cette approche, largement adoptée aujourd'hui, notamment par les entreprises technologiques innovantes, permet d'accroître la rapidité et la qualité du développement tout en maximisant la satisfaction des utilisateurs finaux.

Ce projet de fin d'études marque l'aboutissement de notre parcours universitaire. Il nous a permis de mettre en pratique les connaissances théoriques et pratiques acquises tout au long de notre cursus. Le projet consistait à développer une plateforme e-commerce moderne et sécurisée, parfaitement intégrée avec le système ERP Dolibarr.

Durant ce projet, nous avons pu réaliser plusieurs modules clés de l'application, couvrant :
\begin{itemize}
\item La gestion des utilisateurs et l'authentification (Sprint 1)
\item Le catalogue de produits et la gestion du panier (Sprint 2)
\item La gestion des commandes, incluant le processus de création, le suivi et l'intégration avec Dolibarr pour la synchronisation des données (Sprint 3)
\item Le système de support client avec gestion des tickets et communication en temps réel (Sprint 4)
\item Les tableaux de bord et les analyses de ventes
\item La synchronisation bidirectionnelle avec Dolibarr pour une cohérence parfaite des données
\item L'interface d'administration pour la gestion complète de la plateforme
\end{itemize}

L'objectif principal était de créer une plateforme robuste et intuitive permettant une gestion efficace des différents aspects du commerce électronique, tout en assurant une cohérence parfaite des données avec Dolibarr. Nous avons mis l'accent sur une architecture MVC propre, des performances optimisées. 

\vspace{1cm}
\textbf{Perspectives d'Évolution}

En dépit des réussites obtenues, il reste encore des occasions d'amélioration et d'évolution pour le projet ZAI. Plusieurs perspectives d'amélioration peuvent être envisagées :

\begin{itemize}
\item \textbf{Application Mobile} : Développement d'une application mobile native pour iOS et Android
\item \textbf{Intelligence Artificielle} : Intégration d'un système de recommandations basé sur l'IA
\item \textbf{Optimisation des Performances} : Mise en place d'un système de cache avancé et optimisation des requêtes
\item \textbf{Sécurité Renforcée} : Implémentation de l'authentification à deux facteurs et audit de sécurité
\end{itemize}

\vspace{0.5cm}
En conclusion, ce projet nous a non seulement permis de consolider nos compétences techniques et organisationnelles, mais aussi de fournir une solution logicielle moderne et adaptée aux besoins spécifiques du client pour son activité e-commerce. La plateforme ZAI constitue une base solide pour l'avenir, prête à évoluer avec les tendances du marché et les besoins croissants des utilisateurs.



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

\bibitem{ecommerce2025}
Statista, \textit{E-commerce worldwide - statistics \& facts}, 2024, \url{https://www.statista.com/topics/871/online-shopping/}
\end{thebibliography}

\end{document}