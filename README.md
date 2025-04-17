# Flexbox-/Grid-Layout System (kompatibel mit Bootstrap)

> [!NOTE]  
> In Verison 3.2 wurden die alten Legacy-Elemente entfernt.

Dieses Bundle erweitert Contao um Content-Elemente zum Erzeugen von Flexbox Layouts auf Basis von Booststrap-Klassen [Bootstrap 5](https://getbootstrap.com). Durch ein öffnendes Element wird ein Layout gestartet und die Spalten Konfiguriert. Alle Content-Elemente innerhalb des Layouts werden dann in ein DIV verpackt und mit den entsprechenden CSS-Klassen ausgegeben.

**Im Seitenlayout muss das JavaScript-Template js_flexbox aktiviert werden (dient nur dazu das CSS-Framework zuladen, beinhaltet kein JavScript), alternativ kann das Bootstrap Framework geladen werden.**


## Dokumentation Flex-Layout

### 1. Stelle: Sichtbarkeit (optional)
```
h, hide		Blendet eine Zelle aus.  
s, show		Blendet die Zelle ein.
```
#### Bespiele:
```
 XL: 4:4:4:h 		letzte Zelle wird ausgelbendet
XXL: 3:3:3:3:s,3 	letzte Zelle wird wieder eingeblendet
```
### 2. Stelle: Breite
```
1 - 12		Anzahl der Spalten über die sich die Zelle erstreckt.
a, auto		Breite der Zelle richtet sich nach dessen Inhalt.
n, none		Ohne Breiten Angabe, alle Zellen in einer Zeile sind gleich breit.
```
### 3. Stelle: Versatz (optional)
```
0 - 12		Versatz vor der Zelle über Anzahl der 12 Spalten.
```
#### Bespiele:
```
MD: 8,2		alle Zellen werden mittig ein drittel der Breite angezeigt  
XL: 6		alle Zellen werden nebeneinander angezeigt
```
### 4. Stelle: Position bzw. Order (optional)
```
f, first	Positioniert die Zelle an den Anfang.  
l, last		Positioniert die Zelle an das Ende.  
0 - 5		Positioniert die Zelle an die angegeben Position.
```
#### Bespiele:
```
MD: 6,,1:6,,2:6,,4:6,,3		die dritte und vierte Zelle werden vertauscht  
XL: 3,,0			die Zellen sind wieder in der normalen Reihenfolge
```


## Dokumentation Grid-Layout
### 1. Stelle: Sichtbarkeit (optional)
```
h, hide	Blendet eine Zelle aus.  
s, show	Blendet die Zelle ein.
```
### 2. Stelle: Spalte \$START / \$BREITE
```
$START: 1-12		Postition von links in der die Zelle beginnt. (optional)
$START: a		Postition zurücksetzten. (optional)
$BREITE: 1-12		Anzahl der Spalten über die sich die Zelle erstreckt.
```
`
Beide angabgen werden durch ein / getrennt:	grid-column: $START / span $BREITE
`
### 3. Stelle: Zeile \$START / \$HÖHE
```
$START: 1-12		Postition bon oben in der die Zelle beginnt. (optional)
$START: a		Postition zurücksetzten. (optional)
$HÖHE: 1-12		Anzahl der Zeilen über die sich die Zelle erstreckt.
```
`
Beide angabgen werden durch ein / getrennt:	grid-row: $START / span $HÖHE
`
### 4. Stelle: Position bzw. Order (optional)
```
f, first	Positioniert die Zelle an den Anfang.  
l, last		Positioniert die Zelle an das Ende.  
0 - 5		Positioniert die Zelle an die angegeben Position.
```

## Breite der Spalten:
![](doc/overview-colmns.png)
