#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Script de Génération Automatique de Présentation PFE
Pour le projet: Plateforme E-commerce Intégrée avec Dolibarr ERP
Entreprise: ZAI - Zied Abid Informatique

Prérequis:
pip install python-pptx pillow requests
"""

from pptx import Presentation
from pptx.util import Inches, Pt
from pptx.dml.color import RGBColor
from pptx.enum.text import PP_ALIGN, MSO_ANCHOR
from pptx.enum.shapes import MSO_SHAPE
import json
import os
from datetime import datetime

class PFEPresentationGenerator:
    def __init__(self):
        self.prs = Presentation()
        self.setup_theme()
        self.slide_data = self.load_presentation_data()
    
    def setup_theme(self):
        """Configure le thème de la présentation"""
        # Couleurs ZAI (Corporate Blue)
        self.primary_color = RGBColor(0, 51, 102)  # Bleu foncé
        self.secondary_color = RGBColor(0, 123, 191)  # Bleu clair
        self.accent_color = RGBColor(255, 165, 0)  # Orange
        self.text_color = RGBColor(51, 51, 51)  # Gris foncé
    
    def load_presentation_data(self):
        """Charge les données de la présentation"""
        return {
            "metadata": {
                "title": "Développement d'une Plateforme E-commerce Intégrée avec Dolibarr ERP",
                "student": "[Votre Nom Complet]",
                "student_id": "[Votre Numéro d'Étudiant]",
                "program": "[Votre Filière - ex: Génie Logiciel]",
                "university": "[Votre Université]",
                "company": "ZAI - Zied Abid Informatique",
                "supervisor_academic": "[Nom de l'Encadrant Académique]",
                "supervisor_company": "[Nom de l'Encadrant Entreprise]",
                "academic_year": "2024-2025",
                "defense_date": "[Date de Soutenance]",
                "location": "[Lieu de Soutenance]"
            },
            "slides": [
                {
                    "title": "Développement d'une Plateforme E-commerce Intégrée avec Dolibarr ERP",
                    "type": "title",
                    "content": {
                        "subtitle": "Projet de Fin d'Études",
                        "details": [
                            "Présenté par: [Votre Nom]",
                            "Filière: [Votre Filière]",
                            "Entreprise d'accueil: ZAI - Zied Abid Informatique",
                            "Encadrant académique: [Nom]",
                            "Encadrant entreprise: [Nom]",
                            "Année universitaire: 2024-2025"
                        ]
                    }
                },
                {
                    "title": "Plan de Présentation",
                    "type": "agenda",
                    "content": {
                        "duration": "Durée totale: 30 minutes",
                        "sections": [
                            "1. Introduction et Contexte (3 min)",
                            "2. Analyse et Conception (5 min)",
                            "3. Réalisation Technique (8 min)",
                            "4. Validation et Résultats (3 min)",
                            "5. Conclusion et Perspectives (1 min)",
                            "6. Questions/Réponses (10 min)"
                        ],
                        "objectives": [
                            "Présenter la solution e-commerce développée",
                            "Démontrer l'intégration avec Dolibarr ERP",
                            "Justifier les choix techniques et méthodologiques",
                            "Évaluer les résultats et l'impact business"
                        ]
                    }
                },
                {
                    "title": "Contexte Général - Marché E-commerce",
                    "type": "context",
                    "content": {
                        "statistics": [
                            "Marché e-commerce mondial: 6.2 trillions USD (2024)",
                            "Croissance annuelle: +10.4% (2020-2024)",
                            "Part mobile: 72.9% des ventes en ligne",
                            "Nombre d'acheteurs en ligne: 2.71 milliards"
                        ],
                        "trends": [
                            "Intégration ERP-E-commerce en forte demande",
                            "Personnalisation et expérience client prioritaires",
                            "Automatisation des processus métier",
                            "Solutions cloud et API-first"
                        ],
                        "tunisia_context": [
                            "E-commerce tunisien: 180 millions TND (2023)",
                            "Croissance: +25% par an",
                            "Digitalisation PME: 35% seulement",
                            "Opportunité: Solutions locales adaptées"
                        ]
                    }
                },
                {
                    "title": "Problématique - Défis de ZAI",
                    "type": "problem",
                    "content": {
                        "current_situation": [
                            "ZAI: 150+ clients, 12 ans d'expérience",
                            "Demandes e-commerce: +300% (2022-2024)",
                            "Satisfaction client actuelle: 78%",
                            "Processus manuel: 85% des opérations"
                        ],
                        "challenges": [
                            "Absence d'interface e-commerce moderne",
                            "→ Perte de CA estimée: 25%",
                            "Processus de commande manuel inefficace",
                            "→ Temps moyen par commande: 45 min",
                            "Fragmentation des données clients/produits",
                            "→ Taux d'erreur: 12%",
                            "Solutions génériques inadaptées aux besoins",
                            "→ Coût d'adaptation: 15,000 TND"
                        ],
                        "central_question": "Comment développer une solution e-commerce intégrée qui optimise les processus métier de ZAI tout en offrant une expérience client moderne?"
                    }
                },
                {
                    "title": "Présentation de ZAI",
                    "type": "company",
                    "content": {
                        "profile": [
                            "Fondée en 2012 par Zied Abid",
                            "CA 2023: 850,000 TND (+15% vs 2022)",
                            "Croissance moyenne: 18% par an",
                            "Certifications: ISO 9001, Microsoft Partner"
                        ],
                        "market_presence": [
                            "150+ clients actifs",
                            "Taux de satisfaction: 78%",
                            "Taux de rétention: 85%",
                            "Couverture: Tunisie + Maghreb"
                        ],
                        "team_resources": [
                            "12 collaborateurs",
                            "R&D: 20% du budget",
                            "Certifications techniques: 8 experts",
                            "Support 24/7 disponible"
                        ],
                        "expertise": [
                            "ERP Dolibarr: 8 ans d'expérience",
                            "Solutions web: PHP, MySQL, JavaScript",
                            "Secteurs: PME, Commerce, Services",
                            "Intégrations: CRM, Comptabilité, E-commerce"
                        ]
                    }
                }
                # Ajouter les autres diapositives...
            ]
        }
    
    def create_title_slide(self, slide_data):
        """Crée la diapositive de titre"""
        slide_layout = self.prs.slide_layouts[0]  # Layout titre
        slide = self.prs.slides.add_slide(slide_layout)
        
        # Titre principal
        title = slide.shapes.title
        title.text = slide_data["title"]
        title.text_frame.paragraphs[0].font.size = Pt(36)
        title.text_frame.paragraphs[0].font.color.rgb = self.primary_color
        title.text_frame.paragraphs[0].font.bold = True
        title.text_frame.paragraphs[0].alignment = PP_ALIGN.CENTER
        
        # Sous-titre et détails
        subtitle = slide.placeholders[1]
        content_text = slide_data["content"]["subtitle"] + "\n\n"
        content_text += "\n".join(slide_data["content"]["details"])
        subtitle.text = content_text
        
        # Style du sous-titre
        for i, paragraph in enumerate(subtitle.text_frame.paragraphs):
            if i == 0:  # Sous-titre
                paragraph.font.size = Pt(24)
                paragraph.font.color.rgb = self.secondary_color
                paragraph.font.bold = True
            else:  # Détails
                paragraph.font.size = Pt(16)
                paragraph.font.color.rgb = self.text_color
            paragraph.alignment = PP_ALIGN.CENTER
    
    def create_content_slide(self, slide_data):
        """Crée une diapositive de contenu standard"""
        slide_layout = self.prs.slide_layouts[1]  # Layout titre + contenu
        slide = self.prs.slides.add_slide(slide_layout)
        
        # Titre
        title = slide.shapes.title
        title.text = slide_data["title"]
        title.text_frame.paragraphs[0].font.size = Pt(32)
        title.text_frame.paragraphs[0].font.color.rgb = self.primary_color
        title.text_frame.paragraphs[0].font.bold = True
        
        # Contenu
        content_placeholder = slide.placeholders[1]
        
        if slide_data["type"] == "agenda":
            self._fill_agenda_content(content_placeholder, slide_data["content"])
        elif slide_data["type"] == "context":
            self._fill_context_content(content_placeholder, slide_data["content"])
        elif slide_data["type"] == "problem":
            self._fill_problem_content(content_placeholder, slide_data["content"])
        elif slide_data["type"] == "company":
            self._fill_company_content(content_placeholder, slide_data["content"])
        else:
            self._fill_generic_content(content_placeholder, slide_data["content"])
    
    def _fill_agenda_content(self, placeholder, content):
        """Remplit le contenu pour la diapositive agenda"""
        text_content = content["duration"] + "\n\n"
        text_content += "\n".join(content["sections"]) + "\n\n"
        text_content += "Objectifs:\n"
        text_content += "\n".join([f"• {obj}" for obj in content["objectives"]])
        
        placeholder.text = text_content
        self._style_content_text(placeholder)
    
    def _fill_context_content(self, placeholder, content):
        """Remplit le contenu pour la diapositive contexte"""
        text_content = "Statistiques Mondiales:\n"
        text_content += "\n".join([f"• {stat}" for stat in content["statistics"]]) + "\n\n"
        text_content += "Tendances Clés:\n"
        text_content += "\n".join([f"• {trend}" for trend in content["trends"]]) + "\n\n"
        text_content += "Contexte Tunisien:\n"
        text_content += "\n".join([f"• {ctx}" for ctx in content["tunisia_context"]])
        
        placeholder.text = text_content
        self._style_content_text(placeholder)
    
    def _fill_problem_content(self, placeholder, content):
        """Remplit le contenu pour la diapositive problématique"""
        text_content = "Situation Actuelle:\n"
        text_content += "\n".join([f"• {sit}" for sit in content["current_situation"]]) + "\n\n"
        text_content += "Défis Identifiés:\n"
        text_content += "\n".join([f"• {challenge}" for challenge in content["challenges"]]) + "\n\n"
        text_content += f"Question Centrale:\n{content['central_question']}"
        
        placeholder.text = text_content
        self._style_content_text(placeholder)
    
    def _fill_company_content(self, placeholder, content):
        """Remplit le contenu pour la diapositive entreprise"""
        text_content = "Profil Entreprise:\n"
        text_content += "\n".join([f"• {profile}" for profile in content["profile"]]) + "\n\n"
        text_content += "Présence Marché:\n"
        text_content += "\n".join([f"• {market}" for market in content["market_presence"]]) + "\n\n"
        text_content += "Expertise Technique:\n"
        text_content += "\n".join([f"• {expertise}" for expertise in content["expertise"]])
        
        placeholder.text = text_content
        self._style_content_text(placeholder)
    
    def _fill_generic_content(self, placeholder, content):
        """Remplit le contenu générique"""
        if isinstance(content, list):
            text_content = "\n".join([f"• {item}" for item in content])
        elif isinstance(content, dict):
            text_content = "\n".join([f"• {key}: {value}" for key, value in content.items()])
        else:
            text_content = str(content)
        
        placeholder.text = text_content
        self._style_content_text(placeholder)
    
    def _style_content_text(self, placeholder):
        """Applique le style au texte de contenu"""
        for paragraph in placeholder.text_frame.paragraphs:
            paragraph.font.size = Pt(18)
            paragraph.font.color.rgb = self.text_color
            paragraph.space_after = Pt(6)
            
            # Style spécial pour les titres de section
            if not paragraph.text.startswith("•") and paragraph.text.endswith(":"):
                paragraph.font.bold = True
                paragraph.font.color.rgb = self.secondary_color
                paragraph.font.size = Pt(20)
    
    def add_footer(self, slide):
        """Ajoute un pied de page à la diapositive"""
        # Ajouter le logo ZAI et numéro de page
        left = Inches(0.5)
        top = Inches(6.8)
        width = Inches(1)
        height = Inches(0.5)
        
        textbox = slide.shapes.add_textbox(left, top, width, height)
        text_frame = textbox.text_frame
        text_frame.text = "ZAI - Zied Abid Informatique"
        text_frame.paragraphs[0].font.size = Pt(10)
        text_frame.paragraphs[0].font.color.rgb = self.text_color
    
    def generate_presentation(self, output_filename="presentation_pfe_zai.pptx"):
        """Génère la présentation complète"""
        print("🚀 Génération de la présentation PFE en cours...")
        
        # Créer les diapositives
        for i, slide_data in enumerate(self.slide_data["slides"]):
            print(f"📄 Création de la diapositive {i+1}: {slide_data['title']}")
            
            if slide_data["type"] == "title":
                self.create_title_slide(slide_data)
            else:
                self.create_content_slide(slide_data)
            
            # Ajouter le pied de page (sauf pour la page de titre)
            if slide_data["type"] != "title":
                self.add_footer(self.prs.slides[-1])
        
        # Sauvegarder
        self.prs.save(output_filename)
        print(f"✅ Présentation créée avec succès: {output_filename}")
        print(f"📊 Nombre de diapositives: {len(self.prs.slides)}")
        
        return output_filename
    
    def generate_speaker_notes(self, output_filename="speaker_notes.md"):
        """Génère les notes de présentation"""
        notes_content = "# Notes de Présentation - PFE ZAI\n\n"
        notes_content += "## Conseils Généraux\n"
        notes_content += "- Maintenir le contact visuel avec le jury\n"
        notes_content += "- Parler clairement et à un rythme modéré\n"
        notes_content += "- Utiliser des exemples concrets\n"
        notes_content += "- Préparer des réponses aux questions techniques\n\n"
        
        for i, slide_data in enumerate(self.slide_data["slides"]):
            notes_content += f"## Diapositive {i+1}: {slide_data['title']}\n"
            notes_content += f"**Durée recommandée**: 1-2 minutes\n\n"
            notes_content += "**Points clés à mentionner**:\n"
            
            if slide_data["type"] == "title":
                notes_content += "- Se présenter et remercier le jury\n"
                notes_content += "- Annoncer la structure de la présentation\n"
                notes_content += "- Mentionner la durée et les questions\n"
            else:
                notes_content += "- [Adapter selon le contenu de la diapositive]\n"
            
            notes_content += "\n---\n\n"
        
        with open(output_filename, 'w', encoding='utf-8') as f:
            f.write(notes_content)
        
        print(f"📝 Notes de présentation créées: {output_filename}")

def main():
    """Fonction principale"""
    print("🎯 Générateur de Présentation PFE - ZAI E-commerce Platform")
    print("=" * 60)
    
    # Créer le générateur
    generator = PFEPresentationGenerator()
    
    # Générer la présentation
    pptx_file = generator.generate_presentation()
    
    # Générer les notes
    generator.generate_speaker_notes()
    
    print("\n🎉 Génération terminée avec succès!")
    print(f"📁 Fichiers créés:")
    print(f"   - {pptx_file}")
    print(f"   - speaker_notes.md")
    print("\n💡 Prochaines étapes:")
    print("   1. Personnaliser les informations [Votre Nom], [Votre Université], etc.")
    print("   2. Ajouter des images et diagrammes")
    print("   3. Réviser le contenu technique")
    print("   4. Pratiquer la présentation")

if __name__ == "__main__":
    main()