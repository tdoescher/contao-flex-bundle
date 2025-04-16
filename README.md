# Flexbox-/Grid-Layout System (kompatibel mit Bootstrap)

> [!NOTE]  
> In Verison 3.2 wurden die alten Legacy-Elemente entfernt.

Dieses Bundle erweitert Contao um Content-Elemente zum Erzeugen von Flexbox Layouts auf Basis von Booststrap-Klassen [Bootstrap 5](https://getbootstrap.com). Durch ein öffnendes Element wird ein Layout gestartet und die Spalten Konfiguriert. Alle Content-Elemente innerhalb des Layouts werden dann in ein DIV verpackt und mit den entsprechenden CSS-Klassen ausgegeben.

**Im Seitenlayout muss das JavaScript-Template js_flexbox aktiviert werden (dient nur dazu das CSS-Framework zuladen, beinhaltet kein JavScript), alternativ kann das Bootstrap Framework geladen werden.**

## Dokumentation Flex-Layout

### Wert 1: Sichtbarkeit (optional)

**h/hide:**			Blendet eine Zelle aus.  
**s/show:**			Blendet die Zelle ein.

```
Breakpoint XL:	4:4:4:h 		letzte Zelle wird ausgelbendet
Breakpoint XXL:	3:3:3:3:s,3 		letzte Zelle wird wieder eingeblendet
```

### Wert 2: Breite

**a/auto:**			Breite der Zelle richtet sich nach dessen Inhalt. (nur für Flex)
**n/none:**			Ohne Breiten Angabe, alle Zellen in einer Zeile sind gleich breit. (nur für Flex)
**1-12:**			Anzahl der Spalten über die sich die Zelle erstreckt.

### Wert 3: Versatz (optional)

**0-12:**			Versatz vor der Zelle über Anzahl der 12 Spalten.

```
Breakpoint MD:	8,2		alle Zellen werden mittig ein drittel der Breite angezeigt  
Breakpoint XL:	6		alle Zellen werden nebeneinander angezeigt
```

### Wert 4 für: Position (optional)

**f/first:**		Positioniert die Zelle an den Anfang.  
**l/last:**			Positioniert die Zelle an das Ende.  
**0-5:**			Positioniert die Zelle an die angegeben Position.

```
Breakpoint MD:	6,,1:6,,2:6,,4:6,,3		die dritte und vierte Zelle werden vertauscht  
Breakpoint XL:	3,,0				die Zellen sind wieder in der normalen Reihenfolge
```

## Dokumentation Grid-Layout

### Wert 1: Sichtbarkeit (optional)

**h/hide:**			Blendet eine Zelle aus.  
**s/show:**			Blendet die Zelle ein.

```
Breakpoint XL:	4:4:4:h 		letzte Zelle wird ausgelbendet
Breakpoint XXL:	3:3:3:3:s,3 		letzte Zelle wird wieder eingeblendet
```

### Wert 1: Breite ___ ***( grid-col: auto / span $WERT )***

**1-12:**			Anzahl der Spalten über die sich die Zelle erstreckt.

### Wert 2: Spalte Start ___ ***( grid-col: $WERT / span 2 )*** (optional)

**1-12:**			Spaltennummer wo die Zelle beginnt.
**a**				Set diesen wert auf auto / reset.

### Wert 3: Höhe ___ ***( grid-row: auto / span $WERT )*** (optional)

**1-12:**			Anzahl der Zeilen über die sich die Zelle erstreckt.

### Wert 4: Zeilen Start ___ ***( grid-row: $WERT / span 2 )*** (optional)

**1-12:**			Positioniert die Zelle an die angegeben Position.
**a**				Set diesen wert auf auto / reset.

## Breite der Spalten:

![](doc/overview-colmns.png)
