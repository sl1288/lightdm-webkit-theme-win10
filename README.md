# Win10 for LightDM

Änderungen gegenüber Xseba360/lightdm-webkit-theme-win10:  

* Übersetzung auf Deutsch
* Unterstützung von anderen Auflösungen als 1366x768 
* Entfernen unnötiger Symbole (Netzwerk, Bedienhilfen)
* Liste der User wird von einer Web-API abgerufen
* Zuletzt ausgewählter User wird über Web-API abgespeichert
  
  
Folgendes muss vor Verwendung angepasst werden:  

* Im Ordner 'font' muss 'SEGUISYM.TTF' abgelegt werden
* In 'main.js' den String 'http://XXX.XXX.XXX.XXX:8888' durch den Host des Backend Systems ersetzen
* Im Ordner 'php' befindet sich eine mögliche Implementierung für den Backend Service, in dieser die IP, Zugangsdaten zum LDAP Server und die Gruppe angeben.
  
Wenn der Login screen auf meherern Systemen zum einsatz kommen soll, muss in der 'main.js' der String 'SYSTEMIDVALUE' auf jedem system geändert werden.