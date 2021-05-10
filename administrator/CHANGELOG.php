<?php
/**
 * @version     3.15.0
 * @package     com_einsatzkomponente
 * @copyright   Copyright (C) 2017 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@mail.de> - https://einsatzkomponente.de
 */
 ?>

<?php defined('_JEXEC') or die(); ?>
<h1>Einsatzkomponente für das Joomla-CMS</h1>

<h3>Changelog <small>Version 3.50</small></h3>
<ul>
# Filtersortierung im Front-und Backend nach Reihenfolge bzw. Namen
# Fehlerhafte Anzeige der OSM-KArte in in der Übersicht behoben
# diverse kleinere Bugfixes
</ul>

<h3>Changelog <small>Version 3.43</small></h3>
<ul>
# diverse kleinere Bugfixes
# Fehler beim Sperren und Veröffentlichen in der Einsatzübersicht behoben
+ Anzeige der Einsatznummer in der Detailansicht
# Fehler in Kartenzentrierung (OSM) behoben (in der View Gmap-Konfig.)
# Einsatzorte nur für registr. User anzeigen -> Einsatzübersichts-Karte
</ul>

<h3>Changelog <small>Version 3.42</small></h3>
<ul>
# SQL-Fehler unter MySQL8 behoben
# RSS-Feed Bug behoben
+ Optionaler Emailinfotext bei Automatischer Mailbenachrichtigung
+ Temporär Auto-Emailfunktion abschaltbar
</ul>

<h3>Changelog <small>Version 3.40</small></h3>
<ul>
# kleine Bugfixes
</ul>

<h3>Changelog <small>Version 3.30</small></h3>
<ul>
# Updateserver erneuert
# Bugfix Detaillink in der Einsatzkarte
# Detail-Layout 3 bei Einsatzberichten geändert 
</ul>

<h3>Changelog <small>Version 3.22</small></h3>
<ul>
+ OSM-Karten hinzugefügt
</ul>

<h3>Changelog <small>Version 3.21</small></h3>
<ul>
# State-Problem ab Joomla 3.9.1 behoben
+ Readmore-Funktion in Ausrüstung-Ansichten 
# alle Einsatzorte auf Einsatzübersichtskarte
# Überlagerung Pagination
# Bug in der Übersicht-Pagination behoben
</ul>

<h3>Changelog <small>Version 3.20</small></h3>
<ul>
# Bug durch Update auf Joomla 3.8.4 (Übersichtsbutton,Filter,...)
# Entferne alte Einsatzbericht-Optionen (mttronc)
# Organisation-Filter (Placeholder) im Einsatzarchiv (mttronc)
# überarbeitete Monatsnamenerzeugung (mttronc)
# Joomla-Artikel Intro-Text wurde doppelt angezeigt
# Joomla-Artikel aus Frontend erstellen (Option-Bug)
# Detail_Layout4 Socialbuttons MyShariff
</ul>

<h3>Changelog <small>Version 3.18</small></h3>
<ul>
# Die alte Einsatzübersicht wird nicht mehr unterstützt !
# exportierter Joomla-Artikel war trotz abwählter Option immer Haupteintrag
# exportierter Joomla-Artikel wird bei Bearbeitung des Einsatzberichtes geupdatet 
# Fehlerhafter Image-Upload seit J!3.8.2
# PDF Zeilenumbruch bei Organisationen und Fahrzeugen
+ System-Read more in Artikelexport hinzugefügt
# Fehler Frontendeintrag,-bearbeitung: fehlende Organisationen
# Option Streckenverlauf Farbe der Auswahlbuttons rot-grün
</ul>

<h3>Changelog <small>Version 3.17</small></h3>
<ul>
+ Presselinkinfo in Übersicht als Icon möglich
+ Fahrzeugübersicht: Anzeige nach Organisation möglich
# Einsatz im Frontend eintragen unter PHP7.1
# Fahrzeugübersicht: Ausser Dienst gestellte FHZ konnten nicht gefiltert werden
# Fahrzeugübersicht: Ausser Dienst gestellte FHZ wurden nicht angezeigt
+ Menüpunkte: Detailansicht Organisation + Einsatzfahrzeug
+ Optionen: Pre-Selektion Auswahlfeld Organisation im Einsatzbericht
+ Einsatzberichte: Erstellt von / Bearbeitet von
+ Option Einsatzbericht-Text anzeigen
# Filterauswahl Jahre im Einsatzarchiv
# Bootstrap-Tooltips in Einsatzarchiv entfernt
# Fehler Pagination+Nummerierung (alte Einsatzübersicht)
# Fehler behoben "Warning getimagesize"
</ul>

<h3>Changelog <small>Version 3.16</small></h3>
<ul>
# Action-Buttons im Einsatzarchiv funktionieren jetzt
# Berechtigungen im Einsatzarchiv korrigiert
# gelöschte Einsatzkategorien wurden beim Update wieder neu angelegt
# Erstellte Joomla-Artikel können jetzt geupdatet werden
+ Mehrfachauswahl Organisation im Menüfilter (Einsatzarchiv)
# Joomla-Artikel erstellen
+ Bild-Kommentar in Bild-Info geändert
+ Kurzinfo in Layouts des Einsatzarchives
# Option: Einsatzart -> Ausschluss aus Nummerierung der Einsätze
# Datum bei der Json-Ausgabe korrigiert
# Organisations-und Einsatzlinks aus Fahrzeugübersicht
# Fahrzeug-und Einsatzlinks aus Organisationübersicht
# Organisation-und Fahrzeuglinks aus Einsatzdetailansicht
+ Option Menüpfade hinterlegen
+ Bootstrap Option: Joomla oder Eiko
+ Auswahl Fahrzeuge (alle) pro Orga in EinsatzEdit
+ Wasserzeichen kann im Einsatzbericht-EDIT gesetzt werden
# Wasserzeichen-Position korrigiert
# Wasserzeichen-Pfad geändert
# Code für JED-Extensions-Eintrag bereinigt
- Flash SWF-Bilduploader (nicht notwendig)
# Ersatzbild in Einsatzarchiv und detail_layout_1
# Fehler: OSM-Karte funktioniert jetzt auch bei SSL-Verbindung
# Fehler: Pagination (Seitenwahl) in Einsatzübersicht (alt)
</ul>

<h3>Changelog <small>Version 3.14</small></h3>
<ul>
# Fehler: 0[]operator not supported for strings PHP7.1 behoben
+ Option: Listenlänge Einsatzüberisicht
+ Option: Standardbild für Facebook-Teilen auswählbar
+ Option: Einsatzart -> Ausschluss aus Nummerierung der Einsätze
- Social-Button wurden entfernt ! Alternativ Plugin: https://joomla-agentur.de/joomla/downloads/jooag-shariff-plugin
+ Sprache "Englisch" hinzugefügt.
+ Sprachvariabeln komplett überarbeit
+ JSON-VIEW für Einsatzarchiv-Übersicht hinzugefügt
+ RSS-Feed für Einsatzarchiv-Übersicht hinzugefügt
# Bootstrap CSS + JS werden jetzt direkt aus Joomla verwendet
+ main_layout_3 für Einsatzarchiv hinzugefügt
+ Optionen Fahrzeugübersicht
+ Einsatzkarte (alle oder nur aktuelles Jahr anzeigen)
# Created-by-Filter im Einsatzbildmanager (Danke an mttronc)
# Google-Api-Key bei Einsatz-Edit im Frontend eingesetzt.
+ Einsatzdauer in detail_layout_1 und 4 hinzugefügt. (Danke an r4id)
# eingesetzte Fahrzeuge als Textaufzählung in detail_layout_4 korrigiert
+ Detailbutton in Einsatzübersicht main_layout_4 hinzugefügt
</ul>

<h3>Changelog <small>Version 3.13</small></h3>
<ul>
+ Einsatzkarte in Übersicht -Einsatzarchiv- hinzugefügt.
+ Anzeige Beladung in Fahrzeug-Detailansicht
+ Einsatzbericht im Frontend kopieren
+ Info zu Pressebericht in Einsatzübersicht
# externer Link in Organisations-Detailansicht korrigiert
# Alle im entsprechenden Verzeichniss vorhandene Wasserzeichen werden jetzt aufgelistet
# Fehler in der Sortierung nach Counter-Anzahl behoben
- neue bootstrap.min.css V3.3.7 (bringt zu viele Layoutfehler)
# Fatal error: Call to a member function getData() in Fahrzeug-und Organisationsdetail
# Senden-Button beim Frontend-Einsatzfahrzeug-Edit hinzugefügt
# User-Berechtigung EINSATZ ANLEGEN korrigiert. edit-create
# Joomla-Artikel-Export -> Detailansicht -> Übersicht Link repeariert
+ fehlende index.html's im Frontend hinzugefüg
+ neue bootstrap.min.css V3.3.7 hinzugefügt
+ GoogleApiKey für Maps hinzugefügt
# Links zu GoogleMaps geändert
+ Einsatznummern in der Einsatzübersicht
# Backend-Übersichten Filter repariert 
# Auswahl der Optionen bearbeitet
+ Entfernungsanzeige unter der Karte im Detail-Layout4 hinzugefügt
# diverse kleinere Änderungen im Detail-Layout4 
- Jahreszahl-Image aus Detail-Layout4 entfernt
# weitere diverse kleinere Änderungen 

</ul>
