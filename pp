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
\usepackage{pdfpages}
\usepackage{longtable}
\usepackage{indentfirst} % For first line indent

% Set page geometry
\geometry{a4paper, margin=2.5cm}

% Set font to Calibri
\setmainfont{Calibri}

% Set line spacing to 1.5 lines
\setstretch{1.5}

% Set paragraph formatting
\setlength{\parindent}{0.8cm} % First line indent
\setlength{\parskip}{6pt} % Space between paragraphs
\addtolength{\parskip}{0pt} % No additional space

% Ensure full justification
\usepackage{ragged2e}
\justifying

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
\includepdf[pages=-]{Template.pdf}

\thispagestyle{empty}
\vspace*{5cm}
\
\chapter*{Dédicaces}


Avant toute chose, je rends grâce à Dieu, le Tout-Puissant, pour m’avoir accordé la force, la patience et le courage nécessaires pour mener ce projet à bien. Sa bienveillance m’a accompagné tout au long de ce parcours, même dans les moments les plus difficiles.

Je dédie ce travail à ma famille, pilier fondamental de mon équilibre et de ma motivation. À mes parents, dont l’amour inconditionnel, le soutien sans relâche et les encouragements constants m’ont porté chaque jour. Merci pour votre confiance, votre patience et pour avoir toujours cru en moi, même lorsque moi-même j’en doutais. Vous êtes ma source première de force et d’inspiration.

À mes frères, merci pour votre affection, votre complicité et votre présence rassurante. Votre soutien, parfois discret mais toujours sincère, m’a été précieux tout au long de cette aventure. Vous avez su m’apporter du réconfort et de la légèreté dans les moments les plus intenses.

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
\vspace{0.5cm}

\begin{minipage}{\textwidth}
\setlength{\parindent}{0.5cm}
\setlength{\parskip}{1em}  % Increased space between paragraphs
\linespread{1.4}          % Increased line spacing
\fontsize{11}{14}\selectfont % Slightly increased line height

Aujourd'hui, nous vivons dans un monde en pleine transformation numérique où le commerce électronique connaît une croissance exponentielle. Le marché mondial du e-commerce dépasse désormais les \textbf{5 000 milliards de dollars} en 2025, un chiffre qui témoigne de l'importance cruciale de ce secteur. Les entreprises, qu'elles soient petites ou grandes, doivent constamment améliorer leur présence en ligne et optimiser leurs processus de vente pour rester compétitives dans cet environnement en évolution rapide.

L'intégration d'une plateforme e-commerce avec un système ERP existant représente un défi technique majeur, mais dont les bénéfices sont considérables. Cette intégration permet une gestion unifiée des stocks, des commandes et des données clients, éliminant les silos informationnels et réduisant les erreurs humaines. Elle offre notamment une efficacité opérationnelle améliorée, des coûts réduits, et surtout une bien meilleure expérience pour les clients.

Notre projet vise précisément à développer une solution e-commerce moderne et sécurisée, parfaitement intégrée à Dolibarr, l'ERP open-source largement adopté par les PME. L'objectif est de créer une interface utilisateur intuitive et responsive qui se connecte directement à la base de données Dolibarr, évitant ainsi la duplication des données et assurant une cohérence en temps réel entre les différents systèmes.
\end{minipage}
% Chapitre 1 : Présentation du cadre de projet
\chapter{Présentation du cadre de projet}

\section{Introduction}
Ce chapitre présente mon stage au sein de ZAI, spécialiste des solutions retail en Tunisie. Nous analyserons d'abord son écosystème (1 000+ clients, et ses innovations (systèmes de caisse, outils e-commerce). Puis nous détaillerons la méthodologie appliquée dans le développement de ses solutions pour environnements commerciaux complexes, au sein d'une équipe de 15 experts.

\section{Problématique}
Dans un contexte économique en constante évolution, marqué par la digitalisation croissante des activités commerciales, la transformation numérique des entreprises et l'essor du commerce électronique sont devenues des enjeux majeurs tant pour les commerçants que pour leurs clients. Malgré la disponibilité de multiples solutions de gestion d'entreprise comme Dolibarr, de nombreuses entreprises rencontrent des difficultés à moderniser leur présence en ligne et à optimiser leurs processus de vente, tandis que leurs clients peinent à accéder à une expérience d'achat fluide et moderne en raison de l'absence d'interfaces e-commerce adaptées et de la complexité des systèmes de gestion traditionnels.

Notre client utilise déjà Dolibarr pour gérer l'ensemble de son activité commerciale - inventaire, gestion clientèle, traitement des commandes, facturation, etc. Cependant, cette solution, bien qu'efficace pour la gestion interne, présente des limitations importantes dans le contexte actuel du commerce numérique. En effet, plusieurs défis de taille émergent dans le monde ultra-compétitif du e-commerce d'aujourd'hui, nécessitant une approche innovante pour maintenir la compétitivité et répondre aux attentes croissantes des consommateurs.

Les principales problématiques :

1. \textbf{Absence d'Interface E-commerce Moderne} : L'entreprise ne dispose pas d'une plateforme de vente en ligne adaptée aux standards actuels du e-commerce. Cette situation limite considérablement les opportunités de vente, en particulier pour les clients qui privilégient les achats en ligne et recherchent une expérience utilisateur moderne, intuitive et responsive sur tous les appareils.

2. \textbf{Processus de Commande Manuel et Inefficace} : Le processus de prise de commande nécessite systématiquement l'intervention d'un commercial, créant des goulots d'étranglement et des délais de traitement. Cette approche manuelle entraîne une perte de productivité, augmente les coûts opérationnels et peut décourager les clients habitués à l'autonomie des plateformes e-commerce modernes.

3. \textbf{Incohérence et Fragmentation des Données} : La difficulté à maintenir la cohérence des informations entre les différents systèmes et canaux de vente génère des erreurs de stock, des problèmes de synchronisation des prix et des incohérences dans les données clients. Cette fragmentation compromet la fiabilité des informations et peut entraîner des erreurs coûteuses dans la gestion des commandes.

4. \textbf{Manque de Personnalisation et d'Adaptabilité} : L'absence d'une solution sur mesure qui s'adapte parfaitement aux processus métier spécifiques de l'entreprise limite l'efficacité opérationnelle. Les solutions génériques ne permettent pas de tirer parti des particularités et des avantages concurrentiels de l'entreprise, réduisant ainsi son potentiel de différenciation sur le marché.



\section{Objectifs du Projet}
Nous développons une solution e-commerce clé en main qui se connecte directement à Dolibarr pour automatiser la gestion commerciale. Notre plateforme permettra de synchroniser en temps réel les produits, stocks et commandes entre le site marchand et l'ERP, éliminant les saisies manuelles et les erreurs associées. L'interface utilisateur, simple et intuitive, offrira une expérience d'achat fluide sur tous les appareils,  Cette intégration permettra aux entreprises de gagner du temps sur leur gestion quotidienne tout en améliorant la précision de leurs données. La solution sera déployée progressivement, avec une première version opérationnelle rapidement, suivie d'optimisations continues pour s'adapter aux besoins spécifiques de chaque activité.




\section{Présentation de l'Organisme d'Accueil}
ZAI, fondée en 2002 en tant que spécialiste tunisien des technologies pour le commerce de détail, s'est imposée comme leader du marché des solutions de gestion commerciale et de points de vente, servant plus de 1 000 clients à travers l'Afrique du Nord avec près de 500 systèmes installés. La société maintient un taux de croissance annuel de 30 pour cent  grâce à ses solutions innovantes et sur mesure pour divers secteurs du commerce, notamment la mode, la restauration, les pressing et la distribution en gros, proposant des systèmes de gestion adaptés aux commerces indépendants comme aux enseignes multi-sites. Avec 15 techniciens qualifiés et 10 revendeurs agréés en Tunisie, Algérie, Maroc et Libye, ZAI fournit des systèmes de caisse intelligents, des solutions pour environnements commerciaux à fort trafic et des plateformes e-commerce intégrées, ayant déployé plus de 1 000 terminaux POS et 100 systèmes antivol adaptés à plus de 40 types d'activités. La société garantit une innovation continue grâce à des partenariats techniques européens et maintient la satisfaction client via un support technique dédié et des réseaux de service localisés, tout en préparant une expansion régionale accrue avec ses technologies éprouvées de gestion commerciale. 

\begin{figure}[H]
\centering
\includegraphics {logo.jpeg}
\caption{zai}
\label{fig:zai}
\end{figure}














\section{Présentation de Dolibarr}
\subsection{Qu'est-ce que Dolibarr ?}
Dolibarr est un progiciel de gestion intégré (ERP) et de gestion de la relation client (CRM) open-source, développé en France et largement adopté par les petites et moyennes entreprises à travers le monde. Lancé en 2003, Dolibarr s'est imposé comme une solution de référence pour la gestion d'entreprise grâce à sa simplicité d'utilisation, sa flexibilité et son approche modulaire qui permet aux entreprises d'activer uniquement les fonctionnalités dont elles ont besoin.

\begin{figure}[H]
\centering
\includegraphics[width=0.6\textwidth]{logodoli.png}
\caption{Logo Dolibarr}
\label{fig:dolibarr_logo}
\end{figure}

\subsection{Fonctionnalités Principales}
Dolibarr offre un ensemble complet de modules couvrant tous les aspects de la gestion d'entreprise :

\begin{itemize}
    \item \textbf{Gestion Commerciale} :
    \begin{itemize}
        \item Gestion des prospects et clients (CRM)
        \item Création et suivi des devis et propositions commerciales
        \item Gestion des commandes clients et fournisseurs
        \item Facturation automatisée avec modèles personnalisables
        \item Suivi des paiements et relances automatiques
    \end{itemize}
    
    \item \textbf{Gestion des Stocks et Produits} :
    \begin{itemize}
        \item Catalogue produits avec variantes et options
        \item Gestion multi-entrepôts avec traçabilité complète
        \item Mouvements de stock automatisés
        \item Inventaires périodiques et valorisation des stocks
        \item Gestion des codes-barres et étiquetage
    \end{itemize}
    
    \item \textbf{Comptabilité et Finance} :
    \begin{itemize}
        \item Comptabilité générale avec plan comptable personnalisable
        \item Gestion de la TVA et déclarations fiscales
        \item Rapports financiers et tableaux de bord
        \item Gestion de trésorerie et prévisions
        \item Interface avec les logiciels comptables externes
    \end{itemize}
    
    \item \textbf{Ressources Humaines} :
    \begin{itemize}
        \item Gestion des employés et contrats
        \item Suivi des congés et absences
        \item Gestion des notes de frais
        \item Calcul des salaires et charges sociales
    \end{itemize}
\end{itemize}

\subsection{Architecture et Technologies}
Dolibarr repose sur une architecture web moderne et éprouvée :

\begin{itemize}
    \item \textbf{Langage} : Développé en PHP 
    \item \textbf{Base de données} : Compatible MySQL, MariaDB, PostgreSQL
    \item \textbf{Interface} : Interface web responsive accessible depuis tout navigateur
    \item \textbf{API} : API REST complète pour l'intégration avec des systèmes tiers
    \item \textbf{Sécurité} : Authentification multi-niveaux, chiffrement des données sensibles
    \item \textbf{Multilingue} : Support de plus de 50 langues
\end{itemize}

\subsection{Avantages pour les Entreprises}
L'adoption de Dolibarr présente de nombreux avantages stratégiques :

\begin{itemize}
    \item \textbf{Coût réduit} : Solution open-source sans frais de licence, réduisant significativement le coût total de possession (TCO)
    \item \textbf{Flexibilité} : Architecture modulaire permettant une adaptation précise aux besoins spécifiques de chaque entreprise
    \item \textbf{Évolutivité} : Capacité à accompagner la croissance de l'entreprise avec des modules additionnels
    \item \textbf{Indépendance} : Pas de dépendance à un éditeur propriétaire, liberté de modification et d'adaptation
    \item \textbf{Communauté active} : Large communauté de développeurs et d'utilisateurs assurant un support continu
    \item \textbf{Conformité} : Respect des réglementations locales et internationales (RGPD, normes comptables)
\end{itemize}

\subsection{Positionnement sur le Marché}
Dolibarr se positionne comme une alternative crédible aux solutions ERP propriétaires coûteuses, particulièrement adaptée aux PME qui recherchent :

\begin{itemize}
    \item Une solution complète sans complexité excessive
    \item Un déploiement rapide avec une courbe d'apprentissage réduite
    \item Une maîtrise totale de leurs données et processus
    \item La possibilité de personnalisation selon leurs besoins métier
    \item Un support communautaire actif et des prestataires spécialisés
\end{itemize}

Avec plus de 100\,000 installations dans le monde et une croissance constante, Dolibarr démontre sa pertinence et sa fiabilité pour la gestion d'entreprise moderne. Cette popularité en fait un choix stratégique pour notre projet d'intégration e-commerce, garantissant la pérennité et l'évolutivité de la solution développée.












\section{Problématique et Solution Proposée}
\subsection{Problématique Détaillée}
Notre client, bien qu'utilisant déjà Dolibarr pour la gestion intégrale de son activité commerciale (inventaire, gestion clientèle, traitement des commandes, facturation), fait face à des défis majeurs qui limitent sa croissance et sa compétitivité dans l'écosystème numérique actuel. Cette situation révèle des lacunes critiques qui nécessitent une intervention stratégique pour moderniser et optimiser les processus commerciaux.

Les défis identifiés se manifestent à travers quatre axes principaux :

\begin{itemize}
   \item \textbf{Absence d'Interface E-commerce Moderne} : L'entreprise ne dispose d'aucune plateforme de vente en ligne conforme aux standards contemporains du commerce électronique. Cette lacune constitue un handicap concurrentiel majeur en 2025, privant l'organisation d'opportunités de croissance significatives et limitant l'accessibilité de ses produits aux consommateurs privilégiant les canaux numériques.
    
    \item \textbf{Processus de Commande Manuel et Inefficient} : Le système actuel de prise de commande requiert systématiquement l'intervention d'un commercial, générant des goulots d'étranglement opérationnels et des délais de traitement prolongés. Cette approche manuelle compromet l'efficacité organisationnelle, augmente les coûts de traitement et peut dissuader une clientèle habituée à l'autonomie des plateformes e-commerce modernes.
    
    \item \textbf{Incohérence et Fragmentation des Données} : La difficulté à maintenir la synchronisation et la cohérence des informations entre les différents systèmes et canaux de distribution constitue une source récurrente d'erreurs opérationnelles. Cette fragmentation des données compromet la fiabilité des informations, génère des incohérences dans la gestion des stocks et peut entraîner des erreurs coûteuses dans le traitement des commandes.
    
    \item \textbf{Besoin de Personnalisation et d'Adaptabilité} : L'absence d'une solution technologique sur mesure, parfaitement alignée avec les processus métier spécifiques et les exigences opérationnelles de l'entreprise, limite l'optimisation des performances et l'exploitation du potentiel concurrentiel. Les solutions génériques ne permettent pas de capitaliser sur les particularités et les avantages distinctifs de l'organisation.
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
L'adoption de la méthodologie Scrum pour ce projet s'est imposée comme un choix stratégique optimal. Cette approche agile permet un développement itératif et incrémental parfaitement adapté aux exigences du projet. Les raisons de ce choix méthodologique sont multiples :

\begin{itemize}
\item \textbf{Adaptabilité aux besoins évolutifs} : La nature itérative de Scrum permet de s'adapter efficacement aux changements de spécifications et aux nouvelles exigences du client
\item \textbf{Livraison continue de valeur} : Les sprints courts garantissent la livraison régulière de fonctionnalités opérationnelles, offrant une visibilité constante sur l'avancement du projet
\item \textbf{Flexibilité dans la priorisation} : Le framework Scrum facilite la réorganisation des priorités en fonction des retours utilisateurs et des contraintes business
\item \textbf{Collaboration client renforcée} : L'implication continue du client dans le processus de développement assure l'alignement permanent entre les livrables et les attentes
\end{itemize}


\begin{figure}[H]
    \centering
     \includegraphics[width=1 \textwidth]{ScrumValues-500.png}
    \caption{Scrum}
    \label{fig:scrum}
\end{figure}

\subsection{Organisation de l'Équipe Scrum}
L'équipe Scrum mise en place pour ce projet présente une structure organisationnelle optimisée et clairement définie :

\begin{itemize}
    \item \textbf{Product Owner} : Responsable de la définition des fonctionnalités du produit et de la priorisation du backlog, garantissant l'alignement avec les objectifs business
    \item \textbf{Scrum Master} : Facilitateur méthodologique chargé de l'application des pratiques Scrum et de l'élimination des obstacles organisationnels
    \item \textbf{Équipe de développement} : Composée des membres des groupes 4 et 6, avec une répartition spécialisée par module CRUD pour optimiser l'efficacité et la qualité du développement
\end{itemize}
\begin{figure}[H]
    \centering
     \includegraphics[width=1 \textwidth]{Scrum.jpg}
    \caption{Méthodologie Scrum appliquée au projet}
    \label{fig:scrum_methodology}
\end{figure}
\section{Conclusion}
Ce chapitre a permis d'établir le cadre conceptuel et méthodologique du projet. Nous avons présenté le contexte institutionnel d'ESPRIT, analysé en détail la problématique du client, effectué une étude comparative des solutions existantes et justifié le choix de la méthodologie Scrum. La solution sur mesure proposée répond précisément aux besoins spécifiques identifiés tout en assurant une intégration optimale avec l'écosystème Dolibarr existant. Les fondations méthodologiques et techniques sont désormais établies pour aborder la phase de développement.

% Chapter 2
\chapter{Sprint 0: Analyse Et spécifications des besoins}
\section{Introduction}
Cette phase constitue l'étape fondamentale d'établissement des bases architecturales et conceptuelles du projet. Ce chapitre présente l'ensemble de la conception et de l'architecture système : analyse détaillée des besoins, modélisation UML, planification des sprints et spécifications techniques. Cette démarche méthodologique garantit la solidité des fondations avant l'initiation de la phase de développement. Bien que cette étape soit principalement conceptuelle, elle demeure essentielle pour assurer la qualité et la cohérence de l'ensemble du projet.

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
    \item \textbf{Performance} : Temps de réponse inférieur à 2 secondes pour les opérations courantes
    \item \textbf{Sécurité} : Protection renforcée des données utilisateurs et des transactions, avec authentification sécurisée et chiffrement des données sensibles
    \item \textbf{Disponibilité} : Système disponible 24h/24 et 7j/7 avec un taux de disponibilité cible de 99,9\%
    \item \textbf{Scalabilité} : Capacité à gérer une montée en charge progressive d'utilisateurs et de produits
    \item \textbf{Maintenabilité} : Architecture modulaire avec code structuré et documentation complète pour faciliter la maintenance évolutive
    \item \textbf{Compatibilité} : Interface responsive compatible avec l'ensemble des appareils et navigateurs modernes
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
L'architecture globale du système repose sur le modèle MVC (Modèle-Vue-Contrôleur), un pattern architectural éprouvé et largement adopté dans l'industrie. Cette approche garantit une séparation claire des responsabilités et facilite significativement la maintenance et l'évolutivité du code. Cette architecture modulaire offre une organisation structurée et cohérente, parfaitement adaptée aux exigences du projet.



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
L'organisation architecturale du système s'articule autour des composants suivants :
\begin{itemize}
    \item \textbf{Pattern MVC} : Séparation structurelle entre Model (couche de données), View (interface utilisateur) et Controller (logique métier), garantissant une architecture claire et maintenable
    \item \textbf{API RESTful} : Interface standardisée assurant une communication optimisée entre les couches frontend et backend
    \item \textbf{Architecture modulaire} : Modules indépendants dédiés à l'authentification, au catalogue et aux commandes, favorisant la scalabilité et la maintenance
    \item \textbf{Système de cache multi-niveaux} : Implémentation de Redis pour la gestion des sessions et Memcached pour l'optimisation des données fréquemment consultées
\end{itemize}

\subsubsection{Stack Technologique}
La stack technologique sélectionnée repose sur des technologies éprouvées et performantes :
\begin{itemize}
    \item \textbf{Backend} : PHP 8.1+ avec framework personnalisé, intégration native optimisée avec l'écosystème Dolibarr
    \vspace{0.2cm}
    \begin{center}
    \includegraphics[width=2.5cm]{php.png} \\
    \small\textbf{PHP}
    \end{center}
    \vspace{0.2cm}
    
    \item \textbf{Frontend} : HTML5, CSS3, JavaScript ES6+, Bootstrap 5 pour une interface responsive et moderne
    \vspace{0.2cm}
    \begin{center}
    \begin{tabular}{cccc}
    \includegraphics[width=2cm]{html.png} & 
    \includegraphics[width=3.2cm]{css.png} & 
    \includegraphics[width=3cm]{js.png} & 
    
    
    \end{tabular}
    \end{center}
    \vspace{0.2cm}
    
    \item \textbf{Base de données} : MySQL 8.0+ avec optimisations spécifiques pour l'intégration Dolibarr
    \vspace{0.2cm}
    \begin{center}
    \includegraphics[width=2cm]{mysql-icon.png} \\
    \small\textbf{MySQL}
    \end{center}
    \vspace{0.2cm}
    \vspace{1cm}
    \item \textbf{Serveur web} : Apache 2.4+ avec mod\_rewrite et protocoles SSL/TLS pour la sécurité et les performances
    \vspace{0.2cm}
    \begin{center}
    \includegraphics[width=2cm]{apache-icon.png} \\
    \small\textbf{Apache}
    \end{center}
    \vspace{0.2cm}
    
    \item \textbf{Outils de développement} : Git pour le versioning, Composer pour la gestion des dépendances PHP, NPM pour les assets frontend, Docker pour la containerisation
    \vspace{0.2cm}
    \begin{center}
    \begin{tabular}{cccc}
    \includegraphics[width=2cm]{git.png}  
    
    \small\textbf{Git} 
    \end{tabular}
    \end{center}
\end{itemize}

\subsubsection{Outils de Développement}
\begin{itemize}
    \item \textbf{IDE}: Visual Studio Code avec extensions PHP Intelephense, JavaScript
    \item \textbf{Contrôle de version}: Git avec GitFlow workflow et hooks pre-commit
    \item \textbf{Debugging}: Xdebug pour PHP, Chrome DevTools pour frontend
    \item \textbf{Tests}: PHPUnit pour tests unitaires, Selenium pour tests E2E
    \item \textbf{Qualité de code}: PHP CodeSniffer, ESLint, Prettier,
\end{itemize}

\subsubsection{Gestion de Projet et Collaboration}
\begin{itemize}
    \item \textbf{Gestion de projet}: Jira pour le suivi des sprints, épiques et user stories
    \item \textbf{Documentation}: Confluence pour la documentation technique et fonctionnelle
    \item \textbf{Communication}: Slack pour la communication d'équipe quotidienne
    \item \textbf{Revue de code}: GitHub/GitLab avec pull requests et code review
\end{itemize}

\section{Performance et Optimisation}
\subsection{Stratégies de Performance}
L'optimisation de l'expérience utilisateur constitue une priorité majeure, nécessitant la mise en œuvre de stratégies de performance avancées. Les temps de chargement optimisés sont essentiels pour maintenir l'engagement des utilisateurs dans un contexte e-commerce.

\subsubsection{Optimisation Frontend}
Les optimisations frontend mises en place incluent :
\begin{itemize}
    \item \textbf{Minification et compression} : Minification des ressources CSS/JS et compression Gzip/Brotli pour réduire la taille des transferts
    \item \textbf{Lazy loading} : Chargement différé des images et contenus non critiques pour optimiser le temps de rendu initial
    \item \textbf{CDN (Content Delivery Network)} : Distribution géographique des ressources statiques pour minimiser la latence
    \item \textbf{Critical CSS} : Intégration du CSS critique en inline pour accélérer le rendu initial
    \item \textbf{Service Workers} : Implémentation de stratégies de cache intelligentes côté client pour une navigation fluide
\end{itemize}

\subsubsection{Optimisation Backend}
Les optimisations backend comprennent :
\begin{itemize}
    \item \textbf{Cache applicatif} : Utilisation de Redis pour la gestion des sessions et Memcached pour la mise en cache des données fréquemment consultées
    \item \textbf{Optimisation des requêtes} : Implémentation d'index optimisés, requêtes préparées et pagination efficace pour minimiser les temps de réponse
    \item \textbf{Pool de connexions} : Gestion optimisée des connexions base de données pour maximiser l'utilisation des ressources
    \item \textbf{Compression de réponse} : Compression automatique des réponses API pour réduire l'utilisation de la bande passante
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
Le backlog de produit contient toutes les fonctionnalités à développer, organisées par épics avec leur priorité et estimation en story points.

\begin{longtable}{|l|l|p{7cm}|r|}
\hline
\textbf{ID} & \textbf{Priorité} & \textbf{User Story} & \textbf{SP} \\ \hline
\endfirsthead

\hline
\textbf{ID} & \textbf{Priorité} & \textbf{User Story} & \textbf{SP} \\ \hline
\endhead

\multicolumn{4}{|c|}{\textbf{Épique 1 : Gestion des Utilisateurs}} \\ \hline
US-1.1 & Élevé & En tant que visiteur, je veux m'inscrire  & 5 \\ \hline
US-1.2 & Élevé & En tant qu'utilisateur, je veux me connecter de manière sécurisée & 3 \\ \hline
US-1.3 & Élevé & En tant qu'utilisateur, je veux réinitialiser mon mot de passe & 3 \\ \hline
US-1.4 & Moyenne & En tant qu'utilisateur, je veux modifier mon profil & 5 \\ \hline
US-1.5 & Moyenne & En tant qu'utilisateur, je veux activer l'authentification à deux facteurs & 8 \\ \hline

\multicolumn{4}{|c|}{\textbf{Épique 2 : Catalogue et Recherche}} \\ \hline
US-2.1 & Élevé & En tant qu'utilisateur, je veux consulter le catalogue de produits & 8 \\ \hline
US-2.2 & Élevé & En tant qu'utilisateur, je veux voir les détails d'un produit & 5 \\ \hline
US-2.3 & Élevé & En tant qu'utilisateur, je veux filtrer les produits par catégorie & 8 \\ \hline
US-2.4 & Élevé & En tant qu'utilisateur, je veux rechercher des produits par nom/description & 13 \\ \hline
US-2.5 & Moyenne & En tant qu'utilisateur, je veux trier les produits (prix, popularité, nouveauté) & 5 \\ \hline
US-2.6 & Moyenne & En tant qu'utilisateur, je veux voir les produits recommandés & 21 \\ \hline
US-2.7 & Faible & En tant qu'utilisateur, je veux consulter les avis et notes des produits & 13 \\ \hline
US-2.8 & Faible & En tant qu'utilisateur, je veux comparer plusieurs produits & 8 \\ \hline

\multicolumn{4}{|c|}{\textbf{Épique 3 : Panier et Commandes}} \\ \hline
US-3.1 & Élevé & En tant qu'utilisateur, je veux ajouter des produits à mon panier & 8 \\ \hline
US-3.2 & Élevé & En tant qu'utilisateur, je veux modifier les quantités dans mon panier & 5 \\ \hline
US-3.3 & Élevé & En tant qu'utilisateur, je veux passer une commande & 13 \\ \hline
US-3.4 & Élevé & En tant qu'utilisateur, je veux choisir une adresse de livraison & 8 \\ \hline
US-3.5 & Élevé & En tant qu'utilisateur, je veux sélectionner un mode de paiement & 13 \\ \hline
US-3.6 & Moyenne & En tant qu'utilisateur, je veux consulter l'historique de mes commandes & 8 \\ \hline
US-3.7 & Moyenne & En tant qu'utilisateur, je veux suivre le statut de ma commande & 13 \\ \hline
US-3.8 & Moyenne & En tant qu'utilisateur, je veux sauvegarder mon panier entre les sessions & 8 \\ \hline


\multicolumn{4}{|c|}{\textbf{Épique 4 : Support Client}} \\ \hline
US-4.1 & Moyenne & En tant qu'utilisateur, je veux créer un ticket de support & 8 \\ \hline
US-4.2 & Moyenne & En tant qu'utilisateur, je veux consulter mes tickets de support & 5 \\ \hline
US-4.3 & Moyenne & En tant qu'utilisateur, je veux recevoir des notifications par email & 8 \\ \hline

\end{longtable}



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





\section{Conclusion}
Ce chapitre a présenté une phase de conception et d'architecture complète et moderne pour le projet ZAI E-commerce, établissant les fondations d'une solution robuste et évolutive.

\subsection{Synthèse des Contributions}
Les principales contributions de cette phase incluent :

\begin{itemize}
    \item \textbf{Performance optimisée} : Stratégies d'optimisation frontend et backend pour assurer une expérience utilisateur fluide
    \item \textbf{Intégration native Dolibarr} : Solution d'intégration transparente évitant la duplication de données
    \item \textbf{Méthodologie Agile} : Application rigoureuse de Scrum avec backlog détaillé et estimation en story points
  
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
    \label{fig:gestion_tiers_dolibarr}
\end{figure}

L'interface de gestion des tiers dans Dolibarr ERP centralise la gestion des partenaires commerciaux (clients, fournisseurs et prospects). Elle permet d'enregistrer leurs informations, de suivre les interactions et de gérer l'ensemble des relations commerciales au sein d'une seule plateforme intégrée.
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


\subsection{Diagrammes de cas d’utilisation Détaillé}
Le diagramme de cas d'utilisation suivant présente les interactions possibles entre l'utilisateur et le système concernant la gestion des produits et du panier.

\begin{figure}[H]
\centering
\includegraphics[width=1 \textwidth]{v}
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

\begin{figure}[H]
    \centering
    \includegraphics[width=1.1\textwidth]{product.png}  % Changed image reference
    \caption{Interface Dolibarr - Gestion des Produits}  % Updated caption
    \label{fig:gestion_produits_dolibarr}  % Updated label
\end{figure}

L'interface de gestion des produits dans Dolibarr ERP offre un contrôle complet sur le catalogue et l'inventaire. Elle permet de créer, modifier et suivre les articles, leurs stocks, prix et caractéristiques techniques, avec une intégration native aux autres modules commerciaux.

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
\includegraphics[width=1\textwidth]{produit1.png}
\caption{Interface du catalogue de produits - Vue d'ensemble des articles disponibles}
\label{fig:catalogue_produits}
\end{figure}

L'interface du catalogue présente une vue organisée des produits disponibles, avec des options de filtrage et de tri avancées. Les utilisateurs peuvent parcourir les différents articles, visualiser les images principales et accéder rapidement aux informations essentielles (prix, disponibilité, notes).

\subsection{Interface de Détail de Produit}
\begin{figure}[H]
\centering
\includegraphics[width=1\textwidth]{viewp.png}
\caption{Page de détail d'un produit - Informations complètes et options d'achat}
\label{fig:detail_produit}
\end{figure}

L'interface de détail présente toutes les caractéristiques techniques du produit, des images détaillées, les options disponibles et les avis clients. Elle permet d'ajouter l'article au panier, de sélectionner les variantes et de consulter les recommandations de produits similaires.

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
\vspace{14cm}
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



\begin{thebibliography}{20}

\bibitem{scrum}
Scrum.org. \textit{What is Scrum?} [en ligne]. Consulté le 08/11/2024. Disponible sur : \url{https://www.scrum.org/resources/what-is-scrum}

\bibitem{dolibarr}
Dolibarr ERP \& CRM. \textit{Documentation officielle} [en ligne]. Consulté le 04/11/2024. Disponible sur : \url{https://www.dolibarr.org/documentation.php}

\bibitem{php}
PHP Documentation. \textit{PHP Manual} [en ligne]. Consulté le 10/11/2024. Disponible sur : \url{https://www.php.net/manual/en/}

\bibitem{mysql}
MySQL Documentation. \textit{MySQL Reference Manual} [en ligne]. Consulté le 12/11/2024. Disponible sur : \url{https://dev.mysql.com/doc/}

\bibitem{mvc}
FREEMAN, A. \textit{Pro ASP.NET MVC 5}. Apress, 2013.

\bibitem{ecommerce}
LAUDON, K. C. et TRAVER, C. G. \textit{E-commerce: Business, Technology, Society}. Pearson, 2018.

\bibitem{erp}
MONK, E. et WAGNER, B. \textit{Concepts in Enterprise Resource Planning}. Cengage Learning, 2012.

\bibitem{agile}
BECK, K., et al. \textit{Manifesto for Agile Software Development} [en ligne]. 2001. Disponible sur : \url{https://agilemanifesto.org/}

\bibitem{gdpr}
Commission Européenne. \textit{Règlement Général sur la Protection des Données (RGPD)}. 2018.

\bibitem{pci}
PCI Security Standards Council. \textit{Payment Card Industry Data Security Standard}. Version 4.0, 2022.

\bibitem{restapi}
FIELDING, R. T. \textit{Architectural Styles and the Design of Network-based Software Architectures}. Thèse de doctorat, UC Irvine, 2000.

\bibitem{bootstrap}
Bootstrap Team. \textit{Bootstrap Documentation} [en ligne]. Consulté le 18/11/2024. Disponible sur : \url{https://getbootstrap.com/docs/}

\bibitem{git}
CHACON, S. et STRAUB, B. \textit{Pro Git}. Apress, 2014.


\bibitem{performance}
SOUDERS, S. \textit{High Performance Web Sites}. O'Reilly Media, 2007.

\bibitem{ux}
NORMAN, D. \textit{The Design of Everyday Things}. Basic Books, 2013.

\bibitem{ecommerce2025}
Statista. \textit{E-commerce worldwide - statistics \& facts} [en ligne]. 2024. Disponible sur : \url{https://www.statista.com/topics/871/online-shopping/}

\end{thebibliography}
\cleardoublepage
\chapter*{Résumé}
\addcontentsline{toc}{chapter}{Résumé}

Ce projet de fin d'études présente le développement d'une plateforme e-commerce moderne intégrée au système ERP Dolibarr. Réalisé au sein de l'entreprise ZAI, spécialiste tunisien des solutions retail, ce travail répond aux défis de la transformation numérique des entreprises.

La problématique centrale concerne l'absence d'interface e-commerce moderne chez les entreprises utilisant Dolibarr, entraînant des processus manuels inefficaces et une fragmentation des données. Notre solution propose une plateforme web sur mesure développée selon l'architecture MVC, offrant une intégration native avec Dolibarr.

La méthodologie Scrum a structuré le développement en quatre sprints principaux :
\begin{itemize}
\item \textbf{Sprint 1} : Gestion des utilisateurs et authentification sécurisée
\item \textbf{Sprint 2} : Catalogue de produits et gestion du panier d'achat
\item \textbf{Sprint 3} : Système de commandes avec synchronisation Dolibarr
\item \textbf{Sprint 4} : Plateforme de support client avec gestion des tickets
\end{itemize}

Les technologies utilisées incluent PHP pour le backend, MySQL pour la base de données, et une interface responsive moderne. L'architecture garantit la cohérence des données entre la plateforme e-commerce et l'ERP, éliminant les saisies manuelles et les erreurs associées.

Les résultats obtenus démontrent une amélioration significative de l'efficacité opérationnelle, une réduction des coûts de traitement des commandes, et une expérience utilisateur optimisée. La solution offre une base solide pour l'évolution future vers des fonctionnalités avancées comme l'intelligence artificielle et les applications mobiles.

\textbf{Mots-clés :} E-commerce, ERP, Dolibarr, Intégration, PHP, MVC, Scrum, Transformation numérique



\cleardoublepage
\chapter*{Abstract}
\addcontentsline{toc}{chapter}{Abstract}

This final year project presents the development of a modern e-commerce platform integrated with the Dolibarr ERP system. Conducted within ZAI company, a Tunisian specialist in retail solutions, this work addresses the challenges of digital transformation for businesses.

The central problem concerns the absence of modern e-commerce interfaces for companies using Dolibarr, leading to inefficient manual processes and data fragmentation. Our solution proposes a custom web platform developed using MVC architecture, offering native integration with Dolibarr.

The Scrum methodology structured the development into four main sprints:
\begin{itemize}
\item \textbf{Sprint 1}: User management and secure authentication
\item \textbf{Sprint 2}: Product catalog and shopping cart management
\item \textbf{Sprint 3}: Order system with Dolibarr synchronization
\item \textbf{Sprint 4}: Customer support platform with ticket management
\end{itemize}

The technologies used include PHP for the backend, MySQL for the database, and a modern responsive interface. The architecture ensures data consistency between the e-commerce platform and the ERP, eliminating manual data entry and associated errors.

The results obtained demonstrate significant improvement in operational efficiency, reduction in order processing costs, and optimized user experience. The solution provides a solid foundation for future evolution towards advanced features such as artificial intelligence and mobile applications.

The project successfully delivers a comprehensive e-commerce solution that bridges the gap between traditional ERP systems and modern digital commerce requirements. The platform's modular design and robust integration capabilities position it as a scalable solution for businesses seeking to modernize their online presence while maintaining operational consistency.

\textbf{Keywords:} E-commerce, ERP, Dolibarr, Integration, PHP, MVC, Scrum, Digital transformation
\end{document}