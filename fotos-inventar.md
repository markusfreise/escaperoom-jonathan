# Foto-Inventar Escape-Room „Jonathan“ – Neubau mit Magnific

Alle Bilder, die im Raum vorkommen oder in Chats erwähnt werden, mit Fundstelle und Motiv als Vorlage für den Neubau. Pfade relativ zu `www/images/`. Hintergrund zur Figur: `charakter-jonathan.md`.

## Grundregeln für den Neubau

1. **Drei Bildsorten, drei Werkzeuge.**
   - **Fotos** (Selfies, Orte, Personen) → Magnific.
   - **Text-Bilder** (Zeitungsartikel, Statistiken, Tweets, Text-Memes) → als Layout in HTML/Figma bauen. Magnific höchstens für das Foto im Artikel.
   - **GIF/Video-Memes** → aus eigenem Material oder lizenzfreien Clips. Magnific-Video nur für einfache Clips.
2. **Keine echten Personen, Sender, Medien oder Figuren.** Aktuell enthalten: Markus Lanz/ZDF, ein NDR-Tweet, Neil Patrick Harris, Mr. Bean, eine Yakuza-Spielfigur, der Monopoly-Mann, BKA-Grafiken. Ersatz durch fiktive Talkshow, fiktiven Sender, fiktive Zeitung („Stadtanzeiger“, Kanon) und fiktive Behörde. Ausnahme: historische NS-Figuren wie Hitler (siehe Grundregel 3).
3. **NS-Bezüge sind Lerninhalt und bleiben drin.** Der Raum ist ein Bildungsangebot; Kennzeichen verfassungswidriger Organisationen dürfen zur staatsbürgerlichen Aufklärung gezeigt werden (§ 86a Abs. 3 i. V. m. § 86 Abs. 4 StGB). Das betrifft `Bild_1.png` (Hitler-Meme „SS-KALIERT GLEICH“) und die schwarze Sonne. Umsetzung:
   - **Historische Personen nicht generieren, sondern Archivfotos nehmen.** Für das Hitler-Meme ein gemeinfreies oder frei lizenziertes Archivfoto (z. B. Bundesarchiv auf Wikimedia Commons, Lizenz und Bildnachweis prüfen). Echte Propaganda-Memes arbeiten genauso, und KI-Generatoren lehnen solche Motive meist ab.
   - **Text als Layout-Ebene** darüberlegen („SS-KALIERT GLEICH“, Video-Zeitstempel, Wasserzeichen), nicht generieren.
   - **Rahmen sichern**: Das Material ist nur im Spiel im Kontext zu sehen; die Nachbesprechung sollte Codes wie „SS-kaliert“, schwarze Sonne und „Reconquista“ aufgreifen. Die Repos nicht öffentlich schalten.
4. **Gleiche Gesichter durchziehen.** Jonathan (16), Fritz (10), Steffen, Siggi, die Eltern: erst Referenzbilder bauen, dann alle Varianten daraus. Aktuell sind mehrere Avatare doppelt belegt (siehe Abschnitt 5).

## 1. Chat-Bilder (`images/chats/`)

### Propaganda und „News“ im Vereins-Chat und bei Papa
| Datei | Wo | Aktuell | Neu bauen | Art |
|---|---|---|---|---|
| `Bild_20.jpg` | WhatsChat Papa Tag 60, Only Good Vibes Tag 137 | Zeitungsausriss „Stadtverwaltung kündigt Bau einer neuen Geflüchtetenunterkunft an“ (01.03.2024) mit Plattenbau-Foto | Artikel im Layout des fiktiven Stadtanzeigers; Foto: frisch sanierter Wohnblock mit Bauzaun (Magnific) | Layout + Foto |
| `Bild_7.jpg` (= `Bild_07.jpg`) | WhatsChat Papa, Tag 93 („Dieser Mann ist so klug“) | Markus-Lanz-Screenshot „zerlegt naive linke Migrationspolitik“ | Screenshot einer fiktiven Talkshow, fiktiver Moderator, Clickbait-Titel | Layout + Foto (Studio) |
| `Bild_9.png` | Familiengruppe, Tag 43 („Klimakleber“) | Schlagzeile „Klima-Chaoten möchten Polizeieinsätze nicht bezahlen“ mit Polizeifoto | Boulevard-Schlagzeile + Foto: Polizei löst Straßenblockade auf (Magnific, Gesichter unkenntlich) | Layout + Foto |
| `Bild_1.png` | Rechter Haken, Tag 125 | Hitler-Bild (Redepose) mit „SS-KALIERT GLEICH“, Video-Zeitstempel 12:58 | Archivfoto Hitler in Redepose + Text- und Video-Player-Ebene im Layout; Wortspiel SS/eskaliert ist der Lerninhalt | Archivfoto + Layout |
| `Bild_3.png` | Rechter Haken Tag 125, Only Good Vibes Tag 138 | Meme „Ich habe einen guten Draht zu Flüchtlingen“ (Stacheldraht, verpixelte Menschen) | Rassistisches Text-Meme bewusst erkennbar menschenverachtend; Hintergrund: Stacheldraht ohne Personen | Layout + Foto |
| `Bild_22.png` (= `Statistik_1.png`) | Rechter Haken Tag 127, Only Good Vibes Tag 127 | BKA-Infografik „Allgemeinkriminalität“ | Fiktive Behördengrafik mit Prozentwerten | Layout |
| `Bild_23.png` (= `Statistik_2.png`) | Rechter Haken, Tag 127 | BKA-Balkendiagramm Rohheitsdelikte | Fiktives Balkendiagramm | Layout |
| `Bild_28.png` | Rechter Haken, Tag 127 („aber die sind alle friedfertig!“) | Schlagzeile Gruppenvergewaltigungen Berlin | Fiktive Schlagzeile, ohne reale Stadt | Layout |
| `Bild_30.png` (= `Bild_6.png`) | Rechter Haken, Tag 127 | Schlagzeile „18-Jährige vergewaltigt“ | Fiktive Schlagzeile | Layout |
| `Bild_5.jpg` | Rechter Haken, Tag 127 (Lia) | Tweet an @ndr | Fiktiver Post auf fiktiver Plattform an fiktiven Sender | Layout |
| `Bild_24.png` | Rechter Haken, Tag 143 („Jon hats geschafft“) | Zeitungsmeldung „Radikale Botschaft“ mit Foto der schwarzen Sonne an Backsteinschule | Artikel im Stadtanzeiger-Layout; Foto: schwarzes Graffiti-Symbol an Realschul-Backsteinwand, Absperrband (Magnific) | Layout + Foto |
| `Bild_4.jpg` | Rechter Haken, Tag 146 | Wojak/Chad-Meme „Multikulturalismus zerstört Kulturen“ | Eigenes Zwei-Figuren-Meme im Strichstil | Grafik |
| `Bild_25.jpg` (= `Bild_6.jpg`, `Bild_8.jpg`, `Statistik_3.jpg`) | Rechter Haken, Tag 149 | Text-Post „Die Asylzahlen sinken um etwa die Hälfte!“ mit Deutschlandflagge | Text-Post im Telegram-Kanal-Stil | Layout |
| `Bild_26.jpg` | Rechter Haken, Tag 169 (Lia: „sogar was in der Zeitung“) | Artikel „Polizei untersucht Angriff auf Obdachlosen“ mit Foto einer Matratze und Decke | Stadtanzeiger-Artikel; Foto: Schlafplatz mit Matratze in Unterführung, kein Mensch (Magnific) | Layout + Foto |
| `Bild_27.jpg` (= `Statistik_5.jpg`) | Rechter Haken, Tag 171 | Tabelle Messergewalt nach Nationalität | Fiktive Tabelle | Layout |
| `Statistik_4.png` | nicht verwendet | Schlagzeile Gruppenvergewaltigungen | entfällt (Duplikat-Thema zu `Bild_28`) | – |

### Memes, Videos, Sprachnachrichten
| Datei | Wo | Aktuell | Neu bauen |
|---|---|---|---|
| `Meme_1.mp4` | WhatsChat Fritz, Tag 54 | Lachendes Baby „HAHAHAA“ | Eigener Clip / lizenzfreies Lach-GIF |
| `Meme_3.mp4` | WhatsChat Fritz, Tag 54 (Jonathan: „ich zieh dich ab“) | Mr. Bean winkt „HEY LOSER“ (echte Person) | Eigener „Hey Loser“-Clip mit fiktiver Figur |
| `Meme_4.mp4` | WhatsChat Fritz, Tag 107 | Monopoly-Mann tanzt | Fiktiver Spielfigur-Tanz |
| `Meme_5.mp4` (+ Duplikat `Meme_5 copy.mp4`) | WhatsChat Emilia, Tag 62 („Hausaufgabe verpennt“) | Neil Patrick Harris im Hörsaal | Schüler zuckt mit den Schultern, Klassenzimmer |
| `Meme_6.mp4` | WhatsChat Fritz, Tag 50 („Pizza“) | Pizzabäcker wirft Teig | Kann ähnlich bleiben (lizenzfrei) |
| `Meme_7.mp4` | WhatsChat Tom, Tag 75 | Baby „LET'S GOOOO“ (Eishockey-Trikot) | Lizenzfreies Jubel-Meme |
| `Meme_8.mp4` | SafeChat Florian, Tag 121 | Yakuza-Figur „It Is Gaming Time“ | Eigener „Gaming Time“-Clip |
| `Video_1.mp4` | Clan-Chat Siggi, Tag 201 | Hand dreht Zahlenschloss (ABUS) | **Rätselrelevant**: muss das echte Schloss im Raum zeigen – neu filmen, nicht generieren |
| `Sprachnachricht_1–4, 22–24.ogg` | Mama, Familie, Siggi, Only Good Vibes | Audio | Kein Foto – ggf. neu einsprechen |

## 2. Selfie-Posts (`images/chats/Selfie1–19.jpg`, Captions in `Selfie Jonathan.xlsx`)

`images/selfie/Selfie1–16.jpg` sind identische Kopien von `images/chats/Selfie1–16.jpg`.

| Datei | Caption | Aktuell | Neu bauen | Hinweis |
|---|---|---|---|---|
| `Selfie1` | „Es gibt immer einen neuen morgen“ | Faust vor Sonnenuntergang | Jonathans Faust gegen Abendhimmel | Frühes Radikalisierungssignal |
| `Selfie2` | „Neuer Style, neues Ich“ #stark | Glatzköpfiger junger Mann mit Lach-Emojis | **Jonathan (16) mit frisch rasiertem Kopf**, Spiegel-Selfie, Badezimmer | Aus Referenzbild Jonathan |
| `Selfie3` | „Konzerte auf der Birkenwiese“ | Open-Air-Konzert, Sänger mit Mikro | Open-Air-Bühne auf einer Wiese, Menge von hinten, keine Bandlogos | |
| `Selfie4` | „Mal wieder Pizza zum Abendessen“ #familie | Pizza mit Spinat | Tiefkühlpizza auf Backblech, Küchentisch | Bezug: Eltern nie da |
| `Selfie5` | „Wer hat den Scheiß gemacht?“ #nichtcool | Klippenspringer mit Mittelfinger-Emoji | **Motiv passt nicht**: Foto der schwarzen Sonne an der Schulwand, gespielt empört | Nach Tag 142 |
| `Selfie6` | „Wird ja immer bunter hier“ #Flüchtline | Zeitungsartikel Geflüchtetenunterkunft | Artikel-Ausschnitt wie `Bild_20` | Layout |
| `Selfie7` | „Bin von der Klippe gesprungen“ #Mut | Klippensprung über See | Jonathan springt von Felsen in den See (Rückenansicht), Sommer | |
| `Selfie8` | „War heute wieder am See“ | See mit Wald, blauer Himmel | Badesee mit Steg, Clique unscharf im Hintergrund | |
| `Selfie9` | „Kumpel hat … beim Training gemacht“ | Profiboxer im Ring | Amateurtraining im alten Stellwerk: Jonathan am Sandsack, Backsteinhalle | Ort Kanon |
| `Selfie10` | „Heute Konzert“ | Konzertpublikum, Bühnenlicht | Kleiner Club, Menge von hinten | |
| `Selfie11` | „Erstes Mal beim Boxtraining“ | Rosa Boxhandschuhe auf Beton | Abgenutzte Leih-Boxhandschuhe auf Hallenboden | |
| `Selfie12` | „Noch ein Schnappschuss“ #fußball | Handy filmt Stadion | Handy filmt Amateurfußballplatz | |
| `Selfie13` | „Stadion muss“ | Großes Stadion | Stehplatztribüne, Fahnen ohne Vereinslogos | |
| `Selfie14` | „Ein Tag am See ist immer ein guter Tag“ | See bei Sonnenuntergang | Gleicher See, Abendstimmung | |
| `Selfie15` | „Heute starkes Spiel (wurde nicht eingesetzt)“ | Profifußball, blau gegen orange | Kreisliga-Spiel, Blick von der Ersatzbank | Kernschmerz |
| `Selfie16` | „War heute mal mit meinen Eltern aus“ | Lächelndes Porträt (= Jonathans Avatar) | Restaurant-Tisch mit drei Tellern, seltener Familienabend | |
| `Selfie17` (Feed box_ring) | Löwen-Spruch #löwe #stark | Löwenkopf | Löwe vor Schwarz | Kann bleiben |
| `Selfie18` (Feed Emilia) | „Was war das letzte, über das ihr glücklich wart?“ | Junge Frau am Zaun | Emilia, 16 – **muss zum Avatar `emilia.jpg` passen** (aktuell zwei verschiedene Personen) | |
| `Selfie19` (Feed Ali) | „Tag erstmal gut starten“ | Frühstücks-Sandwich | Frühstück, kann bleiben | |

## 3. In Chats erwähnt, aber ohne Bild
| Wo | Erwähnung | Vorschlag |
|---|---|---|
| Only Good Vibes, Tag 135 | „was sind das für Posts auf Instagram?“ | Die Selfie-Posts 9/11 decken das ab |
| Rechter Haken, Tag 125 | Video mit Jens Meier | Optional: Screenshot eines Video-Thumbnails im Layout |
| Rechter Haken, Tag 144 | Lias Reel zu „Frauen im Islam“ | Optional: Reel-Thumbnail (Backvideo-Look) als Layout |
| E-Mail Schulleitung, Tag 142 | „Die Polizei hat bereits Bilder des Graffitis veröffentlicht“ | Gleiches Foto wie in `Bild_24` verwenden |
| SafeChat Steffen, Tag 191 | „Buch“ im Boxspint | Requisite im Raum, kein Bild nötig |

## 4. Avatare (`images/avatars/`)

| Datei | Figur | Aktuell | Neu bauen |
|---|---|---|---|
| `me.jpg`, `jonathan.jpg`, `jonathan.png` | Jonathan | Lächelnder Teenager im Pulli (= `Selfie16`) | **Referenzbild Jonathan**: 16, mittelblond, früher lockiger, später Glatze (`Selfie2`) |
| `fritz.jpg` | Fritz | 3D-Comicfigur mit Headset | Fritz, 10, Comic-Avatar kann bleiben – oder Foto mit Familienähnlichkeit |
| `mama.jpg` | Anette | Orange Blüten | Kann bleiben |
| `papa.jpg` | Werner | Glatzköpfiger Mann grillt (KI) | Werner, 49, Arbeitskleidung – kann bleiben, wenn stimmig |
| `steffen.jpg` | Steffen | Blonder Boxer von hinten | Steffen, Anfang 20, Rückenansicht im Stellwerk |
| `siggi.jpg` | Siggi | Boxring mit **Deutschlandfahne** | Kann bleiben |
| `rechterhaken.jpg` | Gruppe | Logo rote und weiße Boxhandschuhe | Kann bleiben |
| `andreas.jpg` | Andreas | Maskierter Gamer (**gleiches Bild wie Alex in Emma/Tom**) | Eigenes Motiv |
| `tobias.jpg` | Tobias | Junge im Kapuzenpulli (**gleiches Bild wie Niklas in Emma/Tom**) | Eigenes Motiv |
| `lia.jpg` | Lia | Volleyballerin (**gleiches Bild wie Emmas Trainerin**) | Backen-Influencerin, Mehl auf Händen, ca. 20 |
| `florian.jpg`, `markus.jpg` | Kameraden | Teenager-Porträts | Eigene Motive, junge Männer 18–22 |
| `matheo.jpg` | Matheo | Fußball auf Rasen | Kann bleiben |
| `aleyna.jpg` | Aleyna | Mädchen mit Kopftuch, Selfie | Aleyna, 16 – passt |
| `hamid.jpg` | Hamid | Junge vor Bus | Hamid, 16 – passt |
| `kathrin.jpg` | Kathrin | Rothaarige mit Sommersprossen | Kann bleiben |
| `emilia.jpg` | Emilia | Blonder Bob mit Rucksack | An `Selfie18` angleichen |
| `emma.jpg` | Emma | Blonde junge Frau (= Emma-Raum) | Referenzbild Emma, aber 16 statt 14 (andere Welt) – oder eigene Figur |
| `tom.jpg` | Tom | Junger Mann mit blonden Locken und Mütze | Eigene Figur (anderer Tom als im Tom-Raum) |
| `karsten.jpg` | Karsten Wegener | Lehrer mit Brille im Klassenzimmer | Kann bleiben (ca. 45 laut Mail: Jahrgang ~1978) |
| `schulleitung.jpg` | Schulleitung | **US-Highschool** („Sherman High School“) | Deutsche Realschule, Backsteinbau (passt zu `Bild_24`) |
| `only-good-vibes.jpg` | Gruppe | See | Kann bleiben |
| `selfie.jpg` | Selfie Support | App-Icon | Bleibt |

## 5. Aufräumen
- Doppelte Dateien: `Bild_7.jpg` = `Bild_07.jpg`, `Bild_25.jpg` = `Bild_6.jpg` = `Bild_8.jpg` = `Statistik_3.jpg`, `Bild_30.png` = `Bild_6.png`, `Bild_22.png` = `Statistik_1.png`, `Bild_23.png` = `Statistik_2.png`, `Meme_5.mp4` = `Meme_5 copy.mp4`, `images/selfie/` = `images/chats/Selfie1–16`.
- `Selfie Jonathan.xlsx` liegt im Webordner `images/chats/` und wird mit ausgeliefert.
